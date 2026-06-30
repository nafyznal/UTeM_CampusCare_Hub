<?php
    session_start(); 

    $user_id = $_SESSION['user_id'] ?? 1;
    $qrData = "http://localhost:8080/coding/collect.php?id=" . $user_id;

    if(!isset($_SESSION['username'])) {
        header("location: index.php");
        exit;
    }
    $username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan and Collect</title>
    <link rel="stylesheet" type="text/css" href="format.css">
</head>
<body>

    <?php include("scanheader.php"); ?>
    
    <main class="center">
        <div>
            <p>Use the QR code below to scan and collect your points.</p>
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?php echo urlencode($qrData);?>" alt="QR Code" class="qr-code">
        </div>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const menuBtn = document.getElementById('menu-btn');
            const sidebar = document.getElementById('mySidebar');

            if (menuBtn && sidebar) {
                menuBtn.addEventListener('click', function (event) {
                    event.stopPropagation();
                    sidebar.classList.toggle('hidden');
                });
            }

            // Dropdown toggles mapped to the explicit IDs inside your header file
            window.toggleSubMenu = function (event) {
                event.stopPropagation();
                const subMenu = document.getElementById('aidSubMenu');
                if (subMenu) subMenu.classList.toggle('dropdown-closed');
            };

            window.toggleFoodMenu = function (event) {
                event.stopPropagation();
                const foodMenu = document.getElementById('foodSubMenu');
                if (foodMenu) foodMenu.classList.toggle('dropdown-closed');
            };

            // Close sidebar dynamically if user clicks outside of it
            document.addEventListener('click', function (event) {
                if (sidebar && !sidebar.contains(event.target) && !menuBtn.contains(event.target)) {
                    sidebar.classList.add('hidden');
                }
            });

        });

        function prosesLogout() {
            window.location.href = "logout.php";
        }

        document.querySelectorAll(".icon").forEach(icon=>{
            icon.addEventListener("mouseover",()=>{
                icon.classList.add("hover")
            });

            icon.addEventListener("mouseleave",()=>{
                icon.classList.remove("hover")
            });

        });
        </script>

    <?php include("footer.php"); ?>
</body>
</html>