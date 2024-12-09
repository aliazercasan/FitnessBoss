<?php
include 'config.php';

// inactive and active
if (isset($_SESSION['expiration_membership'])) {
    $expiration_date = $_SESSION['expiration_membership']; 
    $current_date = date('d-m-Y');
    $users_account_id = $_SESSION['users_account_id'];

    // Use DateTime for accurate date comparison
    $expiration_date_obj = new DateTime($expiration_date);
    $current_date_obj = new DateTime($current_date);

    if ($current_date_obj > $expiration_date_obj) {
        // Use parameterized queries to prevent SQL injection
        $sql = "UPDATE tbl_users_account SET status = 'inactive' WHERE users_account_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $users_account_id);
        $stmt->execute();
    }else{
          // If the membership is not expired, set the status to 'active' if not already active
          $sql = "UPDATE tbl_users_account SET status = 'active' WHERE users_account_id = ? AND status != 'active'";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param('s', $users_account_id);
          $stmt->execute();
    }
} else {
    echo "Expiration date is not set in session.";
}


