<?php
// 1. Secure Session Start
session_start([
    'cookie_httponly' => true,
    // 'cookie_secure' => true, // Uncomment this line if you are using HTTPS
    'cookie_samesite' => 'Strict'
]);

// 2. Database Connection
$servername = "127.0.0.1:3301";
$username   = "root";
$password   = "";  
$dbname     = "campuscare_hub";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 3. Generate CSRF token if one doesn't exist
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$error_message = '';

// 4. Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    
    // Verify CSRF Token
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("CSRF token validation failed. Request denied.");
    }

    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $login_success = false;
    $user_name     = '';
    $is_admin      = false;

    // 4a. Check admin table
    $stmt = $conn->prepare("SELECT Name AS name, Password AS password FROM admin WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $login_success = true;
            $user_name     = $row['name'];
            $is_admin      = true;
        }
    }
    $stmt->close();

    // 4b. Check student table if not admin
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
        $stmt->close();
    }

    // 5. Processing Results
    if ($login_success) {
        session_regenerate_id(true);
        
        $_SESSION['em']       = $email;
        $_SESSION['username'] = $user_name;
        $_SESSION['is_admin'] = $is_admin; 
        
        if ($is_admin) {
            header("Location: adminDashboard.php");
        } else {
            header("Location: homepage.php");
        }
        exit;
    } else {
        $error_message = "Sorry, your email or password is incorrect. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <style>
    /* === Global Overrides === */
    html, body {
      margin: 0;
      padding: 0;
      height: 100%;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: url('images/donation.webp');
    }

    /* === Full Screen Background Layout === */
    .container {
      width: 100%;
      height: 100vh;
      /* Replace path below with your background image asset */
      background-image: url('images/volunteer_bg.jpg'); 
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      position: relative;
    }

    .background {
      width: 100%;
      height: 100%;
      display: flex;
      justify-content: flex-end; /* Coordinates the box to the right side matching image_743f77.jpg */
      align-items: center;
      padding-right: 10%; 
      box-sizing: border-box;
    }

    /* === Maroon Rounded Login Card === */
    .login-box {
      background-color: #581818; /* Rich deep maroon color */
      padding: 45px 35px;
      border-radius: 24px;       /* Sleek curved geometry border */
      width: 100%;
      max-width: 380px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
      color: white;
      text-align: center;
      box-sizing: border-box;
    }

    .login-box h1 {
      margin: 0 0 30px 0;
      font-size: 28px;
      font-weight: bold;
      letter-spacing: 1px;
    }

    .login-box label {
      display: block;
      text-align: left;
      font-size: 11px;
      margin-bottom: 6px;
      color: #e5c5c5;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .login-box input[type="email"],
    .login-box input[type="password"] {
      width: 100%;
      padding: 12px;
      margin-bottom: 22px;
      border: none;
      border-radius: 4px;
      box-sizing: border-box;
      font-size: 14px;
    }

    /* === Light Tan Action Button === */
    .login-box button[type="submit"] {
      background-color: #dec2b0; /* Beige color palette matched from reference */
      color: #3a1515;
      border: none;
      padding: 10px 35px;
      border-radius: 8px;
      font-size: 14px;
      font-weight: bold;
      cursor: pointer;
      margin-top: 10px;
      margin-bottom: 15px;
      transition: background-color 0.2s ease, transform 0.1s ease;
    }

    .login-box button[type="submit"]:hover {
      background-color: #cdb19f;
      transform: scale(1.02);
    }

    .login-box p {
      margin: 15px 0 0;
      font-size: 12px;
      color: #e5c5c5;
    }

    .login-box p a {
      color: white;
      text-decoration: none;
      font-weight: bold;
      margin-left: 4px;
    }
    
    .login-box p a:hover {
      text-decoration: underline;
    }

    /* === Float Left Home Navigation Icon === */
    header.center {
      position: absolute;
      left: 20px;
      top: 50%;
      transform: translateY(-50%);
      z-index: 999;
    }

    header .icon svg {
      width: 24px;
      height: 24px;
      padding: 10px;
      background: rgba(255, 255, 255, 0.9);
      border-radius: 50%;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      transition: transform 0.2s ease;
    }

    header .icon svg:hover {
      transform: scale(1.1);
    }

    /* === Standard Error Alert Overlays === */
    .error-alert {
      color: #b91c1c;
      background-color: #fee2e2;
      border: 1px solid #fca5a5;
      padding: 10px;
      border-radius: 6px;
      margin-bottom: 20px;
      font-size: 0.85rem;
    }

    /* Responsive adjustments */
    @media (max-width: 600px) {
      .background {
        justify-content: center;
        padding-right: 0;
      }
      .login-box {
        max-width: 90%;
      }
      header.center {
        top: 20px;
        left: 20px;
        transform: none;
      }
    }
  </style>
</head>
<body>

    <!-- Repositioned and fixed structure for the Floating Home Icon -->
    <header class="center">             
        <div class="icon">
            <a href="SignIn.php" id="home-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#541A1A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                    <polyline points="9 22 9 12 15 12 15 22" />
                </svg>
            </a>
        </div>
    </header>

    <div class="container">
        <div class="background">
            <div class="login-box">
                <h1>LOGIN</h1>
                
                <!-- Errors Injection Block -->
                <?php if (!empty($error_message)): ?>
                  <div class="error-alert">
                    <?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?>
                  </div>
                <?php endif; ?>

                <form method="POST" action="">
                  <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                  <label for="email">Email</label>
                  <input type="email" id="email" name="email" required value="<?php echo isset($email) ? htmlspecialchars($email, ENT_QUOTES, 'UTF-8') : ''; ?>">

                  <label for="password">Password</label>
                  <input type="password" id="password" name="password" required>

                  <button type="submit" name="submit">Login</button>
                  <p>Don't have an account?<a href="register.php">Register</a></p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>