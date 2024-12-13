<?php
  // Include the database configuration
  include 'data_queries/config.php';

  $error_mess = "";
  if (isset($_POST['btn-changepassword']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize user inputs
    $email_username = trim($_POST['username_email']);
    $new_password = trim($_POST['newpassword']);
    $confirm_password = trim($_POST['confirmpassword']);

    // Input validation
    if (empty($email_username) || empty($new_password) || empty($confirm_password)) {
      $error_mess = "*All fields are required.";
    } elseif ($new_password !== $confirm_password) {
      $error_mess = "*Passwords do not match.";
    } elseif (strlen($new_password) > 6) {
      $error_mess = "*Password must be at least 6 characters long.";
    } elseif (!preg_match('/[A-Z]/', $new_password) || !preg_match('/[\W]/', $new_password)) {
      $error_mess = "*Password must contain at least one uppercase letter and one special character.";
    } else {
      // Check if the user exists in the database
      $check_user_query = "SELECT * FROM tbl_users_account WHERE username_email = ?";
      $stmt = $conn->prepare($check_user_query);

      if (!$stmt) {
        die("Query preparation failed: " . $conn->error);
      }

      $stmt->bind_param("s", $email_username);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
        // User exists; proceed to update the password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $update_query = "UPDATE tbl_users_account SET password = ? WHERE username_email = ?";
        $update_stmt = $conn->prepare($update_query);

        if (!$update_stmt) {
          die("Query preparation failed: " . $conn->error);
        }

        $update_stmt->bind_param("ss", $hashed_password, $email_username);

        if ($update_stmt->execute()) {
          echo "<script>alert('Password successfully updated.');</script>";
        } else {
          echo "<script>alert('Error updating password. Please try again later.');</script>";
        }

        $update_stmt->close();
      } else {
        $error_mess = "*Email not found.";
      }

      $stmt->close();
    }

    // Close the database connection
    $conn->close();
  }
  ?>