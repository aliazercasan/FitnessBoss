<?php
include('data_queries/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit_product') {
    $product_name = $_POST['product_name'];
    $product_stocks = $_POST['product_stocks'];
    $product_price = $_POST['product_price'];

    $sql = "UPDATE products SET product_stocks = ?, product_price = ? WHERE product_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ids", $product_stocks, $product_price, $product_name);

    if ($stmt->execute()) {
        header("Location: dashboard.php"); // Redirect back to the dashboard
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form id="editProductForm" method="POST" action="edit_product.php">
    <input type="hidden" name="action" value="edit_product">
    <input type="hidden" name="product_name" id="editProductId">
    <div class="mb-3">
        <label for="editProductStocks" class="form-label">Stocks</label>
        <input type="number" class="form-control" name="product_stocks" id="editProductStocks" required placeholder="Stocks">
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

</body>
</html>