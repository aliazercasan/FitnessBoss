<?php
include 'data_queries/config.php';

// Set timezone to Asia/Manila
date_default_timezone_set('Asia/Manila');
$current_date = new DateTime('now');
$date_now = $current_date->format('Y-m-d');

// Ensure the user is logged in
if (!isset($_SESSION['users_account_id'])) {
    echo "<script>alert('You need to be logged in to perform this action.');</script>";
    exit();
}

$user_id = $_SESSION['users_account_id'];

// Add Note
if (isset($_POST['addnote'])) {
    $title = trim($_POST['titlenote']);
    $paragraph = trim($_POST['paragraphnote']);

    // Ensure fields are not empty
    if (empty($title) || empty($paragraph)) {
        echo "<script>alert('Title and Note content cannot be empty.');</script>";
    } else {
        try {
            $sql = "INSERT INTO users_note (users_account_id, title, notes, note_created) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isss", $user_id, $title, $paragraph, $date_now);

            if ($stmt->execute()) {
                echo "<script>alert('Note added successfully!'); window.location.href = '".$_SERVER['PHP_SELF']."';</script>";
                exit();
            } else {
                echo "<script>alert('Failed to add note.');</script>";
            }
            $stmt->close();
        } catch (Exception $e) {
            echo "<script>alert('Error: " . addslashes($e->getMessage()) . "');</script>";
        }
    }
}

// Delete Note
if (isset($_POST['deletenote'])) {
    $note_id = $_POST['note_id'];

    try {
        // First, verify the note belongs to the current user
        $verify_sql = "SELECT users_account_id FROM users_note WHERE note_id = ?";
        $verify_stmt = $conn->prepare($verify_sql);
        $verify_stmt->bind_param("i", $note_id);
        $verify_stmt->execute();
        $verify_result = $verify_stmt->get_result();

        if ($verify_result->num_rows > 0) {
            $note_owner = $verify_result->fetch_assoc();
            
            // Only allow deletion if the note belongs to the current user
            if ($note_owner['users_account_id'] == $user_id) {
                $sql = "DELETE FROM users_note WHERE note_id = ? AND users_account_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ii", $note_id, $user_id);

                if ($stmt->execute()) {
                    echo "<script>alert('Note deleted successfully!'); window.location.href = '".$_SERVER['PHP_SELF']."';</script>";
                    exit();
                } else {
                    echo "<script>alert('Failed to delete note.');</script>";
                }
                $stmt->close();
            } else {
                echo "<script>alert('You are not authorized to delete this note.');</script>";
            }
        } else {
            echo "<script>alert('Note not found.');</script>";
        }
        $verify_stmt->close();
    } catch (Exception $e) {
        echo "<script>alert('Error: " . addslashes($e->getMessage()) . "');</script>";
    }
}

// Edit Note
if (isset($_POST['editnote'])) {
    $note_id = $_POST['note_id'];
    $titlenoteEdit = trim($_POST['titlenoteEdit']);
    $paragraphnoteEdit = trim($_POST['paragraphnoteEdit']);

    // Validate input
    if (empty($titlenoteEdit) || empty($paragraphnoteEdit)) {
        echo "<script>alert('Title and Note content cannot be empty.');</script>";
    } else {
        try {
            // First, verify the note belongs to the current user
            $verify_sql = "SELECT users_account_id FROM users_note WHERE note_id = ?";
            $verify_stmt = $conn->prepare($verify_sql);
            $verify_stmt->bind_param("i", $note_id);
            $verify_stmt->execute();
            $verify_result = $verify_stmt->get_result();

            if ($verify_result->num_rows > 0) {
                $note_owner = $verify_result->fetch_assoc();
                
                // Only allow editing if the note belongs to the current user
                if ($note_owner['users_account_id'] == $user_id) {
                    $sql = "UPDATE users_note SET title = ?, notes = ? WHERE note_id = ? AND users_account_id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ssii", $titlenoteEdit, $paragraphnoteEdit, $note_id, $user_id);

                    if ($stmt->execute()) {
                        echo "<script>alert('Note updated successfully!'); window.location.href = '".$_SERVER['PHP_SELF']."';</script>";
                        exit();
                    } else {
                        echo "<script>alert('Failed to update note.');</script>";
                    }
                    $stmt->close();
                } else {
                    echo "<script>alert('You are not authorized to edit this note.');</script>";
                }
            } else {
                echo "<script>alert('Note not found.');</script>";
            }
            $verify_stmt->close();
        } catch (Exception $e) {
            echo "<script>alert('Error: " . addslashes($e->getMessage()) . "');</script>";
        }
    }
}
?>