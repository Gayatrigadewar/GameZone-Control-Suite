<?php
include('conf/config.php'); // Include your database configuration

if(isset($_POST['id'])){
    $category_id = $_POST['id'];

    // Perform the deletion in the database
    $query = "DELETE FROM category_list WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $category_id);

    if($stmt->execute()){
        echo 'success';
    }else{
        echo 'error';
    }

    $stmt->close();
}
?>
