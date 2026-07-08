<?php
session_start();
include("connectDonation.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate</title>

    <link rel="stylesheet" href="donation.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

<div class="container">

    <a href="index.php" class="back-btn">
        <i class="fa-solid fa-arrow-left"></i>
    </a>

    <h1>DONATE</h1>

    <div class="donation-section">

        <div class="donation-form">

            <form action="paymentGateway.php" method="POST">

                <div class="top-row">

                    <div>
                        <label>Amount (RM)</label>
                        <input type="number" name="amount" min="1" step="0.01" required>
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
                    <input type="checkbox" name="category[]" value="Food"> Food
                </div>

                <div class="checkbox-row">
                    <input type="checkbox" name="category[]" value="Necessity"> Necessity
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

        </div>

        <div class="donators-box">

            <h2>DONATORS</h2>

            <div class="donators-list" style="max-height: 400px; overflow-y: auto;">
                <?php
                // Fetch all donations ordered by the latest contribution first
                $sqlFetch = "SELECT DonorName, Amount FROM donation ORDER BY DonationID DESC";
                $result = mysqli_query($conn, $sqlFetch);

                if ($result && mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        $donorName = htmlspecialchars($row['DonorName']);
                        $donorAmount = number_format($row['Amount'], 2);
                        
                        echo "<p><strong>" . $donorName . "</strong> - RM " . $donorAmount . "</p>";
                    }
                } 
                else 
                {
                    echo "<p class='no-donations'>No donations yet. Be the first!</p>";
                }
                ?>
            </div>

        </div>

    </div>

</div>

</body>
</html>