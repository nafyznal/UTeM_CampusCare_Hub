<!DOCTYPE html>
<html>
<head>
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate</title>
    <link rel="stylesheet" href="payment.css">
</head>
</head>

<body>

<div class="donate-container">

    <a href="#" class="back-btn">&#8592;</a>

    <h1>DONATE</h1>

    <div class="wrapper">

        <form action="paymentGateway.php" method="POST" class="payment-box">

            <label>Amount</label>
            <input type="number" name="amount" required>

            <label>Donation Category</label>
            <select name="category" required>
                <option>Food</option>
                <option>Essential</option>
                <option>Academic Support</option>
            </select>

            <label>Your Information</label>
            <input type="text" name="name" placeholder="Name" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Phone Number</label>
            <input type="text" name="phone" required>

            <label>How Often</label>
            <select name="donationType">
                <option>Anonymous</option>
                <option>Recognizable</option>
            </select>

            <label>Payment Method</label>

            <div class="radio">
                <input type="radio" name="payment" value="QR" required> QR
                <input type="radio" name="payment" value="Credit/Debit"> Credit/Debit
            </div>

            <button type="submit">
                Proceed Payment
            </button>

        </form>

        <div class="donator-box">
            <h3>DONATORS</h3>
            <hr><hr><hr><hr><hr>
            <hr><hr><hr><hr><hr>
        </div>

    </div>

</div>

</body>
</html>