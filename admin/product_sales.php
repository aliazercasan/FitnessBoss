<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../../login.php");
    exit();
}

include 'data_queries/products_sales_query.php'
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
<!-- NAVIGATION -->
<?php include 'header.php' ?>
<?php include 'data_queries/products_sales_query.php' ?>


<body class="bg-black lg:tw-p-5 md:tw-p-3 tw-p-0 tw-min-h-screen tw-overflow-hidden">
    <div class="container-fluid  tw-flex tw-flex-col  ">
        <div class="d-flex align-items-center justify-content-start tw-mt-20">
            <a href="dashboard-admin.php" class="tw-text-[#EA3EF7] tw-text-3xl tw-mb-3 me-3"><i class="bi bi-arrow-90deg-left"></i></a>
            <img src="../assets/Total Sales.png" alt="">
            <h1 class="tw-text-3xl tw-font-bold tw-text-white tw-mb-3 ms-1">Product Sales Report</h1>

        </div>

        <div class="row tw-mx-auto tw-max-w-7xl tw-w-full">
            <!-- Search Bar -->
            <div class="tw-w-full tw-mb-4 tw-flex tw-justify-between ">
                <div class="dropdown" class="">
                    <button class=" dropdown-toggle w-text-black tw-font-semibold py-1 px-2 tw-rounded tw-transition tw-duration-300 ease-in-out tw-bg-[#00e69d]" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Over All
                    </button>
                 

                    <ul class="dropdown-menu bg-black">
                        <li><a class="dropdown-item" href="monthly_sales_report.php">Daily</a></li>
                        <li><a class="dropdown-item" href="session_sales_report.php">Monthly</a></li>
                    </ul>
                </div>

                <div class="dropdown">
                    <a class="w-text-black tw-font-semibold py-1 px-2 tw-rounded tw-transition tw-duration-300 ease-in-out tw-bg-[#00e69d]" href="#">
                        Product Sales
                    </a>
                </div>
            </div>

            <div class="col-12 col-md-12 col-lg-12 tw-mx-auto tw-my-5">
                <div class="table-responsive">
                    <div class="tw-overflow-x-auto tw-max-h-96 tw-scrollbar-thin tw-scrollbar-thumb-gray-400 tw-scrollbar-track-gray-200">
                        <table class="table table-dark tw-w-full" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col" class="tw-w-1/12">Account ID</th>
                                    <th scope="col" class="tw-w-2/12">Name</th>
                                    <th scope="col" class="tw-w-2/12">Product Name</th>
                                    <th scope="col" class="tw-w-2/12">Product Quantity</th>
                                    <th scope="col" class="tw-w-2/12">Price</th>
                                    <th scope="col" class="tw-w-2/12">Total</th>
                                    <th scope="col" class="tw-w-1/12">Payment Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td class="tw-text-blue-500 tw-text-center"><?php echo htmlspecialchars($row['users_account_id']); ?></td>
                                        <td class="tw-text-blue-500"><?php echo htmlspecialchars($row['fullname']); ?></td>
                                        <td class="tw-text-blue-500"><?php echo htmlspecialchars($row['product_name']); ?></td>
                                        <td class="tw-text-blue-500"><?php echo htmlspecialchars($row['product_qty']); ?></td>
                                        <td class="tw-text-blue-500"><?php echo htmlspecialchars($row['price']); ?></td>
                                        <td class="tw-text-blue-500"><?php echo htmlspecialchars($row['product_total']); ?></td>
                                        <td class="tw-text-blue-500"><?php echo htmlspecialchars($row['date_issued']); ?></td>

                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-white">
                        <?php
                        $sql = "SELECT SUM(product_total) as total_product_sale FROM product_sales";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $total = 0;

                        if ($row = $result->fetch_assoc()) {
                            $total = $row['total_product_sale'];
                        }
                        ?>

                        <div class="tw-bg-white tw-text-black tw-py-2 tw-px-4 tw-rounded mt-2">
                            <h1 class="">Total Sales: ₱<?php include 'data_queries/total_sales.php';
                                                        echo htmlspecialchars($total) ?></h1>
                        </div>
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