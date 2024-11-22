<?php
session_start();
include("../connection.php");

// Ensure the appointment_id is passed and set
if (!isset($_GET['appointment_id'])) {
    echo "Appointment ID is missing.";
    exit;
}

$appointment_id = $_GET['appointment_id'];

try {
    // Prepare the SQL statement to select messages based on the appointment ID
    $query = "SELECT * FROM messages WHERE appoid = ? ORDER BY id ASC"; // Ascending order for chronological display
    $stmt = $database->prepare($query);
    $stmt->bindValue(1, $appointment_id, PDO::PARAM_INT); // Use bindValue for PDO
    $stmt->execute();

    // Loop through the messages and display them
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $userClass = ($row['user'] === 'mentor') ? 'mentor' : 'student';
        echo '<div class="message ' . htmlspecialchars($userClass) . '" style="color: ' . htmlspecialchars($row['textcolor']) . ';">' .
             htmlspecialchars($row['message']) . '</div>';
    }
    $stmt->closeCursor(); // Close cursor for further operations
    $database = null; // Close database connection
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
