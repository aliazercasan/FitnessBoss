<?php
include 'config.php';
// Initialize search query and results
$searchQuery = "";

if (isset($_GET['users_id'])) {
    // Get the search query from the form
    $searchQuery = trim($_GET['users_id']);

    // Prepare and execute SQL query
    $stmt = $conn->prepare("SELECT ua.users_account_id,
                ui.fullname,ui.age
                FROM tbl_users_account ua 
                INNER JOIN tbl_users_info ui 
                ON ua.user_info_id = ui.user_info_id 
                WHERE ua.users_account_id LIKE ?");

    $likeQuery = "%" . $searchQuery . "%";
    $stmt->bind_param("s", $likeQuery);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $_SESSION['fullname'] = $row['fullname'];
            $_SESSION['users_account_id'] = $row['users_account_id'];
            $_SESSION['age'] = $row['age'];


        }
    } else {
        echo "No results found.";
    }

    $stmt->close();
}
