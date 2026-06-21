<?php
session_start();

$registered = false;
$error = '';


$servername = "127.0.0.1:3307";
$username = "root";
$password = "";
$dbname = "campuscare_hub";

// Hubungkan ke database 
$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
  die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['register'])){
  $name = trim($_POST['name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';
  $gender = $_POST['gender'] ?? '';

  if (empty($name) || empty($email) || empty($password) || empty($gender)) {
        $error = "Please fill in all required fields.";
  } else {
        // 1. Semak sama ada email wujud dalam table namestudent_b40 (Whitelist)
        $stmt = $conn->prepare("SELECT id_b40 FROM namestudent_b40 WHERE emailStudent = ?");
        
        if ($stmt === false) {
            die("Ralat SQL (Semakan Whitelist Gagal): " . $conn->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $id_b40 = $row['id_b40'];
            $stmt->close(); // Tutup statement pertama selepas selesai guna

            // 2. Semak jika email ini sudah pernah mendaftar di table student sebelum ini
            $checkExist = $conn->prepare("SELECT email FROM student WHERE email = ?");
            
            if ($checkExist === false) {
                die("Ralat SQL (Gagal menyemak jadual 'student'). Pastikan jadual 'student' wujud di phpMyAdmin! Error: " . $conn->error);
            }

            $checkExist->bind_param("s", $email);
            $checkExist->execute();
            $resExist = $checkExist->get_result();

            if ($resExist->num_rows > 0) {
                $error = "This email has already been registered!";
                $checkExist->close();
            } else {
                $checkExist->close();


                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                
                $insert = $conn->prepare("INSERT INTO student (id_b40, name, email, password, gender) VALUES (?, ?, ?, ?, ?)");
                
             
                if ($insert === false) {
                    die("Ralat SQL (INSERT Gagal): " . $conn->error . ". Sila semak semula nama kolum di dalam table 'student' anda.");
                }

                $insert->bind_param("issss", $id_b40, $name, $email, $hashedPassword, $gender);

                if ($insert->execute()) {
                    $registered = true;
                    $insert->close();
                    header("Location: successful.html");
                    exit;
                } else {
                    $error = "Error inserting data: " . $insert->error;
                    $insert->close();
                }
            }
        } else {
            // Email tak jumpa dalam namestudent_b40
            $error = "Sorry, your email is not registered as a B40 student.";
            $stmt->close();
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

          <label>Gender</label>
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