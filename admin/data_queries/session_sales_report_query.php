<?php

include 'data_queries/config.php'; // Ensure this file contains the DB connection

// Prepare the search query safely
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Prepare SQL query with placeholders for safe querying
$sql =  "SELECT 
users_account_id,
fullname,
reference_number,
date_expiration,
category,
amount,
payment_created
FROM payment_history 
WHERE category = 'session' 
AND (receipt_id LIKE ? OR reference_number LIKE ?)
ORDER BY payment_created DESC;
";

// Prepare the statement
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('Error preparing the query: ' . $conn->error);
}

// Bind the parameters
$searchTerm = "%" . $search . "%";
$stmt->bind_param("ss", $searchTerm, $searchTerm);

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();
