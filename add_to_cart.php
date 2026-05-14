<?php
session_start();
include "db.php";

$id    = $_POST['product_id'];
$name  = $_POST['product_name'];
$price = $_POST['product_price'];

$sessionId = session_id();

   //LOGGED‑IN USER
   
if (isset($_SESSION['user_id'])) {

    $user_id = $_SESSION['user_id'];

    $check = $conn->query(
        "SELECT id, quantity 
         FROM cart 
         WHERE user_id = $user_id 
         AND product_id = $id"
    );

    if ($check->num_rows > 0) {
        // Update quantity
        $conn->query(
            "UPDATE cart 
             SET quantity = quantity + 1 
             WHERE user_id = $user_id 
             AND product_id = $id"
        );
    } else {
        // Insert new product
        $conn->query(
            "INSERT INTO cart 
            (user_id, session_id, product_id, product_name, product_price, quantity)
            VALUES ($user_id, NULL, $id, '$name', $price, 1)"
        );
    }

 //  GUEST USER
   
} else {

    $check = $conn->query(
        "SELECT id, quantity 
         FROM cart 
         WHERE session_id = '$sessionId' 
         AND product_id = $id"
    );

    if ($check->num_rows > 0) {
        // Update quantity
        $conn->query(
            "UPDATE cart 
             SET quantity = quantity + 1 
             WHERE session_id = '$sessionId' 
             AND product_id = $id"
        );
    } else {
        // Insert new guest cart item
        $conn->query(
            "INSERT INTO cart
            (user_id, session_id, product_id, product_name, product_price, quantity)
            VALUES (NULL, '$sessionId', $id, '$name', $price, 1)"
        );
    }
}

header("Location: index.php");
exit;
?>