<?php
session_start();

$registered = false;
$error = '';
$file = 'userDatabase.txt';

// Semua proses HANYA berjalan jika butang register ditekan
if (isset($_POST['register'])) {
    
    // 1. Ambil data dari borang (Guna ?? '' untuk elak error jika kosong)
    $fname    = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $gender   = $_POST['gender'] ?? '';
    $password = $_POST['password'] ?? ''; // Jangan lupa simpan atau hash password!

    // 2. Validasi: Pastikan semua ruangan wajib diisi
    if (empty($fname) || empty($email) || empty($password) || empty($gender)) {
        $error = "Please fill in all required fields.";   
    }
    else {
        // Hash password demi keselamatan data pengguna
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // 3. Masukkan data ke dalam array (Hanya setelah dipastikan borang lengkap)
        $data = [$fname, $email, $gender, $hashedPassword];

        // 4. Buka fail untuk menulis ('a' bermaksud append / tambah di bawah sekali)
        $fp = @fopen($file, 'a');

        if ($fp) {
            // Tulis baris baru menggunakan kaedah foreach yang awak mahukan
            // Letak \n di hadapan untuk memastikan ia bermula di baris baru
            @fwrite($fp, "\n"); 
            foreach ($data as $v) {
                @fwrite($fp, "$v\t");
            }
            
            @fclose($fp);

            $registered = true;
            header("Location: successful.html");
            exit;
        } else {
            $error = "Couldn't open file for writing!";
        }
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
          <input type="text" name="name" required>

          <label>Email</label>
          <input type="email" name="email" required>

          <label>Password</label>
          <input type="password" name="password" required>

          <label>Select Role</label>
          <select id="gender" name="gender" required>
            <option value="" disabled selected>--Select Gender--</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>

          <button type="submit" name="register">Register</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
