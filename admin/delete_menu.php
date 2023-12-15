<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get menu ID from the AJAX request
    $menuId = $_POST['id'];

    // Delete data from the database
    $delete_query = "DELETE FROM product_list WHERE id = ?";
    $stmt = $mysqli->prepare($delete_query);
    $stmt->bind_param('i', $menuId);

    if ($stmt->execute()) {
        echo 'Menu deleted successfully';
    } else {
        echo 'Error deleting menu: ' . $stmt->error;
    }

    $stmt->close();
} else {
    echo 'Invalid request';
}
?>
