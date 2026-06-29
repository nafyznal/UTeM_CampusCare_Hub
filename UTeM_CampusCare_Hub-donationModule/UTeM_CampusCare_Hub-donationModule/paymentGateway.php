<?php
session_start();
include("connectDonation.php");

// POST data from donation.php
$amount = $_POST['amount'];
$payment = $_POST['payment'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$visibility = $_POST['visibility'];

// Collect categories if selected (as a comma-separated string)
$category = isset($_POST['category']) ? implode(", ", $_POST['category']) : "General";

$qrData = "UTeM CampusCare Hub Donation | RM " . $amount . " | Method: " . $payment;
$qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=" . urlencode($qrData);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dummy Payment Gateway</title>
    <link rel="stylesheet" href="payment.css">
</head>
<body>

<div class="gateway">
    <div class="gateway-card">
        <h2>Dummy Payment Gateway</h2>

        <p><strong>Amount :</strong> RM <?php echo htmlspecialchars($amount); ?></p>
        <p><strong>Payment Method :</strong> <?php echo htmlspecialchars($payment); ?></p>
        <p><strong>Category :</strong> <?php echo htmlspecialchars($category); ?></p>

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
            <input type="hidden" name="amount" value="<?php echo htmlspecialchars($amount); ?>">
            <input type="hidden" name="payment" value="<?php echo htmlspecialchars($payment); ?>">
            <input type="hidden" name="name" value="<?php echo htmlspecialchars($name); ?>">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
            <input type="hidden" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
            <input type="hidden" name="visibility" value="<?php echo htmlspecialchars($visibility); ?>">
            <input type="hidden" name="category" value="<?php echo htmlspecialchars($category); ?>">

            <div class="gateway-action-group">
                <button type="submit">Complete Payment</button>
                <a href="donation.php" class="btn-cancel-link">
                    <button type="button" class="btn-cancel">Cancel Payment</button>
                </a>
            </div>
        </form>
    </div>
</div>

</body>
</html>