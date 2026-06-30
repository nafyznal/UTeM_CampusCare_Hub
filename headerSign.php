<?php
$username = $_SESSION['username'] ?? 'Guest';
?>
<link rel="stylesheet" type="text/css" href="formatHomepage.css">

<header class="center" style="width:100%">
            <div id="header-container">
                <div class="icon" id="menu-btn">
                    <svg id="menu-icon" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#541A1A" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </div>
                    
                <h1 style="color: #541A1A;">UTeM CampuscareHub</h1>
                
                <div class="icon">
                    <a href="SignIn.php" id="home-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#541A1A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                            <polyline points="9 22 9 12 15 12 15 22" />
                        </svg>
                    </a>
                </div>
            </div>
        </header>


<nav class="sidebar hidden" id="nav-section">

    <div class="sidebar-profile">
        <svg viewBox="0 0 24 24" fill="#c98a8a"><circle cx="12" cy="8" r="5"/><path d="M3 21c0-5 3.5-8 9-8s9 3 9 8"/></svg>
        <span class="greeting">Hi</span>
        <button type="button" name="login" onclick="window.location.href='index.php'" style="margin-top: 5px; padding: 2px 12px; background-color: #c98a8a; color: white; border: none; border-radius: 4px; cursor: pointer;"> LOGIN</button>
    </div>

    <ul class="sidebar-menu">

        <li>
            <div class="menu-item-container" onclick="toggleSubMenu(event)">
                <div class="menu-item-left">
                    <svg class="sidebar-svg" viewBox="0 0 24 24" fill="none"
                         stroke="white" stroke-width="2.5"
                         stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="4"/>
                        <line x1="12" y1="8" x2="12" y2="16"/>
                        <line x1="8" y1="12" x2="16" y2="12"/>
                    </svg>
                    <span>Aid</span>
                </div>
                <svg id="aid-caret" class="caret-icon" viewBox="0 0 24 24" fill="none"
                     stroke="white" stroke-width="2.5"
                     stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9"/>
                </svg>
            </div>

            <ul class="sub-menu dropdown-closed" id="aidSubMenu">
                <li>
                    <div class="sub-menu-btn" onclick="toggleFoodMenu(event)">
                        <span>Food</span>
                        <svg id="food-caret" class="caret-icon" viewBox="0 0 24 24" fill="none"
                             stroke="white" stroke-width="2.5"
                             stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"/>
                        </svg>
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
</nav>