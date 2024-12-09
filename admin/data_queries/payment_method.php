<?php
include 'config.php'; // Include database configuration
@session_start();

// Set timezone to Asia/Manila
date_default_timezone_set('Asia/Manila');

// Generate current date and expiration date
$current_date = new DateTime('now');
$date_now = $current_date->format('Y-m-d'); // Use 'Y-m-d' for database compatibility
$expiration_date = $current_date->modify('+1 month')->format('Y-m-d');

// Generate a random reference number
$reference_number = sprintf("FNB-%03d-%03d-%03d", rand(100, 999), rand(100, 999), rand(100, 999));

// Handle form submission
if (isset($_POST['submit_reciept']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure session variables are set
    if (!isset($_SESSION['users_account_id'], $_SESSION['admin_id'], $_SESSION['admin_name'], $_SESSION['age'])) {
        echo "<script>alert('Session variables are not set. Please log in again.');</script>";
        exit();
    }

    // Check if the user is not an admin
    if ($_SESSION['users_account_id'] === $_SESSION['admin_id']) {
        echo "<script>alert('Admins are not allowed to perform this action.');</script>";
        exit();
    }

    // Extract session variables
    $users_account_id = $_SESSION['users_account_id'];
    $fullname = $_SESSION['fullname'];
    $age = $_SESSION['age'];
    $admin_name = $_SESSION['admin_name'];
    $monthly_session = trim($_POST['session_monthly'] ?? '');

    // Validate monthly session input
    if (empty($monthly_session)) {
        echo "<script>alert('The session type must not be empty.');</script>";
        exit();
    }

    // Determine payment amount and category
    if ($monthly_session === 'session') {
        $amount = ($age < 20) ? 70 : 90;
        $expiration_date = (new DateTime('now'))->modify('+1 day')->format('Y-m-d'); // 1-day expiration for sessions
    } else {
        $amount = ($age < 20) ? 700 : 900;
        // Keep the original expiration date for other categories
    }

    // Insert payment history
    $sql = "INSERT INTO payment_history 
            (users_account_id, fullname, reference_number, date_expiration, category, amount, payment_created) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo "<script>alert('Error preparing payment history query: " . $conn->error . "');</script>";
        exit();
    }

    $stmt->bind_param(
        "issssis",
        $users_account_id,
        $fullname,
        $reference_number,
        $expiration_date,
        $monthly_session,
        $amount,
        $date_now
    );

    if ($stmt->execute()) {
        // Fetch the inserted record's ID
        $insert_id = $stmt->insert_id;

        // Insert receipt details
        $sql2 = "INSERT INTO payment_history_user 
                (receipt_id, users_account_id, admin_name, reference_number,date_expiration ,category, amount, payment_created) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt2 = $conn->prepare($sql2);

        if (!$stmt2) {
            echo "<script>alert('Error preparing receipt details query: " . $conn->error . "');</script>";
            exit();
        }

        $stmt2->bind_param(
            "isssssis",
            $insert_id,
            $users_account_id,
            $admin_name,
            $reference_number,
            $expiration_date,
            $monthly_session,
            $amount,
            $date_now
        );

        if ($stmt2->execute()) {
            echo "<script>alert('Payment history and receipt created successfully.');</script>";
        } else {
            echo "<script>alert('Error inserting receipt details: " . $stmt2->error . "');</script>";
        }
        $stmt2->close();
    } else {
        echo "<script>alert('Error inserting payment history: " . $stmt->error . "');</script>";
    }
    $stmt->close();

    // Close the database connection
    $conn->close();
}
?>
