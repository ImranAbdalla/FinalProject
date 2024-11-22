<?php
session_start();
include("../connection.php");

// Check if the required POST data is set
if (!isset($_POST['message']) || !isset($_POST['user']) || !isset($_POST['appointment_id'])) {
    echo "Required data is missing.";
    exit;
}

$message = $_POST['message'];
$user = $_POST['user'];
$appointment_id = $_POST['appointment_id'];

// Optional: Set a text color for each user type
$textcolor = ($user === 'mentor') ? 'blue' : 'green';

try {
    // Prepare and execute the insert statement
    $query = "INSERT INTO messages (message, user, appoid, textcolor) VALUES (?, ?, ?, ?)";
    $stmt = $database->prepare($query);
    $stmt->bind_param("ssiss", $message, $user, $appointment_id, $textcolor);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Message sent.";
    } else {
        echo "Failed to send message.";
    }
    $stmt->close();
    $database->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
