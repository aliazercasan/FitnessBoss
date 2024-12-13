<?php
session_start();
include('data_queries/config.php');

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../../login.php");
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Administrator Dashboard</title>
    <link rel="icon" href="../assets/logo.jpg" type="image/x-icon">

    <!-- CSS -->
    <link rel="stylesheet" href="style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Black+Ops+One&family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Ultra&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            prefix: "tw-",
        };
    </script>
</head>

<body class="bg-black lg:tw-p-5 md:tw-p-3 tw-p-0">
    <!-- Navigation -->
    <?php include 'header.php'; ?>

    <!-- walk_in_users_query -->
    <?php include 'data_queries/walk_in_users_query.php' ?>
    <!-- Main Content -->
    <div class="container-fluid md:tw-p-10 tw-p-7 tw-mt-20 tw-flex tw-items-center tw-justify-center text-white">
        <div class="tw-w-full md:tw-w-3/4 tw-bg-[#9603a1] tw-p-10 tw-rounded-xl tw-shadow-lg tw-flex tw-flex-col md:tw-flex-row tw-items-center">
            <!-- Content Section -->
            <div class="tw-w-full md:tw-w-1/2 tw-pr-8">
                <div class="tw-flex tw-items-center tw-justify-between tw-mb-8">
                    <h1 class="tw-text-4xl tw-font-bold tw-text-white tw-tracking-wide">Payment</h1>
                    <div class="tw-hidden md:tw-flex tw-items-center">
                        <img src="../assets/Review.png" alt="" class="tw-w-6 tw-h-6 tw-mr-2">
                        <a href="payment_history_admin.php" class="tw-text-white tw-font-bold tw-underline tw-text-lg hover:tw-text-gray-200">Payment History</a>
                    </div>
                </div>

                <!-- Payment Form -->
                <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <label for="" class="mt-3 tw-text-xl">Fullname</label>
                    <input
                        type="text"
                        class="form-control tw-w-full tw-px-4 tw-py-3 tw-rounded-lg tw-bg-gray-100 tw-text-black focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-green-400"
                        placeholder="Type here..."
                        name="walk_in_name">

                    <label for="" class="mt-3 tw-text-xl">Payment for</label>
                    <div class="tw-flex tw-items-center tw-gap-4">
                        <input
                            type="text"
                            class="form-control tw-w-full tw-px-4 tw-py-3 tw-rounded-lg tw-bg-gray-100 tw-text-black"
                            value="Walk In" disabled>
                        <button
                            class="tw-bg-[#00e69d] tw-text-black tw-font-bold tw-py-2 tw-px-4 tw-rounded-lg tw-transition-all hover:tw-bg-[#00FFAE]"
                            type="submit"
                            name="walk_in_submit">
                            Confirm
                        </button>
                    </div>
                </form>
            </div>

            <!-- Image Section -->
            <div class="tw-w-full md:tw-w-1/2 tw-flex tw-items-center tw-justify-center tw-mt-10 md:tw-mt-0">
                <img src="../assets/logo.jpg" alt="Logo">
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>