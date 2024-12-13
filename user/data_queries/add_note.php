<?php
session_start();
include 'data_queries/config.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $user_id = $_SESSION['users_account_id'];

    // Check if fields are empty
    if (empty($title) || empty($content)) {
        $_SESSION['error_message'] = 'Title or content cannot be empty.';
        header("Location: index.php");
        exit();
    }

    // Insert query
    $sql = "INSERT INTO users_note (users_account_id, title, notes, note_created) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $user_id, $title, $content);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = 'Note added successfully!';
    } else {
        $_SESSION['error_message'] = 'Failed to add note. Please try again.';
    }

    // Redirect back to dashboard
    header("Location: index.php");
    exit();
}
?>