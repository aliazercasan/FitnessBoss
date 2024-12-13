<?php
include 'config.php'; // Ensure this file contains the DB connection

// Prepare the search query safely
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Prepare SQL query with placeholders for safe querying
$sql = "SELECT 
        walk_in_id ,
        fullname,
        reference_number,
         date_expiration,
        category,
        amount,
        payment_created
    FROM walk_in_users ORDER BY payment_created DESC;";

// Prepare the statement
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('Error preparing the query: ' . $conn->error);
}

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();

?>