<?php
session_start();
include('conf/config.php');
$tz = 'Asia/Kolkata';   
date_default_timezone_set($tz);
// Check if the user is logged in
if (!isset($_SESSION['client_id'])) {
  // Redirect to login page or handle unauthorized access
  header("location: login.php");
  exit();
}
function login() {
  // Do logic and log in the user
  // Set a session variable

  if ($logged_in) {
    $_SESSION['logged_in_time'] = time();
  }
}


// include('conf/config.php');



// Initialize $category_id to null
$category_id = null;

// Check if the category_id is provided in the URL
if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];
    
    // Get menu items for the selected category
    // $menuItems = getMenuItemsByCategory($mysqli, $category_id);
} else {
    // If category_id is not provided, set an empty array
    $menuItems = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("dist/_partials/head.php"); ?>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include("dist/_partials/nav.php"); ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include("dist/_partials/sidebar.php"); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <!-- Display categories in the sidebar -->
                    <!-- <div class="col-md-3">
                        <ul class="list-group">
                            <?php
                            $categories = $mysqli->query("SELECT * FROM category_list ORDER BY id ASC");
                            while ($category = $categories->fetch_assoc()): ?>
                                <li class="list-group-item">
                                    <a href="User_FoodOrder.php?category_id=<?= $category['id']; ?>">
                                        <?= $category['name']; ?>
                                    </a>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    </div> -->

                    <div class="navbar">
                    <style>
    .nav-item {
        margin-right: 10px;
    }
    
    .nav-link {
        color: #007bff; /* Change to blue color */
        text-decoration: none;
        /* background-color: white;Darker blue color on hover */
    }

    .nav-link:hover {
        color: black; 
        background-color:grey ;
    }
</style>

<ul class="nav">
    <?php
    $categories = $mysqli->query("SELECT * FROM category_list ORDER BY id ASC");
    while ($category = $categories->fetch_assoc()): ?>
        <li class="nav-item">
            <!-- <a class="nav-link btn btn-outline-primary" href="User_FoodOrder.php?category_id=<?= $category['id']; ?>"> -->
            <a class="nav-link btn btn-outline-primary" data-category-id="<?= $category['id']; ?>" href="#">
                <?= $category['name']; ?>
            </a>
        </li>
    <?php endwhile; ?>
</ul>

</div>


                    <!-- Display menu items in Bootstrap cards with quantity section and Add Item button -->
                    <div class="col-md-9">
                        <?php if ($category_id !== null): ?>
                            <h2>Menu Items for Category ID: <?= $category_id; ?></h2>
                            <div class="card-columns">
                                <?php foreach ($menuItems as $menuItem): ?>
                                    <div class="card">
                                        <img src="path/to/menu_images/<?= $menuItem['img_path']; ?>" class="card-img-top" alt="Menu Image">
                                        <div class="card-body">
                                            <h5 class="card-title"><?= $menuItem['name']; ?></h5>
                                            <p class="card-text">Price: <?= $menuItem['price']; ?></p>
                                            <div class="input-group">
                                                <span class="input-group-prepend">
                                                    <button class="btn btn-outline-secondary" type="button" onclick="decrementQuantity(this)">-</button>
                                                </span>
                                                <input type="text" class="form-control text-center" value="1" readonly>
                                                <span class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="button" onclick="incrementQuantity(this)">+</button>
                                                </span>
                                            </div>
                                            <!-- <button class="btn btn-primary mt-2" onclick="addItemToCart(<?= $menuItem['id']; ?>)">Add Item</button> -->
                                            <!-- Update the button in the menu items loop -->
                                            <button class="btn btn-primary mt-2" onclick="addItemToCart(<?= $menuItem['id']; ?>, '<?= $menuItem['name']; ?>', <?= $menuItem['price']; ?>)">Add Item</button>

                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p>Please select a category to view menu items.</p>
                        <?php endif; ?>
                    </div>
                    
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                        <div class="order-header">
                            <h2 class="card-title">Your Order</h2>
                        </div>
                            
                            <ul id="order-items-list" class="list-group">
                                <!-- Display order items here -->
                            </ul>
                            
                            <p class="card-text">Total Price: $<span id="total-price">0.00</span></p>
                            <button class="btn btn-success" onclick="placeOrder()">Place Order</button>
                            <p id="order-message"></p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- /.content-wrapper -->

        <!-- Update your existing HTML file -->


<!-- ------------------------------------ -->

<!-- Add this section where you want to display the user's order -->
<!-- <div class="col-md-3" id="order-section">
    <h2>Your Order</h2>
    <ul id="order-items-list" class="list-group">
        
    </ul>
    <p>Total Price: $<span id="total-price">0.00</span></p>
    <button class="btn btn-success" onclick="placeOrder()">Place Order</button>
    <p id="order-message"></p>
</div> -->

<!-- ... (rest of your HTML code) -->
<?php
// ... (your existing code)

// Check if it's an Ajax request
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








<!-- --------------------------- -->



        <!-- Footer -->
        <?php include("dist/_partials/footer.php"); ?>
    </div>
    <!-- ./wrapper -->

    <!-- Your existing JavaScript imports and scripts -->

    <!-- Add Bootstrap JS and Popper.js scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <!-- Add JavaScript for quantity increment and decrement -->
    <script>
        function incrementQuantity(input) {
            var value = parseInt(input.previousElementSibling.value, 10);
            input.previousElementSibling.value = value + 1;
        }

        function decrementQuantity(input) {
            var value = parseInt(input.nextElementSibling.value, 10);
            if (value > 1) {
                input.nextElementSibling.value = value - 1;
            }
        }

        // function addItemToCart(menuItemId) {
        //     // Add your logic here to handle adding items to the cart
        //     // You can use JavaScript AJAX to send a request to the server
        //     // For simplicity, let's just show an alert for now
        //     alert('Added item to cart. Item ID: ' + menuItemId);
        // }

            // ... (your existing code)
            function addItemToCart(menuItemId, itemName, itemPrice) {
    // Retrieve existing cart items from localStorage
    var existingCartItems = JSON.parse(localStorage.getItem('cartItems')) || [];

    // Add the new item to the cartItems array
    existingCartItems.push({
        id: menuItemId,
        name: itemName,
        price: itemPrice
    });

    // Update the localStorage with the updated cart items
    localStorage.setItem('cartItems', JSON.stringify(existingCartItems));

    // Update the order section
    updateOrderSection();

    // Show a message or perform additional logic if needed
    alert('Added item to cart. Item ID: ' + menuItemId);
}



// ... (your existing code)


    </script>

        <!-- Add this script section after including Bootstrap JS -->
<script>
    var cartItems = [];

    function updateOrderSection() {
        var orderList = document.getElementById('order-items-list');
        var totalPriceElement = document.getElementById('total-price');
        var orderMessageElement = document.getElementById('order-message');

        // Clear existing items in the order list
        orderList.innerHTML = '';

        // Iterate through the items in the cart and display them
        var totalPrice = 0;
        cartItems.forEach(function (item) {
            var listItem = document.createElement('li');
            listItem.className = 'list-group-item';
            listItem.textContent = item.name + ' - $' + item.price;
            orderList.appendChild(listItem);

            // Update total price
            totalPrice += parseFloat(item.price);
        });

        // Update the total price in the order section
        totalPriceElement.textContent = totalPrice.toFixed(2);

        // Display a message if the cart is empty
        if (cartItems.length === 0) {
            orderMessageElement.textContent = 'Your cart is empty.';
        } else {
            orderMessageElement.textContent = '';
        }
    }

    function addItemToCart(menuItemId, itemName, itemPrice) {
        // Add the item to the cartItems array

        var existingCartItems = JSON.parse(localStorage.getItem('cartItems')) || [];

        cartItems.push({
            id: menuItemId,
            name: itemName,
            price: itemPrice
        });

        // Update the order section
        updateOrderSection();

        // You can also perform additional logic or send data to the server here
        // For simplicity, let's just show an alert for now
        alert('Added item to cart. Item ID: ' + menuItemId);
    }

    // Other functions (incrementQuantity, decrementQuantity) remain unchanged

    function placeOrder() {
        // Add logic to handle placing the order (e.g., sending data to the server)
        // For simplicity, let's just show an alert for now
        cartItems = [];
        localStorage.setItem('cartItems', JSON.stringify(cartItems));

        // Update the order section
        updateOrderSection();




        alert('Placed order!');
    }

    // ... (your existing code)

// Function to fetch menu items via Ajax
function fetchMenuItems(categoryId) {
    $.ajax({
        url: 'get_menu_by_category.php',
        type: 'GET',
        data: {
            category_id: categoryId
        },
        success: function (htmlContent) {
            // Update the menu items on success
            $('.col-md-9').html(htmlContent);
        },
        error: function () {
            alert('Error fetching menu items.');
        }
    });
}


// Function to update the menu items on the page
function updateMenuItems(menuItems) {
    // Update the content of the menu items section
    var menuItemsContainer = $('.col-md-9');
    var menuItemsHtml = '';

    $.each(menuItems, function (index, menuItem) {
        menuItemsHtml += '<div class="card">';
        // ... (your existing code to display menu item details)
        menuItemsHtml += '</div>';
    });

    menuItemsContainer.html(menuItemsHtml);
}

// Event handler for category link clicks
$('.nav-link').on('click', function (e) {
    e.preventDefault();

    // Get the category ID from the link
    var categoryId = $(this).data('category-id');

    // Fetch menu items for the selected category
    fetchMenuItems(categoryId);
});

// ... (your existing code)

</script>

    



</body>
</html>

