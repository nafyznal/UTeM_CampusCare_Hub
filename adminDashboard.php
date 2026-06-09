<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="format.css">
</head>
<body>
    <header class="center">
        <div id="header-container">
            <div class="icon" id="menu-btn">
                <svg id="menu-icon" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#541A1A" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </div>
                
            <h1>Admin Dashboard</h1>
            
            <div class="icon">
                <a href="home.html" id="home-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#541A1A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                <a href="adminDashboard.html">Dashboard</a>
            </li>
            <li id="approval">
                <svg id="history-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path>
                    <polyline points="3 3 3 8 8 8"></polyline>
                    <line x1="12" y1="7" x2="12" y2="12"></line>
                    <line x1="12" y1="12" x2="16" y2="14"></line>
                </svg>
                <a href="History.html">History</a>
            </li>
            <li id="scan"> 
                <svg id="scan-icon" width="20" height="20" viewBox="0 0 24 24" fill="white" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 7V5a2 2 0 0 1 2-2h2"></path>
                    <path d="M17 3h2a2 2 0 0 1 2 2v2"></path>
                    <path d="M7 21H5a2 2 0 0 1-2-2v-2"></path>
                    <path d="M21 17v2a2 2 0 0 1-2 2h-2"></path>
                    <line x1="7" y1="12" x2="17" y2="12"></line>
                </svg>
                <a href="scan.html">Scan and Collect</a>
            </li>
        </ul>
        <hr/>
        
        <div id="logout">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" viewBox="0 0 24 24"><path d="M16 13v-2H7V8l-5 4 5 4v-3z"/><path d="M20 3H9a2 2 0 0 0-2 2v4h2V5h11v14H9v-4H7v4a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2z"/></svg>
            <p style="margin:0; font-weight:bold; font-size:14px; letter-spacing:1px;">LOGOUT</p>
        </div>
    </nav>

    <div class="card">
        <div class="icon-container">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="7" r="3" />
            <path d="M5 20a7 7 0 0 1 14 0" />
            <line x1="5" y1="20" x2="19" y2="20" />
        </svg>

        </div>
        <div class="content">
        <span class="value">2</span>
        <span class="label">Request</span>
        </div>
  </div>

  <div class="card">
    <div class="icon-container">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <rect x="3" y="3" width="18" height="18" rx="2" />
        <path d="M7.5 7v3.5M9 7v3.5M6 7v3.5" />
        <path d="M6 10.5c0 1 1.5 1 1.5 1V16M9 10.5c0 1-1.5 1-1.5 1" />
        <path d="M16.5 7c-1 0-1.5 1-1.5 2s.3 2 1.5 2 1.5-1 1.5-2-.5-2-1.5-2z" />
        <line x1="16.5" y1="11" x2="16.5" y2="16" />
      </svg>
    </div>
    <div class="content">
      <span class="value">RM 75</span>
      <span class="label">Food</span>
    </div>
  </div>

  <div class="card">
    <div class="icon-container">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <line x1="4" y1="7" x2="10" y2="7" />
        <line x1="4" y1="12" x2="8" y2="12" />
        <line x1="4" y1="17" x2="12" y2="17" />
        <circle cx="16" cy="11" r="3" />
        <line x1="18.1" y1="13.1" x2="20.5" y2="15.5" />
      </svg>
    </div>
    <div class="content">
      <span class="value">Rm 0</span>
      <span class="label">Essential</span>
    </div>
  </div>

    <script type="text/javascript">
        // Sidebar Toggle
        document.querySelector('#menu-btn').addEventListener('click', function() {
            document.getElementById('nav-section').classList.toggle('hidden');
        });

        // Combined Single Loop for Hover Effects
        document.querySelectorAll('.icon, li, #logout').forEach(element => {
            element.addEventListener("mouseover", () => element.classList.add("hover"));
            element.addEventListener("mouseleave", () => element.classList.remove("hover"));
        });
    </script>
</body>
</html>