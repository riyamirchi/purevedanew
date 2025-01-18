<?php
include('config.php'); // Database connection

// Fetch products from database
$query = "SELECT * FROM products";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PureVeda - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="pureveda.css">
</head>
<body>

<!-- Navbar -->
<?php
    include('nav.php');
?>

<!-- Product Cards -->
<div class="container my-4">
    <div class="row">
        <?php while ($product = $result->fetch_assoc()) { ?>
            <div class="col-md-3">
                <div class="card" style="width: 18rem;">
                    <img src="<?= $product['image']; ?>" class="card-img-top" alt="Product Image">
                    <div class="card-body">
                        <h5 class="card-title"><?= $product['name']; ?></h5>
                        <p class="card-text"><?= substr($product['description'], 0, 100); ?>...</p>
                        <h6>$<?= number_format($product['price'], 2); ?></h6>
                        <a href="product.php?product_id=<?= $product['product_id']; ?>" class="btn btn-primary">View Product</a>
                    </div>
                </div>
            </div>
        <?php }?>
    </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3">
    <p>&copy; 2025 PureVeda Cosmetics</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
