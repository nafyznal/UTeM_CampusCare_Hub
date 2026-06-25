<?php
// Include the database connection file
include("connectInventory.php");

// Catch the current category from the URL to determine default descriptions
$currentCategory = isset($_GET['category']) ? trim($_GET['category']) : 'Foods';

// Define your default text map for descriptions
$defaultDescriptions = [
    'Foods'         => 'Standard emergency food supply kit containing non-perishables.',
    'Personal Care' => 'Hygiene and sanitization products for personal care maintenance.',
    'First Aid'     => 'Essential medical items, bandages, and basic wound treatment supplies.'
];

// Fallback to a general string if the category doesn't match the map keys
$defaultDescriptionText = isset($defaultDescriptions[$currentCategory]) ? $defaultDescriptions[$currentCategory] : 'Inventory item kit profile.';

// ==========================================
// 1. HANDLE BACKEND ACTIONS (CREATE, UPDATE, DELETE)
// ==========================================

// HANDLE ADD NEW KIT
if (isset($_POST['action']) && $_POST['action'] == 'add') {
    $kitName = mysqli_real_escape_string($conn, $_POST['kitName']);
    $quantity = intval($_POST['quantity']);
    // If the description input is empty, fallback to our default text before saving
    $description = !empty(trim($_POST['description'])) ? mysqli_real_escape_string($conn, $_POST['description']) : mysqli_real_escape_string($conn, $defaultDescriptionText);

    if (!empty($kitName)) {
        $sql = "INSERT INTO kit (KitName, Quantity, Description) VALUES ('$kitName', '$quantity', '$description')";
        if ($conn->query($sql) === TRUE) {
            header("Location: itemManagement.php?category=" . urlencode($currentCategory) . "&msg=success");
            exit();
        } else {
            echo "Error adding record: " . $conn->error;
        }
    }
}

// HANDLE UPDATE KIT
if (isset($_POST['action']) && $_POST['action'] == 'edit') {
    $kitId = intval($_POST['kitId']);
    $kitName = mysqli_real_escape_string($conn, $_POST['kitName']);
    $quantity = intval($_POST['quantity']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    if (!empty($kitName)) {
        $sql = "UPDATE kit SET KitName='$kitName', Quantity='$quantity', Description='$description' WHERE Kit_Id=$kitId";
        if ($conn->query($sql) === TRUE) {
            header("Location: itemManagement.php?category=" . urlencode($currentCategory) . "&msg=updated");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
}

// HANDLE DELETE KIT
if (isset($_GET['delete'])) {
    $kitId = intval($_GET['delete']);
    $sql = "DELETE FROM kit WHERE Kit_Id = $kitId";
    if ($conn->query($sql) === TRUE) {
        header("Location: itemManagement.php?category=" . urlencode($currentCategory) . "&msg=deleted");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kit Inventory Management - <?php echo htmlspecialchars($currentCategory); ?></title>
    <link rel="stylesheet" href="item.css">
</head>
<body>
    <?php include("header.php"); ?>

    <main>
    <div class="inventory-content">
        <h2>KIT MANAGEMENT (<?php echo strtoupper(htmlspecialchars($currentCategory)); ?>)</h2>

        <div class="kit-container">
            <div class="kit-card">
                <div class="kit-header">
                    <h3>Available Kit Profiles</h3>
                    <button class="delete-kit-btn" onclick="openAddModal('<?php echo addslashes($defaultDescriptionText); ?>')">
                        Add New Kit
                    </button>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Kit Name</th>
                                <th>Quantity (Stock)</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // 2. READ / FETCH DATA FROM DATABASE
                            $sql = "SELECT * FROM kit";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['KitName']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Quantity']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Description']) . "</td>";
                                    // FIXED: Clean single quotes and syntax inside JS invocation
                                    echo "<td>
                                            <a href='#' onclick='openEditModal(" . $row['Kit_Id'] . ", \"" . htmlspecialchars($row['KitName'], ENT_QUOTES) . "\", " . $row['Quantity'] . ", \"" . htmlspecialchars($row['Description'], ENT_QUOTES) . "\")'>Edit</a> | 
                                            <a href='itemManagement.php?category=" . urlencode($currentCategory) . "&delete=" . $row['Kit_Id'] . "' onclick='return confirm(\"Are you sure you want to delete this kit?\");'>Delete</a>
                                          </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>No kits found in inventory.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="card-btn">
                    <button class="add-item-btn">
                        <a href="inventoryManagement.php" style="color: inherit; text-decoration: none;">Back</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
    </main>

    <div id="kitModal" class="modal-overlay">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h3 id="modalTitle">Add Kit</h3>
            
            <form action="itemManagement.php?category=<?php echo urlencode($currentCategory); ?>" method="POST">
                <input type="hidden" name="action" id="formAction" value="add">
                <input type="hidden" name="kitId" id="modalKitId" value="">

                <div class="form-group">
                    <label for="modalKitName">Kit Name:</label>
                    <input type="text" id="modalKitName" name="kitName" required maxlength="20">
                </div>

                <div class="form-group">
                    <label for="modalQuantity">Quantity:</label>
                    <input type="number" id="modalQuantity" name="quantity" required min="0" max="999">
                </div>

                <div class="form-group">
                    <label for="modalDescription">Description:</label>
                    <input type="text" id="modalDescription" name="description" maxlength="300">
                </div>

                <div class="card-btn">
                    <button type="submit" class="delete-kit-btn" style="background:#541A1A; color:white;">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Menu Toggle
        document.getElementById("menu-icon")?.addEventListener("click", function() {
            document.getElementById("nav-section").classList.toggle("hidden");
        });

        const modal = document.getElementById("kitModal");

        function openAddModal(defaultDesc) {
            document.getElementById("modalTitle").innerText = "Add New Kit";
            document.getElementById("formAction").value = "add";
            document.getElementById("modalKitId").value = "";
            document.getElementById("modalKitName").value = "";
            document.getElementById("modalQuantity").value = "";
            document.getElementById("modalDescription").value = defaultDesc;
            modal.style.display = "flex";
        }

        function openEditModal(id, name, qty, desc) {
            document.getElementById("modalTitle").innerText = "Edit Kit";
            document.getElementById("formAction").value = "edit";
            document.getElementById("modalKitId").value = id;
            document.getElementById("modalKitName").value = name;
            document.getElementById("modalQuantity").value = qty;
            document.getElementById("modalDescription").value = desc;
            modal.style.display = "flex";
        }

        function closeModal() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>

    <?php include("footer.php"); ?>
</body>
</html>