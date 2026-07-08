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

        @media (max-width: 768px) {
            .desc { display: block !important; }
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
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            position: relative;
        }

        #backIcon {
            position: absolute;
            top: 10px; left: 10px;
            cursor: pointer;
            width: 24px;
        }

        .medium { width: 50px; height: 50px; }
    </style>
</head>
<body>

<?php include 'headerSign.php'; ?>

<div id="rightSide">

    <center>
    <div class="food" id="flex-container">
        <button type="button" class="dfood" onclick="location.href='kitLogin.php'" style="border-radius: 20px;">KIT</button>
        <button type="button" class="dfood" onclick="location.href='mealLogin.php'" style="border-radius: 20px;">MEAL</button>
    </div>
    </center>
<?php 
$message = "";
$success = false;

$conn = new mysqli("localhost:3301", "root", "", "campuscare_hub");
if($conn->connect_error){
    die("Connection failed: " .$conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Kit_Id = $_POST['Kit_Id'] ?? '';

    $message = "You should register first before make a request";
    $success = false;
}

// Fetch kit items
$result = $conn->query("SELECT Kit_Id, KitName, Description, Picture FROM kit WHERE Kit_Id LIKE 'KIT%'");
?>

<!-- Kit Request -->
<?php
while ($row = $result->fetch_assoc()) {
    $pic       = $row['Picture'] ?? '';
    $hasPic    = !empty($pic);
    $bgStyle   = $hasPic ? "background-image: url('" . htmlspecialchars($pic) . "');" : "";
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
?>

</div><!-- /#rightSide -->

<!-- Popup -->
<div id="popup" class="popup">
    <div class="popup-content">
        <img src="image/arrowUpLeft.svg" id="backIcon" alt="Close">
        <img src="<?php echo $success ? 'image/success.png' : 'image/error.png'; ?>" class="medium" alt="Status">
        <h3 id="popupMessage"><?php echo htmlspecialchars($message); ?></h3>
    </div>
</div>

<script>
    // === POPUP: Auto-show if server returned a message ===
    const serverMessage = <?php echo json_encode($message); ?>;

    if (serverMessage !== "") {
        document.getElementById('popup').style.display = 'flex';
    }

    document.getElementById('backIcon').addEventListener('click', () => {
        document.getElementById('popup').style.display = 'none';
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

    // === ICON HOVER EFFECT ===
    document.querySelectorAll(".icon,svg.img").forEach(icon => {
        icon.addEventListener("mouseover",  () => icon.classList.add("hover"));
        icon.addEventListener("mouseleave", () => icon.classList.remove("hover"));
    });
</script>

<?php include 'footer.php'; ?>
</body>
</html>