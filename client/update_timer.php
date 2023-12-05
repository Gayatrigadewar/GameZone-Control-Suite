<?php
include('conf/config.php'); // get configuration file
$tz = 'Asia/Kolkata';   
   date_default_timezone_set($tz);
$query = "SELECT login_id ,client_id, login_time FROM login_activity WHERE login_status IN ('1', '2') AND logout_time IS NULL";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($login_id, $client_id, $login_time);
// Fetch all rows into an array
$loginData = array();
while ($stmt->fetch()) {
    $loginData[] = array('login_id' => $login_id,'client_id' => $client_id, 'login_time' => $login_time);
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
        deductWalletBalance($data['client_id'], 1, $data['login_id']); // Per-minute charge of ₹0.5
       // sleep(60); // Deduct every minut
    } else {
        // Handle the error if the update statement preparation fails
        die('Error in preparing the update statement: ' . $mysqli->error);
    }
}

?>
 <!-- API -->

<?php

// Database connection parameters
// $dbHost = "localhost";
// $dbName = "your_database_name";
// $dbUsername = "your_database_username";
// $dbPassword = "your_database_password";

// // Establish database connection
// try {
//     $dbConnection = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
// } catch (PDOException $e) {
//     echo "Error connecting to database: " . $e->getMessage();
//     exit;
// }


// Function to deduct money from user's wallet
function deductWalletBalance($client_Id, $perMinuteCharge, $login_id) {
    global $mysqli;


    // Calculate deduction amount based on per-minute charge
    $deductionAmount = $perMinuteCharge ;
    
    // // Update wallet balance
    // $updateWalletBalanceQuery = "UPDATE ib_bankaccounts SET acc_amount = acc_amount - ? WHERE client_id = ?";
    // $stmt =$mysqli ->prepare($updateWalletBalanceQuery);
    // $stmt->bind_param('di', $deductionAmount, $client_Id); // 'di' is for double and integer
    // $stmt->execute();
    // $stmt->close();




    
     // Update wallet balance
     $updateWalletBalanceQuery = "UPDATE ib_bankaccounts SET acc_amount = acc_amount - ? WHERE client_id = ?";
     $stmt = $mysqli->prepare($updateWalletBalanceQuery);
     $stmt->bind_param('di', $deductionAmount, $client_Id);
     $stmt->execute();
     $stmt->close();

     $query1 = "SELECT client_id, login_id,deduction_amount FROM temp_transaction WHERE client_id = ? AND login_id = ?";

     $stmt = $mysqli->prepare($query1);
     $stmt->bind_param("ii", $client_Id, $login_id); // Assuming both are integers
     $stmt->execute();
     $stmt->bind_result($client_Id, $login_id, $deduction_amount);
     
     $result = array();
     while ($stmt->fetch()) {
         $result[] = array('login_id' => $login_id, 'client_id' => $client_Id, 'deduction_amount' => $deduction_amount);
     }
     print_r($result);
     // Close the SELECT statement and free up the result set
     $stmt->close();
          
           if(empty($result )){
            // Insert the deduction amount for the current transaction into the temp_transaction table
                $insertTransactionQuery = "INSERT INTO temp_transaction (deduction_amount, client_id, login_id) VALUES (?, ?, ?)";
                $stmt = $mysqli->prepare($insertTransactionQuery);
                $stmt->bind_param('dii', $deductionAmount, $client_Id, $login_id);
                $stmt->execute();
                $stmt->close();
           } else{
            // Update the total deducted amount in the database based on login_id
            $updateTotalDeductedQuery = "UPDATE temp_transaction SET deduction_amount = ($deduction_amount+1)  WHERE login_id = ? AND client_id = ? ";
            $stmt = $mysqli->prepare($updateTotalDeductedQuery);
            $stmt->bind_param('di',  $login_id, $client_Id);
            $stmt->execute();
            $stmt->close();
           }
         
 
 
    // Calculate total deducted amount till now based on login_id
    $selectTotalDeductedQuery = "SELECT SUM(deduction_amount) FROM temp_transaction WHERE login_id = ?";
    $stmt = $mysqli->prepare($selectTotalDeductedQuery);
    $stmt->bind_param('i', $login_id);
    $stmt->execute();
    $stmt->bind_result($totalDeductedAmount);
    $stmt->fetch();
    $stmt->close();

    



   
}
// Function to notify admin of total deducted amount
function notifyAdmin($totalDeducted_Amount) {
    // Send notification to admin using your preferred method (email, SMS, etc.)
    echo "Admin notification: Total deducted amount: ₹$total_Deducted_Amount";
     
}


?>