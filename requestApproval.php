<!DOCTYPE html>
<?php
$requestTime = "19/03/2026 11:45 AM";
$requestType = "Mini food kit";
$requestor = "Lutfi Hadi";
?>
<html>
<head>
    <title>Request Approval</title>
    <link rel="stylesheet" href="requestApproval.css">
    <script src="requestApproval.js"></script>
</head>
<body>

    <div class="page">

        <div class="top-title">
            APPROVAL
        </div>

        <div class="menu-icon">
            ☰
        </div>

        <div class="home-icon">
            ⌂
        </div>

        <div class="sidebar">

            <div class="profile">
                <div class="profile-icon">◎</div>
                <div>
                    Hi!<br>
                    Blablabla
                </div>
            </div>

            <div class="menu">
                <a href="#">Dashboard</a>
                <a href="#">Approval</a>
                <a href="#">Item</a>
            </div>

            <div class="logout">
                <a href="#">Logout</a>
            </div>

        </div>

        <div class="content">

            <div class="approval-box">

                <h1>Approval</h1>

                <!-- request table -->
                <div class="table-section">

                    <table>
                        <tr>
                            <th>Time</th>
                            <th>Type</th>
                            <th>Requestor</th>
                            <th>Actions</th>
                        </tr>

                        <tr>
                            <td><?php echo $requestTime; ?></td>
                                    <td><?php echo $requestType; ?></td>
                                            <td><?php echo $requestor; ?></td>
                            <td>
                                <button class="approve-btn" onclick="approveRequest()">Approve</button>
                                <button class="reject-btn" onclick="rejectRequest()">Reject</button>
                            </td>
                        </tr>

                        <tr>
                            <td>&nbsp;</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>

                </div>

            </div>

        </div>

    </div>

</body>
</html>