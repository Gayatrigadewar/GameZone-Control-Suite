<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$admin_id = $_SESSION['admin_id'];

// Fetch admin name
$query = "SELECT name FROM iB_admin WHERE admin_id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('s', $admin_id);
$stmt->execute();
$stmt->bind_result($admin_name);
$stmt->fetch();
$stmt->close();

// Process form data when the form is submitted
if (isset($_POST['add_system'])) {
    $system_name = $_POST['system_name'];
    $price_per_hour = $_POST['price_per_hour'];
    $price_per_minute = $_POST['price_per_minute'];
    $room_no = $_POST['room_no']; // Added field

    // Insert data into the database
    $query = "INSERT INTO iB_systems (system_name, price_per_hour, price_per_minute, room_no) VALUES (?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('ssss', $system_name, $price_per_hour, $price_per_minute, $room_no);
    $stmt->execute();

    // Check if the insertion was successful
    if ($stmt) {
        $success = "System Added Successfully";
    } else {
        $err = "Error Adding System. Please Try Again.";
    }
}
?>

<!DOCTYPE html>
<html>
<?php include("dist/_partials/head.php"); ?>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include("dist/_partials/nav.php"); ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include("dist/_partials/sidebar.php"); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Add System</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="pages_dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="add_system.php">Manage Systems</a></li>
                                <li class="breadcrumb-item active">Add System</li>
                            </ol>
                        </div>
                    </div>

                    <!-- Display the admin's name -->
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <p>Welcome, <?php echo $admin_name; ?>!</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-purple">
                                <div class="card-header">
                                    <h3 class="card-title">Fill All Fields</h3>
                                </div>
                                <form method="post" role="form">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="system_name">System Name</label>
                                                <input type="text" name="system_name" required class="form-control" id="system_name">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="price_per_hour">Price per Hour</label>
                                                <input type="text" name="price_per_hour" required class="form-control" id="price_per_hour">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="price_per_minute">Price per Minute</label>
                                                <input type="text" name="price_per_minute" required class="form-control" id="price_per_minute">
                                            </div>

                                            <!-- New section for user's name -->
                                            <div class="col-md-6 form-group">
                                                <label for="room_no">Room no.</label>
                                                <input type="text" name="room_no" required class="form-control" id="room_no">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" name="add_system" class="btn btn-success">Add System</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Footer and scripts -->
        <?php include("dist/_partials/footer.php"); ?>
    </div>

    <!-- jQuery, Bootstrap, and other scripts -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>
    <script src="dist/js/demo.js"></script>
</body>
</html>
