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
  else {
    $registered = true;
    header("Location: successful.html");
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register Page</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <div class="background">
      <div class="login-box">
        <h1>REGISTER</h1>

        <?php if (!empty($error)): ?>
          <p style="color:red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
          <label>Name</label>
          <input type="text" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>

          <label>Email</label>
          <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>

          <label>Password</label>
          <input type="password" name="password" required>

          <label>Select Role</label>
          <select id="role" name="role" required>
            <option value="" disabled selected>--Select Role--</option>
            <option value="donor">User</option>
            <option value="admin">Admin</option>
          </select>

          <button type="submit" name="register">Register</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
