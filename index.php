
<?php
session_start();

$registered = false;
$error = '';

if (isset($_POST['register'])) {
  $name     = trim($_POST['name']);
  $email    = trim($_POST['email']);
  $password = $_POST['password'];
  $role     = $_POST['role'];

  if (empty($name) || empty($email) || empty($password) || empty($role)) {
    $error = "Please fill in all fields.";
  } 
  else 
    {
    $registered = true;
    }
}?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="background">
            <div class="login-box">
                <h1>LOGIN</h1>
                <form action = "homepage.php">
                    <label>Email</label>
                    <input type="email" required>

                    <label>Password</label>
                    <input type="password" required>

                    <button type="submit">Login</button>

                    <p> Don't have an account ? <a href="register.php">Register</a>
                    </p>
                </form>
            </div>

        </div>
    </div>
</body>
</html>