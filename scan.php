<?php
    
    session_start(); 
    // make sure session_start() duk atas sekali

    $user_id = $_SESSION['user_id'] ?? 1;

    $qrData = "http://localhost:8080/coding/collect.php?id=" . $user_id;


    if(!isset($_SESSION['username']))
        {
            header("location: index.php");
            exit;
        }
    $username=$_SESSION['username'];

    include("header.php");

?>

<html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan and Collect</title>
</head>
<link rel="stylesheet" href="format.css">
<body>
    
    <main class="center">
        <div>
            <p>Use the QR code below to scan and collect your points.</p>
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?php echo urldecode($qrData);?>" alt="QR Code" class="qr-code">
        </div>
        
    </main>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                // Sidebar Toggle
                const menuBtn = document.querySelector('#menu-icon'); 
                const navSection = document.getElementById('nav-section');

                if (menuBtn && navSection) {
                    menuBtn.addEventListener('click', function (e) {
                        e.preventDefault();
                        navSection.classList.toggle('hidden');
                    });
                }

                // Hover Effects
                document.querySelectorAll('.icon, li, #logout').forEach(element => {
                    element.addEventListener("mouseover", function () {
                        this.classList.add("hover");
                    });
                    element.addEventListener("mouseleave", function () {
                        this.classList.remove("hover");
                    });
                });
            });
        </script>

    <?php
    include("footer.php");
    ?>
</body>
</html>
</html>