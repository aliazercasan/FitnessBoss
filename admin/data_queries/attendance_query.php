<?php
include 'config.php';

// Set timezone to Asia/Manila
date_default_timezone_set('Asia/Manila');

// Generate current date in 'Y-m-d' format
$date_now = (new DateTime('now'))->format('Y-m-d');
$previous_date = (new DateTime('now'))->modify('-1 day')->format('Y-m-d');

if (isset($_POST['attendance']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['attendance_user_id'])) {
        // Sanitize input
        $attendance_user_id = intval($_POST['attendance_user_id']);

        // Check if user exists, retrieve data, and check status
        $sql = "
            SELECT 
                ua.users_account_id, 
                ua.expiration_membership, 
                ua.status, 
                ui.fullname, 
                ph.category 
            FROM tbl_users_account ua
            INNER JOIN tbl_users_info ui 
                ON ua.user_info_id = ui.user_info_id
            INNER JOIN payment_history ph 
                ON ua.users_account_id = ph.users_account_id
            WHERE ua.users_account_id = ? 
              AND DATE(ua.expiration_membership) >= CURDATE()
        ";
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
                $status = $row['status'];

                if ($status === 'inactive') {
                    echo "<script>alert('Hi $fullname, your account is inactive. Please contact support.');</script>";
                } elseif ($category === 'monthly' || $category === 'session') {
                    // Check for duplicate attendance within the last day
                    $check_duplication = "
                        SELECT * FROM attendance_users 
                        WHERE users_account_id = ? AND attendance_date = ?";
                    $stmt_check = $conn->prepare($check_duplication);

                    if ($stmt_check) {
                        $stmt_check->bind_param("is", $users_account_id, $date_now);
                        $stmt_check->execute();
                        $result_check = $stmt_check->get_result();

                        if ($result_check->num_rows > 0) {
                            echo "<script>alert('Hi $fullname, your attendance has already been recorded today.');</script>";
                        } else {
                            // Insert attendance
                            $insert_attendance = "
                                INSERT INTO attendance_users 
                                (users_account_id, fullname, category, expiration_date, attendance_date) 
                                VALUES (?, ?, ?, ?, ?)";
                            $stmt_insert = $conn->prepare($insert_attendance);

                            if ($stmt_insert) {
                                $stmt_insert->bind_param("issss", $users_account_id, $fullname, $category, $expiration_membership, $date_now);

                                if ($stmt_insert->execute()) {
                                    // Insert notification
                                    $insert_notification = "
                                        INSERT INTO users_notification 
                                        (users_account_id, message, message_date) 
                                        VALUES (?, ?, ?)";
                                    $stmt_notify = $conn->prepare($insert_notification);

                                    if ($stmt_notify) {
                                        $message = "Your attendance has been successfully recorded.";
                                        $stmt_notify->bind_param("iss", $users_account_id, $message, $date_now);

                                        if ($stmt_notify->execute()) {
                                            echo "<script>alert('Hi $fullname, your attendance has been successfully recorded today!');</script>";
                                        } else {
                                            echo "<script>alert('Failed to record notification. Please try again later.');</script>";
                                        }
                                        $stmt_notify->close();
                                    } else {
                                        echo "<script>alert('Error preparing notification query.');</script>";
                                    }
                                } else {
                                    echo "<script>alert('Failed to record attendance. Please try again.');</script>";
                                }
                                $stmt_insert->close();
                            } else {
                                echo "<script>alert('Error preparing attendance query.');</script>";
                            }
                        }
                        $stmt_check->close();
                    } else {
                        echo "<script>alert('Error checking attendance records.');</script>";
                    }
                } else {
                    echo "<script>alert('Hi $fullname, your membership does not support attendance recording. Please check with the cashier.');</script>";
                }
            } else {
                echo "<script>alert('This user is already expired his membership.');</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('Error preparing user query.');</script>";
        }
    } else {
        echo "<script>alert('User ID is required to record attendance.');</script>";
    }
}
?>
