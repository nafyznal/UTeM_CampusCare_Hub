<?php
session_start();
if(!isset($_SESSION['username']))
    {
        header("location: index.php");
        exit;
    }
$username=$_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UTeM Campus Care - History Page</title>
    <link rel="stylesheet" href="history.css">
</head>
<body>
    <header class="header">
        <div class="header-container">
            <div class="menu-icon" id="menuBtn" onclick="toggleSidebar()">
                 <svg id="menu-icon" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#541A1A" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </div>
           
            <div class="home-icon" onclick="window.location.href='homepage.php'" style="cursor:pointer">
               <a href="home.php" id="home-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#541A1A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        <polyline points="9 22 9 12 15 12 15 22" />
                    </svg>
                </a>
            </div>
        </div>
    </header>
    <section class="sidebar hidden" id="mySidebar">
        <div class="sidebar-profile">
           <svg width="30" height="30" viewBox="0 0 24 24" fill="#c98a8a">
                <circle cx="12" cy="8" r="5"/>
                <path d="M3 21c0-5 3.5-8 9-8s9 3 9 8"/></svg>
            <p id="greeting" style="font-size: 22px; font-weight:bold">Hi,<?= htmlspecialchars($username) ?>! </p>
        </div>
        
        <ul class="sidebar-menu">
            <li>
                <div class="menu-item-container" onclick="toggleSubMenu(event)">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="12" y1="8" x2="12" y2="16"></line>
                        <line x1="8" y1="12" x2="16" y2="12"></line>
                    </svg>
                    <span>Aid</span>
                    <span id="caret-icon" style="margin-left: auto; font-size: 12px; transition: transform 0.2s;"></span>
                </div>
              
                <ul class="sub-menu dropdown-closed" id="aidSubMenu">
                    <li>
                        <div class="sub-menu-btn" onclick="toggleFoodMenu(event)" style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                            <span>Food</span>
                            <span id="food-caret" style="font-size: 10px; transition: transform 0.2s; margin-right: 20px;"></span>
                        </div>
                        
                        <ul class="sub-sub-menu dropdown-closed" id="foodSubMenu">
                            <li><a href="#">Kit</a></li>
                            <li><a href="#">Meal</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Essential</a></li>
                </ul>
            </li>
            <li>
                <a href="history.html" class="menu-link">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                        <path d="M3.51 9a9 9 0 0 1 14.85-3.36"></path>
                    </svg>
                    <span>History</span>
                </a>
            </li>
            <li>
                <a href="#" class="menu-link" style="display: flex; align-items: flex-start; gap: 15px;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-top: 3px;">
                        <path d="M3 7V5a2 2 0 0 1 2-2h2"></path>
                        <path d="M17 3h2a2 2 0 0 1 2 2v2"></path>
                        <path d="M7 21H5a2 2 0 0 1-2-2v-2"></path>
                        <path d="M21 17v2a2 2 0 0 1-2 2h-2"></path>
                    </svg>
                    <div style="display: flex; flex-direction: column; line-height: 1.2;">
                        <span>Scan &</span>
                        <span>Collect</span>
                    </div>
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <div id="logout" onclick="prosesLogout()">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
                <span>LOGOUT</span>
            </div>
        </div>
    </section>

    <main class="main-container" id="mainContent">
        <div class="title-container">
            <h1 class="page-title">History</h1>
        </div>

        <div class="table-container">
            <table class="history-table">    
                    <tr>
                        <th>Date</th>
                        <th>Request</th>
                        <th>Status</th>
                    </tr>
                    <tr>
                        <td>20/5/2026</td>
                        <td>Mini Kit</td>
                        <td>Approved</td>
                    </tr>  
            </table>
        </div>
    </main>

    <script>
        let sidebar = document.getElementById('mySidebar');
        let mainContent = document.getElementById('mainContent');
        let menuBtn = document.getElementById('menuBtn');

        function toggleSidebar() {
            sidebar.classList.toggle('hidden');  
        }

       
        function toggleSubMenu(event) {
            event.stopPropagation(); 
            let subMenu = document.getElementById('aidSubMenu');
            
            subMenu.classList.toggle('dropdown-closed');
            
        }

       
        function toggleFoodMenu(event) {
            event.stopPropagation(); 
            let foodSubMenu = document.getElementById('foodSubMenu');
            let foodCaret = document.getElementById('food-caret');
            
            foodSubMenu.classList.toggle('dropdown-closed');
         
        }

        document.addEventListener('click', function(event) {
            if (!sidebar.classList.contains('hidden') &&  !sidebar.contains(event.target) && !menuBtn.contains(event.target)) {
                sidebar.classList.add('hidden');  
            }
        });

        function prosesLogout() {
            window.location.href = "index.php";
        }
    </script>

</body>
</html>