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

    <div class="donation-form">

        <form action="paymentGateway.php" method="POST">

                <div class="top-row">

                    <div>
                        <label>Amount (RM)</label>
                        <input type="number" name="amount" min="1" required>
                    </div>

                    <div>
                        <label>How Often</label>

                        <select name="frequency" required>
                            <option value="">Select</option>
                            <option value="One Time">One Time</option>
                            <option value="Weekly">Weekly</option>
                            <option value="Monthly">Monthly</option>
                        </select>

                    </div>

                </div>

                <h2>Donation Category</h2>

                <div class="checkbox-row">
                    <input type="checkbox" name="category[]" value="Foods">
                    <label>Foods</label>
                </div>

                <div class="checkbox-row">
                    <input type="checkbox" name="category[]" value="Necessities">
                    <label>Necessities</label>
                </div>

                <h2>Your Information</h2>

                <div class="top-row">

                    <div>
                        <label>Name</label>
                        <input type="text" name="name" placeholder="Name" required>
                    </div>

                    <div>
                        <label>Email</label>
                        <input type="email" name="email" placeholder="abc@gmail.com" required>
                    </div>

                </div>

                <div class="top-row">

                    <div>
                        <label>Phone Number</label>
                        <input type="text" name="phone" placeholder="012345678" required>
                    </div>

                    <div class="radio-group">

                        <label>
                            <input type="radio" name="visibility" value="Anonymous" required>
                            Anonymous
                        </label>

                        <label>
                            <input type="radio" name="visibility" value="Recognisable">
                            Recognisable
                        </label>

                    </div>

                </div>

                <h2>Payment Method</h2>

                <div class="payment-method">

                    <label>
                        <input type="radio" name="payment" value="QR" required>
                        QR
                    </label>

                    <label>
                        <input type="radio" name="payment" value="Credit / Debit">
                        Credit / Debit
                    </label>

                </div>

                <button type="submit" class="payment-btn">
                    Proceed Payment
                </button>

            </form>

        <div class="donator-box">
            <h3>DONATORS</h3>
            <hr><hr><hr><hr><hr>
            <hr><hr><hr><hr><hr>
        </div>

    </div>

</>

</body>
</html>