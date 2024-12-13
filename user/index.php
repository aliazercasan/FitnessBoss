<?php
session_start();
if (!isset($_SESSION['users_account_id'])) {
    header("Location: ../login.php");
    exit();
}
?>
<?php
if (isset($_SESSION['message']) && !empty($_SESSION['message'])) {
    $messageClass = ($_SESSION['message_type'] == 'success') ? 'alert-success' : 'alert-danger';
    echo "<div class='alert $messageClass'>" . htmlspecialchars($_SESSION['message']) . "</div>";
    
    // Clear the message after displaying
    $_SESSION['message'] = '';
    $_SESSION['message_type'] = '';
}
?>

<?php include 'data_queries/addnotes.php';?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="fontstyle.css" />
    <link rel="icon" href="./../assets/logo.jpg" type="image/x-icon">
    <title>Fitness Boss</title>
    <!--CSS SHEET-->
    <link rel="stylesheet" href="style.css">
    <!--Google Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Black+Ops+One&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ultra&display=swap" rel="stylesheet">

    <!--Bootstrap Icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <!--Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />

    <!--Taiwind Framework-->
    <script src="https://cdn.tailwindcss.com"></script>

    <!--Taiwind config (to avoid conflict)-->
    <script>
        tailwind.config = {
            prefix: "tw-",
        };
    </script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set data in Edit Modal
    document.querySelectorAll('[data-bs-target="#editModal"]').forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('editNoteId').value = button.getAttribute('data-note-id');
            document.getElementById('editTitle').value = button.getAttribute('data-title');
            document.getElementById('editNotes').value = button.getAttribute('data-notes');
        });
    });

    // Set data in Delete Modal
    document.querySelectorAll('[data-bs-target="#deleteModal"]').forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('deleteNoteId').value = button.getAttribute('data-note-id');
        });
    });
});
</script>
</head>

<body class="bg-black text-white">
    <?php
    include 'data_queries/expired_inactive_users.php';
    ?>

    <!--NAVIGATION BAR-->
    <?php include 'data_queries/session_reminder.php' ?>
    <?php include 'data_queries/membership_reminder.php' ?>
    <?php include 'navigation.php' ?>


    <div class="container tw-mt-40">
        <div class="d-flex flex-wrap align-items-center justify-content-between text-center text-md-start">
            <div class="mb-3 mb-md-0">
                <h1 class="tw-text-4xl tw-font-bold text-white">Hello, <?php echo htmlspecialchars($_SESSION['fullname']); ?>!</h1>
                <div class="tw-flex tw-items-center mt-3 justify-content-center justify-content-md-start">
                    <h1 class="tw-text-xl text-white me-2">Every reps brings you closer to becoming your strongest self!</h1>
                </div>
            </div>
            <div class="text-black d-flex align-items-center justify-content-center tw-bg-[#EA3EF7] tw-border-[#00FFAE] tw-border-2 tw-px-4 tw-py-2 tw-rounded-lg">
                <img src="../assets/Membership Card.png" alt="Membership Card" width="30">
                <h1 class="tw-ml-2 tw-font-bold tw-text-xl">Membership Expires:</h1>
                <div class="text-center ms-3 tw-text-md tw-text-white">
                    <?php
                    date_default_timezone_set('Asia/Manila');
                    $current_date = new DateTime('now');
                    $expiration_date = new DateTime($_SESSION['expiration_membership']);
                    $formatted_expiration_date = $expiration_date->format('F j, Y');
                    echo ($expiration_date > $current_date) ? $formatted_expiration_date : 'Expired';
                    ?>
                </div>
            </div>
        </div>

        <!-- Cards Section -->
        <div class="row mt-5 g-4">

            <!-- Calendar Card -->
            <div class="col-md-6">
                <div class="card text-black p-3 tw-border-4 tw-border-[#00FFAE] h-100">
                    <div class="d-flex align-items-center mb-3">
                        <img src="../assets/book.png" alt="Calendar Icon" width="40" class="me-2">
                        <h2 class="tw-font-bold">Calendar</h2>
                    </div>
                    <div>
                        <?php include 'data_queries/calendar.php'; ?>
                    </div>
                </div>
            </div>

            <!-- Notifications Card -->
            <div class="col-md-6">
                <div class="card text-black p-3 tw-border-4 tw-border-[#00FFAE] h-100">
                    <div class="d-flex align-items-center mb-3">
                        <img src="../assets/Notifications.png" alt="Notification Icon" width="40" class="me-2">
                        <h2 class="tw-font-bold">Notifications</h2>
                    </div>
                    <div style="max-height: 300px; overflow-y: auto;">
                        <?php
                        $sql = "SELECT message, message_date FROM users_notification WHERE users_account_id = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $_SESSION['users_account_id']);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<div class="p-2 mb-2 tw-bg-[#EA3EF7] tw-rounded-lg">';
                                echo '<p>' . htmlspecialchars($row['message']) . '</p>';
                                echo '<p class="tw-text-sm text-white text-end">' . htmlspecialchars($row['message_date']) . '</p>';
                                echo '</div>';
                            }
                        } else {
                            echo '<p>No notifications available.</p>';
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Notes Card -->
            <div class="col-12">
                <div class="card text-black p-3 tw-border-4 tw-border-[#00FFAE]">
                    <div class="d-flex align-items-center mb-3">
                        <img src="../assets/Create.png" alt="Notes Icon" width="40" class="me-2">
                        <h2 class="tw-font-bold">Notes</h2>
                    </div>
                    <div>
                        <div class="accordion accordion-flush" id="notesAccordion">
                            <?php
                            $sql = "SELECT note_id, title, notes, note_created FROM users_note WHERE users_account_id = ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $_SESSION['users_account_id']);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                $counter = 0;
                                while ($row = $result->fetch_assoc()) {
                                    $counter++;
                                    echo '<div class="accordion-item">';
                                    echo '<h2 class="accordion-header" id="heading' . $counter . '">';
                                    echo '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse' . $counter . '">';
                                    echo htmlspecialchars($row['title']);
                                    echo '</button></h2>';
                                    echo '<div id="collapse' . $counter . '" class="accordion-collapse collapse" data-bs-parent="#notesAccordion">';
                                    echo '<div class="accordion-body">';
                                    echo '<p>' . htmlspecialchars($row['notes']) . '</p>';
                                    echo '<p class="tw-text-sm text-end">' . htmlspecialchars($row['note_created']) . '</p>';
                                    echo '<div class="d-flex justify-content-end mt-2">';
                                    echo '<button class="btn btn-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editModal" 
                                data-note-id="' . $row['note_id'] . '" 
                                data-title="' . htmlspecialchars($row['title']) . '" 
                                data-notes="' . htmlspecialchars($row['notes']) . '">Edit</button>';
                                    echo '<button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" 
                                data-note-id="' . $row['note_id'] . '">Delete</button>';
                                    echo '</div>';
                                    echo '</div></div></div>';
                                }
                            } else {
                                echo '<p>No notes found.</p>';
                            }
                            ?>
                        </div>
                        <div class="text-end mt-3">
                            <button data-bs-toggle="modal" data-bs-target="#addNoteModal">
                                <img src="../assets/Add.png" alt="Add Note" width="30">
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Note Modal -->
<div class="modal fade" id="addNoteModal" tabindex="-1" aria-labelledby="addNoteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addNoteModalLabel">Add Note</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="index.php" method="post">
                    <input type="text" name="titlenote" class="form-control" placeholder="Title" required>
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

<!-- Edit Note Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel">Edit Note</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="index.php" method="post">
                    <input type="hidden" name="note_id" id="editNoteId">
                    <input type="text" name="titlenoteEdit" id="editTitle" class="form-control" placeholder="Title" required>
                    <textarea name="paragraphnoteEdit" id="editNotes" class="form-control mt-3" placeholder="Type here..." required></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="editnote">Save Changes</button>
            </div>
                </form>
        </div>
    </div>
</div>

<!-- Delete Note Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h1 class="modal-title fs-5" id="deleteModalLabel">Confirm Delete</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p class="fs-5">Are you sure you want to delete this note?</p>
                <p class="text-muted">Are you sure you want to delete this note?</p>
            </div>
            <div class="modal-footer">
                <form action="index.php" method="post">
                    <input type="hidden" name="note_id" id="deleteNoteId">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" name="deletenote">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>


            <!-- Footer -->
            <footer class="text-center tw-mt-10 tw-text-slate-500">
                <p>&copy; 2024 Visionary Creatives X Fitness Boss. All Rights Reserved.</p>
            </footer>
        </div>
        <!--Bootstrap JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous">
        </script>
</body>

</html>