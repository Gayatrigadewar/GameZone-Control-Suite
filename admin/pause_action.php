<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $systemId = $_POST['systemId'];

    // Update the login_activity table to pause the timer for the specified system
    $updateQuery = "UPDATE login_activity SET login_status = 2 WHERE system_id = ? AND login_status = 1";
    $updateStmt = $mysqli->prepare( $updateQuery);

    if ($updateStmt) {
        $updateStmt->bind_param('s', $systemId);
        $updateStmt->execute();
        $updateStmt->close();

        echo 'Timer paused successfully.';
    } else {
        echo 'Failed to pause the timer.';
    }
} else {
    echo 'Invalid request.';
}
?>
