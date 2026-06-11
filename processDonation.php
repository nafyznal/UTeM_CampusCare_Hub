<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="donationFormat.css">
</head>
<body>
    <?php
    //Retrieve student information
    // $name = $_POST['name']; 
    // $email = $_POST['email']; 
    // $phone = $_POST['phone']; 
    $amount = $_POST['amount']; 
    $frequency = $_POST['frequency']; 
    $visibility = $_POST['visibility']; 
    $payment = $_POST['payment'];

    /* Category checkbox */ 
    if(isset($_POST['category'])) 
    { 
        $category = implode(", ", $_POST['category']); 
    }
    else 
    { 
    $category = "None"; 
    }

    /* Anonymous donor */ 
    // $displayName = $name; 

    // if($visibility == "Anonymous") 
    // { 
    //     $displayName = "Anonymous"; 
    // }
    // else
    // {
    //     $displayName;
    // }

    $reference = "REF" . rand(10000,99999); 
    
    $dateTime = date("d/m/Y h:i:s A");

    include 'config.php';

    // $sql = "INSERT INTO donors
    //         (donor_name, amount)
    //         VALUES
    //         ('$displayName', '$amount')";

    // mysqli_query($conn, $sql);
    
    ?>

     <div class="container">

        <a href="donation.php" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i>
        </a>

        <div class="success-card">
            <h1>Payment Successful</h1>

            <div class="success-image">
                <img src="successful.png" alt="Payment Successful">
            </div>

            <div class="payment-details">
                <p><strong>Reference : </strong>
                    <span id="reference"></span>
                    <?php echo $reference; ?>
                </p>
                
                <p><strong>Payment Date / Time : </strong>
                    <span id="datetime"></span>
                    <?php echo $dateTime; ?>
                </p>

                <p><strong>Payment With :
                    <?php echo $payment; ?>
                </strong></p>

                <p><strong>Total Amount : </strong>
                    <?php echo $amount; ?>
                </p>

                <p><strong>Status : </strong>
                    Successful
                </p>
            </div>

        </div>
    </div>
</body>
</html>