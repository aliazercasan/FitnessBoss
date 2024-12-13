<?php
include 'config.php';

// SQL query to count all rows in attendance_users and walk_in_users tables within the last 1 day
$sql = "
    SELECT COUNT(attendance_id) AS users_attendance
    FROM attendance_users
    WHERE attendance_date >= NOW() - INTERVAL 1 DAY
    UNION ALL
    SELECT COUNT(walk_in_id) AS users_attendance
    FROM walk_in_users
    WHERE payment_created >= NOW() - INTERVAL 1 DAY
";

// Prepare the SQL statement
$stmt = $conn->prepare($sql);

if ($stmt) {
    // Execute the statement
    $stmt->execute();

    // Fetch the result
    $result = $stmt->get_result();

    // Initialize counters
    $attendance_count = 0;
    $walk_in_count = 0;

    // Fetch both rows
    $row1 = $result->fetch_assoc();
    if ($row1) {
        $attendance_count = $row1['users_attendance'];
    }

    $row2 = $result->fetch_assoc();
    if ($row2) {
        $walk_in_count = $row2['users_attendance'];
    }
    // Calculate the total count
    $total_count = $attendance_count + $walk_in_count;

    // Close the statement
    $stmt->close();
} else {
    echo "Error preparing query: " . $conn->error;
}

// Close the database connection
$conn->close();
