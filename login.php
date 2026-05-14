<?php
session_start();
include 'db.php';

$error = "";

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $res = $conn->query(
        "SELECT * FROM users 
         WHERE username='$username' 
         AND password='$password'"
    );

    if ($res->num_rows == 1) {

        $row = $res->fetch_assoc();

        //  Set session
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];

        //  Merge guest cart into user cart
        $sessionId = session_id();
        $user_id   = $row['id'];

        $guestCart = $conn->query(
            "SELECT product_id, quantity 
             FROM cart 
             WHERE session_id='$sessionId'"
        );

        while ($item = $guestCart->fetch_assoc()) {

            $userItem = $conn->query(
                "SELECT id, quantity 
                 FROM cart 
                 WHERE user_id=$user_id 
                 AND product_id={$item['product_id']}"
            );

            if ($userItem->num_rows > 0) {
                // Merge quantities
                $existing = $userItem->fetch_assoc();
                $newQty = $existing['quantity'] + $item['quantity'];

                $conn->query(
                    "UPDATE cart 
                     SET quantity=$newQty 
                     WHERE id={$existing['id']}"
                );

                $conn->query(
                    "DELETE FROM cart 
                     WHERE session_id='$sessionId' 
                     AND product_id={$item['product_id']}"
                );
            } else {
                // Assign guest item to user
                $conn->query(
                    "UPDATE cart 
                     SET user_id=$user_id, session_id=NULL 
                     WHERE session_id='$sessionId' 
                     AND product_id={$item['product_id']}"
                );
            }
        }

        //  IMPORTANT: redirect directly to cart
        header("Location: cart.php");
        exit;

    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h2>Login to Continue</h2>

<?php if ($error): ?>
    <p style="color:red"><?= $error ?></p>
<?php endif; ?>

<form method="POST">
    Username:<br>
    <input type="text" name="username" required><br><br>

    Password:<br>
    <input type="password" name="password" required><br><br>

    <button type="submit" name="login">Login</button>
</form>

<br>
Don't have an account?<a href="register.php"> Sign Up</a>

</body>
</html>
