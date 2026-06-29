<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

date_default_timezone_set("Asia/Kuala_Lumpur");
date_default_timezone_set("Asia/Kuala_Lumpur");

$success = false;
$receipt = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = $_POST["amount"];
    $category = $_POST["category"];
    $donorName = $_POST["donorName"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $method = $_POST["method"];
    $reference = "PAY" . date("YmdHis");
    $dateTime = date("d/m/Y h:i A");

    $receipt = [
        "reference" => $reference,
        "dateTime" => $dateTime,
        "method" => $method,
        "amount" => $amount,
        "status" => "Successful"
    ];

    $data = "$reference | $dateTime | $donorName | $email | $phone | $category | RM$amount | $method | Successful\n";
    file_put_contents("payments.txt", $data, FILE_APPEND);

    $success = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dummy Payment</title>
    <link rel="stylesheet" href="payment.css">
</head>
<body>

<?php if (!$success) { ?>

    <main class="payment-page">
        <a href="../requestApproval.php" class="back-btn">←</a>

        <h1>DONATE</h1>

        <div class="payment-wrapper">

            <form method="POST" class="payment-card">
                <label>Amount</label>
                <input type="number" name="amount" placeholder="RM" required>

                <label>Donation Category</label>
                <select name="category" required>
                    <option value="">-- Select Category --</option>
                    <option value="Food">Food</option>
                    <option value="Essential">Essential</option>
                    <option value="Academic Support">Academic Support</option>
                </select>

                <label>Your Information</label>
                <input type="text" name="donorName" placeholder="Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="phone" placeholder="Phone Number" required>

                <label>Payment Method</label>
                <div class="method-row">
                    <label><input type="radio" name="method" value="QR" required> QR</label>
                    <label><input type="radio" name="method" value="Credit / Debit" required> Credit / Debit</label>
                </div>

                <button type="submit">Proceed Payment</button>
            </form>

            <div class="donator-card">
                <h3>DONATORS</h3>
                <div class="donator-lines">
                    <span></span><span></span><span></span><span></span><span></span>
                    <span></span><span></span><span></span><span></span><span></span>
                </div>
            </div>

        </div>
    </main>

<?php } else { ?>

    <main class="success-page">
        <a href="payment.php" class="back-btn">←</a>

        <div class="success-card">
            <h3>Payment Successful</h3>

            <div class="check-circle">✓</div>

            <div class="receipt">
                <p><strong>Reference :</strong> <?php echo $receipt["reference"]; ?></p>
                <p><strong>Payment Date / Time :</strong> <?php echo $receipt["dateTime"]; ?></p>
                <p><strong>Payment With :</strong> <?php echo $receipt["method"]; ?></p>
                <p><strong>Total Amount :</strong> RM <?php echo $receipt["amount"]; ?></p>
                <p><strong>Status :</strong> <?php echo $receipt["status"]; ?></p>
            </div>

            <a href="payment.php" class="done-btn">Done</a>
        </div>
    </main>

<?php } ?>

</body>
</html>