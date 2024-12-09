<?php

include 'data_queries/config.php'; // Ensure this file contains the DB connection

// Prepare the search query safely
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Prepare SQL query with placeholders for safe querying
$sql = "SELECT 
     walk_in_id,name,reference_number,
     category,amount,date_expiration,payment_created 
     FROM walk_in_users WHERE category = 'walk_in';
";

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