<?php
session_start();
// include("connectDonation.php");

// POST data
$name = $_POST['name'];
$amount = $_POST['amount'];
$visibility = $_POST['visibility'];
$payment = $_POST['payment'];

if ($visibility == "Anonymous")
{
    $displayName = "Anonymous";
}
else
{
    $displayName = $name;
}

$_SESSION['name'] = $displayName;
$_SESSION['amount'] = $amount;

// ⚠️ REQUIRED by your DB but NOT in form → temporary default
// $staffID = "STF001";   // you must later replace with login staff system

// Date format MUST be DATE (not datetime)
$dateTime = date("d/m/Y h:i:s A");

// Reference number (optional for UI only)
$reference = "REF" . rand(10000, 99999);

// $sql = "INSERT INTO donation(DonorName, DonationType, Amount, Date)
//         VALUES('$name', '$payment','$amount', '$dateTime')";
// mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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

            <p><strong>Reference:</strong> <?php echo $reference; ?></p>

            <p><strong>Payment Date / Time :</strong> <?php echo $dateTime; ?></p>

            <p><strong>Payment With :</strong> <?php echo $payment; ?></p>

            <p><strong>Total Amount:</strong> RM <?php echo number_format($amount,2); ?></p>

            <p><strong>Status:</strong> Successful</p>

        </div>

    </div>
</div>

</body>
</html>