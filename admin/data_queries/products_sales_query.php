<?php
include 'config.php';

$sql = "SELECT users_account_id, fullname, product_name, product_qty, price, product_total, date_issued FROM product_sales";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
?>



