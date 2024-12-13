<?php
session_start();
include('data_queries/config.php');

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}

session_regenerate_id(true);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Attendance Log Book</title>
    <link rel="icon" href="../assets/logo.jpg" type="image/x-icon">

    <!-- CSS -->
    <link rel="stylesheet" href="style.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Black+Ops+One&family=Poppins:wght@100;400;700&display=swap"
        rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            prefix: 'tw-',
        };
    </script>
</head>

<!-- Navigation -->
<?php include 'header.php'; ?>
<body class="tw-bg-black">
    <!-- attendance_query -->
    <?php include 'data_queries/attendance_query.php'; ?>

    <div class="tw-flex tw-items-center tw-mt-20 ms-5">
        <img src="../assets/Logbook.png" alt="Logbook" class="tw-h-16 tw-w-auto">
        <h1 class="tw-text-2xl tw-text-white fw-bold ms-3">Attendance</h1>
    </div>

    <div class="tw-bg-[#9603a1] tw-rounded-lg container py-4 tw-text-white tw-flex tw-flex-col md:tw-flex-row tw-justify-evenly tw-items-center tw-mt-10">
        <!-- Form Section -->
        <div class="tw-text-start">
            <p class="tw-mb-6">Please enter the account ID of the member you  <br> want to log</p>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                <input type="text" class="form-control tw-mt-3 tw-mb-4" placeholder="Type member account ID"
                    name="attendance_user_id" required>

                <button class="tw-text-black py-2 px-4 tw-rounded tw-transition tw-duration-300 ease-in-out tw-bg-[#00e69d] hover:tw-bg-[#00FFAE]" type="submit" name="attendance">Submit</button>
            </form>
        </div>

        <!-- Logo Section -->
        <div class="tw-mt-10 md:tw-mt-0">
            <img src="../assets/logo.jpg" alt="Logo" class="tw-w-96 tw-h-auto">
        </div>
    </div>


    <!-- Footer -->
    <footer class="footer tw-text-center tw-text-slate-500 tw-mt-5 tw-mb-5 tw-fixed tw-bottom-0 tw-w-full">
        <div>
            <h1>&copy; 2024 Visionary Creatives X Fitness Boss. All Rights Reserved.</h1>
        </div>
    </footer>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>