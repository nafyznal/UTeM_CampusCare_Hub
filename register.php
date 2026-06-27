<?php
session_start();

$registered = false;
$error = '';

$servername = "127.0.0.1:3301";
$username = "root";
$password = "";
$dbname = "campuscare_hub";

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
        $stmt = $conn->prepare("SELECT id_group FROM student_utem WHERE emailStudent = ?");
        
        if ($stmt === false) {
            die("Ralat SQL (Semakan Whitelist Gagal): " . $conn->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $id_group = $row['id_group'];
            $stmt->close(); // ✅ Properly closed now

            $checkExist = $conn->prepare("SELECT Email FROM student WHERE Email = ?");
            
            if ($checkExist === false) {
                die("Ralat SQL (Gagal menyemak jadual 'student'): " . $conn->error);
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
                
                // ✅ Fixed column names to match exact casing in student table
                $insert = $conn->prepare("INSERT INTO student (id_group, Name, Email, Password, Gender) VALUES (?, ?, ?, ?, ?)");
                
                if ($insert === false) {
                    die("Ralat SQL (INSERT Gagal): " . $conn->error);
                }

                $insert->bind_param("issss", $id_group, $name, $email, $hashedPassword, $gender);

                if ($insert->execute()) {
                    $insert->close();
                    $conn->close();
                    header("Location: successful.html");
                    exit;
                } else {
                    $error = "Error inserting data: " . $insert->error;
                    $insert->close();
                }
            }
        } else {
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