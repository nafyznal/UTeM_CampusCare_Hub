<?php
session_start();

if (!isset($_SESSION['StudentId'])) {
    header("Location: login.php");
    exit;
}

$studentId = (int) $_SESSION['StudentId'];

$conn = new mysqli("localhost:3301", "root", "", "campuscare_hub");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT r.RequestID, r.RequestDate, k.KitName
        FROM request r
        JOIN kit k ON r.Kit_Id = k.Kit_Id
        WHERE r.StudentId = ? AND r.Status = 'Approved'
        ORDER BY r.RequestDate ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $studentId);
$stmt->execute();
$result = $stmt->get_result();

$approvedRequests = [];
while ($row = $result->fetch_assoc()) {
    $approvedRequests[] = $row;
}

$stmt->close();
$conn->close();

// Collection point details (static for now — move to a DB table later if
// different kits/meals end up being collected from different locations).
$collectPoint = [
    "place" => "Pusat Pelajar UTeM",
    "map"   => "https://maps.google.com/?q=Pusat+Pelajar+UTeM",
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan and Collect</title>
    <link rel="stylesheet" href="format.css">
</head>

<body>

<?php include("headerScan.php"); ?>

<main class="scan-main">
    <h2>Scan & Collect</h2>

    <div class="qr-list">
        <?php if (count($approvedRequests) > 0): ?>
            <?php foreach($approvedRequests as $request): ?>
                <?php
                // QR must contain ONLY the plain numeric RequestID.
                // scanner.php validates with ctype_digit(), so no labels,
                // no separators, no extra text - just the number.
                $qrData = (string) $request["RequestID"];

                $qrUrl =
                    "https://api.qrserver.com/v1/create-qr-code/?size=220x220&data="
                    . urlencode($qrData);
                ?>

                <div class="qr-card">
                    <h3><?php echo htmlspecialchars($request["KitName"]); ?></h3>

                    <img src="<?php echo $qrUrl; ?>" alt="QR Code" class="qr-code">

                    <p class="instruction">Please show this QR code to the staff</p>

                    <div class="collect-info">
                        <p><strong>Request ID:</strong> <?php echo $request["RequestID"]; ?></p>
                        <p><strong>Date:</strong> <?php echo date("d/m/Y", strtotime($request["RequestDate"])); ?></p>
                        <p>
                            <strong>Collection Point:</strong>
                            <?php echo htmlspecialchars($collectPoint["place"]); ?>
                        </p>
                        <p>
                            <a href="<?php echo htmlspecialchars($collectPoint["map"]); ?>"
                               target="_blank" rel="noopener noreferrer"
                               class="map-link">
                                View on Map
                            </a>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-requests">You have no approved requests to collect yet.</p>
        <?php endif; ?>
    </div>
</main>

<?php include("footer.php"); ?>

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

</body>
</html>