<?php
session_start();
include "db.php";

$sessionId = session_id();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $result = $conn->query(
        "SELECT * FROM cart WHERE user_id=$user_id"
    );
} else {
    $result = $conn->query(
        "SELECT * FROM cart WHERE session_id='$sessionId'"
    );
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Cart</title>
</head>
<body>

<h2>My Cart</h2>

<?php if (!isset($_SESSION['user_id'])): ?>
    <p>
        You are browsing as Guest |
        <a href="login.php">Login to save your cart</a>
    </p>
<?php endif; ?>

<?php if ($result->num_rows == 0): ?>
    <p>Your cart is empty.</p>
    <a href="index.php">Go Shopping</a>
<?php else: ?>

<table border="1" cellpadding="8">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Price</th>
    <th>Quantity</th>
    <th>Total</th>
    <th>Action</th>
</tr>

<?php 
$grandTotal = 0;

while ($row = $result->fetch_assoc()):
    $itemTotal = $row['product_price'] * $row['quantity'];
    $grandTotal += $itemTotal;
?>

<tr>
    <td><?= $row['product_id'] ?></td>
    <td><?= $row['product_name'] ?></td>
    <td>₹<?= $row['product_price'] ?></td>

    <td>
        <!-- Minus -->
        <form method="POST" action="update_quantity.php" style="display:inline;">
            <input type="hidden" name="cart_id" value="<?= $row['id'] ?>">
            <input type="hidden" name="type" value="minus">
            <button>-</button>
        </form>

        <?= $row['quantity'] ?>

        <!-- Plus -->
        <form method="POST" action="update_quantity.php" style="display:inline;">
            <input type="hidden" name="cart_id" value="<?= $row['id'] ?>">
            <input type="hidden" name="type" value="plus">
            <button>+</button>
        </form>
    </td>

    <td>₹<?= $itemTotal ?></td>

    <td>
        <form method="POST" action="remove_from_cart.php">
            <input type="hidden" name="cart_id" value="<?= $row['id'] ?>">
            <button>Remove</button>
        </form>
    </td>
</tr>

<?php endwhile; ?>

<tr>
    <td colspan="4"><b>Grand Total</b></td>
    <td colspan="2"><b>₹<?= $grandTotal ?></b></td>
</tr>

</table>

<?php endif; ?>

<br>
<a href="index.php">Back to Products</a>

</body>
</html>

<?php $conn->close(); ?>