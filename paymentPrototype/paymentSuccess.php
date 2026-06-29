<?php
date_default_timezone_set('Asia/Kuala_Lumpur');

$amount = $_POST['amount'] ?? '';
$payment = $_POST['payment'] ?? '';

if ($amount == '' || $payment == '') {
    header("Location: donation.php");
    exit();
}

$reference = "PAY" . rand(100000,999999);
$date = date('d/m/Y h:i A');

$data = "$reference | $date | RM$amount | $payment | SUCCESS\n";
file_put_contents("payments.txt", $data, FILE_APPEND);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <link rel="stylesheet" href="payment.css">
</head>

<body>

<div class="success-container">
    <div class="success-card">
        <h3>Payment Successful</h3>

        <div class="tick">✓</div>

        <p><strong>Reference :</strong> <?php echo $reference; ?></p>
        <p><strong>Payment Date / Time :</strong> <?php echo $date; ?></p>
        <p><strong>Payment With :</strong> <?php echo $payment; ?></p>
        <p><strong>Total Amount :</strong> RM <?php echo $amount; ?></p>
        <p><strong>Status :</strong> Successful</p>
    </div>
</div>

</body>
</html>