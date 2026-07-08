<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kit</title>
    <link rel="stylesheet" type="text/css" href="format.css">
    <style>
        #rightSide{ 
            margin-top: 70px;      
            margin-bottom: 50px;   
            padding: 20px 10px;
            width: 65%;
            margin-left: auto;
            margin-right: auto;    
            min-height: calc(100vh - 70px - 50px);
        }
        .dfood {
            background-color: #541A1A;  
            color: #fff;
            padding: 10px 20px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            margin: 5px;
        }
        .dfood:hover {
            background-color: #6a2323;
            transform: scale(1.05);
        }
        .kit {
            margin: 20px auto 30px auto;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            align-items: flex-start;
            background-color: #541A1A;
            background-size: cover;
            background-position: center;
            color: white;
            border-radius: 12px;
            padding: 0;
            width: 65%;
            min-height: 160px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(84,26,26,0.25);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .kit:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(84,26,26,0.35);
        }

        /* Dark gradient overlay so text is always readable over any image */
        .kit-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                to bottom,
                rgba(0,0,0,0.10) 0%,
                rgba(84,26,26,0.75) 60%,
                rgba(84,26,26,0.95) 100%
            );
            border-radius: 12px;
        }

        /* Fallback pattern when no image */
        .kit-no-img {
            background-image: repeating-linear-gradient(
                135deg,
                rgba(255,255,255,0.03) 0px,
                rgba(255,255,255,0.03) 1px,
                transparent 1px,
                transparent 12px
            ) !important;
        }

        .kit-body {
            position: relative;
            z-index: 1;
            padding: 18px 20px 16px 20px;
            width: 100%;
            box-sizing: border-box;
        }

        .kfood {
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 0.5px;
            display: block;
            margin-bottom: 4px;
        }

        .desc {
            display: none;
            color: rgba(255,255,255,0.85);
            font-size: 13px;
            margin-bottom: 10px;
            line-height: 1.5;
        }
        .kit:hover .desc {
            display: block;
        }

        .request {
            display: inline-block;
            white-space: nowrap;
            padding: 8px 18px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            background: rgba(255,255,255,0.15);
            color: #fff;
            border: 1.5px solid rgba(255,255,255,0.45);
            backdrop-filter: blur(4px);
            transition: background 0.2s ease, transform 0.15s ease;
            margin-top: 8px;
        }
        .request:hover {
            background: rgba(255,255,255,0.30);
            transform: scale(1.04);
        }

        /* Show desc always on mobile */

        /* Show descriptions on mobile */
        @media (max-width: 768px) {
            .desc { display: block !important; }
        }

        /* === POPUP === */
        .popup {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        .popup-content {
            background: white;
            color: black;
            padding: 30px 20px 20px 20px;
            border-radius: 10px;
            text-align: center;
            position: relative;
            min-width: 280px;
            max-width: 400px;
        }

        /* Close button — pure CSS/SVG, no external image needed */
        #backIcon {
            position: absolute;
            top: 10px;
            left: 10px;
            cursor: pointer;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: background 0.2s;
        }
        #backIcon:hover {
            background: #f0f0f0;
        }

        /* Status icon — CSS-drawn circle, no external image needed */
        .status-icon {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px auto;
            font-size: 28px;
            font-weight: bold;
        }
        .status-icon.success {
            background-color: #e6f4ea;
            color: #2e7d32;
        }
        .status-icon.error {
            background-color: #fdecea;
            color: #c62828;
        }

        #popupMessage {
            font-size: 15px;
            margin: 0;
            line-height: 1.5;
        }
    </style>
</head>
<body>

<?php include ('headerKit.php'); ?>

<div id="rightSide">

    <!-- Tab Navigation -->
    <center>
    <div class="food" id="flex-container">
        <button type="button" class="dfood" onclick="location.href='kit.php'" style="border-radius: 20px;">KIT</button>
        <button type="button" class="dfood" onclick="location.href='meal.php'" style="border-radius: 20px;">MEAL</button>
    </div>
    </center>

<?php 
$message = "";
$success = false;

$conn = new mysqli("localhost:3301", "root", "", "campuscare_hub");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Kit_Id    = $_POST['Kit_Id'] ?? '';
    $StudentId = $_SESSION['StudentId'] ?? '';
    $status    = "Pending";
    $date      = date("Y-m-d");

    // Get student group
    $grpStmt = $conn->prepare("SELECT id_group FROM student WHERE StudentId=?");
    $grpStmt->bind_param("i", $StudentId);
    $grpStmt->execute();
    $grpStmt->bind_result($id_group);
    $grpStmt->fetch();
    $grpStmt->close();

    // Determine cooldown interval by group prefix
    $intervalDays = 0;
    if (strpos($id_group, 'B') === 0)      $intervalDays = 14;
    elseif (strpos($id_group, 'M') === 0)  $intervalDays = 30;
    elseif (strpos($id_group, 'T') === 0)  $intervalDays = 60;

    // Check last request date for this kit
    $lastStmt = $conn->prepare(
        "SELECT RequestDate 
         FROM request 
         WHERE StudentId=? AND Kit_Id=? 
         ORDER BY RequestDate DESC LIMIT 1"
    );
    $lastStmt->bind_param("is", $StudentId, $Kit_Id);
    $lastStmt->execute();
    $lastStmt->bind_result($lastDate);
    $hasLast = $lastStmt->fetch();
    $lastStmt->close();

    $canRequest = true;
    if ($hasLast) {
        $nextAllowed = date("Y-m-d", strtotime($lastDate . " +$intervalDays days"));
        if ($date < $nextAllowed) {
            $message    = "You can only request $Kit_Id again after $nextAllowed.";
            $success    = false;
            $canRequest = false;
        }
    }

    if ($canRequest) {
        $stmt = $conn->prepare(
            "INSERT INTO request (Kit_Id, StudentId, Status, RequestDate) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("siss", $Kit_Id, $StudentId, $status, $date);
        if ($stmt->execute()) {
            $message = "Request for $Kit_Id submitted successfully!";
            $success = true;
        } else {
            $message = "Error: " . $stmt->error;
            $success = false;
        }
        $stmt->close();
    }
}
?>

<!-- Kit Cards -->
<?php
$conn2 = new mysqli("localhost:3301", "root", "", "campuscare_hub");
if ($conn2->connect_error) { die("Connection failed: " . $conn2->connect_error); }

$result = $conn2->query("SELECT Kit_Id, KitName, Description, Picture FROM kit WHERE Kit_Id LIKE 'KIT%'");

// Map Kit_Id to local image files
$kitImages = [
    'KIT-001' => 'images/miniKit.jpeg',
    'KIT-002' => 'images/bigKit.jpeg',
];

while ($row = $result->fetch_assoc()) {
    $pic = $kitImages[$row['Kit_Id']] ?? $row['Picture'] ?? '';
    $hasPic = !empty($pic);
    $bgStyle = $hasPic ? "background-image: url('" . htmlspecialchars($pic) . "');" : "";
    $noImgClass = $hasPic ? "" : "kit-no-img";
?>
    <div class="kit <?php echo $noImgClass; ?>" style="<?php echo $bgStyle; ?>">
        <div class="kit-overlay"></div>
        <div class="kit-body">
            <span class="kfood"><?php echo htmlspecialchars($row['KitName']); ?></span>
            <div class="desc">
                <?php echo htmlspecialchars($row['Description']); ?>
            </div>
            <form method="POST" action="">
                <input type="hidden" name="Kit_Id" value="<?php echo htmlspecialchars($row['Kit_Id']); ?>">
                <button type="submit" class="request">
                    Request <?php echo htmlspecialchars($row['KitName']); ?>
                </button>
            </form>
        </div>
    </div>
<?php
}
$conn2->close();
?>

</div><!-- /#rightSide -->

<!-- ===== POPUP ===== -->
<div id="popup" class="popup">
    <div class="popup-content">

        <!-- Close / back icon — inline SVG arrow, no file needed -->
        <div id="backIcon" title="Close">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                 fill="none" stroke="#541A1A" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"/>
                <polyline points="12 19 5 12 12 5"/>
            </svg>
        </div>

        <!-- Status icon — pure CSS circle + emoji, no image file needed -->
        <div class="status-icon <?php echo $success ? 'success' : 'error'; ?>">
            <?php echo $success ? '✓' : '✗'; ?>
        </div>

        <h3 id="popupMessage"><?php echo htmlspecialchars($message); ?></h3>
    </div>
</div>

<script>
    // Auto-show popup if server returned a message
    const serverMessage = <?php echo json_encode($message); ?>;
    if (serverMessage !== "") {
        document.getElementById('popup').style.display = 'flex';
    }

    // Close popup on back icon click
    document.getElementById('backIcon').addEventListener('click', () => {
        document.getElementById('popup').style.display = 'none';
    });

    // Also close popup when clicking the dark overlay
    document.getElementById('popup').addEventListener('click', function (e) {
        if (e.target === this) {
            this.style.display = 'none';
        }
    });

    // === SIDEBAR & DROPDOWN ===
    document.addEventListener("DOMContentLoaded", function () {
        const menuBtn = document.getElementById('menu-btn');
        const sidebar = document.getElementById('nav-section');

        menuBtn?.addEventListener('click', function (e) {
            e.stopPropagation();
            sidebar.classList.toggle('hidden');
        });

        document.addEventListener('click', function (e) {
            if (sidebar && !sidebar.contains(e.target) && !menuBtn?.contains(e.target)) {
                sidebar.classList.add('hidden');
            }
        });
    });

    window.toggleSubMenu = function (e) {
        e.stopPropagation();
        document.getElementById('aidSubMenu')?.classList.toggle('dropdown-closed');
    };

    window.toggleFoodMenu = function (e) {
        e.stopPropagation();
        document.getElementById('foodSubMenu')?.classList.toggle('dropdown-closed');
    };

    function prosesLogout() {
        window.location.href = "logout.php";
    }

    // Icon hover effect
    document.querySelectorAll(".icon, svg, img").forEach(icon => {
        icon.addEventListener("mouseover",  () => icon.classList.add("hover"));
        icon.addEventListener("mouseleave", () => icon.classList.remove("hover"));
    });
</script>

<?php include 'footer.php'; ?>
</body>
</html>