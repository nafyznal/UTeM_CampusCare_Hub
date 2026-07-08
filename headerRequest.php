<html>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>header</title>
        <link rel="stylesheet" type="text/css" href="formatAdmin.css">
    </head>
    <body>
        <header class="center" style="width:100%">
            <div id="header-container">
                <div class="icon" id="menu-btn">
                    <svg id="menu-icon" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#541A1A" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </div>
                    
                <h1 style="color: #541A1A;">Request Approval</h1>
                
                <div class="icon">
                    <a href="adminDashboard.php" id="home-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#541A1A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                            <polyline points="9 22 9 12 15 12 15 22" />
                        </svg>
                    </a>
                </div>
            </div>
        </header>

        <nav id="nav-section" class="hidden">
            <div class="user-info">
                <svg width="30" height="30" viewBox="0 0 24 24" fill="#c98a8a"><circle cx="12" cy="8" r="5"/><path d="M3 21c0-5 3.5-8 9-8s9 3 9 8"/></svg>
                <p>Hi, Admin!</p>
            </div>
            <hr/>

            <ul id="nav-list">
                <li id="dashboard">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="9" rx="1" />
                        <rect x="14" y="3" width="7" height="5" rx="1" />
                        <rect x="3" y="16" width="7" height="5" rx="1" />
                        <rect x="14" y="12" width="7" height="9" rx="1" />
                    </svg>
                    <a href="adminDashboard.php">Dashboard</a>
                </li>
                <li id="approval">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                        <polyline points="9 11 11 13 15 9" />
                    </svg>
                    <a href="requestApproval.php">Approval</a>
                </li>
                <li id="scan"> 
                    <svg xmlns="http://www.w3.org/2000/svg" 
                        viewBox="0 0 24 24" 
                        fill="none" 
                        stroke="#FFFFFF" 
                        stroke-width="2" 
                        stroke-linecap="round" 
                        stroke-linejoin="round">

                        <path d="M3 7l9-4 9 4-9 4-9-4z"/>
                        <path d="M3 7v10l9 4 9-4V7"/>
                        <line x1="12" y1="11" x2="12" y2="21"/>
                    </svg>
                    <a href="inventoryManagement.php">Item Inventory</a>
                </li>
                <li id="qrscan"> 
                    <svg xmlns="http://www.w3.org/2000/svg" 
                        viewBox="0 0 24 24" 
                        fill="none" 
                        stroke="#FFFFFF" 
                        stroke-width="2" 
                        stroke-linecap="round" 
                        stroke-linejoin="round">

                        <rect x="3" y="3" width="7" height="7" rx="1"/>
                        <rect x="14" y="3" width="7" height="7" rx="1"/>
                        <rect x="3" y="14" width="7" height="7" rx="1"/>
                        <line x1="14" y1="14" x2="14" y2="14.01"/>
                        <line x1="14" y1="21" x2="14" y2="21.01"/>
                        <line x1="21" y1="14" x2="21" y2="14.01"/>
                        <line x1="21" y1="21" x2="21" y2="21.01"/>
                        <line x1="17.5" y1="14" x2="17.5" y2="17.5"/>
                        <line x1="14" y1="17.5" x2="17.5" y2="17.5"/>
                        <line x1="17.5" y1="17.5" x2="21" y2="17.5"/>
                        <line x1="17.5" y1="21" x2="21" y2="21"/>
                    </svg>
                    <a href="scanner.php">QR Scanner</a>
                </li>
            </ul>
            <hr/>
            
            <div class="sidebar-footer">
                <a href="logout.php" id="logout">
                    <svg class="sidebar-svg" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    <span>Logout</span>
                </a>
            </div>
        </nav>
    </body>
    </html>
</html>