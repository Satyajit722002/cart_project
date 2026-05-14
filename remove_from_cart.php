<?php
session_start();
include "db.php";

$cart_id = $_POST['cart_id'];
$sessionId = session_id();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $conn->query(
        "DELETE FROM cart WHERE id=$cart_id AND user_id=$user_id"
    );
} else {
    //  Guest cart support
    $conn->query(
        "DELETE FROM cart WHERE id=$cart_id AND session_id='$sessionId'"
    );
}

header("Location: cart.php");
exit;
?>
