<?php

date_default_timezone_set('Asia/Kuala_Lumpur');

$reference =
"PAY" . rand(100000,999999);

$date =
date('d/m/Y h:i A');

$amount =
$_POST['amount'];

$payment =
$_POST['payment'];

$data =
"$reference | $date | RM$amount | $payment | SUCCESS\n";

file_put_contents(
    "payments.txt",
    $data,
    FILE_APPEND
);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment Success</title>
    <link rel="stylesheet" href="payment.css">
</head>

<body>

<div class="success-container">

    <div class="success-card">

        <h3>Payment Successful</h3>

        <div class="tick">
            ✓
        </div>

        <p>
            Reference :
            <?php echo $reference; ?>
        </p>

        <p>
            Payment Date / Time :
            <?php echo $date; ?>
        </p>

        <p>
            Payment With :
            <?php echo $payment; ?>
        </p>

        <p>
            Total Amount :
            RM <?php echo $amount; ?>
        </p>

        <p>
            Status :
            Successful
        </p>

    </div>

</div>

</body>
</html>