<?php 
session_start();

if (!isset($_SESSION['StudentId'])) {
    header("location: index.php");
    exit;
}

$StudentId = $_SESSION['StudentId'];
include('connect.php');

$sql_user = "SELECT * FROM student WHERE StudentId = $StudentId";
$result_user = $conn->query($sql_user);

$sql_count = "SELECT COUNT(*) as totalReq FROM request WHERE StudentId = $StudentId";
$result_count = $conn->query($sql_count);
$row_count = $result_count->fetch_assoc();
$totalReq = $row_count['totalReq'];

if ($result_user && $result_user->num_rows > 0) {
    $row = $result_user->fetch_assoc();
    $_SESSION['Picture'] = $row['Picture'];
    $_SESSION['username'] = $row['Name'];
}

$username = $_SESSION['username'] ?? 'Guest';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" type="text/css" href="formatProfile.css">
</head>
<body>
    <?php 
    include('headerProfile.php');
    ?>

    <div class="responsive">
        <div class="image">
            <?php if (!empty($row['Picture']) && file_exists($row['Picture'])): ?>
                <img src="<?php echo htmlspecialchars($row['Picture']); ?>" 
                    alt="Profile Picture" class="profile" onclick="openLightbox(this)">
            <?php else: ?>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" class="profile" onclick="openLightbox(this)">
                    <circle cx="50" cy="50" r="50" fill="#541A1A"/>
                    <circle cx="50" cy="38" r="18" fill="white"/>
                    <ellipse cx="50" cy="85" rx="28" ry="20" fill="white"/>
                </svg>
            <?php endif; ?>
        </div>
    </div>

    <div id="lightbox" onclick="closeLightbox()">
        <span id="lightbox-close">&times;</span>
        <img id="lightbox-img" src="" alt="Enlarged Profile Picture">
    </div>
    

    <div class="box-analysis">
        <div id="totalreq">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
                <line x1="16" y1="13" x2="8" y2="13"/>
                <line x1="16" y1="17" x2="8" y2="17"/>
                <polyline points="10 9 9 9 8 9"/>
            </svg>
            <p>Total Requests</p>
            <h2><?php echo $totalReq; ?></h2>
        </div>
    </div>
    <center>
        <div id="profile-container" class="center">
            
            <table>
                <tr>
                    <th>Student ID : </th>
                    <td><?php echo isset($row['StudentId']) ? htmlspecialchars($row['StudentId']) : "";?></td>
                </tr>
                <tr>
                    <th>Name : </th>
                    <td><?php echo isset($row['Name']) ? htmlspecialchars($row['Name']) : "";?></td>
                </tr>
                <tr>
                    <th>Email : </th>
                    <td><?php echo isset($row['Email']) ? htmlspecialchars($row['Email']) : "";?></td>
                </tr>
                <tr>
                    <th>Gender : </th>
                    <td><?php echo isset($row['Gender']) ? htmlspecialchars($row['Gender']) : "";?></td>
                </tr>
            </table>
        </div>

    </center>
    <?php include('updateProfile.php') ?>
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

        document.querySelectorAll(".icon,img,svg").forEach(icon=>{
            icon.addEventListener("mouseover",()=>{
                icon.classList.add("hover")
            });

            icon.addEventListener("mouseleave",()=>{
                icon.classList.remove("hover")
            });

        });

        function openLightbox(img) {
            const lightbox = document.getElementById('lightbox');
            const lightboxImg = document.getElementById('lightbox-img');
            lightboxImg.src = img.src;
            lightbox.classList.add('active');
        }

        function closeLightbox() {
            document.getElementById('lightbox').classList.remove('active');
        }

        // Close with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeLightbox();
        });
    </script>
    <?php include('footer.php') ?>
</body>

</html>