<?php
// Include database connection
include("connectInventory.php");

// 1. BACKEND ACTION: HANDLE FORM SUBMISSION (ADD OR EDIT KIT)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_kit'])) {
    $action      = isset($_POST['action']) ? trim($_POST['action']) : 'add';
    $kitId       = isset($_POST['kitId']) ? trim($_POST['kitId']) : '';
    $kitName     = isset($_POST['kitName']) ? trim($_POST['kitName']) : '';
    $quantity    = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';

    if (!empty($kitId) && !empty($kitName)) {
        if ($action === 'add') {
            // INSERT Query
            $stmt = $conn->prepare("INSERT INTO kit (Kit_Id, KitName, Quantity, Description) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssis", $kitId, $kitName, $quantity, $description);
            
            if ($stmt->execute()) 
            {
                header("Location: inventoryManagement.php");
                exit();
            } 
            else 
            {
                echo "<script>alert('Error adding kit. Kit ID might already exist.');</script>";
            }
            $stmt->close();
        } 
        else if ($action === 'edit') 
        {
            // UPDATE Query
            $stmt = $conn->prepare("UPDATE kit SET KitName = ?, Quantity = ?, Description = ? WHERE Kit_Id = ?");
            $stmt->bind_param("siss", $kitName, $quantity, $description, $kitId);
            
            if ($stmt->execute()) 
            {
                header("Location: inventoryManagement.php");
                exit();
            } 
            else 
            {
                echo "<script>alert('Error updating kit details.');</script>";
            }
            $stmt->close();
        }
    }
}

// 2. BACKEND ACTION: HANDLE CASCADING DELETION (KIT + LINKED ITEMS)
if (isset($_GET['delete_id'])) 
{
    $delete_id = trim($_GET['delete_id']); 
    
    $conn->begin_transaction();
    try {
        // Step A: Delete all items belonging to this kit first
        $stmtItems = $conn->prepare("DELETE FROM item WHERE Kit_Id = ?");
        $stmtItems->bind_param("s", $delete_id);
        $stmtItems->execute();
        $stmtItems->close();

        // Step B: Delete the actual kit profile second
        $stmtKit = $conn->prepare("DELETE FROM kit WHERE Kit_Id = ?");
        $stmtKit->bind_param("s", $delete_id);
        $stmtKit->execute();
        $stmtKit->close();

        $conn->commit();
        header("Location: inventoryManagement.php");
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        echo "<script>alert('Error deleting kit and its items: " . addslashes($e->getMessage()) . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kit Inventory Management</title>
    <link rel="stylesheet" href="item.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php include("headerInventory.php"); ?>
    
<main>
    <div class="inventory-content">
        <h2>KIT MANAGEMENT</h2>

        <div class="kit-container">
            <div class="kit-inventory">

                <button class="add-btn" onclick="openAddModal()">
                    + ADD NEW KIT
                </button>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Kit ID</th>
                                <th>Kit Name</th>
                                <th>Quantity</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM kit ORDER BY Kit_Id ASC";
                            $result = $conn->query($query);

                            if ($result && $result->num_rows > 0) 
                            {
                                while ($row = $result->fetch_assoc()) 
                                {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['Kit_Id']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['KitName']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Quantity']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Description']) . "</td>";
                                    // Added the Edit option smoothly right alongside Manage and Delete links
                                    echo "<td>
                                            <a href='itemManagement.php?kit_id=" . urlencode($row['Kit_Id']) . "'>Manage Items</a> |
                                            <a href='#' onclick='openEditModal(\"" . htmlspecialchars($row['Kit_Id'], ENT_QUOTES) . "\", \"" . htmlspecialchars($row['KitName'], ENT_QUOTES) . "\", " . $row['Quantity'] . ", \"" . htmlspecialchars($row['Description'], ENT_QUOTES) . "\")'>Edit</a> |
                                            <a href='#' onclick='confirmDelete(\"" . htmlspecialchars($row['Kit_Id'], ENT_QUOTES) . "\")'>Delete</a>
                                          </td>";
                                    echo "</tr>";
                                }
                            } 
                            else 
                            {
                                echo "<tr><td colspan='5' style='text-align:center;'>No kits found in system inventory.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</main>

<div id="kitModal" class="modal-overlay">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h3 id="modalTitle">Add New Kit Profile</h3>
        <form action="inventoryManagement.php" method="POST">
            <input type="hidden" name="action" id="formAction" value="add">

            <div class="form-group">
                <label for="kitId">Kit ID:</label>
                <input type="text" id="kitId" name="kitId" required placeholder="e.g., KIT-003 or ESS-004">
            </div>
            <div class="form-group">
                <label for="kitName">Kit Name:</label>
                <input type="text" id="kitName" name="kitName" required placeholder="e.g., Hygiene Pack">
            </div>
            <div class="form-group">
                <label for="quantity">Initial Quantity:</label>
                <input type="number" id="quantity" name="quantity" min="0" value="0" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <input type="text" id="description" name="description" placeholder="List details...">
            </div>
            <button type="submit" name="save_kit" class="modal-submit-btn">Save Kit Profile</button>
        </form>
    </div>
</div>

<script>
    document.getElementById("menu-icon")?.addEventListener("click", function() {
        document.getElementById("nav-section").classList.toggle("hidden");
    });

    const modal = document.getElementById('kitModal');
    const kitIdInput = document.getElementById('kitId');

    function openAddModal() {
        document.getElementById("modalTitle").innerText = "Add New Kit Profile";
        document.getElementById("formAction").value = "add";
        kitIdInput.value = "";
        kitIdInput.readOnly = false; // Let the primary key text run free on new entries
        document.getElementById("kitName").value = "";
        document.getElementById("quantity").value = "0";
        document.getElementById("description").value = "";
        modal.style.display = 'flex';
    }

    function openEditModal(id, name, qty, desc) {
        document.getElementById("modalTitle").innerText = "Edit Kit Profile";
        document.getElementById("formAction").value = "edit";
        kitIdInput.value = id;
        kitIdInput.readOnly = true; // Lock down structural ID value to guard table safety during updates
        document.getElementById("kitName").value = name;
        document.getElementById("quantity").value = qty;
        document.getElementById("description").value = desc;
        modal.style.display = 'flex';
    }

    function closeModal() {
        modal.style.display = 'none';
    }

    window.addEventListener('click', (e) => {
        if (e.target === modal) { closeModal(); }
    });

    function confirmDelete(id) {
        if (confirm("WARNING: Deleting this kit will permanently delete ALL component items listed inside it! Do you still want to proceed?")) {
            window.location.href = "inventoryManagement.php?delete_id=" + encodeURIComponent(id);
        }
    }
</script>

<?php include("footer.php"); ?>
</body>
</html>