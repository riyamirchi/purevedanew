<?php
// Fetch all products from the database
$result = $conn->query("SELECT * FROM products");

if ($result->num_rows > 0) {
    echo '<table>';
    echo '<tr><th>Product</th><th>Price</th><th>Action</th></tr>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['name']) . '</td>';
        echo '<td>' . $row['price'] . '</td>';
        echo '<td>';
        echo '<form action="add_to_cart.php" method="POST">';
        echo '<input type="hidden" name="product_id" value="' . $row['id'] . '">';
        echo '<input type="number" name="quantity" value="1" min="1">';
        echo '<button type="submit">Add to Cart</button>';
        echo '</form>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo "No products found.";
}
?>
