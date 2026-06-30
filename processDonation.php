<?php
session_start();
include("connectDonation.php");

// Basic validation
$name       = trim($_POST['name'] ?? '');
$amount     = $_POST['amount'] ?? '';
$visibility = $_POST['visibility'] ?? '';
$payment    = $_POST['payment'] ?? '';
$categories = $_POST['category'] ?? []; // Mengambil array category[]

if ($name === '' || $amount === '' || $payment === '') {
    die("Missing required donation information.");
}

$displayName = ($visibility === "Anonymous") ? "Anonymous" : $name;

// JIKA USER TAK TICK MANA-MANA CATEGORY, LETAKKAN NILAI DEFAULT
if (empty($categories)) {
    $categoryString = "General";
} else {
    // Join multiple categories into one string, e.g. "Food, Necessity"
    $categoryString = implode(", ", $categories);
}

$_SESSION['name']   = $displayName;
$_SESSION['amount'] = $amount;

// === DI SINI PUNCA UTAMANYA ===
// Tukar kepada format 'Y-m-d' sahaja supaya padan dengan kolum 'date' dalam phpMyAdmin
$dateTime = date("Y-m-d");

// Reference number (UI only)
$reference = "REF" . rand(10000, 99999);

// Insert using a prepared statement
$stmt = $conn->prepare("INSERT INTO donation (DonorName, DonationType, DonationCategory, Amount, Date) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssds", $displayName, $payment, $categoryString, $amount, $dateTime);
$stmt->execute();
$stmt->close(); // Tutup statement selepas selesai eksekusi
$conn->close(); // Tutup connection untuk keselamatan data
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>

    <link rel="stylesheet" href="donation.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

<div class="container">

    <a href="donation.php" class="back-btn">
        <i class="fa-solid fa-arrow-left"></i>
    </a>

    <div class="success-card">
        <h1>Payment Successful</h1>

        <div class="success-image">
            <img src="successful.png" alt="Success">
        </div>

        <div class="payment-details">

            <p><strong>Reference:</strong> <?php echo htmlspecialchars($reference); ?></p>

            <p><strong>Payment Date :</strong> <?php echo htmlspecialchars($dateTime); ?></p>

            <p><strong>Payment With :</strong> <?php echo htmlspecialchars($payment); ?></p>

            <p><strong>Total Amount:</strong> RM <?php echo number_format((float)$amount, 2); ?></p>

            <p><strong>Status:</strong> Successful</p>

        </div>

    </div>
</div>

</body>
</html>