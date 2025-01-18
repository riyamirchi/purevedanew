<?php
session_start();
include('config.php'); // Database connection

// Only allow admin users to access this page
if ($_SESSION['role'] != 'admin') {
    header('Location: index.php'); // Redirect to homepage if not admin
    exit();
}

// Handle product addition
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category_id = $_POST['category_id'];
    $image_path = ''; // You would need to handle image upload properly

    if (isset($_FILES['image'])) {
        $image_name = $_FILES['image']['name'];
        $image_temp = $_FILES['image']['tmp_name'];
        $image_path = 'uploads/' . basename($image_name);
    
        move_uploaded_file($image_temp, $image_path); // Upload image to 'uploads' folder
    }
    

    // Insert product into database
    $query = "INSERT INTO products (name, description, price, stock, category_id, image) 
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssdiis", $name, $description, $price, $stock, $category_id, $image_path);
    if ($stmt->execute()) {
        echo "Product added successfully!";
    } else {
        echo "Error adding product.";
    }

    
    



    // Update query
    $query = "UPDATE products SET name = '$name', price = $price, description = '$description' WHERE id = $id";
    
    if ($conn->query($query) === TRUE) {
        echo "Product updated successfully.";
    } else {
        echo "Error updating product: " . $conn->error;
    }



    
      

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">PureVeda</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin_panel.php">Add Product</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </div>
</nav>

<!-- Add Product Form -->
<div class="container my-5">
    <h2>Add New Product</h2>
    <form action="admin_panel.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Product Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" required>
        </div>
        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" class="form-control" id="stock" name="stock" required>
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select class="form-select" id="category_id" name="category_id" required>
                <!-- Populate categories dynamically from database -->
                <?php
                $result = $conn->query("SELECT * FROM categories");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='".$row['category_id']."'>".$row['name']."</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Product Image</label>
            <input type="file" class="form-control" id="image" name="image" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Product</button>
    </form>

                                <!-- update_product_form.php -->
                            <?php
                            // Fetch product data based on the product ID passed in the query string
                            $id = $_GET['id']; // Ensure this comes from the Edit button
                            $result = $conn->query("SELECT * FROM products WHERE id = $id");
                            $product = $result->fetch_assoc();
                            ?>
                            <form action="update_product.php" method="POST">
                                <input type="hidden" name="id" value="<?php echo $product['id']; ?>"> <!-- Hidden field for ID -->
                                <label for="name">Product Name:</label>
                                <input type="text" name="name" value="<?php echo $product['name']; ?>" required>

                                <label for="price">Price:</label>
                                <input type="number" name="price" value="<?php echo $product['price']; ?>" required>

                                <label for="description">Description:</label>
                                <textarea name="description" required><?php echo $product['description']; ?></textarea>

                                <button type="submit">Update Product</button>
                            </form>

</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3">
    <p>&copy; 2025 PureVeda Cosmetics</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
