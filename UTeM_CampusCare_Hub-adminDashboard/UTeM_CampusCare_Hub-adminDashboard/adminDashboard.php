<?php 
    $conn = mysqli_connect("localhost","root","","campuscare_hub");

    if(!$conn){
        die("Connection Failed! :". mysqli_connect_error());
    }

    $sql = "SELECT request.*, student.Name, kit.KitName 
            FROM request
            JOIN student ON request.StudentId = student.StudentId
            JOIN kit ON request.Kit_Id = kit.Kit_Id
            ORDER BY request.RequestID DESC";
    $result = mysqli_query($conn, $sql);

    $sql_count = "SELECT COUNT(*) as total FROM request";
    $result_count = mysqli_query($conn, $sql_count);
    $row_count = mysqli_fetch_assoc($result_count);

    $sql_food = "SELECT SUM(Amount) as totalFood FROM donation WHERE DonationType = 'Food'";
    // SUM utk tmbh data contoh nya amount donation
    $result_food = mysqli_query($conn, $sql_food);
    $row_food = mysqli_fetch_assoc($result_food);

    $sql_Necessity = "SELECT SUM(Amount) as totalNecessity FROM donation WHERE DonationType = 'Necessity'";
    // SUM utk tmbh data contoh nya amount donation
    $result_Necessity = mysqli_query($conn, $sql_Necessity);
    $row_Necessity = mysqli_fetch_assoc($result_Necessity);

    $sql_donor = "SELECT * FROM Donation ORDER BY DonationID DESC";
    $result_donor = mysqli_query($conn, $sql_donor);
    $row_donor = mysqli_fetch_assoc($result_donor);




?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meSta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="formatAdmin.css">
</head>
<body>
    <?php include("headerAdmin.php"); ?>
    
    <main class="grid-container">
        <div class="card">
            <div class="icon-container">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="7" r="3" />
                    <path d="M5 20a7 7 0 0 1 14 0" />
                    <line x1="5" y1="20" x2="19" y2="20" />
                </svg>
            </div>
            <div class="content">
                <span class="value"><?php echo $row_count['total'] ?></span>
                <span class="label">Request</span>
            </div>
        </div>

        <div class="card">
            <div class="icon-container">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="18" height="18" rx="2" />
                    <path d="M7.5 7v3.5M9 7v3.5M6 7v3.5" />
                    <path d="M6 10.5c0 1 1.5 1 1.5 1V16M9 10.5c0 1-1.5 1-1.5 1" />
                    <path d="M16.5 7c-1 0-1.5 1-1.5 2s.3 2 1.5 2 1.5-1 1.5-2-.5-2-1.5-2z" />
                    <line x1="16.5" y1="11" x2="16.5" y2="16" />
                </svg>
            </div>
            <div class="content">
                <span class="value">
                    <?php 
                    $totalFood = $row_food['totalFood'] ?? 0;
                    echo "RM" . " " . $totalFood;
                    ?>
                </span>
                <span class="label">Food</span>
            </div>
        </div>

        <div class="card">
            <div class="icon-container">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="4" y1="7" x2="10" y2="7" />
                    <line x1="4" y1="12" x2="8" y2="12" />
                    <line x1="4" y1="17" x2="12" y2="17" />
                    <circle cx="16" cy="11" r="3" />
                    <line x1="18.1" y1="13.1" x2="20.5" y2="15.5" />
                </svg>
            </div>
            <div class="content">
                <span class="value">
                    <?php 
                        $totalNec = $row_Necessity['totalNecessity'] ?? 0;
                        echo "RM". " " . $totalNec;
                    ?>
                </span>
                <span class="label">Necessity</span>
            </div>
        </div>

        <div class="table-recent">
        <h2>Recent Request</h2>
        <table class="recent-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Request</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                <?php 
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?php echo $row['Name'];?></td>
                    <td><?php echo $row['KitName'];?></td>
                    <td class="
                    <?php 
                        if($row['Status'] == 'Approved') echo 'status-approved';
                        else if ($row['Status'] == 'Pending' ) echo 'status-pending';
                        else if ($row['Status'] == 'Rejected') echo 'status-rejected';
                    
                    ?>">
                    <?php echo $row['Status'];?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="table-recent">
        <h2>Recent Donor</h2>
        <table class="recent-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Amount</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>
                        <?php 
                        $donorName = $row_donor['DonorName'] ?? '';
                        echo $donorName;
                        ?>
                    </td>
                    <td>
                        <?php 
                        $type = $row_donor['DonationType'] ?? '';
                        echo $type;
                        ?>
                    </td>
                    <td>
                        <?php 
                        $Amount = $row_donor['Amount'] ?? '';
                        echo "RM" . " ". $Amount;
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    </main>
      
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        // Sidebar Toggle
        const menuBtn = document.querySelector('#menu-icon'); 
        const navSection = document.getElementById('nav-section');

        if (menuBtn && navSection) {
            menuBtn.addEventListener('click', function (e) {
                e.preventDefault();
                navSection.classList.toggle('hidden');
            });
        }

        // Hover Effects
        document.querySelectorAll('.icon, li, #logout').forEach(element => {
            element.addEventListener("mouseover", function () {
                this.classList.add("hover");
            });
            element.addEventListener("mouseleave", function () {
                this.classList.remove("hover");
            });
        });
    });

    $(document).ready(function(){

        // Fade in
        $('body').hide().fadeIn(1000);

        // Sidebar Toggle (jQuery way)
        $('#menu-icon').click(function(e){
            e.preventDefault();
            $('#nav-section').toggleClass('hidden');
        });

    });

    </script>

    <?php include("footer.php"); ?>
</body>
</html>