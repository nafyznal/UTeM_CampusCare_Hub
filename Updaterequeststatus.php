<?php
session_start();
header('Content-Type: application/json');

$conn = new mysqli("localhost:3301", "root", "", "campuscare_hub");
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]);
    exit;
}

$input = json_decode(file_get_contents("php://input"), true);

$requestId = $input['requestId'] ?? null;
$status    = $input['status'] ?? null;

$allowedStatuses = ['Pending', 'Approved', 'Rejected', 'Collected'];

if (!$requestId || !in_array($status, $allowedStatuses, true)) {
    echo json_encode(["success" => false, "message" => "Invalid request data."]);
    exit;
}

$stmt = $conn->prepare("UPDATE request SET Status = ? WHERE RequestID = ?");
$stmt->bind_param("si", $status, $requestId);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Status updated to $status."]);
} else {
    echo json_encode(["success" => false, "message" => "Error: " . $stmt->error]);
}

$stmt->close();
$conn->close();