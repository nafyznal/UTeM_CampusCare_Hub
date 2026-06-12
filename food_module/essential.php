<?php
// === HANDLE FORM SUBMISSION ===
$message = "";
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Kit_Id  = $_POST['Kit_Id'] ?? 'Unknown';
    $status  = "Pending";
    $date    = date("Y-m-d H:i:s");

    $data = $date . " | " . $Kit_Id . " | " . $status . "\n";

    if (file_put_contents("requests.txt", $data, FILE_APPEND | LOCK_EX) !== false) {
        $message = "Request untuk $Kit_Id berjaya disimpan!";
        $success = true;
    } else {
        $message = "Error: Gagal menulis data ke dalam fail.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kit</title>
    <link rel="stylesheet" type="text/css" href="format.css">
    <style>
        /* untuk rightSide */
        #rightSide{
            float: right;
            width: 65%;
            margin-top: 70px;
            padding: 20px 10px;          
            right: 0;          
            height: calc(100% - 70px);
        }
        .essential {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: flex-start;
            background-color: grey;
            background-size: cover;
            background-position: center;
            color: white;
            border-radius: 7pt;
            margin: 10pt;
            padding: 7pt;
            width: 65%;
        }

        .toiletries { background-image: url("image/toiletries.jpeg"); }
        .personalCare  { background-image: url("image/personalCare.jpeg"); }
        .sanitaryPad { background-image: url("image/sanitaryPad.jpeg");}

        .desc {
            display: none;
            color: white;
            padding: 10px;
            margin-top: 5px;
            border-radius: 6px;
            font-size: 14px;
        }

        /* Show descriptions on mobile (no hover available) */
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

<?php include 'kitHeader.php'; ?>

<div id="rightSide">

    <!-- Tab Navigation -->
    <div class="food" id="flex-container">
        <button type="button" class="dfood" onclick="location.href='kit.php'">KIT</button>
        <button type="button" class="dfood" onclick="location.href='meal.php'">MEAL</button>
    </div>

    <!-- Toiletries -->
    <div class="essential toiletries">
        <span class="kfood">Toiletries</span>
        <div class="desc" id="toiletriesDesc">
            <p>Description:</p>
            <p>Colgate, berus gigi, sabun mandi, sabun baju</p>
        </div>
        <form method="POST" action="">
            <input type="hidden" name="Kit_Id" value="KIT-001">
            <button type="submit" class="request">Request Mini Kit</button>
        </form>
    </div>

    <!-- PersonalCare -->
    <div class="essential personalCare">
        <span class="kfood">Personal Care</span>
        <div class="desc" id="personalCareDesc">
            <p>Description:</p>
            <p>Softener, sabun baju</p>
        </div>
        <form method="POST" action="">
            <input type="hidden" name="Kit_Id" value="KIT-002">
            <button type="submit" class="request">Request Big Kit</button>
        </form>
    </div>

    <!-- Sanitary Pad -->
    <div class="essential sanitaryPad">
        <span class="kfood">Sanitary Pad</span>
        <div class="desc" id="sanitaryPadDesc">
            <p>Description:</p>
            <p>Oreo, Lexus, Chocolate "Aik Cheong"</p>
        </div>
        <form method="POST" action="">
            <input type="hidden" name="Kit_Id" value="KIT-002">
            <button type="submit" class="request">Request Big Kit</button>
        </form>
    </div>
</div>

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

    // === KIT HOVER DESCRIPTIONS ===
    function addHoverToggle(boxSelector, descId) {
        const box  = document.querySelector(boxSelector);
        const desc = document.getElementById(descId);
        if (!box || !desc) return;
        box.addEventListener('mouseenter', () => desc.style.display = 'block');
        box.addEventListener('mouseleave', () => desc.style.display = 'none');
    }

    addHoverToggle('.kit.mini', 'miniDesc');
    addHoverToggle('.kit.big',  'bigDesc');

    // === SIDEBAR & DROPDOWN ===
    document.addEventListener("DOMContentLoaded", function () {
        const menuBtn = document.getElementById('menu-btn');
        const sidebar = document.getElementById('mySidebar');

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
    document.querySelectorAll(".icon").forEach(icon => {
        icon.addEventListener("mouseover",  () => icon.classList.add("hover"));
        icon.addEventListener("mouseleave", () => icon.classList.remove("hover"));
    });
</script>

<?php include 'footer.php'; ?>
</body>
</html>