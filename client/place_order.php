<?php
// place_order.php

// include('conf/config.php');
// include('conf/checklogin.php');

// echo('im alive....');
// exit();

// // Handle the order details received from the client
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
//     // Assuming you have a database connection

//     // Process the order details (use prepared statements to prevent SQL injection)
//     $orderItems = $_POST['orderItems'];
//     $totalPrice = $_POST['totalPrice'];

//     // Insert order details into the database and generate an order ID
//     $stmt = $mysqli->prepare("INSERT INTO ord (order_id, menu_item_id, item_name,  quantity, total_price, order_date) VALUES (?, ?, ?, ?, ?, ?)");

//     // Bind parameters
//     $stmt->bind_param("iisids", $orderId, $menuItemId, $itemName,  $quantity, $totalPrice, $orderDate);

//     // Generate a random order ID
//     $orderId = generateOrderId();

//     // Get the current date and time
//     $orderDate = date("Y-m-d H:i:s");

//     // Iterate through each order item and insert into the database
//     foreach ($orderItems as $orderItem) {
//         $menuItemId = $orderItem['id'];
//         $itemName = $orderItem['name'];
//         $quantity = $orderItem['quantity'];

//         $stmt->execute();
//     }

//     // Close the prepared statement
//     $stmt->close();

//     // Send a response back to the client
//     echo json_encode(['status' => 'success', 'orderID' => $orderId]);
// } else {
//     // Invalid request
//     echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
// }

// // Function to generate a random order ID (for demo purposes)
// function generateOrderId() {
//     return rand(100000, 999999);
// }
?>

<?php
session_start();
include('conf/config.php'); // Include your database configuration

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get order details from the POST request
    $orderItems = json_decode($_POST['orderItems'], true);
    $totalPrice = floatval($_POST['totalPrice']);
echo('hellowcein');
    // Generate a random order ID (you can adjust this based on your requirements)
    $orderID = uniqid('ORDER_');

    // Insert order details into the database
    $insertOrderQuery = "INSERT INTO ord (order_id, total_price) VALUES ('$orderID', $totalPrice)";
    $mysqli->query($insertOrderQuery);

    // Insert order items into the order_items table
    foreach ($orderItems as $item) {
        $itemID = $item['id'];
        $itemName = $mysqli->real_escape_string($item['name']);
        $itemPrice = floatval($item['price']);
        $itemQuantity = intval($item['quantity']);

        $insertOrderItemQuery = "INSERT INTO order_items (order_id, item_id, item_name, item_price, item_quantity) VALUES ('$orderID', $itemID, '$itemName', $itemPrice, $itemQuantity)";
        $mysqli->query($insertOrderItemQuery);
    }

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

