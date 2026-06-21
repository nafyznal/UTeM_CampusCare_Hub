<?php
session_start();

$servername = "localhost:3306";
$username   = "root";
$password   = "root1234";  
$dbname     = "campuscare_hub";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (isset($_POST['submit'])) {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $login_success = false;
    $user_name     = '';
    $is_admin      = false;

    // 1. Check admin
    $stmt = $conn->prepare("SELECT name, password FROM admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if ($password === $row['password']) {
            $login_success = true;
            $user_name     = $row['name'];
            $is_admin      = true;
        }
    }

    // 2. Kalau belum login, check student
    if (!$login_success) {
        $stmt = $conn->prepare("SELECT name, password, StudentId FROM student WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            if (password_verify($password, $row['password'])) {
                $login_success = true;
                $user_name     = $row['name'];
                $_SESSION['StudentId'] = $row['StudentId'];
            }
        }
    }
    if ($login_success) {
        $_SESSION['em']       = $email;
        $_SESSION['username'] = $user_name;

        if ($is_admin) {
            header("Location: adminDashboard.php");
        } else {
            header("Location: homepage.php");
        }
        exit;
    } else {
        session_unset();
        session_destroy();

        echo "<div style='color:red; text-align:center; margin-top:20px;'>";
        echo "Sorry, your email or password is incorrect. Please try again.<br>";
        echo "Redirecting you back in 3 seconds...";
        echo "</div>";
        echo "<meta http-equiv=\"refresh\" content=\"3;URL=index.php\">";
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