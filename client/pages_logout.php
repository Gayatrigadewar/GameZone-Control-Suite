<?php
    session_start();
    date_default_timezone_set('Asia/Kolkata');
echo "Server Time (Indian Standard Time): " . date('Y-m-d H:i:s');
include('conf/config.php'); //get configuration file

    $logoutTime = date('Y-m-d H:i:s');
 // $systemId = getSystemId(); // You need to implement a function to get the system_id
  $loginStatus = 0; // Set to 0 for logout
  
  $updateQuery = "UPDATE login_activity SET logout_time=?, login_status=? WHERE client_id=? AND logout_time IS NULL";

  $updateStmt = $mysqli->prepare($updateQuery);
  
  if ($updateStmt) {
      $updateStmt->bind_param('sii', $logoutTime, $loginStatus, $_SESSION['client_id']);
      $updateStmt->execute();
      $updateStmt->close();
  } else {
      // Handle the error if the update statement preparation fails
      die('Error in preparing the update statement: ' . $mysqli->error);
  }

    unset($_SESSION['client_id']);

    session_destroy();

    header("Location: login.html"); //pages_client_index.php
    exit;

