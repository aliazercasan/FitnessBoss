<?php
include 'config.php';

// Set timezone to Asia/Manila
date_default_timezone_set('Asia/Manila');

// Generate current date in 'Y-m-d' format
$current_date = new DateTime('now');
$date_now = $current_date->format('Y-m-d');

// Add a date interval of one day
$previous_date = $current_date->modify('-1 day')->format('Y-m-d'); // Get the date for 1 day ago

if (isset($_POST['attendance']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['attendance_user_id'])) {
        // Sanitize input
        $attendance_user_id = intval($_POST['attendance_user_id']);

        // Check if user exists and retrieve data
        $sql = "SELECT 
                    ua.users_account_id, 
                    ua.expiration_membership, 
                    ui.fullname, 
                    ph.category 
                FROM tbl_users_account ua
                INNER JOIN tbl_users_info ui 
                    ON ua.user_info_id = ui.user_info_id
                INNER JOIN payment_history ph 
                    ON ua.users_account_id = ph.users_account_id
                WHERE ua.users_account_id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $attendance_user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                $users_account_id = $row['users_account_id'];
                $expiration_membership = $row['expiration_membership'];
                $fullname = $row['fullname'];
                $category = $row['category'];

                if ($category === 'monthly' || $category === 'session') {
                    $check_dulication = "SELECT * FROM attendance_users WHERE users_account_id = ? AND attendance_date >= ?";
                    $stmt_check = $conn->prepare($check_dulication);

                    if ($stmt_check) {
                        $stmt_check->bind_param("is", $users_account_id, $previous_date);
                        $stmt_check->execute();
                        $result_check = $stmt_check->get_result();

                        if ($result_check->num_rows > 0) {
                            $stmt_check->close();
                            echo "<script>alert('Hi $fullname, you already have attendance recorded today.');</script>";
                        } else {
                            // Prepare the query to insert attendance
                            $users_attendance = "INSERT INTO attendance_users 
                                (users_account_id, fullname, category, expiration_date, attendance_date) 
                                VALUES (?, ?, ?, ?, ?)";
                            $stmt_insert = $conn->prepare($users_attendance);

                            if ($stmt_insert) {
                                // Bind parameters for attendance query
                                $stmt_insert->bind_param("issss", $users_account_id, $fullname, $category, $expiration_membership, $date_now);

                                // Execute the attendance query
                                if ($stmt_insert->execute()) {
                                    // Prepare the query to insert notification
                                    $insert_user_message = "INSERT INTO users_notification 
                                        (users_account_id, message, message_date) 
                                        VALUES (?, ?, ?)";
                                    $stmt_insert_message = $conn->prepare($insert_user_message);

                                    if ($stmt_insert_message) {
                                        // Bind parameters for notification query
                                        $stmt_insert_message->bind_param("iss", $users_account_id, $message, $date_now);

                                        // Set the message content
                                        $message = "Your attendance has been successfully recorded.";

                                        // Execute the notification query
                                        if ($stmt_insert_message->execute()) {
                                            echo "<script>alert('Hi $fullname, your attendance has been recorded today!');</script>";
                                        } else {
                                            echo "<script>alert('Failed to record notification. Please try again.');</script>";
                                        }

                                        // Close the notification statement
                                        $stmt_insert_message->close();
                                    } else {
                                        echo "<script>alert('Error preparing notification query. Please try again later.');</script>";
                                    }
                                } else {
                                    echo "<script>alert('Oops! Failed to record attendance. Please try again.');</script>";
                                }

                                // Close the attendance statement
                                $stmt_insert->close();
                            } else {
                                echo "<script>alert('Error preparing attendance query. Please try again later.');</script>";
                            }
                        }
                    } else {
                        echo "<script>alert('Error checking attendance status.');</script>";
                    }
                } else {
                    echo "<script>alert('Oops! You don\'t have a valid monthly or session membership. <br> Please proceed to the cashier.');</script>";
                }

                $stmt->close();
            } else {
                echo "<script>alert('User not found.');</script>";
            }
        } else {
            echo "<script>alert('User ID is required to record attendance.');</script>";
        }
    }
}
?>
