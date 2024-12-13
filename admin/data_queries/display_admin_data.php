<?php
session_start();
include 'config.php';

if (isset($_SESSION['admin_name'])) {
    $username_email = $_SESSION['admin_name'];

    // SQL query
    $sql = "
          SELECT 
              ua.username_email,
              ua.password,
              ua.role,
              ua.account_created,
              ui.fullname,
              ui.gender,
              ui.age
          FROM 
              tbl_users_account ua
          INNER JOIN 
              tbl_users_info ui 
          ON 
              ui.user_info_id = ua.user_info_id
          WHERE 
              ua.username_email = ?
          LIMIT 1
      ";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        // Bind the parameter
        $stmt->bind_param("s", $username_email);

        // Execute the query
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Fetch the row as an associative array
            $row = $result->fetch_assoc();
            $_SESSION['admin_name'] = $row['fullname'];
            $_SESSION['gender'] = $row['gender'];
            $_SESSION['age'] = $row['age'];
            $_SESSION['account_created'] = $row['account_created'];
        } else {
            echo "<p>No user data found.</p>";
        }

        $stmt->close();
    } else {
        echo "Error preparing the query: " . $conn->error;
    }
} else {
    echo "<p>User is not logged in.</p>";
}

$conn->close();
