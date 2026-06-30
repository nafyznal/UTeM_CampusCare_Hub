<?php
$username = $_SESSION['username'] ?? 'Guest';
?>

<link rel="stylesheet" type="text/css" href="formatHeader.css">

<header class="center" style="width:100%">
    <div id="header-container">

        <div class="icon" id="menu-btn">
            <svg id="menu-icon" width="30" height="30" viewBox="0 0 24 24"
                 fill="none" stroke="#541A1A" stroke-width="2.5"
                 stroke-linecap="round" stroke-linejoin="round">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </div>

        <h1>History</h1>

        <div class="icon">
            <a href="homepage.php" id="home-icon">
                <svg xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="#541A1A"
                     stroke-width="2"
                     stroke-linecap="round"
                     stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
            </a>
        </div>

    </div>
</header>

<section class="sidebar hidden" id="mySidebar">

    <div class="sidebar-profile">
        <svg width="30" height="30" viewBox="0 0 24 24" fill="#c98a8a">
            <circle cx="12" cy="8" r="5"/>
            <path d="M3 21c0-5 3.5-8 9-8s9 3 9 8"/>
        </svg>

        <span class="greeting">
            Hi, <?= htmlspecialchars($username) ?>
        </span>
    </div>

    <ul class="sidebar-menu">

        <li>
            <div class="menu-item-container has-hover-icon" onclick="toggleSubMenu(event)" style="display: flex; align-items: center; justify-content: space-between; width: 100%; box-sizing: border-box; padding: 12px 15px;">
                <div style="display: flex; align-items: center; gap: 14px;">
                    <svg id="aid-icon" class="sidebar-svg" width="24" height="24" viewBox="0 0 24 24"
                         fill="none" stroke="white" stroke-width="2.5"
                         stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="4"></rect>
                        <line x1="12" y1="8" x2="12" y2="16"></line>
                        <line x1="8" y1="12" x2="16" y2="12"></line>
                    </svg>
                    <span>Aid</span>
                </div>
                <svg id="aid-caret" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="transition: transform 0.3s ease; flex-shrink: 0; margin-left: auto;">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </div>

            <ul class="sub-menu dropdown-closed" id="aidSubMenu">
                <li>
                    <div class="sub-menu-btn" onclick="toggleFoodMenu(event)" style="display: flex; align-items: center; justify-content: space-between; width: 100%; box-sizing: border-box; padding: 10px 15px;">
                        <span>Food</span>
                        <svg id="food-caret" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="transition: transform 0.3s ease; flex-shrink: 0; margin-left: auto;">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </div>

                    <ul class="sub-sub-menu dropdown-closed" id="foodSubMenu">
                        <li><a href="kit.php">Kit</a></li>
                        <li><a href="meal.php">Meal</a></li>
                    </ul>
                </li>

                <li><a href="#">Essential</a></li>
            </ul>
        </li>

        <li>
            <a href="history.php" class="menu-link has-hover-icon" style="display: flex; align-items: center; gap: 14px;">
                <svg id="history-icon" class="sidebar-svg" width="20" height="20"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="white"
                     stroke-width="2.5"
                     stroke-linecap="round"
                     stroke-linejoin="round">
                    <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
                    <polyline points="3 3 3 8 8 8"/>
                    <line x1="12" y1="7" x2="12" y2="12"/>
                    <line x1="12" y1="12" x2="16" y2="14"/>
                </svg>
                <span>History</span>
            </a>
        </li>

        <li>
            <a href="scan.php" class="menu-link has-hover-icon" style="display: flex; align-items: center; gap: 14px;">
                <svg id="scan-icon" class="sidebar-svg" width="20" height="20"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="white"
                     stroke-width="2"
                     stroke-linecap="round"
                     stroke-linejoin="round">
                    <path d="M3 7V5a2 2 0 0 1 2-2h2"></path>
                    <path d="M17 3h2a2 2 0 0 1 2 2v2"></path>
                    <path d="M7 21H5a2 2 0 0 1-2-2v-2"></path>
                    <path d="M21 17v2a2 2 0 0 1-2 2h-2"></path>
                    <line x1="7" y1="12" x2="17" y2="12"/>
                </svg>
                <span>Scan and Collect</span>
            </a>
        </li>

    </ul>

    <div class="sidebar-footer">
        <a href="logout.php" id="logout" class="has-hover-icon" style="display: flex; align-items: center; justify-content: center; gap: 10px;">
            <svg class="sidebar-svg" xmlns="http://www.w3.org/2000/svg"
                 width="20"
                 height="20"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2"
                 stroke-linecap="round"
                 stroke-linejoin="round"
                 viewBox="0 0 24 24">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                <polyline points="16 17 21 12 16 7"></polyline>
                <line x1="21" y1="12" x2="9" y2="12"></line>
            </svg>
            <span>Logout</span>
        </a> 
    </div>

</section>