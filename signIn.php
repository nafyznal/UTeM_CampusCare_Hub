<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UTeM Campus Care - Home</title>
    <link rel="stylesheet" href="homepage.css">
</head>

<body>
<?php
include("headerSignIn.php");?>
<!-- SideBar -->
    <section class="sidebar hidden" id="mySidebar">
        <div class="sidebar-profile">
             <svg width="30" height="30" viewBox="0 0 24 24" fill="#c98a8a"><circle cx="12" cy="8" r="5"/><path d="M3 21c0-5 3.5-8 9-8s9 3 9 8"/></svg>
        
    <button id="btn-sidebar-login" onclick="window.location.href='index.php'">Login</button>
        </div>
       
        <ul class="sidebar-menu">
            <li>
                <div class="menu-item-container" onclick="toggleSubMenu(event)" style="cursor: pointer;">
                     <svg id="aid-icon" width="24" height="24" viewBox="0 0 24 24" fill="white" stroke="#541A1A" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="4"></rect>
                        <line x1="12" y1="8" x2="12" y2="16"></line>
                        <line x1="8" y1="12" x2="16" y2="12"></line>
                    </svg>Aid   
                </div>
             
                <ul class="sub-menu dropdown-closed" id="aidSubMenu">
                    <li>
                        <div class="sub-menu-btn" onclick="toggleFoodMenu(event)" style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                            <span>Food</span>
                            <span id="food-caret" style="font-size: 12px; transition: transform 0.2s; margin-right: 25px;"></span>
                        </div>
                       
                        <ul class="sub-sub-menu dropdown-closed" id="foodSubMenu">
                            <li><a href="kitLogin.php">Kit</a></li>
                            <li><a href="mealLogin.php">Meal</a></li>
                        </ul>
                    </li>
                    <li><a href="essentialLogin.php">Essential</a></li>
                </ul>
            </li>
        </ul>
        </div>
    </section>

    <main class="main-container" id="mainContent">
        <section class="hero-banner">
            <div class="banner-content">
                <div class="logo-text">
                    <span class="brand-title">UTeM</span>
                    <span class="brand-sub">Campus<br>Care</span>
                </div>
                <a href="donation.php" class="btn-donation">START DONATION</a>
            </div>
        </section>

        <section class="support-section">
            <h2 class="section-title">How Your Support Helps?</h2>
           
            <div class="grid-layout">
                <div class="impact-cards">
                    <div class="card">
                        <span class="card-number">01</span>
                        <h3 class="card-title">Free Daily Meals</h3>
                        <div class="card-image"><img src="images/donation3.png" alt="Meals"></div>
                    </div>
                    <div class="card">
                        <span class="card-number">02</span>
                        <h3 class="card-title">Essential Supplies</h3>
                        <div class="card-image"><img src="images/donation1.jpeg" alt="Supplies"></div>
                    </div>
                    <div class="card">
                        <span class="card-number">03</span>
                        <h3 class="card-title">Academic Support</h3>
                        <div class="card-image"><img src="images/donation2.webp" alt="Academic"></div>
                    </div>
                </div>

                <aside class="mission-box">
                    <h2>OUR MISSION</h2>
                    <p>To eradicate poverty among UTeM students by ensuring every student has access to nutritious meals and essential daily needs</p>
                </aside>
            </div>
        </section>
    </main>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const menuBtn = document.getElementById('menu-btn');
    const sidebar = document.getElementById('nav-section');

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
    window.location.href = "index.php";
}

document.querySelectorAll(".icon,svg,img").forEach(icon=>{
    icon.addEventListener("mouseover",()=>{
        icon.classList.add("hover")
    });

    icon.addEventListener("mouseleave",()=>{
        icon.classList.remove("hover")
    });

});

</script>
  
</body>
</html>