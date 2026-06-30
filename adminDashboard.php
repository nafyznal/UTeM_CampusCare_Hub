<?php 
// 1. Start secure session
session_start([
    'cookie_httponly' => true,
    'cookie_samesite' => 'Strict'
]);

// 2. Admin Authentication Guard
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: index.php");
    exit;
}

// 3. Database Connection (Using modern Object-Oriented approach)
$servername = "127.0.0.1:3301"; // Updated to match your port configuration
$username   = "root";
$password   = "";
$dbname     = "campuscare_hub";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// 4. Fetch All Recent Requests
$sql = "SELECT request.*, student.Name, kit.KitName 
        FROM request
        JOIN student ON request.StudentId = student.StudentId
        JOIN kit ON request.Kit_Id = kit.Kit_Id
        ORDER BY request.RequestID DESC";
$result = $conn->query($sql);

$sql_count = "SELECT COUNT(*) as total FROM request";
$result_count = $conn->query($sql_count);
$row_count = $result_count->fetch_assoc();

// 1. Ambil Jumlah Dana Kategori Food
$queryFood = "SELECT SUM(Amount) AS total FROM donation WHERE DonationCategory LIKE '%Food%'";
$resultFood = $conn->query($queryFood);
$rowFood = $resultFood->fetch_assoc();
$totalFood = $rowFood['total'] ?? 0;

// 2. Ambil Jumlah Dana Kategori Necessity
$queryNecessity = "SELECT SUM(Amount) AS total FROM donation WHERE DonationCategory LIKE '%Necessity%'";
$resultNecessity = $conn->query($queryNecessity);
$rowNecessity = $resultNecessity = $resultNecessity->fetch_assoc();
$totalNecessity = $rowNecessity['total'] ?? 0;

$sql_donor = "SELECT * FROM donation ORDER BY DonationID DESC";
$result_donor = $conn->query($sql_donor);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="formatAdmin.css">
</head>
<body>
    <?php include("headerAdmin.php"); ?>
    
    <main class="grid-container">
        <!-- Requests Total Card -->
        <div class="card">
            <div class="icon-container">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="7" r="3" />
                    <path d="M5 20a7 7 0 0 1 14 0" />
                    <line x1="5" y1="20" x2="19" y2="20" />
                </svg>
            </div>
            <div class="content">
                <span class="value"><?php echo (int)($row_count['total'] ?? 0); ?></span>
                <span class="label">Request</span>
            </div>
        </div>

        <!-- Food Donation Card -->
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
                <span class="value">
                    RM <?php echo number_format($totalFood, 2); ?>
                </span>
                <span class="label">Food</span>
            </div>
        </div>

        <!-- Necessity Donation Card -->
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
                <span class="value">
                    RM <?php echo number_format($totalNecessity, 2); ?>
                </span>
                <span class="label">Necessity</span>
            </div>
        </div>

        <!-- Recent Requests Table -->
        <div class="table-recent">
            <h2>Recent Request</h2>
            <table class="recent-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Request</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['Name'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['KitName'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="<?php 
                                if($row['Status'] == 'Approved') echo 'status-approved';
                                else if ($row['Status'] == 'Pending' ) echo 'status-pending';
                                else if ($row['Status'] == 'Rejected') echo 'status-rejected';
                            ?>">
                                <?php echo htmlspecialchars($row['Status'], ENT_QUOTES, 'UTF-8'); ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="3" style="text-align:center;">No recent requests found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Recent Donors Table -->
        <div class="table-recent">
            <h2>Recent Donor</h2>
            <table class="recent-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result_donor && $result_donor->num_rows > 0): ?>
                        <?php while ($row_donor = $result_donor->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row_donor['DonorName'] ?? 'Anonymous', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row_donor['DonationType'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>RM <?php echo number_format($row_donor['Amount'] ?? 0, 2); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="3" style="text-align:center;">No recent donations found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
      
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
        document.querySelectorAll('.icon, li, #logout').forEach(element => {
            element.addEventListener("mouseover", function () {
                this.classList.add("hover");
            });
            element.addEventListener("mouseleave", function () {
                this.classList.remove("hover");
            });
        });
    });

    // jQuery checks to see if library exists safely
    if (typeof jQuery !== 'undefined') {
        $(document).ready(function(){
            // Fade in
            $('body').hide().fadeIn(1000);

            // Sidebar Toggle (jQuery fallback)
            $('#menu-icon').click(function(e){
                e.preventDefault();
                $('#nav-section').toggleClass('hidden');
            });
        });
    }
    </script>
    <?php include("footer.php"); ?>
</body>
</html>