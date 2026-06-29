<?php
include("connectInventory.php");

// Catch targeted kit configuration scope filter context
$selectedKitId = isset($_GET['kit_id']) ? trim($_GET['kit_id']) : '';

// Dynamic Title configuration: Fetch the Kit Name based on selectedKitId
$displayTitle = "All Registered Contents";
if (!empty($selectedKitId)) {
    $titleStmt = $conn->prepare("SELECT KitName FROM kit WHERE Kit_Id = ?");
    $titleStmt->bind_param("s", $selectedKitId);
    $titleStmt->execute();
    $titleResult = $titleStmt->get_result();
    if ($titleRow = $titleResult->fetch_assoc()) {
        $displayTitle = htmlspecialchars($titleRow['KitName']);
    }
    $titleStmt->close();
}

// ==========================================
// HANDLE BACKEND ACTIONS FOR ITEM ENTITIES
// ==========================================

// HANDLE ADD NEW ITEM
if (isset($_POST['action']) && $_POST['action'] == 'add') {
    $itemName = trim($_POST['itemName']);
    $category = trim($_POST['category']);
    $kitId    = !empty(trim($_POST['kitId'])) ? trim($_POST['kitId']) : null;

    if (!empty($itemName) && !empty($category)) {
        $stmt = $conn->prepare("INSERT INTO item (ItemName, Category, Kit_Id) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $itemName, $category, $kitId);
        
        if ($stmt->execute()) {
            header("Location: itemManagement.php?kit_id=" . urlencode($selectedKitId) . "&msg=success");
            exit();
        } else {
            echo "Error adding record: " . $conn->error;
        }
        $stmt->close();
    }
}

// HANDLE UPDATE ITEM
if (isset($_POST['action']) && $_POST['action'] == 'edit') {
    $itemId   = intval($_POST['itemId']);
    $itemName = trim($_POST['itemName']);
    $category = trim($_POST['category']);
    $kitId    = !empty(trim($_POST['kitId'])) ? trim($_POST['kitId']) : null;

    if (!empty($itemName)) {
        $stmt = $conn->prepare("UPDATE item SET ItemName=?, Category=?, Kit_Id=? WHERE ItemID=?");
        $stmt->bind_param("sssi", $itemName, $category, $kitId, $itemId);
        
        if ($stmt->execute()) {
            header("Location: itemManagement.php?kit_id=" . urlencode($selectedKitId) . "&msg=updated");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
        $stmt->close();
    }
}

// HANDLE DELETE ITEM
if (isset($_GET['delete'])) {
    $itemId = intval($_GET['delete']);
    
    $stmt = $conn->prepare("DELETE FROM item WHERE ItemID = ?");
    $stmt->bind_param("i", $itemId);
    
    if ($stmt->execute()) {
        header("Location: itemManagement.php?kit_id=" . urlencode($selectedKitId) . "&msg=deleted");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Breakdown Management</title>
    <link rel="stylesheet" href="item.css">
</head>
<body>
    <?php include("header.php"); ?>

    <main>
    <div class="inventory-content">
        <h2>ITEM MANAGEMENT 
            <?php echo !empty($selectedKitId) ? "FOR KIT (" . htmlspecialchars($selectedKitId) . ")" : "(ALL ITEMS)"; ?>
        </h2>

        <div class="kit-container">
            <div class="kit-card">
                <div class="kit-header">
                    <h3><?php echo $displayTitle; ?></h3>
                    <button class="delete-kit-btn" onclick="openAddModal('<?php echo htmlspecialchars($selectedKitId); ?>')">
                        Add New Item
                    </button>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Category</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($selectedKitId)) {
                                $stmt = $conn->prepare("SELECT * FROM item WHERE Kit_Id = ? ORDER BY ItemID DESC");
                                $stmt->bind_param("s", $selectedKitId);
                                $stmt->execute();
                                $result = $stmt->get_result();
                            } else {
                                $result = $conn->query("SELECT * FROM item ORDER BY ItemID DESC");
                            }

                            if ($result && $result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['ItemName']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Category']) . "</td>";
                                    echo "<td>
                                            <a href='#' onclick='openEditModal(" . $row['ItemID'] . ", \"" . htmlspecialchars($row['ItemName'], ENT_QUOTES) . "\", \"" . htmlspecialchars($row['Category'], ENT_QUOTES) . "\", \"" . htmlspecialchars($row['Kit_Id'] ?? '', ENT_QUOTES) . "\")'>Edit</a> | 
                                            <a href='itemManagement.php?kit_id=" . urlencode($selectedKitId) . "&delete=" . $row['ItemID'] . "' onclick='return confirm(\"Are you sure you want to delete this item?\");'>Delete</a>
                                          </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3'>No individual component items found for this profile selection.</td></tr>";
                            }
                            if (isset($stmt)) { $stmt->close(); }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="card-btn">
                    <button class="add-item-btn">
                        <a href="inventoryManagement.php" style="color: inherit; text-decoration: none;">Back To Kit Overview</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
    </main>

    <div id="itemModal" class="modal-overlay">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h3 id="modalTitle">Add Item</h3>
            
            <form action="itemManagement.php?kit_id=<?php echo urlencode($selectedKitId); ?>" method="POST">
                <input type="hidden" name="action" id="formAction" value="add">
                <input type="hidden" name="itemId" id="modalItemId" value="">

                <div class="form-group">
                    <label for="modalItemName">Item Name:</label>
                    <input type="text" id="modalItemName" name="itemName" required maxlength="20" placeholder="e.g., Colgate">
                </div>

                <div class="form-group">
                    <label for="modalCategory">Category:</label>
                    <input type="text" id="modalCategory" name="category" required maxlength="20" placeholder="e.g., Personal Care">
                </div>

                <div class="form-group">
                    <label for="modalKitId">Link to Kit ID:</label>
                    <select id="modalKitId" name="kitId">
                        <option value="">None (Standalone Item)</option>
                        <?php
                        $kitList = $conn->query("SELECT Kit_Id, KitName FROM kit");
                        while($k = $kitList->fetch_assoc()) {
                            $isSelected = ($k['Kit_Id'] === $selectedKitId) ? 'selected' : '';
                            echo "<option value='" . htmlspecialchars($k['Kit_Id']) . "' $isSelected>" . htmlspecialchars($k['Kit_Id']) . " - " . htmlspecialchars($k['KitName']) . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="card-btn">
                    <button type="submit" class="delete-kit-btn" style="background:#541A1A; color:white;">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById("menu-icon")?.addEventListener("click", function() {
            document.getElementById("nav-section").classList.toggle("hidden");
        });

        const modal = document.getElementById("itemModal");
        const modalKitSelect = document.getElementById("modalKitId");

        function openAddModal(defaultKitId) {
            document.getElementById("modalTitle").innerText = "Add Component Item";
            document.getElementById("formAction").value = "add";
            document.getElementById("modalItemId").value = "";
            document.getElementById("modalItemName").value = "";
            document.getElementById("modalCategory").value = "";
            modalKitSelect.value = defaultKitId;
            modal.style.display = "flex";
        }

        function openEditModal(id, name, cat, kitId) {
            document.getElementById("modalTitle").innerText = "Edit Item Fields";
            document.getElementById("formAction").value = "edit";
            document.getElementById("modalItemId").value = id;
            document.getElementById("modalItemName").value = name;
            document.getElementById("modalCategory").value = cat;
            modalKitSelect.value = kitId;
            modal.style.display = "flex";
        }

        function closeModal() { modal.style.display = "none"; }
        window.onclick = function(event) {
            if (event.target == modal) { closeModal(); }
        }
    </script>

    <?php include("footer.php"); ?>
</body>
</html>