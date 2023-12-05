<?php
include('conf/config.php');

// Check if 'system_id' and 'status' are set in the POST request
if (isset($_POST['system_id'], $_POST['status'])) {
    $system_id = $_POST['system_id'];
    $status = $_POST['status'];

    // Update the status of the system in the database
    $query = "UPDATE iB_systems SET status = ? WHERE system_id = ?";
    $stmt = $mysqli->prepare($query);
    $newStatus = ($status == 1) ? 0 : 1; // Toggle the status
    $stmt->bind_param('ii', $newStatus, $system_id);
    $stmt->execute();
    $stmt->close();
}
?>
