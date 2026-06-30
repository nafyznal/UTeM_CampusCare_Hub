<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kit</title>
    <link rel="stylesheet" type="text/css" href="format.css">
    <style>
        /* === LAYOUT AND CONTAINERS === */
        #rightSide { 
            margin-top: 70px;      
            margin-bottom: 50px;   
            padding: 20px 10px;
            width: 65%;
            margin-left: auto;
            margin-right: auto;    
            min-height: calc(100vh - 70px - 50px); 
            box-sizing: border-box;
        }

        .essential {
            margin: 20px auto 30px auto;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: flex-start;
            background-color: #808080; /* Styled gray color fallback */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: #ffffff;
            border-radius: 7pt;
            padding: 15px;
            width: 65%;
            box-sizing: border-box;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        /* === DESCRIPTIONS AND INTERACTION === */
        .desc {
            display: none;
            color: #ffffff;
            padding: 10px 0;
            margin-top: 5px;
            border-radius: 6px;
            font-size: 14px;
            width: 100%;
        }

        /* Standard desktop hover controls */
        .essential:hover .desc {
            display: block;
        }

        /* === BUTTONS AND ACTIONS === */
        .request {
            display: inline-block;       
            white-space: nowrap;                   
            padding: 10px 20px;         
            border-radius: 15px;
            font-size: 14px;
            cursor: pointer;
            min-width: fit-content;     
            max-width: 100%;             
            box-sizing: border-box;  
            border: none;
            background-color: #ffffff;
            color: #000000;
            font-weight: bold;
            transition: background-color 0.2s ease, transform 0.2s ease;
        }

        .request:hover {
            background-color: #6a2323;
            color: #ffffff;
            transform: scale(1.05);
        }

        /* === POPUP OVERLAY === */
        .popup {
            display: none;
            position: fixed;
            top: 0; 
            left: 0;
            width: 100%; 
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .popup-content {
            background: #ffffff;
            color: #000000;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            position: relative;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
            min-width: 280px;
        }

        #backIcon {
            position: absolute;
            top: 12px; 
            left: 12px;
            cursor: pointer;
            width: 24px;
            transition: opacity 0.2s ease;
        }

        #backIcon:hover {
            opacity: 0.7;
        }

        .medium { 
            width: 50px; 
            height: 50px; 
            margin-bottom: 10px;
        }

        /* === RESPONSIVE MEDIA QUERIES === */
        @media (max-width: 768px) {
            #rightSide, .essential { 
                width: 90%; 
            }
            .desc { 
                display: block !important; 
            }
        }
    </style>
</head>
<body>

<?php include 'headerSign.php'; ?>

<div id="rightSide">

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
?>

<!-- Essential Request -->
<?php
$result = $conn->query("SELECT Kit_Id, KitName, Description, Picture FROM kit WHERE Kit_Id LIKE 'ESS%'");

while ($row = $result->fetch_assoc()) {
?>
    <div class="essential" style="background-image:url('<?php echo htmlspecialchars($row['Picture']); ?>');">
        <span class="kfood"><?php echo htmlspecialchars($row['KitName']); ?></span>
        <div class="desc">
            <p><strong>Description:</strong></p>
            <p><?php echo htmlspecialchars($row['Description']); ?></p>
        </div>
        <form method="POST" action="">
            <input type="hidden" name="Kit_Id" value="<?php echo htmlspecialchars($row['Kit_Id']); ?>">
            <br><button type="submit" class="request">Request <?php echo htmlspecialchars($row['KitName']); ?></button>
        </form>
    </div>
<?php
}
?>
</div>

<!-- Popup -->
<div id="popup" class="popup">
    <div class="popup-content">
        <img src="images/arrowUpLeft.svg" id="backIcon" alt="Close">
        <img src="<?php echo $success ? 'images/success.png' : 'images/error.png'; ?>" class="medium" alt="Status">
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

<?php 
$conn->close();
include 'footer.php'; 
?>
</body>
</html>