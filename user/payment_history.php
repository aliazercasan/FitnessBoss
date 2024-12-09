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
    <title>Payment History</title>
    <link rel="icon" href="../assets/logo.jpg" type="image/x-icon">

    <!--CSS SHEET-->
    <link rel="stylesheet" href="style.css" />
    <!--Google Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Black+Ops+One&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ultra&display=swap"
        rel="stylesheet" />

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

<body class="bg-black">



    <?php
    include 'data_queries/config.php';
    include 'navigation.php';


    if (isset($_SESSION['users_account_id'])) {
        $sql = "SELECT * FROM payment_history_user WHERE users_account_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $_SESSION['users_account_id']);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $result = null;
    }


    ?>


    <div class="d-flex align-items-center justify-content-start tw-mt-40 mx-4">
        <h1 class="tw-text-3xl tw-font-bold tw-text-white tw-mb-3">Payment history</h1>
    </div>

    <div class="tw-flex tw-flex-col tw-items-center tw-justify-center  tw-px-4 container md:tw-mt-0  tw-mt-40">
        <!-- Search Bar -->
        <div class="tw-w-full tw-mb-4 tw-flex tw-justify-center">
            <input type="text" id="searchBar" class="form-control tw-w-full md:tw-w-1/2 tw-p-2 tw-border tw-border-gray-300 tw-rounded-lg" placeholder="Search by Account ID or Name">
        </div>

        <!-- Table Container -->
        <div class="tw-overflow-x-auto tw-w-full">
            <table class="table table-dark tw-w-full" id="dataTable">
                <thead>
                    <tr>
                        <th scope="col">Receipt ID</th>
                        <th scope="col">Cashier Name</th>
                        <th scope="col">Reference Number</th>
                        <th scope="col">Date Expiration</th>
                        <th scope="col">Session or Monthly</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Payment Issued</th>



                    </tr>
                </thead>
                <tbody>
                    <!-- PHP loop to generate table rows and modals -->
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <!-- Receipt ID -->
                            <td class="tw-text-[#1a8cff]">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#modal<?php echo $row['receipt_id']; ?>">
                                    <?php echo htmlspecialchars($row['receipt_id']); ?>
                                </button>
                            </td>

                            <!-- Admin Name -->
                            <td class="tw-text-[#1a8cff]">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#modal<?php echo $row['receipt_id']; ?>">
                                    <?php echo htmlspecialchars($row['admin_name']); ?>
                                </button>
                            </td>

                            <!-- Reference Number -->
                            <td class="tw-text-[#1a8cff]">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#modal<?php echo $row['receipt_id']; ?>">
                                    <?php echo htmlspecialchars($row['reference_number']); ?>
                                </button>
                            </td>



                            <!-- Date Expiration -->
                            <td class="tw-text-[#1a8cff]">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#modal<?php echo $row['receipt_id']; ?>">
                                    <?php echo htmlspecialchars($row['date_expiration']); ?>
                                </button>
                            </td>

                            <!-- Category -->
                            <td class="tw-text-[#1a8cff]">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#modal<?php echo $row['receipt_id']; ?>">
                                    <?php if ($row['category'] === 'session') { ?>
                                        <span class="tw-text-[#00FFAE]">session</span>
                                    <?php } else { ?>
                                        <span class="tw-text-[#EA3EF7]">monthly</span>
                                    <?php } ?>
                                </button>
                            </td>

                            <!-- Amount -->
                            <td class="tw-text-[#1a8cff]">
                                <button type="button" data-bs-toggle=" modal" data-bs-target="#modal<?php echo $row['receipt_id']; ?>">
                                    <?php echo htmlspecialchars($row['amount']); ?>
                                </button>
                            </td>


                            <!-- Date Issued -->
                            <td class="tw-text-[#1a8cff]">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#modal<?php echo $row['receipt_id']; ?>">
                                    <?php echo htmlspecialchars($row['payment_created']); ?>
                                </button>
                            </td>
                        </tr>

                        <!-- Modal for each row -->
                        <div class="modal fade" id="modal<?php echo $row['receipt_id']; ?>" tabindex="-1" aria-labelledby="modalLabel<?php echo $row['receipt_id']; ?>" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content tw-bg-black tw-text-white tw-rounded-lg">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h1 class="modal-title tw-w-full tw-text-3xl tw-font-bold">
                                            <div class="tw-flex">
                                                <img src="../assets/minilogo.png" alt="" width="50">
                                                <span class="tw-text-[#00FFAE]">Fitness</span><span class="tw-text-[#EA3EF7]">Boss</span>
                                            </div>
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <!-- Modal Body -->
                                    <div class="modal-body">
                                        <h2 class="tw-text-center tw-text-md">Roxas Ext., San Antonio Village, Digos City</h2>
                                        <hr class="tw-border-[#00FFAE] tw-my-4">

                                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                            <!-- Row 1: Reference No. and Cashier Name -->
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="reference_no" class="tw-text-white">Reference No.</label>
                                                        <input type="text" id="reference_no" class="form-control tw-bg-gray-800 tw-text-white"
                                                            disabled placeholder="<?php echo htmlspecialchars($row['reference_number']); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="cashier_name" class="tw-text-white">Cashier Name</label>
                                                        <input type="text" id="cashier_name" class="form-control tw-bg-gray-800 tw-text-white"
                                                            disabled placeholder="<?php echo htmlspecialchars($row['admin_name']); ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Row 2: Amount, Date Expiration, and Category -->
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="amount" class="tw-text-white">Amount</label>
                                                        <input type="text" id="amount" class="form-control tw-bg-gray-800 tw-text-white"
                                                            disabled placeholder="₱<?php echo htmlspecialchars($row['amount']); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="date_expiration" class="tw-text-white">Date Expiration</label>
                                                        <input type="text" id="date_expiration" class="form-control tw-bg-gray-800 tw-text-white"
                                                            disabled placeholder="<?php echo htmlspecialchars($row['date_expiration']); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="category" class="tw-text-white">Monthly or Session</label>
                                                        <input type="text" id="category" class="form-control tw-bg-gray-800 tw-text-white"
                                                            disabled placeholder="<?php echo htmlspecialchars($row['category']); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                        <!-- Thank You Note -->
                                        <div class="text-center mt-5 tw-text-sm">
                                            <p>Thank you for your payment! Stay fit and healthy!</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php } ?>
                </tbody>

            </table>
        </div>
    </div>


    <footer class="footer tw-text-center tw-text-slate-500 tw-mt-5 tw-mb-5 tw-fixed tw-bottom-0 tw-w-full">
        <div>
            <h1>&copy; 2024 Visionary Creatives X Fitness Boss. All Rights Reserved.</h1>
        </div>
    </footer>


    <!--Bootstrap JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <!-- Search Functionality -->
    <script>
        document.getElementById('searchBar').addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            const rows = document.querySelectorAll('#dataTable tbody tr');

            rows.forEach(row => {
                const accountId = row.cells[0].textContent.toLowerCase();
                const name = row.cells[1].textContent.toLowerCase();

                if (accountId.includes(filter) || name.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>