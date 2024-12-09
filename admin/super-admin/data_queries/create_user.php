<?php
include 'config.php';

// Check if the form was submitted
if (isset($_POST["create_account"]) && $_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and validate inputs
    $fullname = trim($_POST["fullname"]);
    $age = (int)$_POST["age"];
    $gender = trim($_POST["gender"]);
    $street = trim($_POST["street"]);
    $province = trim($_POST["province"]);
    $city = trim($_POST["city"]);
    $birthdate = $_POST["birthdate"];
    $phonenumber = trim($_POST["phonenumber"]);
    $email_username = trim($_POST["email_username"]);
    $password = $_POST["password"];
    $membership = $_POST["membership"];
    $status = "active";
    $role = "user";

    // Set timezone to Asia/Manila
    date_default_timezone_set('Asia/Manila');

    // Generate current date and expiration date
    $current_date = new DateTime('now');
    $date_now = $current_date->format('d-m-Y');
    $expiration_membership = $current_date->modify('+1 year')->format('d-m-Y');

    // Concatenate the address
    $address = $street . ", " . $city . ", " . $province;

    // Validate inputs
    if (is_numeric($fullname)) {
        echo "<script>alert('Full name should not be numeric!');</script>";
    } elseif (empty($gender)) {
        echo "<script>alert('Please enter your gender!');</script>";
    } elseif (strlen($password) < 6) {
        echo "<script>alert('Password must be at least 6 characters long.');</script>";
    } elseif (!preg_match('/[A-Z]/', $password) || !preg_match('/[\W]/', $password)) {
        echo "<script>alert('Password must contain at least one uppercase letter and one special character.');</script>";
    } elseif ($age <= 0 || $age > 100) {
        echo "<script>alert('Invalid age! Age must be between 1 and 100.');</script>";
    } elseif (strlen($phonenumber) !== 11 || !ctype_digit($phonenumber)) {
        echo "<script>alert('Phone number must be exactly 11 numeric characters!');</script>";
    } elseif (empty($province) || empty($city) || empty($street)) {
        echo "<script>alert('Please complete your address!');</script>";
    } else {
        // Check for duplicate full name
        $stmt = $conn->prepare("SELECT user_info_id FROM tbl_users_info WHERE fullname = ?");
        $stmt->bind_param("s", $fullname);

        if (!$stmt->execute()) {
            echo "<script>alert('Error executing query: " . htmlspecialchars($stmt->error) . "');</script>";
        } else {
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                echo "<script>alert('Your name already exists.');</script>";
            } else {
                // Insert user data into tbl_users_info
                $insertUserInfo = $conn->prepare("INSERT INTO tbl_users_info (fullname, address, gender, birthdate, age, phonenumber) VALUES (?, ?, ?, ?, ?, ?)");
                $insertUserInfo->bind_param("ssssis", $fullname, $address, $gender, $birthdate, $age, $phonenumber);

                if ($insertUserInfo->execute()) {
                    // Get the last inserted ID
                    $foreign_id = $conn->insert_id;

                    // Hash the password
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    // Insert account data into tbl_users_account
                    $insertUserAccount = $conn->prepare(
                        "INSERT INTO tbl_users_account 
                        (user_info_id, username_email, password, status, date_membership, expiration_membership, role, type_member, account_created) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
                    );
                    $insertUserAccount->bind_param(
                        "issssssss", 
                        $foreign_id, 
                        $email_username, 
                        $hashed_password, 
                        $status, 
                        $date_now, 
                        $expiration_membership, 
                        $role, 
                        $membership, 
                        $date_now
                    );

                    if ($insertUserAccount->execute()) {
                        echo "<script>alert('Account created successfully!');</script>";
                    } else {
                        echo "Error: " . htmlspecialchars($insertUserAccount->error);
                    }

                    $insertUserAccount->close();
                } else {
                    echo "Error: " . htmlspecialchars($insertUserInfo->error);
                }

                $insertUserInfo->close();
            }
        }
        $stmt->close();
    }

    $conn->close();
}
