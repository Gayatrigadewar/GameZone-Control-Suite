<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$admin_id = $_SESSION['admin_id'];
?>



<!DOCTYPE html>
<html>
    
<?php

include("dist/_partials/head.php"); 
?>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include("dist/_partials/nav.php"); ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include("dist/_partials/sidebar.php"); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <?php
                        // Fetch data from the ib_systems table
                        $sql = "SELECT system_name FROM ib_systems";
                        $result = mysqli_query($mysqli, $sql);

                        // Check if any rows are returned
                        if (mysqli_num_rows($result) > 0) {
                            // Loop through each row and display data in cards
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<div class="col-md-4">';
                                echo '<div class="card">';
                                echo '<div class="card-header"><i class="fas fa-desktop"></i> ' . $row['system_name'] . '</div>';

                                // echo '<div class="card-header"><img src="pc_logo.png" alt="PC Logo" style="width: 20px; height: 20px;"> ' . $row['system_name'] . '</div>';
                                // You can add more card content here if needed
                                echo '</div>';
                                echo '</div>';
                            }
                        } else {
                            // Display a message if no data is found
                            echo '<div class="col-md-12"><p>No systems found.</p></div>';
                        }

                        // Close the result set
                        mysqli_free_result($result);
                        ?>
                    </div>
                </div>
            </section>
        </div>
        <!-- /.content-wrapper -->
        <?php include("dist/_partials/footer.php"); ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- Bootstrap Toggle -->
    <link rel="stylesheet" href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap2-toggle.min.css">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap2-toggle.min.js"></script>
    <!-- AJAX script -->
    
</body>

</html>
