<?php

// Ensure all necessary session variables are set
if (isset($_SESSION['users_account_id'])) {
    // Retrieve the user's account ID from the session
    $users_account_id = $_SESSION['users_account_id'];

    // Fetch payment history details from the database
    $sql = "SELECT * FROM payment_history WHERE users_account_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $users_account_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the user's details
        $row = $result->fetch_assoc();
        $users_account_id = $row['users_account_id'];
        $fullname = $row['fullname'];
        $reference_number = $row['reference_number'];
        $date_expiration = $row['date_expiration'];
        $category = $row['category'];
    } else {
        error_log("No record found for users_account_id: $users_account_id");
        exit;
    }

    // Current date in 'd-m-Y' format
    $current_date = date('Y-m-d');
    $show_toast = false;
    $expired_toast = false;

    // Determine when to show the toast based on the membership category
    if (!empty($users_account_id)) {
        if ($category === 'session') {
            if ($current_date < $date_expiration) {
                $show_toast = true;
            } else {
                $expired_toast = true;
            }
        } elseif ($category === 'monthly') {
            if ($current_date >= $date_expiration) {
                $expired_toast = true;
            } else {
                $show_toast = true;
            }
        }

        // Display the toast for active membership
        if ($show_toast) {
?>
            <!-- Toast for Active Membership -->
            <div class="toast-container position-fixed bottom-0 end-0 p-3">
                <div id="liveToast" class="toast align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            Dear <?php echo htmlspecialchars($fullname); ?>,
                            your <?php echo htmlspecialchars($category); ?> membership expires on
                            <span class="tw-text-black fw-bold tw-text-xl">
                                <?php
                                $formatted_date = date('F j, Y', strtotime($date_expiration));
                                echo htmlspecialchars($formatted_date);
                                ?>
                            </span>

                        </div>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var toastEl = document.getElementById('liveToast');
                    var toast = new bootstrap.Toast(toastEl, {
                        autohide: true,
                        delay: 5000 // Set toast to disappear after 5 seconds
                    });
                    toast.show();
                });
            </script>
        <?php
        }

        // Display the toast for expired membership
        if ($expired_toast) {
        ?>
            <!-- Toast for Expired Membership -->
            <div class="toast-container position-fixed bottom-0 end-0 p-3">
                <div id="expiredToast" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            Dear <?php echo htmlspecialchars($fullname); ?>,
                            your <?php echo htmlspecialchars($category); ?> membership has expired.
                            Please renew immediately to avoid interruptions.
                        </div>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var toastEl = document.getElementById('expiredToast');
                    var toast = new bootstrap.Toast(toastEl, {
                        autohide: true,
                        delay: 5000 // Set toast to disappear after 5 seconds
                    });
                    toast.show();
                });
            </script>



<?php
        }
    }
} else {
    // Log error and handle missing session variables
    error_log("Required session variables are missing. Ensure users_account_id is set.");
}
?>




