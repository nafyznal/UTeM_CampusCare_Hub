<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="background">
            <div class="login-box">
                <h1>Done Register</h1>
                <img src="success.png" class="success" alt="Success">
                
                <form onsubmit="home(event)">
                    <button type="submit">Login</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function home(event) {
            event.preventDefault(); 
            window.location.href = "index.php";
        }
    </script>
</body>
</html>