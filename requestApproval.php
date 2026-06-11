<?php include 'header.php'; ?>

<main class="approval-main">
    <div class="approval-box">
        <h2>Request Approval</h2>

        <table>
            <tr>
                <th>Time</th>
                <th>Type</th>
                <th>Requestor</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <tr>
                <td>19/03/2026 11:45 AM</td>
                <td>Mini Food Kit</td>
                <td>Lutfi Hadi</td>
                <td id="actionStatus1">Pending</td>
                <td>
                    <button onclick="approveRequest(1)">Approve</button>
                    <button onclick="rejectRequest(1)">Reject</button>
                </td>
            </tr>
        </table>
    </div>
</main>

<script src="requestApproval.js"></script>

<?php include 'footer.php'; ?>