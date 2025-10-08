<?php
header('Content-Type: application/json');

include 'db_connect.php';

if (isset($_GET['date'])) {
    $selected_date = $_GET['date'];
    $current_date = date('Y-m-d');
    
    if ($selected_date < $current_date) {
        echo json_encode([]);
        exit();
    }
    
    $venue_id = isset($_GET['venue_id']) ? $_GET['venue_id'] : null;

    if ($venue_id !== null && $venue_id != 0) {
        $sql = "SELECT ts.slot_id, ts.time_slots 
                FROM time_slots ts
                LEFT JOIN reservations r ON ts.slot_id = r.slot_id AND r.date = ? AND r.venue_id = ?
                WHERE r.slot_id IS NULL";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $selected_date, $venue_id);
    } else {
        $sql = "SELECT slot_id, time_slots FROM time_slots 
                WHERE slot_id NOT IN (
                    SELECT slot_id FROM reservations WHERE date = ?
                )";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $selected_date);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $available_time_slots = [];
    while ($row = $result->fetch_assoc()) {
        $available_time_slots[] = $row;
    }

    echo json_encode($available_time_slots);
} else {
    echo json_encode([]);
}

$conn->close();
?>
