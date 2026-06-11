<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan and Collect</title>
</head>
<link rel="stylesheet" href="format.css">
<body>
    <?php
    include("header.php");
    ?>
    <main>
        <p>Use the QR code below to scan and collect your points.</p>
        <img src="icon/qr-code-svgrepo-com.svg" alt="QR Code" class="qr-code" width="200" height="200">
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
</body>
</html>