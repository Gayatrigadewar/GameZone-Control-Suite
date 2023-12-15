<?php
include('conf/config.php');


function getMenuItemsByCategory($mysqli, $category_id)
{
    $query = "SELECT * FROM product_list WHERE category_id = ? ORDER BY id ASC";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $category_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $menuItems = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $menuItems;
}

if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];

    $menuItems = getMenuItemsByCategory($mysqli, $category_id);

    // Build HTML content for menu items
    $menuItemsHtml = '';
    foreach ($menuItems as $menuItem) {
        $menuItemsHtml .= '<div class="card">';
        $menuItemsHtml .= '<img src="path/to/menu_images/' . $menuItem['img_path'] . '" class="card-img-top" alt="Menu Image">';
        $menuItemsHtml .= '<div class="card-body">';
        $menuItemsHtml .= '<h5 class="card-title">' . $menuItem['name'] . '</h5>';
        $menuItemsHtml .= '<p class="card-text">Price: ' . $menuItem['price'] . '</p>';
        $menuItemsHtml .= '<div class="input-group">';
        $menuItemsHtml .= '<span class="input-group-prepend">';
        $menuItemsHtml .= '<button class="btn btn-outline-secondary" type="button" onclick="decrementQuantity(this)">-</button>';
        $menuItemsHtml .= '</span>';
        $menuItemsHtml .= '<input type="text" class="form-control text-center" value="1" readonly>';
        $menuItemsHtml .= '<span class="input-group-append">';
        $menuItemsHtml .= '<button class="btn btn-outline-secondary" type="button" onclick="incrementQuantity(this)">+</button>';
        $menuItemsHtml .= '</span>';
        $menuItemsHtml .= '</div>';
        $menuItemsHtml .= '<button class="btn btn-primary mt-2" onclick="addItemToCart(' . $menuItem['id'] . ', \'' . $menuItem['name'] . '\', ' . $menuItem['price'] . ')">Add Item</button>';
        $menuItemsHtml .= '</div>';
        $menuItemsHtml .= '</div>';
    }

    // Return the HTML content
    echo $menuItemsHtml;
} else {
    // Handle the case where category_id is not provided
    echo 'Invalid category ID.';
}
?>
