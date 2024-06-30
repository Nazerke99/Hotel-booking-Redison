<?php
session_start();
require_once ('admin/inc/essen.php');
require_once('admin/db_config.php'); // Include your database connection

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $checkin_date = mysqli_real_escape_string($con, $_POST['checkin_date']);
    $checkout_date = mysqli_real_escape_string($con, $_POST['checkout_date']);
    $adults = (int)$_POST['adults'];
    $children = (int)$_POST['children'];

    
    if ($checkin_date >= $checkout_date) {
        die("Error: Check-out date must be after check-in date.");
    }

    
    $sql = "SELECT * FROM rooms 
            WHERE room_id NOT IN (
                SELECT DISTINCT room_id FROM bookings 
                WHERE booking_date BETWEEN '$checkin_date' AND '$checkout_date'
            )";

    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        // Display available rooms
        echo "<h2>Available Rooms</h2>";
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li>Room ID: " . $row['room_id'] . ", Room Type: " . $row['room_name'] . "</li>";
            // Display more room details as needed
        }
        echo "</ul>";
    } else {
        echo "<p>No rooms available for the selected dates.</p>";
    }

    // Close database connection
    $con->close();
}
?>
