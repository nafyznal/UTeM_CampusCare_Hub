<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Form</title>

    <link rel="stylesheet" href="format.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <?php
    include 'config.php';
    ?>

<div class="container">

    <!-- Back Button -->
    <a href="index.php" class="back-btn">
        <i class="fa-solid fa-arrow-left"></i>
    </a>

    <h1>DONATE</h1>

    <div class="donation-section">

        <!-- Donation Form -->
        <form method="POST" action="processDonation.php">

            <div class="donation-form">

                <!-- Amount & Frequency -->
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

                <!-- Donation Category -->
                <h2>Donation Category</h2>

                <div class="checkbox-row">

                    <input type="checkbox" name="category[]" value="Foods">
                    <label>Foods</label>

                </div>

                <div class="checkbox-row">

                    <input type="checkbox" name="category[]" value="Necessities">
                    <label>Necessities</label>

                </div>

                <!-- Personal Information -->
                <h2>Your Information</h2>

                <div class="top-row">

                    <div>
                        <label>Name</label>
                        <input type="text" name="name" required>
                    </div>

                    <div>
                        <label>Email</label>
                        <input type="email" name="email" required>
                    </div>

                </div>

                <div class="top-row">

                    <div>
                        <label>Phone Number</label>
                        <input type="text" name="phone" required>
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

                <!-- Payment Method -->
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

            </div>

        </form>

        <!-- Donators Box -->
        <!--<?php
            //Retrieve student information
            $name = $_POST['name'];  
            $amount = $_POST['amount']; 
        ?> -->

        <div class="donators-box">

            <h2>DONATORS</h2>

            <div id="donorList">
                <div id="donorList">

                <?php
                $sql = "SELECT donor_name, amount
                FROM donors
                ORDER BY id DESC";

                $result = mysqli_query($conn, $sql);

                if(mysqli_num_rows($result) > 0)
                {
                    while($row = mysqli_fetch_assoc($result))
                    {
                        echo "<p>"
                        . htmlspecialchars($row['donor_name'])
                        . " - RM "
                        . htmlspecialchars($row['amount'])
                        . "</p>";
                    }
                }
                else
                {
                    echo "<p>No donors yet.</p>";
                }

                ?>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>
```
