<?php
session_start();

$registered = false;
$error = '';

// Sambungan database (Port 3307)
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
  $phone = trim($_POST['phone'] ?? ''); 
  $gender = $_POST['gender'] ?? ''; 
  $profilePic = 'uploads/default.jpg'; 

  if (empty($name) || empty($email) || empty($password) || empty($phone) || empty($gender)) {
        $error = "Please fill in all required fields.";
  } 
  else if (!str_ends_with(strtolower($email), '@student.utem.edu.my')) {
        $error = "Access Denied! Only official UTeM student emails (@student.utem.edu.my) are allowed.";
  } 
  else { 
        $checkUtem = $conn->prepare("SELECT id_group FROM student_utem WHERE emailStudent = ?");
        $checkUtem->bind_param("s", $email);
        $checkUtem->execute();
        $resUtem = $checkUtem->get_result();

        if ($resUtem->num_rows == 0) {
            $error = "Access Denied! Your email is not found in the official UTeM Student records.";
            $checkUtem->close();
        } else {
            $utemData = $resUtem->fetch_assoc();
            $id_group = $utemData['id_group'];
            $checkUtem->close();

            if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
                $fileName = $_FILES['profile_pic']['name'];
                $fileTmpName = $_FILES['profile_pic']['tmp_name'];
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                if (in_array($fileExtension, $allowedExtensions)) {
                    $newFileName = time() . '_' . uniqid() . '.' . $fileExtension;
                    $uploadDirectory = 'uploads/';
                    
                    if (!is_dir($uploadDirectory)) {
                        mkdir($uploadDirectory, 0777, true);
                    }

                    $targetFilePath = $uploadDirectory . $newFileName;             
                    if (move_uploaded_file($fileTmpName, $targetFilePath)) {
                        $profilePic = $targetFilePath; // Ganti kepada path gambar baru
                    } else {
                        $error = "Failed to upload profile picture.";
                    }
                } else {
                    $error = "Invalid file type. Only JPG, JPEG, PNG, and WEBP are allowed.";
                }
            }

            if (empty($error)) {
                $checkExist = $conn->prepare("SELECT Email FROM student WHERE Email = ?");
                $checkExist->bind_param("s", $email);
                $checkExist->execute();
                $resExist = $checkExist->get_result();

                if ($resExist->num_rows > 0) {
                    $error = "This email has already been registered!";
                    $checkExist->close();
                } else {
                    $checkExist->close();
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT); 
                    $insert = $conn->prepare("INSERT INTO student (Name, Email, Password, Gender, Picture, id_group) VALUES (?, ?, ?, ?, ?, ?)");
                    
                    if ($insert === false) {
                        die("Error SQL: " . $conn->error);
                    }

                    $insert->bind_param("ssssss", $name, $email, $hashedPassword, $gender, $profilePic, $id_group);

                    if ($insert->execute()) {
                        $registered = true;
                        $insert->close();
                        header("Location: index.php");
                        exit;
                    } else {
                        $error = "Error inserting data: " . $insert->error;
                        $insert->close();
                    }
                }
            }
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
          <p style="color:red; font-weight:bold; text-align:center; padding: 0 10px;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
          <label>Name</label>
          <input type="text" name="name" value="<?= htmlspecialchars($name ?? '') ?>" required>

          <label>Email</label>
          <input type="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" placeholder="D032xxxx@student.utem.edu.my" required>

          <label>Password</label>
          <input type="password" name="password" required>

          <label>Number Phone</label>
          <input type="text" name="phone" value="<?= htmlspecialchars($phone ?? '') ?>" placeholder="e.g. 0123456789" required>

          <label>Gender</label>
          <select name="gender" required>
            <option value="" disabled selected>--Select Gender--</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>

          <label>Profile Picture (Optional)</label>
          <input type="file" name="profile_pic" accept="image/*" style="padding: 10px 0;">

          <button type="submit" name="register">Register</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>