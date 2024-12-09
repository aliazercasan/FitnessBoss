<?php
    include 'config.php';

   // SQL query to count all rows in attendance_users table within the last 1 day
$sql = "SELECT COUNT(attendance_id) AS users_attendance 
FROM attendance_users 
WHERE attendance_date >= NOW() - INTERVAL 1 DAY";

// Prepare the SQL statement
$stmt = $conn->prepare($sql);

if ($stmt) {
// Execute the statement
$stmt->execute();

// Fetch the result
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Get the count value
$users_attendance = $row['users_attendance'];

// Close the statement
$stmt->close();
} else {
echo "Error preparing query: " . $conn->error;
}

// Close the database connection
$conn->close();

?>
