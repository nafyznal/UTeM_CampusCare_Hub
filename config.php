```php
<?php

/* Database Configuration */

$servername = "localhost";
$username = "root";
$password = "";
$database = "donation_db";

/* Create Connection */

$conn = mysqli_connect(
    $servername,
    $username,
    $password,
    $database
);

/* Check Connection */

if (!$conn)
{
    die("Connection Failed: " . mysqli_connect_error());
}

?>
```
