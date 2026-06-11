<?php
session_start();

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($email == "azreenaathirah06@gmail.com" && $password == "12345") {
       $name ="Azreen";
        $_SESSION['em'] = $email;
        $_SESSION['pw'] = $password;
        $_SESSION['username'] = "$name"; 
        header("Location: homepage.php");
        exit;
    } else {
        session_destroy();
        echo "Sorry, your email or password is incorrect. Please try again.";
        echo "<br><meta http-equiv=\"refresh\" content=\"3;URL=index.php\">";
        exit;
    }
}
?>
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
        <form method="POST" action="">
          <label>Email</label>
          <input type="email" name="email" required>

          <label>Password</label>
          <input type="password" name="password" required>

          <button type="submit" name="submit">Login</button>
          <p>Don't have an account? <a href="register.php">Register</a></p>
        </form>
      </div>
    </div>
  </div>
</body>
</html>