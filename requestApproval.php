<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Approval</title>

    <link rel="stylesheet" href="format.css">
    <link rel="stylesheet" href="requestApproval.css">
</head>

<body>

<?php include("headerRequest.php"); ?>

<main>
    <div class="approval-content">
        <h2>REQUEST APPROVAL</h2>

        <div class="approval-table-container">
            <table class="approval-table">
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>Type</th>
                        <th>Requestor</th>
                        <th>Status</th>
                        <th>Action</th>
                        <th>QR Code</th>
                    </tr>
                </thead>

                <tbody>
<?php
$conn = new mysqli("localhost:3301", "root", "", "campuscare_hub");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT r.RequestID, r.RequestDate, r.Status, k.KitName, s.Name AS StudentName
        FROM request r
        JOIN kit k ON r.Kit_Id = k.Kit_Id
        JOIN student s ON r.StudentId = s.StudentId
        ORDER BY r.RequestDate DESC, r.RequestID DESC";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id          = (int) $row['RequestID'];
        $time        = date("d/m/Y h:i A", strtotime($row['RequestDate']));
        $type        = htmlspecialchars($row['KitName']);
        $requestor   = htmlspecialchars($row['StudentName']);
        $status      = htmlspecialchars($row['Status']);
        $isPending   = ($row['Status'] === 'Pending');
?>
                    <tr id="row<?php echo $id; ?>">
                        <td><?php echo $time; ?></td>
                        <td><?php echo $type; ?></td>
                        <td><?php echo $requestor; ?></td>
                        <td id="actionStatus<?php echo $id; ?>"><?php echo $status; ?></td>
                        <td>
<?php if ($isPending) { ?>
                            <button class="request-btn approve-btn" onclick="approveRequest(<?php echo $id; ?>, '<?php echo addslashes($type); ?>', '<?php echo addslashes($requestor); ?>')">Approve</button>
                            <button class="request-btn reject-btn" onclick="rejectRequest(<?php echo $id; ?>)">Reject</button>
<?php } else { ?>
                            <span class="<?php echo $status === 'Approved' ? 'approved-text' : 'rejected-text'; ?>"><?php echo $status; ?></span>
<?php } ?>
                        </td>
                        <td id="qrCode<?php echo $id; ?>">-</td>
                    </tr>
<?php
    }
} else {
?>
                    <tr>
                        <td colspan="6">No requests found.</td>
                    </tr>
<?php
}
$conn->close();
?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php include("footer.php"); ?>

<script src="requestApproval.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function(){
    const menuBtn = document.getElementById("menu-btn");
    const sidebar = document.getElementById("nav-section");

    if(menuBtn && sidebar){
        menuBtn.addEventListener("click", function(){
            sidebar.classList.toggle("hidden");
        });
    }
});
</script>

</body>
</html>