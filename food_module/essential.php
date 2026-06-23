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
            margin-top: 70px;      /* sama dengan tinggi header */
            margin-bottom: 50px;   /* sama dengan tinggi footer */
            padding: 20px 10px;
            width: 65%;
            margin-left: auto;
            margin-right: auto;    /* center di tengah */
            min-height: calc(100vh - 70px - 50px); /* muat antara header & footer */
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

<?php include 'aidHeader.php'; ?>

<div id="rightSide">

<?php 
$message = "";
$success = false;

$conn = new mysqli("localhost", "root", "root1234", "campuscare_hub");
if($conn->connect_error){
    die("Connection failed: " .$conn->connect_error);
}
if($_SERVER['REQUEST_METHOD']==='POST'){
    $Kit_Id = $_POST['Kit_Id'] ?? '';
    $StudentId = $_SESSION['StudentId'] ?? '';
    $status = "Pending";
    $date = date("Y-m-d");

    $check = $conn->prepare("SELECT 1 FROM request WHERE StudentId=? AND Kit_Id=?");
    $check->bind_param("is", $StudentId, $Kit_Id);
    $check->execute();
    $check->store_result();

    if($check->num_rows > 0){
        $message = "You already request this kit.";
        $success = false;
    }else{
        $stmt = $conn->prepare("INSERT INTO request (Kit_Id, StudentId, Status, RequestDate) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siss", $Kit_Id, $StudentId, $status, $date);

        if($stmt->execute()){
            $message = "Request for $Kit_Id submitted successfully!";
            $success = true;
        }else{
            $message = "Error: " .$stmt->error;
            $success = false;
        }
    }
}
?>

<!-- Essential Request -->
<?php
$conn = new mysqli("localhost", "root", "root1234", "campuscare_hub");
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
            <button type="submit" class="request">Request <?php echo $row['KitName']; ?></button>
        </form>
    </div>
<?php
}
?>
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