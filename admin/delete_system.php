<?php
include('conf/config.php');

// Check if 'system_id' is set in the POST request
if (isset($_POST['system_id'])) {
    $system_id = $_POST['system_id'];

    // Check if $system_id is numeric before using it
    if (is_numeric($system_id)) {
        // Delete the system from the database
        $query = "DELETE FROM iB_systems WHERE system_id = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('i', $system_id);
        $stmt->execute();

        if ($stmt) {
            echo 'System deleted successfully';
        } else {
            echo 'Error deleting system';
        }
    } else {
        echo 'Invalid system ID';
    }
} else {
    echo 'Invalid request';
}
?>
