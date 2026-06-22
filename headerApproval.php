<link rel="stylesheet" type="text/css" href="formatHeader.css">

<header class="center" style="width:100%">
    <div id="header-container">
        <div class="icon" id="menu-btn">
            <svg id="menu-icon" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#541A1A" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </div>
            
        <h1 style="color: #541A1A;">Admin Dashboard</h1>
        
        <div class="icon">
            <a href="homepage.php" id="home-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#541A1A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                    <polyline points="9 22 9 12 15 12 15 22" />
                </svg>
            </a>
        </div>
    </div>
</header>

<nav id="nav-section" class="sidebar hidden">
    <div class="sidebar-profile">
        <svg width="30" height="30" viewBox="0 0 24 24" fill="#c98a8a"><circle cx="12" cy="8" r="5"/><path d="M3 21c0-5 3.5-8 9-8s9 3 9 8"/></svg>
        <p>Hi, Admin!</p>
    </div>
    <hr/>

    <ul class="sidebar-menu">
        <li id="dashboard">
            <a href="adminDashboard.php">Dashboard</a>
        </li>

        <li id="approval">
            <a href="requestApproval.php">Approval</a>
        </li>

        <li id="scan">
            <a href="scan.php">Item Inventory</a>
        </li>
    </ul>
    <hr/>
    
    <a href="index.php" id="logout">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" viewBox="0 0 24 24">
        <path d="M16 13v-2H7V8l-5 4 5 4v-3z"/>
        <path d="M20 3H9a2 2 0 0 0-2 2v4h2V5h11v14H9v-4H7v4a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2z"/>
    </svg>

    <span>LOGOUT</span>
</a>
</nav>