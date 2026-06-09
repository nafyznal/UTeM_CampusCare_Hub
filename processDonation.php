```php
<?php

include 'config.php';

/* Get form data */
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
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
$displayName = $name;

if($visibility == "Anonymous")
{
    $displayName = "Anonymous";
}

/* Insert into database */
$sql = "INSERT INTO donors
(
    donor_name,
    email,
    phone,
    amount,
    frequency,
    category,
    visibility,
    payment_method,
    donation_date
)
VALUES
(
    '$displayName',
    '$email',
    '$phone',
    '$amount',
    '$frequency',
    '$category',
    '$visibility',
    '$payment',
    NOW()
)";

$result = mysqli_query($conn, $sql);

/* Check insertion */
if($result)
{
    $id = mysqli_insert_id($conn);

    header("Location: successful.php?id=$id");
    exit();
}
else
{
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);

?>
```
