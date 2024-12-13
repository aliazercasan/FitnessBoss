<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../../login.php");
    exit();
}

include 'data_queries/products_sales_query.php';

// Fetch product names for the dropdown
$dropdownSql = "SELECT product_name FROM products";
$dropdownResult = $conn->query($dropdownSql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Product Sales</title>
    <link rel="icon" href="../assets/logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="style.css" />
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

<body class="bg-black lg:tw-p-5 md:tw-p-3 tw-p-0 tw-min-h-screen tw-overflow-hidden">
    <?php include 'header.php' ?>

    <div class="container-fluid tw-flex tw-flex-col">
        <div class="d-flex align-items-center justify-content-start tw-mt-20">
            <a href="dashboard-admin.php" class="tw-text-[#EA3EF7] tw-text-3xl tw-mb-3 me-3"><i class="bi bi-arrow-90deg-left"></i></a>
            <img src="../assets/Total Sales.png" alt="">
            <a href="product_sales.php">
                <a href="product_sales.php"><h1 class="tw-text-3xl tw-font-bold tw-text-white tw-mb-3 ms-1">Product Sales Report</h1></a>
            </a>
        </div>
        <div class="tw-w-1/4 " style="margin-left: 140px; margin-bottom: 20px;">
            <a href="sales_report.php" class="tw-text-black tw-font-bold py-1 px-2 tw-rounded tw-bg-[#00e69d] hover:tw-bg-[#00FFAE]">Services Sales</a>
        </div>

        <div class="row tw-mx-auto tw-max-w-7xl tw-w-full">
            <div class="tw-w-full tw-mb-4 tw-flex tw-justify-between">

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



                <div class="dropdown tw-flex tw-items-center text-white">
                    <p class="me-2 tw-font-semibold">Category</p>
                    <button class="dropdown-toggle tw-text-black tw-font-semibold py-1 px-2 tw-rounded tw-bg-[#EA3EF7]" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Overall
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item filter-product" data-product="all" href="#">All Products</a></li>
                        <?php if ($dropdownResult && $dropdownResult->num_rows > 0): ?>
                            <?php while ($row = $dropdownResult->fetch_assoc()): ?>
                                <li><a class="dropdown-item filter-product" data-product="<?php echo htmlspecialchars($row['product_name']); ?>" href="#"><?php echo htmlspecialchars($row['product_name']); ?></a></li>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <li><a class="dropdown-item" href="#">No Products Available</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>



            <div class="col-12 tw-my-5">
                <div class="table-responsive">
                    <div class="tw-overflow-x-auto tw-max-h-96">
                        <table class="table table-dark tw-w-full" id="dataTable">
                            <thead>
                                <tr>
                                    <th>Account ID</th>
                                    <th>Name</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Product Quantity</th>
                                    <th>Total</th>
                                    <th>Payment Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()) { ?>
                                    <tr data-product="<?php echo htmlspecialchars($row['product_name']); ?>">
                                        <td><?php echo htmlspecialchars($row['users_account_id']); ?></td>
                                        <td><?php echo htmlspecialchars($row['fullname']); ?></td>
                                        <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                                        <td>₱<?php echo htmlspecialchars($row['price']); ?></td>
                                        <td><?php echo htmlspecialchars($row['product_qty']); ?></td>
                                        <td>₱<?php echo htmlspecialchars($row['product_total']); ?></td>
                                        <td><?php echo htmlspecialchars($row['date_issued']); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                    $sql = "SELECT SUM(product_total) as total_product_sale FROM product_sales";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $total = 0;

                    if ($row = $result->fetch_assoc()) {
                        $total = '₱' . number_format($row['total_product_sale'], 2);
                    }
                    ?>
                    <div class="tw-bg-white tw-text-black tw-py-2 tw-px-4 tw-rounded mt-2">
                        <h1>Total Sales: <span id="totalSalesDisplay"><?php echo htmlspecialchars($total) ?></span></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer tw-text-slate-500 text-center tw-mt-10">
        <h1>&copy; 2024 Visionary Creatives X Fitness Boss. All Rights Reserved.</h1>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
$stmt->close();
$conn->close();
?>