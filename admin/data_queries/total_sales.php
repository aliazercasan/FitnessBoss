<?php
include 'data_queries/config.php';

// Initialize variables to hold the total values
$total = 0;
$total_session = 0;
$total_monthly = 0;
$total_walkin = 0;

$sql = "SELECT SUM(amount) as total FROM payment_history";
$result = $conn->query($sql);
if ($result && $row = $result->fetch_assoc()) {
    $total = $row['total'];  
}

$sql_session = "SELECT SUM(amount) as total_sesion FROM payment_history WHERE category = 'session'";
$result = $conn->query($sql_session);
if ($result && $row_total_session = $result->fetch_assoc()) {
    $total_session = $row_total_session['total_sesion']; 
}

$sql_monthly = "SELECT SUM(amount) as total FROM payment_history WHERE category = 'monthly'";
$result = $conn->query($sql_monthly);
if ($result && $row_monthly = $result->fetch_assoc()) {
    $total_monthly = $row_monthly['total']; 
}

$sql_walkin = "SELECT SUM(amount) as total_walkin FROM walk_in_users";
$result = $conn->query($sql_walkin);
if ($result && $walk_in_row = $result->fetch_assoc()) {
    $total_walkin = $walk_in_row['total_walkin'];  
}

