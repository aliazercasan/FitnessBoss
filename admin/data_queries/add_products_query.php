<?php
include 'config.php';

// Set timezone to Asia/Manila
date_default_timezone_set('Asia/Manila');

// Generate current date in 'Y-m-d' format
$current_date = new DateTime('now');
$date_now = $current_date->format('Y-m-d');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $product_name = trim($_POST['product_name']);
    $product_stocks = trim($_POST['product_stocks']);
    $product_price = trim($_POST['product_price']);

    // Validate input data
    if (empty($product_name) || empty($product_price)) {
        header("Location: dashboard-admin.php?status=error&message=" . urlencode("Product name and price are required."));
        exit();
    }

    if (!is_numeric($product_price) || $product_price <= 0) {
        header("Location: dashboard-admin.php?status=error&message=" . urlencode("Invalid product price."));
        exit();
    }

    // Handle image upload
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $image_tmp_name = $_FILES['product_image']['tmp_name'];
        $image_name = $_FILES['product_image']['name'];
        $image_size = $_FILES['product_image']['size'];
        $image_type = mime_content_type($image_tmp_name);

        // Validate file type and size
        if (!in_array($image_type, $allowed_types)) {
            header("Location: dashboard-admin.php?status=error&message=" . urlencode("Invalid image type. Only JPG, PNG, and GIF are allowed."));
            exit();
        }

        if ($image_size > 2 * 1024 * 1024) { // Limit to 2MB
            header("Location: dashboard-admin.php?status=error&message=" . urlencode("Image size exceeds 2MB."));
            exit();
        }

        // Read the image content
        $image_content = file_get_contents($image_tmp_name);

        // Insert into database using prepared statements
        $stmt = $conn->prepare("INSERT INTO products (picture, product_name, product_stocks, product_price, product_listed) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('ssiis', $image_content, $product_name, $product_stocks, $product_price, $date_now);

        if ($stmt->execute()) {
            // Redirect with success status
            echo "<script>alert('Added product successfully')</script>";
            exit();
        } else {
            // Redirect with database error
            header("Location: dashboard-admin.php?status=error&message=" . urlencode("Database error: " . $stmt->error));
            exit();
        }

        $stmt->close();
    } else {
        // File upload error
        $error_message = match ($_FILES['product_image']['error']) {
            UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => "File size exceeds the limit.",
            UPLOAD_ERR_PARTIAL => "File was only partially uploaded.",
            UPLOAD_ERR_NO_FILE => "No file was uploaded.",
            default => "Unknown file upload error."
        };
        header("Location: dashboard-admin.php?status=error&message=" . urlencode($error_message));
        exit();
    }
}

$conn->close();
?>
