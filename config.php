<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
```php
<?php

// Connect to MySQL database
$conn = mysqli_connect(
    "host",
    "root",
    "",
    "donation_db"
);

// Check connection
if(!$conn)
{
    die("Could not connect to database");
}

// Optional success message for testing
// echo "Database Connected Successfully";

?>
```

</body>
</html>