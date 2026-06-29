<?php
$username = $_SESSION['username'] ?? 'Guest';
?>
<link rel="stylesheet" type="text/css" href="formatHeader.css">



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
                <li><a href="#">Essential</a></li>
            </ul>
        </li>
    </ul>
</nav>