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

//   $query = "SELECT login_id ,client_id, login_time FROM login_activity WHERE login_status IN ('1', '2') AND logout_time IS NULL";



  if ($updateStmt) {
    $updateStmt->bind_param('sii', $logoutTime, $loginStatus, $_SESSION['client_id']);
    $updateStmt->execute();
    // $updateStmt->close();

    $length = 20;
    $_transcode =  substr(str_shuffle('0123456789QWERgfdsazxcvbnTYUIOqwertyuioplkjhmPASDFGHJKLMNBVCXZ'), 1, $length);
    $tr_code = $_transcode;
    $tr_type  = 'Withdraw';
    $tr_status = 'Success';
    $client_id  = $_SESSION['client_id'];
    
    $query = "SELECT deduction_amount  FROM temp_transaction WHERE client_id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $client_id); 
    $stmt->execute();
    $stmt->bind_result($deduction_amount); 
    $stmt->fetch();
    $stmt->close();

    $transaction_amt = $deduction_amount;

    
    $query = "SELECT  account_id , account_number FROM ib_bankaccounts WHERE client_id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $client_id); 
    $stmt->execute();
    $stmt->bind_result($fetched_account_id, $fetched_account_number);
    $stmt->fetch();
    $stmt->close();

    $account_id = $fetched_account_id;
    $account_number = $fetched_account_number;
    


    //Insert Captured information to a database table
    $query = "INSERT INTO iB_Transactions (tr_code, account_id, account_number,  tr_type, tr_status, client_id, transaction_amt) VALUES (?,?,?,?,?,?,?)";
   
    $stmt = $mysqli->prepare($query);

    $rc = $stmt->bind_param('sssssss', $tr_code, $account_id, $account_number, $tr_type, $tr_status, $client_id, $transaction_amt);
    $stmt->execute();
    
    $stmt->close();



    // $notification_stmt->execute();
  }
  
  if ($updateStmt) {
      $updateStmt->bind_param('sii', $logoutTime, $loginStatus, $_SESSION['client_id']);
      $updateStmt->execute();
      $updateStmt->close();
  } else {
      // Handle the error if the update statement preparation fails
      die('Error in preparing the update statement: ' . $mysqli->error);
  }

   // Remove temporary transaction data
   $deleteTempTransactionQuery = "DELETE FROM temp_transaction WHERE client_id=? ";
   $deleteTempTransactionStmt = $mysqli->prepare($deleteTempTransactionQuery);

   if ($deleteTempTransactionStmt) {
       $deleteTempTransactionStmt->bind_param('i', $_SESSION['client_id']);
       $deleteTempTransactionStmt->execute();
       $deleteTempTransactionStmt->close();
   } else {
       // Handle the error if the deletion statement preparation fails
       die('Error in preparing the deletion statement: ' . $mysqli->error);
   }


    unset($_SESSION['client_id']);

    session_destroy();

     header("Location: login.html"); //pages_client_index.php
    exit;



