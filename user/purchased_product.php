<?php
include 'data_queries/config.php';
session_start();

if (isset($_SESSION['users_account_id'])) {
    $users_account_id = $_SESSION['users_account_id'];

    $sql = "SELECT users_account_id,reference_number ,product_name, product_qty, price, product_total, date_issued FROM product_sales WHERE users_account_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $users_account_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetching all rows
    if ($result->num_rows > 0) {
        // Store the result in the session (if needed)
        $_SESSION['product_sales'] = [];
        while ($row = $result->fetch_assoc()) {
            $_SESSION['product_sales'][] = $row;
        }
    } else {
        echo "No records found for this user.";
    }

    $stmt->close();
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
<?php include 'navigation.php'; ?>

<body class="bg-black">
    <div class="d-flex align-items-center justify-content-start tw-mt-40 mx-4">
        <h1 class="tw-text-3xl tw-font-bold tw-text-white tw-mb-3">Payment history</h1>
    </div>

    <div class="tw-flex tw-flex-col tw-items-center tw-justify-center  tw-px-4 container md:tw-mt-0  tw-mt-40">


        <!-- Table Container -->
        <div class="tw-overflow-x-auto tw-w-full">
            <div class="table-responsive tw-overflow-auto tw-h-[400px] tw-scrollbar-thin tw-scrollbar-thumb-gray-400 tw-scrollbar-track-gray-200">
                <table class="table table-dark tw-w-full" id="dataTable">
                    <tr>
                        <th scope="col">Reference </th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Product Quantity</th>
                        <th scope="col">Price</th>
                        <th scope="col">Total Payment</th>
                        <th scope="col">Date Issued</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($_SESSION['product_sales'])): ?>
                            <?php foreach ($_SESSION['product_sales'] as $row): ?>
                                <tr>
                                    <!-- Reference Number -->
                                    <td class="tw-text-[#1a8cff]">
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#modal<?php echo $row['reference_number']; ?>">
                                            <?php echo htmlspecialchars($row['reference_number']); ?>
                                        </button>
                                    </td>

                                    <!-- Product Name -->
                                    <td class="tw-text-[#1a8cff]"><?php echo htmlspecialchars($row['product_name']); ?></td>

                                    <!-- Product Quantity -->
                                    <td class="tw-text-[#1a8cff]"><?php echo htmlspecialchars($row['product_qty']); ?></td>

                                    <!-- Price -->
                                    <td class="tw-text-[#1a8cff]">₱<?php echo htmlspecialchars($row['price']); ?></td>

                                    <!-- Total Payment -->
                                    <td class="tw-text-[#1a8cff]">₱<?php echo htmlspecialchars($row['product_total']); ?></td>

                                    <!-- Date Issued -->
                                    <td class="tw-text-[#1a8cff]"><?php echo htmlspecialchars($row['date_issued']); ?></td>
                                </tr>

                                <!-- Modal for each row -->
                                <div class="modal fade" id="modal<?php echo $row['reference_number']; ?>" tabindex="-1" aria-labelledby="modalLabel<?php echo $row['reference_number']; ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content tw-bg-black tw-text-white tw-rounded-lg">
                                            <!-- Modal content here -->
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="tw-text-center tw-text-white">No purchased products</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>

                </table>
            </div>
        </div>

        <!--Bootstrap JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>


</body>

</html>