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

            <div class="kit-container">

                <div class="kit-card">

                    <div class="kit-header">
                        <h3 >Mini Food Kit</h3>

                        <button class="delete-kit-btn">
                            Delete Kit
                        </button>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Stock</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>Maggie</td>
                                <td>30</td>
                                <td>
                                    <a href="#">Edit</a> |
                                    <a href="#">Delete</a>
                                </td>
                            </tr>

                            <tr>
                                <td>Biscuit</td>
                                <td>20</td>
                                <td>
                                    <a href="#">Edit</a> |
                                    <a href="#">Delete</a>
                                </td>
                            </tr>

                        </tbody>
                    </table>

                    <div class="card-btn">
                        <button class="add-item-btn">
                            Add Item
                        </button>

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
</body>
</html>