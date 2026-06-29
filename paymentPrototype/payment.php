<?php
$amount = $_POST['amount'] ?? '';
$payment = $_POST['payment'] ?? '';
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$category = $_POST['category'] ?? '';
$type = $_POST['donationType'] ?? '';

if ($amount == '' || $payment == '') {
    header("Location: donation.php");
    exit();
}

$qrData = "UTeM CampusCare Hub Donation | RM " . $amount . " | Method: " . $payment . " | Category: " . $category;
$qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=" . urlencode($qrData);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dummy Payment Gateway</title>
    <link rel="stylesheet" href="payment.css">
</head>

<body>

<div class="gateway">
    <div class="gateway-card">
        <h2>Dummy Payment Gateway</h2>

        <p><strong>Amount :</strong> RM <?php echo $amount; ?></p>
        <p><strong>Payment Method :</strong> <?php echo $payment; ?></p>
        <p><strong>Category :</strong> <?php echo $category; ?></p>

        <?php if ($payment == "QR") { ?>
            <div class="qr-section">
                <h3>Scan QR to Pay</h3>
                <img src="<?php echo $qrUrl; ?>" alt="Payment QR Code" class="qr-code">
                <p class="small-text">Scan this QR code using your e-wallet application.</p>
            </div>
        <?php } else { ?>
            <div class="card-section">
                <h3>Card Payment</h3>
                <input type="text" placeholder="Card Number">
                <div class="card-row">
                    <input type="text" placeholder="MM/YY">
                    <input type="text" placeholder="CVV">
                </div>
            </div>
        <?php } ?>

        <form action="paymentSuccess.php" method="POST">
            <input type="hidden" name="amount" value="<?php echo $amount; ?>">
            <input type="hidden" name="payment" value="<?php echo $payment; ?>">
            <input type="hidden" name="name" value="<?php echo $name; ?>">
            <input type="hidden" name="email" value="<?php echo $email; ?>">
            <input type="hidden" name="phone" value="<?php echo $phone; ?>">
            <input type="hidden" name="category" value="<?php echo $category; ?>">
            <input type="hidden" name="donationType" value="<?php echo $type; ?>">

            <button type="submit">Complete Payment</button>
        </form>
    </div>
</div>

</body>
</html>