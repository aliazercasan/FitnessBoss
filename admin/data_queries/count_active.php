<?php
include 'config.php';

// ACTIVE
$sql = "SELECT COUNT(*) as total FROM tbl_users_account WHERE status = 'active' AND role = 'user'";
$result = $conn->query($sql);

if ($result && $row = $result->fetch_assoc()) {
    $row['total'];
}

// Inactive
$sql2 = "SELECT COUNT(*) as total FROM tbl_users_account WHERE status = 'inactive' AND role = 'user'";
$result2 = $conn->query($sql2);

if ($result2 && $row2 = $result2->fetch_assoc()) {
    $row2['total'];
}


