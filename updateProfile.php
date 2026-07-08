<style>
    button{
    background-color: #541A1A;
        border-radius: 20px;
        color: white;
        border: none;
        padding: 5px;
        margin: 5px;
    }
</style>


<?php 
include('connect.php');

if (!isset($_SESSION['StudentId'])) {
    echo "<p style='text-align:center;'>Please log in to update your profile.</p>";
}

$studentId = $_SESSION['StudentId'];

// Fetch current data
$sql    = "SELECT * FROM student WHERE StudentId='$studentId'";
$result = $conn->query($sql);

$row =[];

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $profilePicPath = isset($row['ProfilePic']) ? $row['ProfilePic'] : "";

    if (isset($_FILES['u_picture']) && $_FILES['u_picture']['error'] == 0) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $fileType     = $_FILES['u_picture']['type'];
        $fileSize     = $_FILES['u_picture']['size'];

        if (!in_array($fileType, $allowedTypes)) {
            $error = "Only JPG, PNG, GIF, WEBP allowed!";
        } elseif ($fileSize > 2 * 1024 * 1024) {
            $error = "File size must be under 2MB!";
        } else {
            $uploadDir = "uploads/profile/";
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            $fileName       = time() . "_" . basename($_FILES['u_picture']['name']);
            $profilePicPath = $uploadDir . $fileName;
            move_uploaded_file($_FILES['u_picture']['tmp_name'], $profilePicPath);
        }
    }

    if (!isset($error)) {
        $sql_update = "UPDATE student SET ProfilePic='$profilePicPath' WHERE StudentId='$studentId'";
        if ($conn->query($sql_update)) {
            $_SESSION['ProfilePic'] = $profilePicPath;
            echo "<script>window.location.href='viewProfile.php';</script>";
            exit();
        }else {
            $error = "Update Failed!";
        }
    }
}
?>


<form method="post" action="updateFinal.php" enctype="multipart/form-data">
    <?php 
    if(isset($error)){
        echo "<p style='color: red'>$error</p>";
    }
     ?>

    <center>
    <table>
        <!-- <tr>
            <th>Name : </th>
            <td><input type="text" name="name" value="<?php echo htmlspecialchars($row['Name']); ?>"></td>
        </tr> -->
        <!-- <tr>
            <th>Phone : </th>
            <td><input type="email" name="email" value="<?php echo htmlspecialchars($row['Email']); ?>"></td>
        </tr> -->
        <!-- <tr>
            <th>Category : </th>
            <td><input type="text" name="category" value="<?php //echo htmlspecialchars($row['Category']); ?>"></td>
        </tr> -->
        <tr>
            <th>Profile Picture:</th>
            <td><input type="file" name="u_picture" accept="image/*"></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;margin: 50px;">
                <button type="submit">Save Changes</button>
                <a href="profile.php"><button type="button">Cancel</button></a>
            </td>
        </tr>
    </table>
    </center>
</form>