<?php
session_start();

$username = $_SESSION['username'] ?? 'Student';

$approvedRequests = [
    [
        "request_id" => "REQ1001",
        "student" => $username,
        "item" => "Mini Food Kit",
        "date" => "2026-06-29",
        "time" => "9:00 AM - 12:00 PM",
        "place" => "Pusat Pelajar UTeM",
        "map" => "https://maps.google.com/?q=Pusat+Pelajar+UTeM"
    ],
    [
        "request_id" => "REQ1002",
        "student" => $username,
        "item" => "Essential Kit",
        "date" => "2026-06-30",
        "time" => "2:00 PM - 5:00 PM",
        "place" => "Pusat Pelajar UTeM",
        "map" => "https://maps.google.com/?q=Pusat+Pelajar+UTeM"
    ]
];

usort($approvedRequests, function($a, $b){
    return strtotime($a["date"]) - strtotime($b["date"]);
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan and Collect</title>
    <link rel="stylesheet" href="formatScan.css">
</head>

<body>

<?php include("headerScan.php"); ?>

<main class="scan-main">
    <h2>Scan & Collect</h2>

    <div class="qr-list">
        <?php foreach($approvedRequests as $request): ?>
            <?php
            $qrData =
                "Request ID: " . $request["request_id"] .
                " | Student: " . $request["student"] .
                " | Item: " . $request["item"] .
                " | Date: " . $request["date"] .
                " | Time: " . $request["time"] .
                " | Place: " . $request["place"];

            $qrUrl =
                "https://api.qrserver.com/v1/create-qr-code/?size=220x220&data="
                . urlencode($qrData);
            ?>

            <div class="qr-card">
                <h3><?php echo $request["item"]; ?></h3>

                <img src="<?php echo $qrUrl; ?>" alt="QR Code" class="qr-code">

                <p class="instruction">Please show this QR code to the staff</p>

                <div class="collect-info">
                    <p><strong>Request ID:</strong> <?php echo $request["request_id"]; ?></p>
                    <p><strong>Date:</strong> <?php echo date("d/m/Y", strtotime($request["date"])); ?></p>
                    <p><strong>Time Collection:</strong> <?php echo $request["time"]; ?></p>
                    <p>
                        <strong>Place:</strong>
                        <a href="<?php echo $request["map"]; ?>" target="_blank">
                            <?php echo $request["place"]; ?>
                        </a>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php include("../approveRequest/footer.php"); ?>

<script src="scan.js"></script>

</body>
</html>