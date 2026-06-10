<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="format.css">
</head>
<body>
    <?php
    include("header.php");
    ?>
    
    <main class="grid-container">
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

  <div class="table-recent">
    <h2>Recent Order</h2>
    <table class="recent-table">
        <tr>
            <th>Name</th>
            <th>Request</th>
            <th>Status</th>
        </tr>

        <tr>
            <td>Ali</td>
            <td>Food</td>
        </tr>

        <tr>
            <td>Abu</td>
            <td>Essential</td>
        </tr>
    </table>
  </div>
  

  <div class="table-recent">
    <h2>Recent Donor</h2>
    <table class="recent-table">
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Amount</th>
        </tr>

        <tr>
            <td>Ali</td>
            <td>Food</td>
        </tr>

        <tr>
            <td>Abu</td>
            <td>Essential</td>
        </tr>
    </table>
  </div>
    

    <script>
document.addEventListener("DOMContentLoaded", function () {

    // Sidebar Toggle
    const menuBtn = document.querySelector('#menu-icon'); 
    const navSection = document.getElementById('nav-section');

    if (menuBtn && navSection) {
        menuBtn.addEventListener('click', function (e) {
            e.preventDefault();
            navSection.classList.toggle('hidden');
        });
    }

    // Hover Effects
    document.querySelectorAll('.icon, li, #logout')
    .forEach(element => {

        element.addEventListener("mouseover", function () {
            this.classList.add("hover");
        });

        element.addEventListener("mouseleave", function () {
            this.classList.remove("hover");
        });

    });

});
</script>
</body>
</html>