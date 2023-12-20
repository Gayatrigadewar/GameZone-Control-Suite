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
                    color: green; /* Change to blue color */
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
                            <a class="nav-link btn btn-outline-success" data-category-id="<?= $category['id']; ?>" href="#">
                                <?= $category['name']; ?>
                            </a>
                        </li>
                    <?php endwhile; ?>
                </ul>

        </div>

                    <!-- Display menu items in Bootstrap cards with quantity section and Add Item button -->
                    <div class="col-md-9 " >
                        <?php if ($category_id !== null): ?>
                            <h2>Menu Items for Category ID: <?= $category_id; ?></h2>
                            <div class="card-columns">
                                <?php foreach ($menuItems as $menuItem): ?>
                                    <div class="card col-md-3" >
                                        <img src="path/to/menu_images/<?= $menuItem['img_path']; ?>" class="card-img-top" alt="Menu Image">
                                        <div class="card-body">
                                            <h5 class="card-title">name:<?= $menuItem['name']; ?></h5>
                                            <p class="card-text">Pricee: <?= $menuItem['price']; ?></p>
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
                <!-- <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                         <div class="order-header">
                            <h2 class="card-title">Your Order</h2>
                        </div>
                            
                            <ul id="order-items-list" class="list-group">
                                
                            </ul>
                            
                            <p class="card-text">Total Price: $<span id="total-price">0.00</span></p>
                           
                            <button class="btn btn-success" onclick="placeOrder()">Place Order</button>
                            <p id="order-message"></p>
                        </div>
                    </div>
                </div> -->

                <div class="col-md-6">
    <div class="card">
        <div class="card-body">
            <div class="order-header">
                <h2 class="card-title">Your Order</h2>
            </div>
            <!-- Display the order items in a table -->
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Delete</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody id="order-items-list">
                    <!-- Order items will be dynamically added here -->
                </tbody>
            </table>
            <p class="card-text">Total Price: $<span id="total-price">0.00</span></p>
            <button class="btn btn-success" onclick="placeOrder()">Place Order</button>
            <p id="order-message"></p>
        </div>
    </div>
</div>

                    
                </div>


                <!-- <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                        <div class="order-header">
                            <h2 class="card-title">Your Order</h2>
                        </div>
                            
                            <ul id="order-items-list" class="list-group">
                                
                            </ul>
                            
                            <p class="card-text">Total Price: $<span id="total-price">0.00</span></p>
                            <button class="btn btn-success" onclick="placeOrder()">Place Order</button>
                            <p id="order-message"></p>
                        </div>
                    </div>
                </div> -->

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
        // function incrementQuantity(input) {
        //     console.log('Incrementing quantity');
        //     var value = parseInt(input.previousElementSibling.value, 10);
        //     input.previousElementSibling.value = value + 1;
        // }

        // function decrementQuantity(input) {
        //     console.log('Decrementing quantity');
        //     var value = parseInt(input.nextElementSibling.value, 10);
        //     if (value > 1) {
        //         input.nextElementSibling.value = value - 1;
        //     }
        // }
// ++++++++++++++++++++++++++
        // function incrementQuantity(button) {
        //     var input = button.parentElement.previousElementSibling;
        //     var value = parseInt(input.value, 10);
        //     input.value = isNaN(value) ? 1 : value + 1;
        // }

        // function decrementQuantity(button) {
        //     var input = button.parentElement.nextElementSibling;
        //     var value = parseInt(input.value, 10);
        //     input.value = (isNaN(value) || value <= 1) ? 1 : value - 1;
        // }
//  +++++++++++++++++++++++++++++   

function incrementQuantity(button, index) {
    var input = button.parentElement.previousElementSibling;
    var value = parseInt(input.value, 10);
    input.value = isNaN(value) ? 1 : value + 1;

    // Update the cart item's quantity
    cartItems[index].quantity = parseInt(input.value);
    updateOrderSection();
}

function decrementQuantity(button, index) {
    var input = button.parentElement.nextElementSibling;
    var value = parseInt(input.value, 10);
    input.value = (isNaN(value) || value <= 1) ? 1 : value - 1;

    // Update the cart item's quantity
    cartItems[index].quantity = parseInt(input.value);
    updateOrderSection();
}





        // function addItemToCart(menuItemId) {
        //     // Add your logic here to handle adding items to the cart
        //     // You can use JavaScript AJAX to send a request to the server
        //     // For simplicity, let's just show an alert for now
        //     alert('Added item to cart. Item ID: ' + menuItemId);
        // }

            // ... (your existing code)
//             function addItemToCart(menuItemId, itemName, itemPrice) {
//     // Retrieve existing cart items from localStorage
//     var existingCartItems = JSON.parse(localStorage.getItem('cartItems')) || [];

//     // Add the new item to the cartItems array
//     existingCartItems.push({
//         id: menuItemId,
//         name: itemName,
//         price: itemPrice
//     });

//     // Update the localStorage with the updated cart items
//     localStorage.setItem('cartItems', JSON.stringify(existingCartItems));

//     // Update the order section
//     updateOrderSection();

//     // Show a message or perform additional logic if needed
//     alert('Added item to cart. Item ID: ' + menuItemId);
// }



// ... (your existing code)


    </script>

        <!-- Add this script section after including Bootstrap JS -->
<script>
    var cartItems = [];



function updateOrderSection() {
    var orderTableBody = document.getElementById('order-items-list');
    var totalPriceElement = document.getElementById('total-price');
    var orderMessageElement = document.getElementById('order-message');

    // Clear existing items in the order table
    orderTableBody.innerHTML = '';

    // Iterate through the items in the cart and add rows to the order table
    var totalPrice = 0;
    cartItems.forEach(function (item, index) {
        var row = orderTableBody.insertRow();

        // Create cells for each column
        var nameCell = row.insertCell(0);
        var priceCell = row.insertCell(1);
        var quantityCell = row.insertCell(2);
        var deleteCell = row.insertCell(3);
        var subtotalCell = row.insertCell(4);

        // Set the content for each cell
        nameCell.textContent = item.name;
        priceCell.textContent = '$' + item.price.toFixed(2);
        // quantityCell.textContent = item.quantity;-----------------

          // Create a quantity input for the item
          var quantityInput = document.createElement('input');
        quantityInput.type = 'number';
        quantityInput.value = item.quantity;
        quantityInput.min = 1;
        quantityInput.addEventListener('change', function () {
            // Update the cart item's quantity
            cartItems[index].quantity = parseInt(quantityInput.value);
            updateOrderSection();
        });
        quantityCell.appendChild(quantityInput);

        // Create a delete button for the item
        var deleteButton = document.createElement('button');
        deleteButton.className = 'btn btn-danger btn-sm';
        deleteButton.textContent = 'Delete';
        deleteButton.onclick = function () {
            deleteCartItem(index);
        };
        deleteCell.appendChild(deleteButton);

        // Calculate subtotal for the item
        var subtotal = item.price * item.quantity;
        subtotalCell.textContent = '$' + subtotal.toFixed(2);

        // Update total price
        totalPrice += subtotal;
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



// Function to delete a cart item by index
function deleteCartItem(index) {
    // Remove the item from the cartItems array
    cartItems.splice(index, 1);

    // Update the order section
    updateOrderSection();

    // Update localStorage with the updated cart items
    localStorage.setItem('cartItems', JSON.stringify(cartItems));
}


    function addItemToCart(menuItemId, itemName, itemPrice) {
        // Add the item to the cartItems array
        var quantity = ("1");
    quantity = parseInt(quantity) || 1; // Default to 1 if not a valid number


        cartItems.push({
            id: menuItemId,
            name: itemName,
            price: itemPrice,
             quantity: quantity
        });

        // Update the order section
        updateOrderSection();

        // You can also perform additional logic or send data to the server here
        // For simplicity, let's just show an alert for now
        // alert('Added item to cart. Item ID: ' + menuItemId);
    }

    // Other functions (incrementQuantity, decrementQuantity) remain unchanged

    // function placeOrder() {
    //     cartItems = [];
    //     localStorage.setItem('cartItems', JSON.stringify(cartItems));
    //     updateOrderSection();
    //     alert('Placed order!');
    // }

    function placeOrder() {
        // Check if there are items in the cart
        if (cartItems.length === 0) {
            alert('Your cart is empty. Please add items to place an order.');
            return;
        }
        // Prepare order details for sending to place_order.php
        var orderDetails = {
            orderItems: JSON.stringify(cartItems),
            totalPrice: parseFloat(document.getElementById('total-price').textContent)
            
        };
        // Use AJAX to send order details to place_order.php
        $.ajax({
            url: 'place_order.php',
            type: 'POST',
            data: orderDetails,
            success: function (response) {
                // Check the response from place_order.php
                if (response.status === 'success') {
                   
                    alert('Order placed successfully! Order ID: ' + response.orderID);
                    // Redirect to place_order.php
                    window.location.href = 'place_order.php?order_id=' + response.orderID;
                } else {
                    alert('Failed to place the order. ' + response.message);
                }
            },

            error: function () {
                alert('Error placing the order.');
            }
        });
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

