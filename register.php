<?php
include 'db.php';

$error = "";

if (isset($_POST['register'])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Username validation 
    if (empty($username)) {
        $error = "Username is required";
    } elseif (!preg_match("/^[a-zA-Z0-9]+$/", $username)) {
        $error = "Username can contain only letters and numbers";
    } elseif (strlen($username) < 3) {
        $error = "Username must be at least 3 characters long";
    }

    
    elseif (empty($password)) {
        $error = "Password is required";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters long";
    }

    //Check duplicate username 
    else {
        $check = $conn->query(
            "SELECT id FROM users WHERE username = '$username'"
        );

        if ($check->num_rows > 0) {
            $error = "Username already exists";
        } else {
            // Insert validated user
            $conn->query(
                "INSERT INTO users (username, password) 
                 VALUES ('$username', '$password')"
            );

            header("Location: login.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>

<h2>User Registration</h2>

<?php if ($error): ?>
    <p style="color:red"><?= $error ?></p>
<?php endif; ?>

<form method="POST">
    Username:
    <input name="username" value="<?= isset($username) ? $username : '' ?>">
    <br><br>

    Password:
    <input name="password" type="password">
    <br><br>

    <button name="register">Register</button>
</form>

login.php">Already have an account? Login</a>

</body>
</html>
