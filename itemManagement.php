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

            <div class="kit-card">

                <div class="kit-header">
                    <h3>Mini Food Kit</h3>
                    <button class="delete-kit-btn" onclick="addItem()">
                        Add Item
                    </button>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Stock</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="itemTable">
                            <tr>
                                <td>Maggie</td>
                                <td>30</td>
                                <td>
                                    <a href="#" onclick="editItem(this)">Edit</a> |
                                    <a href="#" onclick="deleteItem(this)">Delete</a>
                                </td>
                            </tr>
                            <tr>
                                <td>Biscuit</td>
                                <td>20</td>
                                <td>
                                    <a href="#" onclick="editItem(this)">Edit</a> |
                                    <a href="#" onclick="deleteItem(this)">Delete</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="card-btn">
                    <button class="add-item-btn" >
                        <a href = "inventoryManagement.php">Back </a>
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

        // Add item
        function addItem()
        {
            let itemName = prompt("Enter item name:");

            // Validation for item name
            if(itemName == null)
                return;

            itemName = itemName.trim();

            if(itemName == "")
            {
                alert("Item name cannot be empty!");
                return;
            }

            let itemStock = prompt("Enter stock quantity:");

            // Validation for stock
            if(itemStock == null)
                return;

            itemStock = itemStock.trim();

            if(itemStock == "")
            {
                alert("Stock quantity cannot be empty!");
                return;
            }

            if(isNaN(itemStock))
            {
                alert("Stock quantity must be a number!");
                return;
            }

            itemStock = parseInt(itemStock);

            if(itemStock < 0)
            {
                alert("Stock quantity cannot be negative!");
                return;
            }

            // Check duplicate item name
            let table = document.getElementById("itemTable");
            let rows = table.rows;

            for(let i = 0; i < rows.length; i++)
            {
                let existingName = rows[i].cells[0].innerText.toLowerCase();

                if(existingName == itemName.toLowerCase())
                {
                    alert("Item already exists!");
                    return;
                }
            }

            // Add new row
            let newRow = table.insertRow();

            newRow.innerHTML = `
                <td>${itemName}</td>
                <td>${itemStock}</td>
                <td>
                    <a href="#" onclick="editItem(this)">Edit</a> |
                    <a href="#" onclick="deleteItem(this)">Delete</a>
                </td>
            `;
        }

        // Edit item
        function editItem(element)
        {
            let row = element.parentElement.parentElement;

            let currentName = row.cells[0].innerText;
            let currentStock = row.cells[1].innerText;

            let newName = prompt("Edit item name:", currentName);

            if(newName == null)
                return;

            newName = newName.trim();

            if(newName == "")
            {
                alert("Item name cannot be empty!");
                return;
            }

            let newStock = prompt("Edit stock quantity:", currentStock);

            if(newStock == null)
                return;

            newStock = newStock.trim();

            if(newStock == "")
            {
                alert("Stock quantity cannot be empty!");
                return;
            }

            if(isNaN(newStock))
            {
                alert("Stock quantity must be a number!");
                return;
            }

            newStock = parseInt(newStock);

            if(newStock < 0)
            {
                alert("Stock quantity cannot be negative!");
                return;
            }

            row.cells[0].innerText = newName;
            row.cells[1].innerText = newStock;
        }

        // Delete item
        function deleteItem(element)
        {
            if(confirm("Are you sure you want to delete this item?"))
            {
                let row = element.parentElement.parentElement;
                row.remove();
            }
        }
     </script>

     <?php include("footer.php")
     ?>
</body>
</html>