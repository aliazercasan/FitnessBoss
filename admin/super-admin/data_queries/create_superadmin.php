<?php
include 'config.php';

// Check if the form was submitted
if (isset($_POST["create_account"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form values and sanitize inputs
    $fullname = trim($_POST["fullname"]);
    $age = (int) $_POST["age"];
    $gender = trim($_POST["gender"]);
    $street = trim($_POST["street"]);
    $province = trim($_POST["province"]);
    $city = trim($_POST["city"]);
    $birthdate = $_POST["birthdate"];
    $phonenumber = trim($_POST["phonenumber"]); // Treat phone number as a string
    $email_username = trim($_POST["email_username"]);
    $password = $_POST["password"];
    $membership = "-";
    $status = "active";
    $role = "super_admin";
    $expiration_membership = $current_date ="-";


    // Concatenate the street, city, and province
    $address = $street . ", " . $city . ", " . $province;

    if (is_numeric($fullname) || is_numeric($address)) {
        echo "<script>alert('Full name and address should not be numeric!');</script>";
    } else if (empty($gender)) {
        echo "<script>alert('Please enter your gender');</script>";
    } else if (strlen($password) < 6) {
        echo "<script>alert('Password must be at least 6 characters long.');</script>";
    } else if (!preg_match('/[A-Z]/', $password) || !preg_match('/[\W]/', $password)) {
        echo "<script>alert('Password must contain at least one uppercase letter and one special character.');</script>";
    } else if ($age > 100 || $age <= 0) {
        echo "<script>alert('Invalid Age! Age must be between 1 and 100.');</script>";
    } else if (strlen($phonenumber) !== 11 || !is_numeric($phonenumber)) {
        echo "<script>alert('Phone number must be exactly 11 numeric characters!');</script>";
    } else if (empty($province) || empty($city) || empty($street)) {
        echo "<script>alert('Please enter your address!');</script>";
    } else if (empty($gender)) {
        echo "<script>alert('Please enter your gender!');</script>";
    } else {
        // Check for duplicate full name
        $check_duplication_fullname = $conn->prepare("SELECT user_info_id FROM tbl_users_info WHERE fullname = ?");
        $check_duplication_fullname->bind_param("s", $fullname);

        if (!$check_duplication_fullname->execute()) {
            echo "<script>alert('Error executing query: " . $check_duplication_fullname->error . "');</script>";
        } else {
            $check_duplication_fullname->store_result();
            if ($check_duplication_fullname->num_rows > 0) {
                echo "<script>alert('Your name already exists.');</script>";
            } else {
                // Insert user data into tbl_users_info
                $sql = "INSERT INTO tbl_users_info (fullname, address, gender, birthdate, age, phonenumber) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssis", $fullname, $address, $gender, $birthdate, $age, $phonenumber);

                if ($stmt->execute()) {

                    // Get the last inserted ID from tbl_users_info
                    $foreign_id = $conn->insert_id;

                    // Hash the password for secure storage
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    // Insert account data into tbl_users_account
                    $sql2 = "INSERT INTO tbl_users_account (user_info_id, username_email, password, status,date_membership, role, type_member,account_created, expiration_membership) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?)";
                    $stmt2 = $conn->prepare($sql2);
                    $stmt2->bind_param("issssssss", $foreign_id, $email_username, $hashed_password, $status, $current_date, $role, $membership, $current_date, $expiration_membership);

                    if ($stmt2->execute()) {
                        echo "<script>alert('Account created successfully')</script>";
                    } else {
                        echo "Error: " . $sql2 . "<br>" . $conn->error;
                    }

                    // Close account statement
                    $stmt2->close();
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }

                // Close user info statement
                $stmt->close();
            }
            // Close duplication check statement
            $check_duplication_fullname->close();
        }
        // Close connection
        $conn->close();
    }
}
