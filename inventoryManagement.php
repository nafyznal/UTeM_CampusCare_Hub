<?php
// Include database connection
include("connectInventory.php");

// 1. BACKEND ACTION: HANDLE FORM SUBMISSION (ADD KIT)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_kit'])) {
    // Safely verify if keys exist in $_POST before assigning them
    $kitName = isset($_POST['kitName']) ? trim($_POST['kitName']) : '';
    $category = isset($_POST['category']) ? trim($_POST['category']) : '';
    $quantity = 0; // Defaulting to 0 as seen in your table structure

    if (!empty($kitName) && !empty($category)) 
    {
        // Matches database table columns: inventory (ItemName, Quantity, Category)
        $stmt = $conn->prepare("INSERT INTO inventory (ItemName, Quantity, Category) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $kitName, $quantity, $category);
        
        if ($stmt->execute()) {
            // Fresh redirect to avoid duplicate post submissions on browser reload
            header("Location: inventoryManagement.php");
            exit();
        } 
        else 
        {
            echo "<script>alert('Error adding item. It might already exist.');</script>";
        }
        $stmt->close();
    }
}

// 2. BACKEND ACTION: HANDLE DELETION
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    
    // Deletes record via primary key Column "ItemID" from your schema
    $stmt = $conn->prepare("DELETE FROM inventory WHERE ItemID = ?");
    $stmt->bind_param("i", $delete_id);
    
    if ($stmt->execute()) {
        header("Location: inventoryManagement.php");
        exit();
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
    <link rel="stylesheet" href="item.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php include("header.php"); ?>
    
<main>
    <div class="inventory-content">
        <h2>ITEM MANAGEMENT</h2>

        <div class="kit-container">
            <div class="kit-inventory">

                <button class="add-btn" id="openModalBtn">
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
                        <tbody id="itemTable">
                            <?php
                            // 3. BACKEND ACTION: FETCH & RENDER RECORDS LIVE FROM MYSQL
                            $query = "SELECT * FROM inventory ORDER BY ItemID DESC";
                            $result = $conn->query($query);

                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    // Uses case-sensitive field names from your phpMyAdmin table snapshot
                                    echo "<td>" . htmlspecialchars($row['ItemName']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Category']) . "</td>";
                                    echo "<td>
                                            <a href='itemManagement.php?id=" . $row['ItemID'] . "'>Manage</a> |
                                            <a href='#' onclick='confirmDelete(" . $row['ItemID'] . ")'>Delete</a>
                                          </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3' style='text-align:center;'>No kits found in inventory.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</main>

<div id="addKitModal" class="modal-overlay">
    <div class="modal-content">
        <span class="close-btn" id="closeModalBtn">&times;</span>
        <h3>Add New Kit</h3>
        <form action="inventoryManagement.php" method="POST">
            <div class="form-group">
                <label for="itemName">Kit Name:</label>
                <input type="text" id="itemName" name="kitName" required placeholder="e.g., Mini Food Kit">
            </div>
            <div class="form-group">
                <label for="kitCategory">Category:</label>
                <select id="kitCategory" name="category" required>
                    <option value="" disabled selected>Select a category</option>
                    <option value="Foods">Foods</option>
                    <option value="Personal Care">Personal Care</option>
                    <option value="First Aid">First Aid</option>
                </select>
            </div>
            <button type="submit" name="add_kit" class="modal-submit-btn">Save Kit</button>
        </form>
    </div>
</div>

<script>
    // Safe header burger menu switch logic
    document.getElementById("menu-icon")?.addEventListener("click", function() {
        document.getElementById("nav-section").classList.toggle("hidden");
    });

    // Modal Control Elements
    const modal = document.getElementById('addKitModal');
    const openModalBtn = document.getElementById('openModalBtn');
    const closeModalBtn = document.getElementById('closeModalBtn');

    // Display Popup Modal
    openModalBtn.addEventListener('click', () => {
        modal.style.display = 'flex';
    });

    // Hide Popup via standard X control
    closeModalBtn.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    // Hide Popup if backdrop wrapper container is clicked
    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });

    // Pass structural data record reference over to backend server delete query logic
    function confirmDelete(id) {
        if (confirm("Are you sure you want to delete this kit permanently from the database?")) {
            window.location.href = "inventoryManagement.php?delete_id=" + id;
        }
    }
</script>

<?php include("footer.php"); ?>
</body>
</html>