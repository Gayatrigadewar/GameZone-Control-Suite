<?php
include('conf/config.php'); // get configuration file
$tz = 'Asia/Kolkata';   
   date_default_timezone_set($tz);
$query = "SELECT client_id, login_time FROM login_activity WHERE login_status IN ('1', '2') AND logout_time IS NULL";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($client_id, $login_time);
// Fetch all rows into an array
$loginData = array();
while ($stmt->fetch()) {
    $loginData[] = array('client_id' => $client_id, 'login_time' => $login_time);
}
// Close the SELECT statement
$stmt->close();

// Process the fetched data and update records
foreach ($loginData as $data) {
    $loginTime = strtotime($data['login_time']);
    $currentTime = time();
    $timestamp = $currentTime - $loginTime;
    $timestampinmin = round($timestamp / 60);

    $updateQuery = "UPDATE login_activity SET login_timer=? WHERE client_id=? AND logout_time IS NULL";
    $updateStmt = $mysqli->prepare($updateQuery);

    if ($updateStmt) {
        $updateStmt->bind_param('ii', $timestampinmin, $data['client_id']);
        $updateStmt->execute();
        $updateStmt->close();
    } else {
        // Handle the error if the update statement preparation fails
        die('Error in preparing the update statement: ' . $mysqli->error);
    }
}

?>
