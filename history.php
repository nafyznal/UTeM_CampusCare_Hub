<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UTeM Campus Care - History</title>
    <link rel="stylesheet" href="format.css">
</head>
<body>
    <?php  include'historyHeader.php'?>

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
         document.addEventListener("DOMContentLoaded", function () {

            const menuBtn = document.getElementById('menu-btn');
            const sidebar = document.getElementById('mySidebar');

            if (menuBtn && sidebar) {
                menuBtn.addEventListener('click', function (event) {
                    event.stopPropagation();
                    sidebar.classList.toggle('hidden');
                });
            }

            // Dropdown toggles mapped to the explicit IDs inside your header file
            window.toggleSubMenu = function (event) {
                event.stopPropagation();
                const subMenu = document.getElementById('aidSubMenu');
                if (subMenu) subMenu.classList.toggle('dropdown-closed');
            };

            window.toggleFoodMenu = function (event) {
                event.stopPropagation();
                const foodMenu = document.getElementById('foodSubMenu');
                if (foodMenu) foodMenu.classList.toggle('dropdown-closed');
            };

            // Close sidebar dynamically if user clicks outside of it
            document.addEventListener('click', function (event) {
                if (sidebar && !sidebar.contains(event.target) && !menuBtn.contains(event.target)) {
                    sidebar.classList.add('hidden');
                }
            });

        });

        function prosesLogout() {
            window.location.href = "logout.php";
        }

        document.querySelectorAll(".icon").forEach(icon=>{
            icon.addEventListener("mouseover",()=>{
                icon.classList.add("hover")
            });

            icon.addEventListener("mouseleave",()=>{
                icon.classList.remove("hover")
            });

        });
    </script>

</body>
</html>