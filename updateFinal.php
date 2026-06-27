<?php
session_start();
include('connect.php');

$studentId = $_SESSION['StudentId'];

if (isset($_FILES['u_picture']) && $_FILES['u_picture']['error'] == 0) {
    $uploadDir = "uploads/profile/";
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

    $fileName       = time() . "_" . basename($_FILES['u_picture']['name']);
    $profilePicPath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['u_picture']['tmp_name'], $profilePicPath)) {
        // ✅ Only update if upload succeeded, StudentId without quotes
        $sql = "UPDATE student SET Picture='$profilePicPath' WHERE StudentId=$studentId";

        if ($conn->query($sql)) {
            header('Location: viewProfile.php');
            exit();
        } else {
            echo "Update Failed: " . $conn->error;
        }
    } else {
        echo "File upload failed.";
    }
} else {
    // No file uploaded, just redirect back
    header('Location: viewProfile.php');
    exit();
}

$conn->close();
?>