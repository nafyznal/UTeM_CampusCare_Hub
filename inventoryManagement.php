<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>

    <link rel="stylesheet" href="item.css">
</head>

<body>
    <?php
    include("header.php");
    ?>

    <main>
        <div class="content">
            <h2>ITEM MANAGEMENT</h2>

            <button class="add-btn">
                +ADD NEW KIT
            </button>

            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>Mini Food Kit</td>
                        <td>Foods</td>
                        <td>
                            <a href="#">Edit</a> | 
                            <a href="#">Delete</a>
                        </td>
                    </tr>

                    <tr>
                        <td>Hygiene Kit</td>
                        <td>Personal Care</td>
                        <td>
                            <a href="#">Edit</a> | 
                            <a href="#">Delete</a>
                        </td>
                    </tr>

                </tbody>

            </table>
            
        </div>
    </main>

     <script>
        document.getElementById("menu-icon").addEventListener("click", function()
        {
            document.getElementById("nav-section").classList.toggle("hidden");
        });
     </script>
</body>
</html>