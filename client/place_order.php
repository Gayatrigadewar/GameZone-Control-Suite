

<?php
session_start();
include('conf/config.php'); // Include your database configuration

if (isset($_POST['totalPrice'])) {
    // Get order details from the POST request
    $orderItems = json_decode($_POST['orderItems'], true);
    $totalPrice = floatval($_POST['totalPrice']);

    // Generate a random order ID (you can adjust this based on your requirements)
    $orderID = uniqid('');


    // Insert order items into the order_items table
    foreach ($orderItems as $item) {
        // $itemID = $item['id'];
        $itemName = $mysqli->real_escape_string($item['name']);
        $itemPrice = floatval($item['price']);
        $itemQuantity = intval($item['quantity']);

        $insertOrderItemQuery = "INSERT INTO ib_order(order_id,  item_name,  item_quantity ,total_price ) VALUES ('$orderID', '$itemName', $itemQuantity ,  $totalPrice)";
        $mysqli->query($insertOrderItemQuery);
    }

         // Deduct the total price from the acc_amount column in ib_bankaccounts
         $clientID = $_SESSION['client_id'];  // Assuming you have stored the client_id in the session
         $deductAmountQuery = "UPDATE ib_bankaccounts SET acc_amount = acc_amount - $totalPrice WHERE client_id = '$clientID'";
         $mysqli->query($deductAmountQuery);
 

         
            // Insert deduction amount transaction into ib_transactions table
            $transactionAmt = $totalPrice;
            
            $trType = "Foodorder debit";

            $insertTransactionQuery = "INSERT INTO ib_transactions(client_id, transaction_amt, tr_type) VALUES ('$clientID', $transactionAmt, '$trType')";
            $mysqli->query($insertTransactionQuery);
            

         // Commit the transaction
         $mysqli->commit();



    

    // Clear the user's cart (you may want to handle this based on your session or local storage)
    $_SESSION['cartItems'] = [];

    // Send a response to the client
    $response = [
        'status' => 'success',
        'orderID' => $orderID,
    ];
    echo json_encode($response);
} else {
    // Handle invalid request method
    http_response_code(405);
    echo 'Method Not Allowed';
}
?>

