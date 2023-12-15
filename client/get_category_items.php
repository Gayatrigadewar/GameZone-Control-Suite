<?php
include('conf/config.php');

if (isset($_GET['ajax']) && $_GET['ajax'] == 1) {
    $category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;

    // Get menu items for the selected category
    $menuItems = getMenuItemsByCategory($mysqli, $category_id);

    // Return the menu items as JSON
    header('Content-Type: application/json');
    echo json_encode($menuItems);
    exit();
}
?>
