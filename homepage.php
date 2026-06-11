<?php
session_start();
// Guard clause: kick unauthenticated users back to login
if (!isset($_SESSION['username'])) {
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
    <title>UTeM Campus Care - Home</title>
    <link rel="stylesheet" href="homepage.css">
</head>
<body>

<?php include 'homepageHeader.php'; ?>

<main class="main-container" id="mainContent">

    <section class="hero-banner">
        <div class="banner-content">

            <div class="logo-text">
                <span class="brand-title">UTeM</span>
                <span class="brand-sub">Campus<br>Care</span>
            </div>

            <a href="donation.php" class="btn-donation">
                START DONATION
            </a>

        </div>
    </section>

    <section class="support-section">
        <h2 class="section-title">How Your Support Helps?</h2>

        <div class="grid-layout">

            <div class="impact-cards">

                <div class="card">
                    <span class="card-number">01</span>
                    <h3>Free Daily Meals</h3>
                    <div class="card-image">
                        <img src="images/donation3.png" alt="Meals">
                    </div>
                </div>

                <div class="card">
                    <span class="card-number">02</span>
                    <h3>Essential Supplies</h3>
                    <div class="card-image">
                        <img src="images/donation1.jpeg" alt="Supplies">
                    </div>
                </div>

                <div class="card">
                    <span class="card-number">03</span>
                    <h3>Academic Support</h3>
                    <div class="card-image">
                        <img src="images/donation2.webp" alt="Academic">
                    </div>
                </div>

            </div>

            <aside class="mission-box">
                <h2>OUR MISSION</h2>
                <p>
                    To eradicate poverty among UTeM students by ensuring every student has access to nutritious meals and essential daily needs.
                </p>
            </aside>

        </div>
    </section>

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
</script>

</body>
</html>