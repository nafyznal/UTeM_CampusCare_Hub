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
include("signinHeader.php");?>
    <header class="header">
        <div id="header-container" >
            <div class="menu-icon" id="menuBtn" onclick="toggleSidebar()">
                 <svg id="menu-icon" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#541A1A" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </div>
            <h1>UTeM Campus Care</h1>
        </div>
    </header>
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
                            <li><a href="#">Kit</a></li>
                            <li><a href="#">Meal</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Essential</a></li>
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
    const sidebar = document.getElementById('mySidebar');
    const menuBtn = document.getElementById('menuBtn');

    function toggleSidebar()
    {
        sidebar.classList.toggle('hidden');
    }
    
    function toggleSubMenu(event) 
    {
        event.stopPropagation(); 
        let subMenu = document.getElementById('aidSubMenu');  
        subMenu.classList.toggle('dropdown-closed');
    }

    function toggleFoodMenu(event) 
    {
        event.stopPropagation(); 
        let foodSubMenu = document.getElementById('foodSubMenu');
        foodSubMenu.classList.toggle('dropdown-closed');
    }

    document.addEventListener('click', function(event) {
        if (!sidebar.classList.contains('hidden') && !sidebar.contains(event.target) && !menuBtn.contains(event.target)) {
            sidebar.classList.add('hidden');
        }
    });
</script>
  
</body>
</html>