<?php
session_start();
if (!isset($_SESSION['users_account_id'])) {
    header("Location: ../login.php");
    exit();
}



?>
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
</head>

<body class="bg-black text-white">
    <?php
    include 'data_queries/expired_inactive_users.php';
  ?>
   
    <!--NAVIGATION BAR-->
    <?php include 'data_queries/session_reminder.php' ?>
    <?php include 'data_queries/membership_reminder.php' ?>
    <?php include 'navigation.php' ?>

   

    <div class="d-flex align-items-center justify-content-between container tw-mt-40">
        <div>
            <h1 class="tw-text-4xl tw-font-bold text-white text-start">Hello, <?php echo htmlspecialchars($_SESSION['fullname']) ?>!</h1>
            <div class="tw-flex tw-items-center mt-3">
                <h1 class="tw-text-xl text-white me-2">Every rep brings you closer to becoming your strongest self!</h1>
                <img src="../assets/Edit.png" alt="" width="20">
            </div>
        </div>
        <div class="text-black tw-flex tw-items-center tw-bg-[#EA3EF7] tw-border-[#00FFAE] tw-border-2 tw-px-4 tw-py-2 tw-rounded-lg">
            <img src="../assets/Membership Card.png" alt="" width="30">
            <h1 class="tw-ml-2 tw-font-bold tw-text-xl">Membership Expire: </h1>

            <div class="text-center ms-3 tw-text-md">
                <?php
                // Set timezone to Asia/Manila
                date_default_timezone_set('Asia/Manila');

                // Get the current date
                $current_date = new DateTime('now');

                // Fetch the expiration date from the session (ensure it's in 'Y-m-d' format)
                $expiration_date = new DateTime($_SESSION['expiration_membership']);

                // Format the expiration date as 'Month Day, Year'
                $formatted_expiration_date = $expiration_date->format('F j, Y');

                // Check if the expiration date is in the future
                if ($expiration_date > $current_date) {
                    echo "<p class='tw-text-white'>" . $formatted_expiration_date;
                }
                ?>
            </div>


        </div>
    </div>
   
    <!--CARDS -->
    <div class="tw-grid lg:tw-grid-cols-2 md:tw-grid-cols-2 container mt-5 gap-4 tw-grid-cols-1 ">

        <!--calendar -->
        <div class="card text-black p-2 tw-border-4 tw-border-[#00FFAE]">
            <div class="header d-flex justify-content-start align-items-center">
                <img src="../assets/book.png" alt="" width="70">

                <p class=" tw-font-bold">Calendar</p>
            </div>
            <div class="tw-flex tw-justify-between tw-items-center">
                <?php include 'data_queries/calendar.php' ?>
            </div>

        </div>

        <!--NOTIFICATIONS-->
        <?php include 'data_queries/notification.php' ?>

        <!--NOTIFICATIONS-->
        <?php
        if (isset($_SESSION['users_account_id'])) {
            // Check if the message session variable is empty
            if (empty($_SESSION['message'])) { ?>
                <!-- No notifications -->
                <div class="card text-black p-2 tw-border-4 tw-border-[#00FFAE]">
                    <div class="header d-flex align-items-center">
                        <img src="../assets/Notifications.png" alt="Notification Icon" width="40">
                        <h1 class="tw-text-xl ms-3 tw-font-bold">Notifications</h1>
                    </div>
                </div>
            <?php } else { ?>
                <!-- Display notification -->
                <div class="card text-black p-2 tw-border-4 tw-border-[#00FFAE]">
                    <div class="header d-flex align-items-center">
                        <img src="../assets/Notifications.png" alt="Notification Icon" width="40">
                        <h1 class="tw-text-xl ms-3 tw-font-bold">Notifications</h1>
                    </div>
                    <div class="text-center mt-4 tw-bg-[#EA3EF7] py-2 tw-rounded-lg text-black">
                        <div class="tw-flex tw-justify-around tw-items-center">
                            <div>
                                <img src="../assets/Membership Card.png" alt="Membership Icon" width="40">
                            </div>
                            <div>
                                <p><?php echo htmlspecialchars($_SESSION['message']); ?></p>
                            </div>
                        </div>
                        <p class="tw-text-sm tw-text-end tw-text-white me-3">
                            <?php echo htmlspecialchars($_SESSION['message_date'] ?? ''); ?>
                        </p>
                    </div>
                </div>
        <?php }
        }
        ?>


<?php 
    ?>
        <!-- Notes -->
        <div class="card text-black p-2 tw-border-4 tw-border-[#00FFAE]">
            <div class="header d-flex align-items-center">
                <img src="../assets/Create.png" alt="" width="40">
                <h1 class="tw-text-xl ms-3 tw-font-bold">Notes</h1>
            </div>
            <div class="text-center mt-4">
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <?php
                    include 'data_queries/config.php';

                    if (isset($_SESSION['users_account_id'])) {
                        $userId = $_SESSION['users_account_id'];
                        // Fix: Use a prepared statement to prevent SQL injection
                        $sql = "SELECT title, notes, note_created FROM users_note WHERE users_account_id = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $userId); // 'i' means the parameter is an integer
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            $counter = 0; // To create unique collapse IDs
                            while ($row = $result->fetch_assoc()) {
                                $title = $row['title'];
                                $note = $row['notes'];
                                $note_created = $row['note_created'];

                                $counter++;
                                // Unique ID for each accordion item
                                $collapseId = "flush-collapse" . $counter;
                    ?>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading<?php echo $counter; ?>">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo $collapseId; ?>" aria-expanded="false" aria-controls="<?php echo $collapseId; ?>">
                                            <?php echo htmlspecialchars($title); ?>
                                        </button>
                                    </h2>
                                    <div id="<?php echo $collapseId; ?>" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            <ul>
                                                <li><?php echo htmlspecialchars($note); ?></li>
                                                <div class="tw-flex tw-justify-between tw-items-center">
                                                    <p class="text-primary text-end"><?php echo htmlspecialchars($note_created) ?></p>
                                                    <div>
                                                        <button class="ms-3 tw-underline tw-text-yellow-600" data-bs-toggle="modal" data-bs-target="#editModal" <?php echo $counter; ?>>Edit</button>
                                                        <button class="ms-3 tw-underline tw-text-red-600" data-bs-toggle="modal" data-bs-target="#deleteModal" <?php echo $counter; ?>>Delete</button>
                                                    </div>

                                                </div>

                                            </ul>

                                        </div>
                                    </div>
                                </div>
                    <?php
                            }
                        } else {
                            echo "<p>No notes found.</p>";
                        }
                        $stmt->close();
                    }
                    ?>
                    <!-- Add Notes -->
                    <?php include 'addnotes.php'; ?>
                    <div class="tw-float-end me-3 mt-3">
                        <button class="" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <img src="../assets/Add.png" alt="" width="30">
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
   
   
    <div class=" tw-text-slate-500 text-center tw-mt-10 ">
        <div>
            <h1>&copy; 2024 Visionary Creatives X Fitness Boss. All Rights Reserved.</h1>

        </div>
        <!--Bootstrap JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
</body>

</html>