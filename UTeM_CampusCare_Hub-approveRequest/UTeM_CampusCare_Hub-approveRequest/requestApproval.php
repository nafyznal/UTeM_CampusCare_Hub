<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Approval</title>

    <link rel="stylesheet" href="requestApproval.css">
</head>

<body>

    <?php
    include("header.php");
    ?>

    <main>
        <div class="content">

            <h2>REQUEST APPROVAL</h2>

            <table>
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>Type</th>
                        <th>Requestor</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    <tr>
                        <td>19/03/2026 11:45 AM</td>
                        <td>Mini Food Kit</td>
                        <td>Lutfi Hadi</td>
                        <td id="actionStatus1">Pending</td>
                        <td>
                            <button class="request-btn approve-btn"
                                onclick="approveRequest(1)">
                                Approve
                            </button>

                            <button class="request-btn reject-btn"
                                onclick="rejectRequest(1)">
                                Reject
                            </button>
                        </td>
                    </tr>

                    <tr>
                        <td>20/03/2026 09:30 AM</td>
                        <td>Essential Kit</td>
                        <td>Alya Sofea</td>
                        <td id="actionStatus2">Pending</td>
                        <td>
                            <button class="request-btn approve-btn"
                                onclick="approveRequest(2)">
                                Approve
                            </button>

                            <button class="request-btn reject-btn"
                                onclick="rejectRequest(2)">
                                Reject
                            </button>
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>
    </main>

    <script src="requestApproval.js"></script>

    <script>
        document.getElementById("menu-icon").addEventListener("click", function()
        {
            document.getElementById("nav-section").classList.toggle("hidden");
        });
    </script>

    <?php
    include("footer.php");
    ?>

</body>
</html>