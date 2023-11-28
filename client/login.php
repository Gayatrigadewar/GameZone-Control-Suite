<?php

header('Access-Control-Allow-Origin: *'); // Be cautious about using wildcard (*) in a production environment.
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');
session_start();
function validateCredentials($username, $password) {
    $dbuser="root";
$dbpass="";
$host="localhost:3307";
$db="predrag_gamezone";
$mysqli=new mysqli($host,$dbuser, $dbpass, $db);
    $password = sha1(md5($password)); //double encrypt to increase security
    $stmt = $mysqli->prepare("SELECT email, password, client_id  FROM iB_clients   WHERE email=? AND password=?"); //sql to log in user
    $stmt->bind_param('ss', $username, $password); //bind fetched parameters
    $stmt->execute(); //execute bind
    $stmt->bind_result($email, $password, $client_id); //bind result
    $rs = $stmt->fetch();
    if($client_id > 0){
    $_SESSION['client_id'] = $client_id; //assaign session toc lient id
    return true;
    }
}

function handleLogin($username,$password) {
    
    // Check if the required fields are set
    if (isset($username) && isset($password)) {
        // Validate user credentials
        if (validateCredentials($username, $password)) {
            // Successful loginpri
           
            return array('status' => 'success', 'message' => 'Login successful',"client_id"=>$_SESSION['client_id']);
        } else {
            // Invalid credentials
            return array('status' => 'error', 'message' => 'Invalid credentials');
        }
    } else {
        // Incomplete data
        return array('status' => 'error', 'message' => 'Incomplete data');
    }
}


// Get the posted data
$data = json_decode(file_get_contents("php://input"));
// Handle login
$response = handleLogin($_POST['username'],$_POST['password']);

// Send the JSON response
header('Content-Type: application/json');
echo json_encode($response);

?>
