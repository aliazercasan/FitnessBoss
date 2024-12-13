<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../../login.php");
    exit();
}

include 'data_queries/config.php'; // Ensure this file contains the DB connection

// Prepare the search query safely
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Prepare SQL query with placeholders for safe querying
$sql = "SELECT 
    users_account_id,
    fullname,
    reference_number,
    date_expiration,
    category,
    amount,
    payment_created
FROM payment_history 
WHERE (receipt_id LIKE ? OR reference_number LIKE ?)
  AND payment_created >= NOW() - INTERVAL 1 DAY

UNION ALL

SELECT 
    walk_in_id AS users_account_id,
     fullname,
    reference_number,
    date_expiration,
    category,
    amount,
    payment_created
FROM walk_in_users
  WHERE payment_created >= NOW() - INTERVAL 1 DAY;
";

// Prepare the statement
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('Error preparing the query: ' . $conn->error);
}

// Bind the parameters
$searchTerm = "%" . $search . "%";
$stmt->bind_param("ss", $searchTerm, $searchTerm);

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Administrator Dashboard</title>
    <link rel="icon" href="../assets/logo.jpg" type="image/x-icon">

    <!-- CSS SHEET -->
    <link rel="stylesheet" href="style.css" />
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Black+Ops+One&family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" />
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Tailwind Framework -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            prefix: "tw-",
        };
    </script>
</head>
<?php include 'header.php' ?>

<body class="bg-black lg:tw-p-5 md:tw-p-3 tw-p-0">
    <div class="container-fluid tw-min-h-screen tw-flex tw-flex-col mt-5">
        <div class="d-flex align-items-center justify-content-start tw-mt-20">
            <a href="dashboard-admin.php" class="tw-text-[#EA3EF7] tw-text-3xl tw-mb-3 me-3"><i class="bi bi-arrow-90deg-left"></i></a>
            <h1 class="tw-text-3xl tw-font-bold tw-text-white tw-mb-3">Payment History</h1>
        </div>

        <div class="row tw-mx-auto tw-max-w-7xl tw-w-full">
            <!-- Search Bar -->
            <div class="tw-w-full tw-mb-4 tw-flex tw-justify-between tw-items-center">
                <input type="text" id="searchBar" class="form-control tw-w-full md:tw-w-1/2 tw-p-2 tw-border tw-border-gray-300 tw-rounded-lg" placeholder="Account ID, or Name">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                       Services
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="product_payment_history.php">Products</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-12 tw-mx-auto tw-my-5">
                <div class="table-responsive">
                    <div class="tw-overflow-x-auto tw-max-h-96 tw-scrollbar-thin tw-scrollbar-thumb-gray-400 tw-scrollbar-track-gray-200">
                        <table class="table table-dark tw-w-full" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col" class="tw-w-1/12">Account ID</th>
                                    <th scope="col" class="tw-w-3/12">Name</th>
                                    <th scope="col" class="tw-w-2/12">Reference #</th>
                                    <th scope="col" class="tw-w-2/12">Expiration Date</th>
                                    <th scope="col" class="tw-w-1/12">Category</th>
                                    <th scope="col" class="tw-w-1/12">Amount</th>
                                    <th scope="col" class="tw-w-2/12">Date Issued</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td class="tw-text-[#1a8cff] tw-w-1/12"><?php echo htmlspecialchars($row['users_account_id']); ?></td>
                                        <td class="tw-text-[#1a8cff] tw-w-3/12"><?php echo htmlspecialchars($row['fullname']); ?></td>
                                        <td class="tw-text-[#1a8cff] tw-w-2/12"><?php echo htmlspecialchars($row['reference_number']); ?></td>
                                        <td class="tw-text-[#1a8cff] tw-w-2/12"><?php echo htmlspecialchars($row['date_expiration']); ?></td>
                                        <td class="tw-text-center">
                                            <?php if ($row['category'] == 'session') { ?>
                                                <span class="tw-text-[#00FFAE]">session</span>
                                            <?php } elseif ($row['category'] == 'monthly') { ?>
                                                <span class="tw-text-[#EA3EF7]">monthly</span>
                                            <?php } else { ?>
                                                <span class="tw-text-red-500">walk in</span>

                                            <?php } ?>
                                        </td>
                                        <td class="tw-text-[#00FFAE] tw-w-1/12"><?php echo htmlspecialchars($row['amount']); ?></td>
                                        <td class="tw-text-[#1a8cff] tw-w-2/12"><?php echo htmlspecialchars($row['payment_created']); ?></td>

                                    </tr>

                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer tw-text-slate-500 text-center tw-mt-10">
        <div>
            <h1>&copy; 2024 Visionary Creatives X Fitness Boss. All Rights Reserved.</h1>
        </div>
    </div>

    <!-- Search Bar Filtering -->
    <script>
        document.getElementById('searchBar').addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            const rows = document.querySelectorAll('#dataTable tbody tr');

            rows.forEach(row => {
                const receiptId = row.cells[0].textContent.toLowerCase();
                const accountId = row.cells[1].textContent.toLowerCase();
                const name = row.cells[2].textContent.toLowerCase();

                if (receiptId.includes(filter) || accountId.includes(filter) || name.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
// Close the statement and connection
$stmt->close();
$conn->close();
?>