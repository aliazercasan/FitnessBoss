<?php
session_start();

// Include the database configuration file
include('data_queries/config.php');

// Set timezone to Asia/Manila
date_default_timezone_set('Asia/Manila');
$current_date = new DateTime('now');
$date_now = $current_date->format('Y-m-d');
$reference_number = sprintf("FNB-%03d-%03d-%03d", rand(100, 999), rand(100, 999), rand(100, 999));

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Edit product logic
    if (isset($_POST['action']) && $_POST['action'] === 'edit_product') {
        $product_name = $_POST['product_name'] ?? '';
        $product_stocks = intval($_POST['product_stocks'] ?? 0);
        $product_price = floatval($_POST['product_price'] ?? 0.0);

        if ($product_name && $product_stocks >= 0 && $product_price >= 0) {
            $sql = "UPDATE products SET product_stocks = ?, product_price = ? WHERE product_name = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ids", $product_stocks, $product_price, $product_name);

            if ($stmt->execute()) {

                echo"<script>alert('Stocks Updated')</script>";
            } else {
                die("Error updating product: " . $conn->error);
            }
        } else {
            die("Invalid product data.");
        }
    }

    // Confirm order logic
    if (isset($_POST['confirmorder'])) {
        $customer_id = $_POST['customer_id'];
        $selected_products = $_POST['selected_products'] ?? [];
        $quantities = $_POST['quantities'] ?? [];
        $product_prices = $_POST['product_prices'] ?? [];

        if (!empty($selected_products) && $customer_id > 0) {
            // Fetch customer details
            $stmt = $conn->prepare("SELECT users_account_id, fullname FROM payment_history WHERE users_account_id = ?");
            $stmt->bind_param("i", $customer_id);
            $stmt->execute();
            $customer_result = $stmt->get_result();

            if ($customer_result->num_rows > 0) {
                $customer = $customer_result->fetch_assoc();
                $users_account_id = $customer['users_account_id'];
                $fullname = $customer['fullname'];

                foreach ($selected_products as $index => $product_name) {
                    $quantity = intval($quantities[$index] ?? 0);
                    $price = floatval($product_prices[$index] ?? 0.0);

                    if ($quantity > 0 && $price > 0) {
                        $total_price = $quantity * $price;

                        // Insert into product_sales
                        $stmt_product = $conn->prepare("INSERT INTO product_sales 
                            (users_account_id, fullname, product_name, reference_number, product_qty, price, product_total, date_issued)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                        $stmt_product->bind_param("isssidds", $users_account_id, $fullname, $product_name, $reference_number, $quantity, $price, $total_price, $date_now);

                        if (!$stmt_product->execute()) {
                            die("Error inserting into product_sales: " . $conn->error);
                        }

                        // Update product stock
                        $orders_processed = false; // Track if any order is processed

                        foreach ($selected_products as $index => $product_name) {
                            $quantity = intval($quantities[$index] ?? 0);
                            $price = floatval($product_prices[$index] ?? 0.0);

                            if ($quantity > 0 && $price > 0) {
                                // Check product stock before updating
                                $stmt_check_stock = $conn->prepare("SELECT product_stocks FROM products WHERE product_name = ?");
                                $stmt_check_stock->bind_param("s", $product_name);
                                $stmt_check_stock->execute();
                                $result_check_stock = $stmt_check_stock->get_result();

                                if ($result_check_stock->num_rows > 0) {
                                    $product = $result_check_stock->fetch_assoc();
                                    $current_stock = intval($product['product_stocks']);

                                    if ($current_stock < $quantity) {
                                        echo "<script>alert('Insufficient stock for product: $product_name. Only $current_stock left.');</script>";
                                        continue; // Skip to the next product
                                    }
                                } else {
                                    echo "<script>alert('Product not found: $product_name.');</script>";
                                    continue; // Skip to the next product
                                }

                                $total_price = $quantity * $price;

                                // Insert into product_sales
                                $stmt_product = $conn->prepare("INSERT INTO product_sales 
                                    (users_account_id, fullname, product_name, reference_number, product_qty, price, product_total, date_issued)
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                                $stmt_product->bind_param("isssidds", $users_account_id, $fullname, $product_name, $reference_number, $quantity, $price, $total_price, $date_now);

                                if (!$stmt_product->execute()) {
                                    die("Error inserting into product_sales: " . $conn->error);
                                }

                                // Update product stock
                                $stmt_update_stock = $conn->prepare("UPDATE products SET product_stocks = product_stocks - ? WHERE product_name = ?");
                                $stmt_update_stock->bind_param("is", $quantity, $product_name);

                                if (!$stmt_update_stock->execute()) {
                                    die("Error updating product stock: " . $conn->error);
                                }

                                $orders_processed = true; // At least one order was processed
                            } else {
                                echo "Invalid quantity or price for product: $product_name.";
                            }
                        }

                        if ($orders_processed) {
                            echo "<script>alert('Order successfully added!'); window.location.href = 'products.php';</script>";
                        } else {
                            echo "<script>alert('No valid orders were placed.');</script>";
                        }
                    }
                }
            }
        }
    }
}

// Fetch products from the database
$sql = "SELECT picture, product_name, product_stocks, product_price FROM products";
$result = $conn->query($sql);

if (!$result) {
    die("Error fetching products: " . $conn->error);
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
<?php include 'header.php' ?>

<body class="bg-black">


    <div class="container mt-5 text-white">
        <h1 class="text-start mb-4 tw-mt-40 tw-text-3xl tw-font-bold">Product List</h1>
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
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result && $result->num_rows > 0): ?>
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                        <tr data-id="<?php echo $row['product_name']; ?>">
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
                                            <td>
                                                <button type="button" class="btn btn-warning btn-edit"
                                                    data-bs-toggle="modal" data-bs-target="#editProductModal"
                                                    data-id="<?php echo htmlspecialchars($row['product_name']); ?>"
                                                    data-name="<?php echo htmlspecialchars($row['product_name']); ?>"
                                                    data-stocks="<?php echo htmlspecialchars($row['product_stocks']); ?>"
                                                    data-price="<?php echo htmlspecialchars($row['product_price']); ?>">
                                                    Edit
                                                </button>
                                                <button type="button" class="btn btn-danger btn-delete"
                                                    data-id="<?php echo htmlspecialchars($row['product_name']); ?>">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No products available.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center mt-3">
                        <button type="button" id="submitBtn" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>

            <!-- Modal for Confirmation -->
            <div class="modal fade" id="productsModal" tabindex="-1" aria-labelledby="productsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered text-black">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="productsModalLabel">Confirm Order</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                            <div class="modal-body">
                                <div id="modalProductList"></div>
                                <input type="text" name="customer_id" placeholder="account Id" class="form-control">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" id="confirmOrderBtn" class="btn btn-primary" name="confirmorder">Confirm</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Edit Product Modal -->
            <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editProductForm" method="POST" action="">
                                <input type="hidden" name="action" value="edit_product">
                                <input type="hidden" name="product_name" id="editProductId">
                                <div class="mb-3">
                                    <label for="editProductStocks" class="form-label">Stocks</label>
                                    <input type="number" class="form-control" name="product_stocks" id="editProductStocks" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editProductPrice" class="form-label">Price</label>
                                    <input type="text" class="form-control" name="product_price" id="editProductPrice" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
            <script>
                // Handle Edit Button Click
                document.querySelectorAll('.btn-edit').forEach(button => {
                    button.addEventListener('click', () => {
                        const productName = button.getAttribute('data-name');
                        const productStocks = button.getAttribute('data-stocks');
                        const productPrice = button.getAttribute('data-price');

                        document.getElementById('editProductId').value = productName;
                        document.getElementById('editProductStocks').value = productStocks;
                        document.getElementById('editProductPrice').value = productPrice;
                    });
                });

                // Handle Delete Button Click
                document.querySelectorAll('.btn-delete').forEach(button => {
    button.addEventListener('click', () => {
        const productName = button.getAttribute('data-id');
        if (confirm(`Are you sure you want to delete the product "${productName}"?`)) {
            fetch('delete_product.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `action=delete_product&product_name=${productName}`
            })
            .then(response => response.text())
            .then(data => {
                if (data === 'success') {
                    alert('Product successfully deleted.');
                    location.reload();
                } else {
                    alert('Failed to delete product: ' + data);
                }
            })
            .catch(err => console.error('Error:', err));
        }
    });
});
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

                document.getElementById('confirmOrderBtn').addEventListener('click', function() {
                    document.getElementById('productForm').submit(); // Submit the form when the modal is confirmed
                });
            </script>


            <!--Bootstrap JS-->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
                crossorigin="anonymous"></script>
</body>

</html>
<?php $conn->close(); ?>