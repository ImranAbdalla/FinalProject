<?php
include("connection.php");

$appointment_id = $_GET['appointment_id'];
$stmt = $database->prepare("SELECT * FROM messages WHERE appointment_id = ? ORDER BY timestamp ASC");
$stmt->bind_param("i", $appointment_id);
$stmt->execute();
$result = $stmt->get_result();
$messages = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($messages);
?>
