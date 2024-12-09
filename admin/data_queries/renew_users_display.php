 <!--Query renewal-->
 <?php

    if (isset($_SESSION['admin_id'])) {
        if (isset($_POST['renew_btn']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $renew_user_account_id = $_POST['users_account_id'];
            $membership = $_POST['membership'];

            // Ensure that user account ID is numeric and membership is selected
            if (!empty($renew_user_account_id) && !empty($membership) && is_numeric($renew_user_account_id)) {

                // Set timezone to Asia/Manila
                date_default_timezone_set('Asia/Manila');

                // Generate current date and expiration date
                $current_date = new DateTime('now');
                $date_now = $current_date->format('Y-m-d'); // Use correct date format for MySQL
                $current_date->modify('+12 months'); // Add 12 months to the current date
                $update_expiration_date = $current_date->format('Y-m-d'); // Format the expiration date correctly

                // Corrected SQL query
                $sql = "UPDATE tbl_users_account SET date_membership = ?, expiration_membership = ?, type_member = ? WHERE users_account_id = ?";
                $stmt = $conn->prepare($sql);

                if ($stmt) {
                    // Bind parameters correctly: date_now, expiration date, membership, and user account ID
                    $stmt->bind_param('sssi', $date_now, $update_expiration_date, $membership, $renew_user_account_id);

                    if ($stmt->execute()) {
                        $message = "Membership has been successfully updated.";
                        $user_notif = "INSERT INTO users_notification (users_account_id, message, message_date) VALUES (?, ?, ?)";
                        $stmt = $conn->prepare($user_notif);
                        if ($stmt) {
                            $stmt->bind_param('sss', $renew_user_account_id, $message, $date_now);
                            $stmt->execute();
                            $stmt->close();
                            echo "<script>alert('Membership has been successfully updated.');</script>";
                        } else {

                            echo "<script>alert('Error executing query: " . $stmt->error . "');</script>";
                        }
                    }
                } else {
                    echo "<script>alert('Error preparing query: " . $conn->error . "');</script>";
                }
            } else {
                echo "<script>alert('Please make sure all fields are filled correctly.');</script>";
            }
        }
    }
    ?>