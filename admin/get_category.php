<?php
include('conf/config.php'); 


if (isset($_GET['category_id'])) {
    $categoryId = $_GET['category_id'];
    $menus = getMenusByCategoryId($mysqli, $categoryId);
    // Output the HTML for the menus
    foreach ($menus as $menu) {
        echo '<p>ID: ' . $menu['id'] . ', Name: ' . $menu['name'] . ', Price: ' . $menu['price'] . '</p>';
    }
} else {
    // Handle the case when category_id is not set in the request
    echo 'Invalid category ID.';
}

?>