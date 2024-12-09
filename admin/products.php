<?php
session_start();
include('data_queries/config.php');
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}

// Set timezone to Asia/Manila
date_default_timezone_set('Asia/Manila');

// Generate current date in 'Y-m-d' format
$current_date = new DateTime('now');
$date_now = $current_date->format('Y-m-d');
$fullname = "";
// Fetch products from the database
$sql = "SELECT picture, product_name,product_stocks ,product_price FROM products";
$result = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmorder'])) {
    $customer_id = $_POST['customer_id'];
    $selected_products = $_POST['selected_products'] ?? [];
    $quantities = $_POST['quantities'] ?? [];
    $product_prices = $_POST['product_prices'] ?? [];

    // Check if customer exists
    $sql = "SELECT users_account_id, fullname FROM payment_history WHERE users_account_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $customer_result = $stmt->get_result();

    if ($customer_result->num_rows > 0) {
        $customer = $customer_result->fetch_assoc();
        $users_account_id = $customer['users_account_id'];
        $fullname = $customer['fullname'];

        if (!empty($selected_products)) {
            foreach ($selected_products as $index => $product_name) {
                // Get the quantity and price for the product
                $quantity = isset($quantities[$index]) ? (int)$quantities[$index] : 0;
                $price = isset($product_prices[$index]) ? (float)$product_prices[$index] : 0;

                if ($quantity > 0 && $price > 0) {
                    // Calculate total price
                    $total_price = $quantity * $price;

                    // Insert into `product_sales` table
                    $sql_product = "INSERT INTO product_sales 
                        (users_account_id, fullname, product_name, product_qty, price, product_total, date_issued)
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
                    $stmt_product = $conn->prepare($sql_product);
                    $stmt_product->bind_param("issiids", $users_account_id, $fullname, $product_name, $quantity, $price, $total_price, $date_now);

                    if ($stmt_product->execute()) {
                        // Update product stock
                        $sql_update_stock = "UPDATE products SET product_stocks = product_stocks - ? WHERE product_name = ?";
                        $stmt_update_stock = $conn->prepare($sql_update_stock);
                        $stmt_update_stock->bind_param("is", $quantity, $product_name);

                        if ($stmt_update_stock->execute()) {
                            echo "<script>alert('" . $fullname . " is purchasing the products.');</script>";
                        } else {
                            echo "Failed to update stock for '$product_name': " . $conn->error . "<br>";
                        }
                    } else {
                        echo "Failed to save order for '$product_name': " . $conn->error . "<br>";
                    }
                } else {
                    echo "Invalid quantity or price for product: '$product_name'.<br>";
                }
            }
        } else {
            echo "No products selected.";
        }
    } else {
        echo "No products selected.";
    }
} else {
    echo "Customer not found.";
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Administrator Dashboard</title>
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


    <div class="container mt-5 text-white">
        <h1 class="text-center mb-4">Product List</h1>
        <form id="productForm" method="POST" action="">
            <div class="card">
                <div class="card-header">
                    <h4>Products</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Select</th>
                                    <th>Image</th>
                                    <th>Product Name</th>
                                    <th>Stocks</th>
                                    <th>Price</th>
                                    <th>Quantity</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result && $result->num_rows > 0): ?>
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="product-checkbox" name="selected_products[]"
                                                    value="<?php echo htmlspecialchars($row['product_name']); ?>"
                                                    data-name="<?php echo htmlspecialchars($row['product_name']); ?>"
                                                    data-price="<?php echo $row['product_price']; ?>"
                                                    data-picture="<?php echo base64_encode($row['picture']); ?>">
                                            </td>
                                            <td>
                                                <img src="data:image/jpeg;base64,<?php echo base64_encode($row['picture']); ?>"
                                                    alt="Product Image" style="width: 50px; height: 50px;">
                                            </td>
                                            <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['product_stocks']); ?></td>
                                            <td>₱<?php echo htmlspecialchars(number_format($row['product_price'], 2)); ?></td>
                                            <td>
                                                <input type="number" class="form-control product-quantity" name="quantities[]"
                                                    min="1" placeholder="0">
                                            </td>

                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No products available.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-3">
                        <button type="button" id="submitBtn" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="productsModal" tabindex="-1" aria-labelledby="productsModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered text-black">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="productsModalLabel">Selected Products</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <ul id="modalProductList"></ul>
                            <input type="text" id="customerIdInput" class="form-control" placeholder="Customer ID"
                                required name="customer_id">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="confirmOrderBtn" class="btn btn-primary"
                                name="confirmorder">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('submitBtn').addEventListener('click', function() {
            const selectedProducts = document.querySelectorAll('.product-checkbox:checked');
            const productList = document.getElementById('modalProductList');
            const form = document.getElementById('productForm');
            productList.innerHTML = ''; // Clear the previous list

            if (selectedProducts.length > 0) {
                let valid = true; // Track if all selected products have valid quantities

                selectedProducts.forEach(product => {
                    const productName = product.getAttribute('data-name');
                    const productPrice = parseFloat(product.getAttribute('data-price'));
                    const productPicture = product.getAttribute('data-picture');
                    const productQuantityElement = product.closest('tr').querySelector('.product-quantity');
                    const productQuantity = parseFloat(productQuantityElement.value);

                    if (!productQuantity || productQuantity <= 0) {
                        valid = false;
                        alert(`Please enter a valid quantity for ${productName}.`);
                        productQuantityElement.focus();
                        return;
                    }

                    const productTotal = productPrice * productQuantity;

                    // Display in modal
                    const productContainer = document.createElement('div');
                    productContainer.classList.add('d-flex', 'align-items-center', 'mb-3');

                    const productImage = document.createElement('img');
                    productImage.src = `data:image/jpeg;base64,${productPicture}`;
                    productImage.alt = productName;
                    productImage.style.width = '100px';
                    productImage.style.height = '100px';
                    productImage.style.marginRight = '10px';

                    const productDetails = document.createElement('div');
                    productDetails.textContent =
                        `${productName} - ₱${productPrice.toFixed(2)} x ${productQuantity} = ₱${productTotal.toFixed(2)}`;

                    productContainer.appendChild(productImage);
                    productContainer.appendChild(productDetails);
                    productList.appendChild(productContainer);

                    // Add hidden input for product price
                    const productPriceInput = document.createElement('input');
                    productPriceInput.type = 'hidden';
                    productPriceInput.name = 'product_prices[]';
                    productPriceInput.value = productPrice;
                    form.appendChild(productPriceInput);

                    // Add hidden input for product quantity
                    const productQuantityInput = document.createElement('input');
                    productQuantityInput.type = 'hidden';
                    productQuantityInput.name = 'quantities[]';
                    productQuantityInput.value = productQuantity;
                    form.appendChild(productQuantityInput);
                });

                if (valid) {
                    const modal = new bootstrap.Modal(document.getElementById('productsModal'));
                    modal.show();
                }
            } else {
                alert('Please select at least one product.');
            }
        });
    </script>


    <!--Bootstrap JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>
<?php $conn->close(); ?>