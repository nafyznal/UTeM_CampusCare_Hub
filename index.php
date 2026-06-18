<?php
session_start();

$file = "userDatabase.txt";

if (isset($_POST['submit'])) {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $login_success = false;
    $user_name = '';

    if (file_exists($file)) {
        $users = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($users as $line) {
            // Pecahkan baris guna TAB
            $userData = explode("\t", $line);

            if (count($userData) >= 4) {
                $savedname  = trim($userData[0]);
                $savedEmail  = trim($userData[1]);
                $savedGender = trim($userData[2]);
                // trim() di sini SANGAT PENTING untuk buang whitespace/tab terselit di hujung hash
                $savedPwd   = trim($userData[3]); 

                if ($savedEmail === $email) {
                    // Semak password
                    if ($savedPwd === $password) {
                        $login_success = true;
                        $user_name = $savedname;
                        break;
                    }
                }
            }
        }
    }

    if ($login_success) {
    $_SESSION['em'] = $email;
    $_SESSION['username'] = $user_name; 

    // Tetapkan emel admin yang unik di sini
    $admin_email = "adminHub@gmail.com"; 

    // Semak adakah emel yang log masuk sepadan dengan emel admin
    if ($_SESSION['em'] === $admin_email) {
        header("Location: adminDashboard.php"); // Bawa ke page admin
    } else {
        header("Location: homepage.php"); // Bawa ke page user biasa
    }
    exit;
} else {
    session_start();
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