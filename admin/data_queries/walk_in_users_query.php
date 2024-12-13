<?php
include 'config.php'; // Include database configuration
// Set timezone to Asia/Manila
date_default_timezone_set('Asia/Manila');

// Generate current date and expiration date
$current_date = new DateTime('now');
$date_now = $current_date->format('Y-m-d'); // For payment_created
$expiration_date = $current_date->modify('+1 day')->format('Y-m-d'); // For expiration_date

// Generate a random reference number
$reference_number = sprintf("FNB-%03d-%03d-%03d", rand(100, 999), rand(100, 999), rand(100, 999));

// Handle form submission
if (isset($_POST['walk_in_submit']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the walk-in name from the form input
    $walk_in_name = trim($_POST['walk_in_name'] ?? '');

    if (empty($walk_in_name)) {
        echo "<script>alert('Walk-in name must not be empty.');</script>";
    } else {
        $category = "walk-in";
        $amount = 120;

        // Insert payment history
        $sql = "INSERT INTO walk_in_users 
                (fullname, reference_number, category, amount, date_expiration, payment_created) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param(
                "sssdss",
                $walk_in_name,
                $reference_number,
                $category,
                $amount,
                $expiration_date,
                $date_now
            );

            if ($stmt->execute()) {
                echo "<script>alert('Payment history inserted successfully.');</script>";
            } else {
                echo "<script>alert('Error inserting payment history: " . htmlspecialchars($stmt->error) . "');</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('Error preparing payment history query: " . htmlspecialchars($conn->error) . "');</script>";
        }
    }
}


?>