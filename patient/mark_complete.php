<?php
// Include database connection
include("../connection.php");


// Query to get all appointments
$sql = "SELECT appoid, appointment_date, status FROM appointments"; // Include other fields as necessary
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Start the table
    echo "<table>";
    echo "<tr><th>Appointment ID</th><th>Appointment Date</th><th>Status</th></tr>";

    // Output data for each appointment
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["appoid"] . "</td>";
        echo "<td>" . $row["appointment_date"] . "</td>";
        echo "<td>" . ($row["status"] == 'completed' ? '<span style="color: green;">Completed</span>' : '<span style="color: orange;">Active</span>') . "</td>";
        echo "</tr>";
    }

    // End the table
    echo "</table>";
} else {
    echo "No appointments found.";
}

$conn->close();
?>

<?php
session_start();
include("../connection.php"); // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['appoid'])) {
    $appoid = intval($_POST['appoid']); // Get the appointment ID

    // Update the appointment status in your database
    $query = "UPDATE appointment SET status='completed' WHERE appoid=$appoid";
    if ($database->query($query) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $database->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>


