<?php
session_start();
include('config.php'); // Database connection

// Check if product_id is present in the URL
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Fetch product details from database
    $query = "SELECT * FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // If product is found, fetch data
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "<p>Product not found.</p>";
        exit;
    }
} else {
    echo "<p>No product ID provided.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
                .product-details {
            margin-top: 30px;
        }
        .product-image {
            max-width: 100%;
            height: auto;
        }
        .btn-custom {
            background-color: #28a745;
            color: white;
        }
        .btn-custom:hover {
            background-color: #218838;
        }
    </style>
    <link rel="stylesheet" href="pureveda.css">
    
</head>
<body>

<!-- Navbar -->


                          
<!-- Product Details -->
<div class="container product-details">
    <div class="row">
        <div class="col-md-6">
            <img src="<?php echo $product['image']; ?>" class="product-image" alt="Product Image">
        </div>
        <div class="col-md-6">
            <h2><?php echo $product['name']; ?></h2>
            <p><?php echo $product['description']; ?></p>
            <h4>Price: $<?php echo number_format($product['price'], 2); ?></h4>
            <button class="btn btn-custom" id="add-to-cart">Add to Cart</button>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3">
    <p>&copy; 2025 PureVeda Cosmetics</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

<!-- Add to Cart Button Script -->
<script>
    document.getElementById('add-to-cart').addEventListener('click', function() {
        alert('Product added to cart!');
        // You can add functionality to add the product to the session cart here
    });
</script>
</body>
</html>
