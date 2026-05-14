<?php
session_start();
include "db.php";

$cart_id = $_POST['cart_id'];
$type    = $_POST['type'];
$sessionId = session_id();

if (isset($_SESSION['user_id'])) {
    // Logged‑in user
    $condition = "id=$cart_id AND user_id={$_SESSION['user_id']}";
} else {
    // Guest user
    $condition = "id=$cart_id AND session_id='$sessionId'";
}

if ($type == 'plus') {
    $conn->query(
        "UPDATE cart 
         SET quantity = quantity + 1 
         WHERE $condition"
    );
}

if ($type == 'minus') {
    $conn->query(
        "UPDATE cart 
         SET quantity = quantity - 1 
         WHERE $condition AND quantity > 1"
    );
}

header("Location: cart.php");
exit;
?>
