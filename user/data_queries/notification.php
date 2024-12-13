<?php
include 'config.php';
if (isset($_SESSION['users_account_id'])) {
    $sql = "SELECT * FROM users_notification 
        WHERE users_account_id = ? 
        ORDER BY message_date DESC";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        // Bind the user account ID to the query
        $stmt->bind_param('s', $_SESSION['users_account_id']);

        // Execute the query
        $stmt->execute();

        // Get the result set
        $result = $stmt->get_result();

        // Check if there are notifications
        if ($result->num_rows > 0) {
            // Loop through notifications
            while ($row = $result->fetch_assoc()) {
                $_SESSION['message'] = $row['message'];
                $_SESSION['message_date'] = $row['message_date'];
            }
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing the query: " . $conn->error;
    }
}
