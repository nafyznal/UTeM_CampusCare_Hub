<?php
session_start();
include("connectDonation.php");

// POST data collection
$name       = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
$amount     = mysqli_real_escape_string($conn, $_POST['amount'] ?? '');
$visibility = $_POST['visibility'] ?? '';
$payment    = mysqli_real_escape_string($conn, $_POST['payment'] ?? ''); // maps to DonationType

// Category data (array from category[] checkboxes)
$categoriesArray = $_POST['category'] ?? [];
if (!is_array($categoriesArray)) {
    $categoriesArray = [$categoriesArray];
}
$categoriesArray = array_filter($categoriesArray, function ($c) {
    return trim((string)$c) !== '';
});
$categoryString = !empty($categoriesArray) ? implode(", ", $categoriesArray) : "General";
$categoryString = mysqli_real_escape_string($conn, $categoryString);

if (!is_numeric($amount) || (float)$amount <= 0) {
    die("Invalid donation amount.");
}

// Handle anonymity setting for the live donators wall display
if ($visibility == "Anonymous") {
    $displayName = "Anonymous";
} else {
    $displayName = $name;
}

$_SESSION['name'] = $displayName;
$_SESSION['amount'] = $amount;

// 1. Prepare data mapping to your schema rules
// Since AdminID column is marked NOT NULL, we supply a temporary placeholder admin if nobody is logged in.
$adminID = isset($_SESSION['AdminID']) ? $_SESSION['AdminID'] : "Admin01"; 
$dbDate = date("Y-m-d"); // Format required for MySQL standard DATE data types
$uiDateTime = date("d/m/Y h:i:s A"); // Kept strictly for user-facing receipt display

// 2. Insert execution into table: donation (now includes DonationCategory)
$sqlDonation = "INSERT INTO donation (AdminID, DonorName, DonationType, DonationCategory, Amount, Date) 
                VALUES ('$adminID', '$displayName', '$payment', '$categoryString', '$amount', '$dbDate')";

if (mysqli_query($conn, $sqlDonation)) {
    // Capture the auto-incremented DonationID created by the operation
    $newDonationID = mysqli_insert_id($conn);
    
    // 3. Optional Bonus: Automatically generate record row matching table: donationreceipt
    $sqlReceipt = "INSERT INTO donationreceipt (DonationID, IssueDate, Amount) 
                   VALUES ('$newDonationID', '$dbDate', '$amount')";
    mysqli_query($conn, $sqlReceipt);
} else {
    echo "Database Error: " . mysqli_error($conn);
}

// Generate an organic UI fallback identifier
$reference = "REF" . rand(10000, 99999);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Success</title>
    <link rel="stylesheet" href="payment.css">
</head>
<body>

<div class="success-container">
    <div class="success-card">
        <h3>Payment Successful</h3>

        <div class="tick">✓</div>

        <p><strong>Reference:</strong> <?php echo htmlspecialchars($reference); ?></p>
        <p><strong>Payment Date / Time :</strong> <?php echo htmlspecialchars($uiDateTime); ?></p>
        <p><strong>Payment With :</strong> <?php echo htmlspecialchars($payment); ?></p>
        <p><strong>Category :</strong> <?php echo htmlspecialchars($categoryString); ?></p>
        <p><strong>Total Amount:</strong> RM <?php echo number_format((float)$amount, 2); ?></p>
        <p><strong>Status:</strong> Successful</p>

        <div class="gateway-action-group">
            <a href="donation.php">
                <button type="button" class="btn-return">Return to Merchant</button>
            </a>
        </div>
    </div>
</div>

</body>
</html>