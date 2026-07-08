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
        .essential {
            margin: 20px auto 30px auto;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: flex-start;
            background-color: grey;
            background-size: cover;
            background-position: center;
            color: white;
            border-radius: 7pt;
            padding: 7pt;
            width: 65%;
        }
        .desc {
            display: none;
            color: white;
            padding: 10px;
            margin-top: 5px;
            border-radius: 6px;
            font-size: 14px;
        }
        .essential .desc{
            display: none;
        }
        .essential:hover .desc{
            display: block;
        }
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
        }
        .request:hover{
            background-color: #6a2323;
            transform: scale(1.05);
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

<?php include ('headerKit.php'); ?>

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
    $StudentId = $_SESSION['StudentId'] ?? '';
    $status = "Pending";
    $date = date("Y-m-d");

    $grpStmt = $conn->prepare("SELECT id_group FROM student WHERE StudentId=?");
    $grpStmt->bind_param("i", $StudentId);
    $grpStmt->execute();
    $grpStmt->bind_result($id_group);
    $grpStmt->fetch();
    $grpStmt->close();

    $intervalDays = 0;
    if (strpos($id_group, 'B') === 0) $intervalDays = 14;
    elseif (strpos($id_group, 'M') === 0) $intervalDays = 30;
    elseif (strpos($id_group, 'T') === 0) $intervalDays = 60;

    $lastStmt = $conn->prepare("SELECT RequestDate 
                                FROM request 
                                WHERE StudentId=? AND Kit_Id=? 
                                ORDER BY RequestDate DESC LIMIT 1");
    $lastStmt->bind_param("is", $StudentId, $Kit_Id);
    $lastStmt->execute();
    $lastStmt->bind_result($lastDate);
    $hasLast = $lastStmt->fetch();
    $lastStmt->close();

    if ($hasLast) {
        $nextAllowed = date("Y-m-d", strtotime($lastDate . " +$intervalDays days"));
        if ($date < $nextAllowed) {
            $message = "You can only request $Kit_Id again after $nextAllowed.";
            $success = false;
        } else {
            $stmt = $conn->prepare("INSERT INTO request (Kit_Id, StudentId, Status, RequestDate) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("siss", $Kit_Id, $StudentId, $status, $date);
            if ($stmt->execute()) {
                $message = "Request for $Kit_Id submitted successfully!";
                $success = true;
            } else {
                $message = "Error: " . $stmt->error;
                $success = false;
            }
        }
    } else {
        $stmt = $conn->prepare("INSERT INTO request (Kit_Id, StudentId, Status, RequestDate) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siss", $Kit_Id, $StudentId, $status, $date);
        if ($stmt->execute()) {
            $message = "Request for $Kit_Id submitted successfully!";
            $success = true;
        } else {
            $message = "Error: " . $stmt->error;
            $success = false;
        }
    }
}
?>

<!-- Essential Request -->
<?php
$conn = new mysqli("localhost:3301", "root", "", "campuscare_hub");
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

$result = $conn->query("SELECT Kit_Id, KitName, Description, Picture FROM kit WHERE Kit_Id LIKE 'ESS%'");

while ($row = $result->fetch_assoc()) {
?>
    <div class="essential" style="background-image:url('<?php echo $row['Picture']; ?>');">
        <span class="kfood"><?php echo $row['KitName']; ?></span>
        <div class="desc">
            <p>Description:</p>
            <p><?php echo $row['Description']; ?></p>
        </div>
        <form method="POST" action="">
            <input type="hidden" name="Kit_Id" value="<?php echo $row['Kit_Id']; ?>">
            <br><button type="submit" class="request">Request <?php echo $row['KitName']; ?></button>
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
    document.querySelectorAll(".icon").forEach(icon => {
        icon.addEventListener("mouseover",  () => icon.classList.add("hover"));
        icon.addEventListener("mouseleave", () => icon.classList.remove("hover"));
    });
</script>

<?php include 'footer.php'; ?>
</body>
</html>