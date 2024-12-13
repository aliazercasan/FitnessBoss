<?php
session_start();
include 'config.php';
$error_mess = "";
if (isset($_POST['btn-signin']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize user inputs
    $username_email = trim($_POST['username_email']);
    $password = $_POST['password'];

    // Input validation
    if (empty($username_email) || empty($password)) {
        echo "<script>alert('Both username/email and password are required.');</script>";
    } elseif (strlen($password) < 6) {
        echo "<script>alert('Password must be at least 6 characters long.');</script>";
    } elseif (!preg_match('/[A-Z]/', $password) || !preg_match('/[\W]/', $password)) {
        echo "<script>alert('Password must contain at least one uppercase letter and one special character.');</script>";
    } else {
        // Prepare SQL query to fetch user/admin details
        $stmt = $conn->prepare("
            SELECT 
                ua.users_account_id,
                ua.username_email,
                ua.password,
                ua.role,
                ui.fullname,
                ui.address,
                ui.gender,
                ui.age,
                ua.type_member,
                ua.status,
                ua.date_membership,
                ua.expiration_membership
            FROM 
                tbl_users_account ua
            INNER JOIN 
                tbl_users_info ui 
            ON 
                ui.user_info_id = ua.user_info_id
            WHERE 
                ua.username_email = ?
            LIMIT 1
        ");

        if (!$stmt) {
            die("Database error: " . htmlspecialchars($conn->error));
        }

        // Bind and execute the query
        $stmt->bind_param("s", $username_email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Validate user and password
        if ($user && password_verify($password, $user['password'])) {
            // Role-based redirection
            if ($user['role'] === 'user') {
                // Regenerate session ID for security
                session_regenerate_id(true);

                // Set common session variables
                $_SESSION['users_account_id'] = $user['users_account_id'];
                $_SESSION['username_email'] = $user['username_email'];
                $_SESSION['fullname'] = $user['fullname'];
                $_SESSION['gender'] = $user['gender'];
                $_SESSION['date_membership'] = $user['date_membership'];
                $_SESSION['expiration_membership'] = $user['expiration_membership'];
                $_SESSION['address'] = $user['address'];

                header("Location: user/index.php");
                exit();
            } elseif ($user['role'] === 'admin') {
                $_SESSION['admin_id'] = $user['users_account_id'];
                $_SESSION['admin_name'] = $user['fullname'];
                header("Location: admin/dashboard-admin.php");
                exit();
            } elseif ($user['role'] === 'super_admin') {
                $_SESSION['super_admin_id'] = $user['users_account_id'];
                header("Location: admin/super-admin/dashboard.php");
                exit();
            } else {
                echo "<script>alert('Unknown role. Please contact support.');</script>";
            }
        } else {
            // Handle invalid credentials
            $error_mess = "*Invalid email or password. Please try again.";
        }

        // Close statement
        $stmt->close();
    }

    // Close database connection
    $conn->close();
}
