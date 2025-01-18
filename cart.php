<?php
session_start();
include('config.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Error: User not logged in. Please log in to view your cart.");
}

$user_id = $_SESSION['user_id'];

// Validation: Ensure user_id is an integer
if (!is_numeric($user_id)) {
    die("Error: Invalid user ID.");
}

// Fetch cart items
$query = "SELECT  cart_id AS cart_id, p.name, p.price, c.quantity 
          FROM cart c 
          INNER JOIN products p ON c.product_id = p.id 
          WHERE c.user_id = ?";
$stmt = $conn->prepare($query);

if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}

// Bind the parameter
$stmt->bind_param("i", $user_id);

// Execute the query
if (!$stmt->execute()) {
    die("Error executing query: " . $stmt->error);
}

$result = $stmt->get_result();

// HTML starts here
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        form {
            display: inline;
        }
        button {
            padding: 5px 10px;
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h1>Your Cart</h1>
    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
            <?php 
            $grand_total = 0;
            while ($row = $result->fetch_assoc()): 
                // Validation for fetched data
                $product_name = htmlspecialchars($row['name']); // Prevent XSS
                $price = is_numeric($row['price']) ? $row['price'] : 0; // Ensure price is numeric
                $quantity = is_numeric($row['quantity']) ? $row['quantity'] : 0; // Ensure quantity is numeric
                $total = $price * $quantity; // Calculate total
                $grand_total += $total;
            ?>
                <tr>
                    <td><?= $product_name; ?></td>
                    <td><?= number_format($price, 2); ?></td>
                    <td><?= $quantity; ?></td>
                    <td><?= number_format($total, 2); ?></td>
                    <td>
                        <!-- Update Quantity Form -->
                        <form action="update_cart.php" method="POST">
                            <input type="hidden" name="cart_id" value="<?= $row['cart_id']; ?>">
                            <input type="number" name="quantity" value="<?= $quantity; ?>" min="1" required>
                            <button type="submit">Update</button>
                        </form>
                        <!-- Remove Item Form -->
                        <form action="delete_from_cart.php" method="POST">
                            <input type="hidden" name="cart_id" value="<?= $row['cart_id']; ?>">
                            <button type="submit">Remove</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
            <tr>
                <td colspan="3"><strong>Grand Total</strong></td>
                <td colspan="2"><strong><?= number_format($grand_total, 2); ?></strong></td>
            </tr>
        </table>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
</body>
</html>
