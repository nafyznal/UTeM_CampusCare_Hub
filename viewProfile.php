<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile </title>
    <link rel="stylesheet" type="text/css" href="formatProfile.css">
</head>
<body>
    <?php 
    include'headerProfile.php';
    include'connect.php';
    ?>

    <img src="icon/DSC00336.JPG"><br>
    <center>
        <div id="profile-container" class="center">
            
            <table>
                <tr>
                    <th>Student ID : </th>
                    <td></td>
                </tr>
                <tr>
                    <th>Name : </th>
                    <td></td>
                </tr>
                <tr>
                    <th>Email : </th>
                    <td></td>
                </tr>
                <tr>
                    <th>Category : </th>
                    <td></td>
                </tr>
                <tr>
                    <th>Gender : </th>
                    <td></td>
                </tr>
            </table>
        </div>

    </center>
    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const menuBtn = document.getElementById('menu-icon');
            const sidebar = document.getElementById('nav-section');

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
    <?php include'footer.php' ?>
</body>

</html>