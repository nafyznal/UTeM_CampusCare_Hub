<?php
$requests = [
    [
        "time" => "19/03/2026 11:45 AM",
        "type" => "Mini food kit",
        "requestor" => "Lutfi Hadi"
    ],
    [
        "time" => "20/03/2026 09:30 AM",
        "type" => "Basic necessities",
        "requestor" => "Aiman Hakim"
    ],
    [
        "time" => "21/03/2026 02:15 PM",
        "type" => "Mini food kit",
        "requestor" => "Nur Alya"
    ]
];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Request Approval</title>
    <link rel="stylesheet" href="requestApproval.css">
    <script src="requestApproval.js"></script>
</head>
<body>

<div class="page">

    <div class="top-title">APPROVAL</div>

    <div class="menu-icon">☰</div>
    <div class="home-icon">⌂</div>

    <div class="sidebar">

        <div class="profile">
            <div class="profile-icon">◎</div>
            <div>
                Hi!<br>
                Admin
            </div>
        </div>

        <div class="menu">
            <a href="#">Dashboard</a>
            <a href="requestApproval.php">Approval</a>
            <a href="#">Item</a>
        </div>

        <div class="logout">
            <a href="#">Logout</a>
        </div>

    </div>

    <div class="content">

        <div class="approval-box">

            <h1>Approval</h1>

            <div class="table-section">

                <table>
                    <tr>
                        <th>Time</th>
                        <th>Type</th>
                        <th>Requestor</th>
                        <th>Actions</th>
                    </tr>

                    <?php foreach ($requests as $index => $request) { ?>
                    <tr>
                        <td><?php echo $request["time"]; ?></td>
                        <td><?php echo $request["type"]; ?></td>
                        <td><?php echo $request["requestor"]; ?></td>
                        <td id="actionStatus<?php echo $index; ?>">
                            <button class="approve-btn" onclick="approveRequest(<?php echo $index; ?>)">Approve</button>
                            <button class="reject-btn" onclick="rejectRequest(<?php echo $index; ?>)">Reject</button>
                        </td>
                    </tr>
                    <?php } ?>

                </table>

            </div>

        </div>

    </div>

</div>

</body>
</html>