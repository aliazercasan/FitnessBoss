<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../../login.php");
    exit();
}

include 'data_queries/sales_report_query.php'
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

<body class="bg-black lg:tw-p-5 md:tw-p-3 tw-p-0 tw-min-h-screen tw-overflow-hidden">
    <div class="container-fluid  tw-flex tw-flex-col  ">
        <div class="d-flex align-items-center justify-content-start tw-mt-20">
            <a href="dashboard-admin.php" class="tw-text-[#EA3EF7] tw-text-3xl tw-mb-3 me-3"><i class="bi bi-arrow-90deg-left"></i></a>
            <img src="../assets/Total Sales.png" alt="">
            <h1 class="tw-text-3xl tw-font-bold tw-text-white tw-mb-3 ms-1">Services Sales Report</h1>

        </div>

        <div class="row tw-mx-auto tw-max-w-7xl tw-w-full">
            <div class="mb-3">
                <a class="tw-text-black tw-font-bold py-1 px-2 tw-rounded tw-transition tw-duration-300 ease-in-out tw-bg-[#00e69d] hover:tw-bg-[#00FFAE]" href="product_sales.php">Product Sales</a>
            </div>

            <div class="tw-w-full tw-mb-4 tw-flex tw-justify-between tw-items-center text-white">

                <!--DAILY SALES CALENDAR-->
                <div class="text-white tw-text-sm text-center">
                    <p class="tw-font-semibold">DAILY </p>
                    <input id="datepicker-format" type="date" class="tw-bg-gray-50 border tw-border-gray-300 tw-text-sm tw-rounded-lg px-2" placeholder="Select date" />
                </div>

                <!-- MONTHLY AND YEARLT SALES CALENDAR -->
                <div class="text-white tw-text-sm text-center">
                    <p class="tw-font-semibold">MONTHLY AND YEARLY</p>
                    <input id="monthpicker-format" type="month" class="tw-bg-gray-50 border tw-border-gray-300 tw-text-sm tw-rounded-lg px-2" placeholder="Select month" />
                </div>
               

                <div class="dropdown  tw-flex tw-items-center">
                    <p class="me-2 tw-font-semibold">Category</p>
                    <a class="tw-bg-[#EA3EF7] px-2 py-1 tw-rounded-lg tw-text-black dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Overall
                    </a>

                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="monthly_sales_report.php">Monthly</a></li>
                        <li><a class="dropdown-item" href="session_sales_report.php">Session</a></li>
                        <li><a class="dropdown-item" href="walk_in_sales.php">Walk in</a></li>


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
                                    <th scope="col" class="tw-w-2/12">Name</th>
                                    <th scope="col" class="tw-w-2/12">Reference #</th>
                                    <th scope="col" class="tw-w-2/12">Date Expiration</th>
                                    <th scope="col" class="tw-w-1/12">Category</th>
                                    <th scope="col" class="tw-w-1/12">Amount</th>
                                    <th scope="col" class="tw-w-1/12">Payment Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td class="tw-text-blue-500 tw-text-center"><?php echo htmlspecialchars($row['users_account_id']); ?></td>
                                        <td class="tw-text-blue-500"><?php echo htmlspecialchars($row['fullname']); ?></td>
                                        <td class="tw-text-blue-500"><?php echo htmlspecialchars($row['reference_number']); ?></td>
                                        <td class="tw-text-blue-500"><?php echo htmlspecialchars($row['date_expiration']); ?></td>
                                        <td class="tw-text-center">
                                            <?php if ($row['category'] == 'session') { ?>
                                                <span class="tw-text-[#00FFAE]">session</span>
                                            <?php } elseif ($row['category'] == 'monthly') { ?>
                                                <span class="tw-text-[#EA3EF7]">monthly</span>
                                            <?php } else { ?>
                                                <span class="tw-text-red-500">walk in</span>

                                            <?php } ?>
                                        </td>
                                        <td class="tw-text-green-500 tw-text-right">₱ <?php echo htmlspecialchars($row['amount']); ?></td>
                                        <td class="tw-text-blue-500"><?php echo htmlspecialchars($row['payment_created']); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tw-bg-white tw-text-black tw-py-2 tw-px-4 tw-rounded mt-2">
                    <h1 class="">Total SALES: ₱<?php include 'data_queries/total_sales.php';
                                                echo htmlspecialchars($row['total']) ?></h1>
                </div>
            </div>
        </div>
    </div>

    <div class="footer tw-text-slate-500 text-center tw-mt-10">
        <div>
            <h1>&copy; 2024 Visionary Creatives X Fitness Boss. All Rights Reserved.</h1>
        </div>
    </div>

    
    <script>
        // DAILY CALENDAR FUNCTION
        document.getElementById('datepicker-format').addEventListener('change', function() {
            const selectedDate = this.value;
            const rows = document.querySelectorAll('#dataTable tbody tr');
            let totalSales = 0;

            rows.forEach(row => {
                const paymentDate = row.cells[6].textContent.trim();
                const rowTotal = parseFloat(row.cells[5].textContent.replace('₱', '').replace(',', '')) || 0;

                if (paymentDate === selectedDate || !selectedDate) {
                    row.style.display = '';
                    totalSales += rowTotal;
                } else {
                    row.style.display = 'none';
                }
            });

            document.getElementById('totalSalesDisplay').textContent = `₱${totalSales.toLocaleString()}`;
        });

        document.querySelectorAll('.filter-product').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const selectedProduct = this.getAttribute('data-product');
                const rows = document.querySelectorAll('#dataTable tbody tr');

                rows.forEach(row => {
                    if (selectedProduct === 'all' || row.getAttribute('data-product') === selectedProduct) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });


        // YEARLY AND MONTHLY CALENDAR FUNCTION
        document.getElementById('monthpicker-format').addEventListener('change', function() {
            const selectedMonth = this.value; // Format: YYYY-MM
            const rows = document.querySelectorAll('#dataTable tbody tr');
            let totalSales = 0;

            rows.forEach(row => {
                const paymentDate = row.cells[6].textContent.trim().substring(0, 7); // Extract YYYY-MM
                const rowTotal = parseFloat(row.cells[5].textContent.replace('₱', '').replace(',', '')) || 0;

                if (paymentDate === selectedMonth || !selectedMonth) {
                    row.style.display = '';
                    totalSales += rowTotal;
                } else {
                    row.style.display = 'none';
                }
            });

            document.getElementById('totalSalesDisplay').textContent = `₱${totalSales.toLocaleString()}`;
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