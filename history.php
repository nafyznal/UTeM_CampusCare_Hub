<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['em'])) {
    header("Location: index.php");
    exit;
}

$student_email = $_SESSION['em'];

$servername = "127.0.0.1:3301";
$username   = "root";
$password   = "";
$dbname     = "campuscare_hub";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$student_id = null;
$stmtUser = $conn->prepare("SELECT StudentId FROM student WHERE email = ?");
if ($stmtUser) {
    $stmtUser->bind_param("s", $student_email);
    $stmtUser->execute();
    $resUser = $stmtUser->get_result();
    if ($rowUser = $resUser->fetch_assoc()) {
        $student_id = $rowUser['StudentId'];
    }
    $stmtUser->close();
}

$history_data = [];

if ($student_id !== null) {
    $query = "SELECT r.RequestDate, r.Kit_Id, r.Status, k.KitName 
              FROM request r 
              LEFT JOIN kit k ON r.Kit_Id = k.Kit_Id 
              WHERE r.StudentId = ? 
              ORDER BY r.RequestID DESC";
    
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $history_data[] = $row;
        }
        $stmt->close();
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UTeM Campus Care - History</title>
    <link rel="stylesheet" href="formatHistory.css">
</head>
<body>
    <?php include ('headerHistory.php'); ?>

    <main class="main-container" id="mainContent">
        <div class="title-container"></div>

        <div class="table-container">
            <table class="history-table">    
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Request Item</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($history_data)): ?>
                        <?php foreach ($history_data as $row): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($row['RequestDate'])) ?></td>
                                
                                <td><?= htmlspecialchars($row['KitName'] ?? $row['Kit_Id']) ?></td>
                                
                                <td>
                                    <?php 
                                    $statusColor = 'orange'; // Warna laluan (Pending)
                                    if ($row['Status'] === 'Approved') { 
                                        $statusColor = 'green'; 
                                    } elseif ($row['Status'] === 'Rejected') { 
                                        $statusColor = 'red'; 
                                    }
                                    ?>
                                    <span class="status-badge" style="font-weight: bold; color: <?= $statusColor ?>;">
                                        <?= htmlspecialchars($row['Status']) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" style="padding: 20px; color: #666;">No request history found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <script>
         document.addEventListener("DOMContentLoaded", function () {
            const menuBtn = document.getElementById('menu-btn');
            const sidebar = document.getElementById('nav-section');

            if (menuBtn && sidebar) {
                menuBtn.addEventListener('click', function (event) {
                    event.stopPropagation();
                    sidebar.classList.toggle('hidden');
                });
            }

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

            document.addEventListener('click', function (event) {
                if (sidebar && !sidebar.contains(event.target) && !menuBtn.contains(event.target)) {
                    sidebar.classList.add('hidden');
                }
            });
        });

        function prosesLogout() {
            window.location.href = "index.php";
        }

        document.querySelectorAll(".icon,svg,img").forEach(icon=>{
            icon.addEventListener("mouseover",()=>{
                icon.classList.add("hover");
            });
            icon.addEventListener("mouseleave",()=>{
                icon.classList.remove("hover");
            });
        });
    </script>
    <?php include 'footer.php'; ?>
</body>
</html>