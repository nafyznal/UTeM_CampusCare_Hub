<?php
$username = $_SESSION['username'] ?? 'Student';
?>

<header class="center" style="width:100%">
    <div id="header-container">

        <div class="icon" id="menu-btn">
            <svg id="menu-icon" viewBox="0 0 24 24" fill="none" stroke="#541A1A" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </div>

        <h1>Scan and Collect</h1>

        <div class="icon">
            <a href="../index.php" id="home-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="#541A1A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
            </a>
        </div>

    </div>
</header>

<nav class="sidebar hidden" id="nav-section">
    <div class="sidebar-profile">
        <svg viewBox="0 0 24 24" fill="none" stroke="#c98a8a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="8" r="5"/>
            <path d="M3 21c0-5 3.5-8 9-8s9 3 9 8"/>
        </svg>

        <span class="greeting">
            Hi, <?php echo htmlspecialchars($username); ?>
        </span>
    </div>

    <hr>

    <ul class="sidebar-menu">
        <li><a href="../index.php">Aid</a></li>
        <li><a href="../history.php">History</a></li>
        <li><a href="scan.php">Scan and Collect</a></li>
    </ul>

    <div class="sidebar-footer">
        <a href="../logout.php" id="logout">Logout</a>
    </div>
</nav>