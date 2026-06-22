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
    <div class="inventory-content">

        <h2>ITEM MANAGEMENT</h2>

        <div class="kit-container">

            <div class="kit-inventory">

                <button class="add-btn">
                    + ADD NEW KIT
                </button>

                <div class="table-container">

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

            </div>

        </div>

    </div>
</main>

     <script>
        document.getElementById("menu-icon").addEventListener("click", function()
        {
            document.getElementById("nav-section").classList.toggle("hidden");
        });
     </script>

     <?php include("footer.php"); 
     ?>
</body>
</html>