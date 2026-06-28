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

<?php include("header.php"); ?>

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
                    <tr>
                        <td>19/03/2026 11:45 AM</td>
                        <td>Mini Food Kit</td>
                        <td>Lutfi Hadi</td>
                        <td id="actionStatus1">Pending</td>
                        <td>
                            <button class="request-btn approve-btn" onclick="approveRequest(1, 'Mini Food Kit', 'Lutfi Hadi')">Approve</button>
                            <button class="request-btn reject-btn" onclick="rejectRequest(1)">Reject</button>
                        </td>
                        <td id="qrCode1">-</td>
                    </tr>

                    <tr>
                        <td>20/03/2026 09:30 AM</td>
                        <td>Essential Kit</td>
                        <td>Alya Sofea</td>
                        <td id="actionStatus2">Pending</td>
                        <td>
                            <button class="request-btn approve-btn" onclick="approveRequest(2, 'Essential Kit', 'Alya Sofea')">Approve</button>
                            <button class="request-btn reject-btn" onclick="rejectRequest(2)">Reject</button>
                        </td>
                        <td id="qrCode2">-</td>
                    </tr>

                    <tr>
                        <td>21/03/2026 02:15 PM</td>
                        <td>Mini Food Kit</td>
                        <td>Ahmad Firdaus</td>
                        <td id="actionStatus3">Pending</td>
                        <td>
                            <button class="request-btn approve-btn" onclick="approveRequest(3, 'Mini Food Kit', 'Ahmad Firdaus')">Approve</button>
                            <button class="request-btn reject-btn" onclick="rejectRequest(3)">Reject</button>
                        </td>
                        <td id="qrCode3">-</td>
                    </tr>
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