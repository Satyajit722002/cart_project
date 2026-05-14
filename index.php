<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
</head>
<body>

<h2>Products</h2>

<form method="POST" action="add_to_cart.php">
    Shirt price : ₹500
    <input type="hidden" name="product_id" value="1">
    <input type="hidden" name="product_name" value="Shirt">
    <input type="hidden" name="product_price" value="500">
    <button name="add">Add</button>
</form><br>

<form method="POST" action="add_to_cart.php">
    Shoes price : ₹1500
    <input type="hidden" name="product_id" value="2">
    <input type="hidden" name="product_name" value="Shoes">
    <input type="hidden" name="product_price" value="1500">
    <button name="add">Add</button>
</form><br>

<form method="POST" action="add_to_cart.php">
    Watch price : ₹5000
    <input type="hidden" name="product_id" value="3">
    <input type="hidden" name="product_name" value="Watch">
    <input type="hidden" name="product_price" value="5000">
    <button name="add">Add</button>
</form><br>

<form method="POST" action="add_to_cart.php">
    Bag price : ₹2000
    <input type="hidden" name="product_id" value="4">
    <input type="hidden" name="product_name" value="Bag">
    <input type="hidden" name="product_price" value="2000">
    <button name="add">Add</button>
</form>

<hr>

<?php if (isset($_SESSION['user_id'])) { ?>
    <p>
        Welcome <?= $_SESSION['username'] ?> |
        <a href="logout.php">Logout</a>
    </p>
<?php } else { ?>
    <p>
        You are browsing as Guest |
       <a href= "login.php">Login to save cart</a> |
    </p>
<?php } ?>
``

<a href="cart.php">Go to Cart</a>


</body>
</html>