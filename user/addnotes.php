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

// Add Note
if (isset($_POST['addnote']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['titlenote']);
    $paragraph = trim($_POST['paragraphnote']);
    $user_id = $_SESSION['users_account_id'];

    $sql = "INSERT INTO users_note (users_account_id, title, notes, note_created) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $user_id, $title, $paragraph, $date_now);

    if ($stmt->execute()) {

        $sql = "SELECT note_id FROM users_note WHERE users_account_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['note_id'] = $row['note_id'];
        }

        echo "<script>alert('Note added successfully!');</script>";
        
        
    } 
    $stmt->close();
}

// Delete Note
if (isset($_POST['deletenote']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $note_id = $_SESSION['note_id'];

    $sql = "DELETE FROM users_note WHERE note_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $note_id);

    if ($stmt->execute()) {
        echo "<script>alert('Note deleted successfully!');</script>";
    } 
    $stmt->close();
}

// Edit Note
if (isset($_POST['editnote']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $titlenoteEdit = trim($_POST['titlenoteEdit']);
    $paragraphnoteEdit = trim($_POST['paragraphnoteEdit']);
    $note_id = $_SESSION['note_id'];

    $sql = "UPDATE users_note SET title = ?, notes = ? WHERE note_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $titlenoteEdit, $paragraphnoteEdit, $note_id);

    if ($stmt->execute()) {
        echo "<script>alert('Note updated successfully!');</script>";
    } 
    $stmt->close();
}
?>
<!-- Add Note -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Note</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <input type="text" placeholder="Title" class="form-control" name="titlenote" required>
                    <textarea name="paragraphnote" class="form-control mt-3" placeholder="Type here..." required></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="addnote">Add Note</button>
            </div>
                </form>
        </div>
    </div>
</div>

<!-- DELETE Note -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold" id="exampleModalLabel">Delete Note</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this note?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <form method="POST">
                    <button type="submit" class="btn btn-danger" name="deletenote">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- EDIT Note -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Note</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <input type="text" placeholder="Title" class="form-control" name="titlenoteEdit" required>
                    <textarea name="paragraphnoteEdit" class="form-control mt-3" placeholder="Type here..." required></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="editnote">Save Changes</button>
            </div>
                </form>
        </div>
    </div>
</div>
