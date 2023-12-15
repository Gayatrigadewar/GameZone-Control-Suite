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
                        $systemsQuery = "SELECT * FROM ib_systems";
                        $systemsResult = mysqli_query($mysqli, $systemsQuery);

                        // Check if any rows are returned from ib_systems
                        if (mysqli_num_rows($systemsResult) > 0) {
                            // Loop through each row and display system_name
                            while ($systemRow = mysqli_fetch_assoc($systemsResult)) {
                                echo '<div class="col-md-4">';
                                echo '<div class="card">';
                                echo '<div class="card-header"><i class="fas fa-desktop"></i> ' . $systemRow['system_name'] . '</div>';

                                // Fetch data from the login_activity table for the current system
                                $loginQuery = "SELECT client_id, login_time, login_timer, login_status FROM login_activity WHERE system_id = '" . $systemRow['system_id'] .  "' AND login_status IN (1, 2)";
                                $loginResult = mysqli_query($mysqli, $loginQuery);

                                // Display login activity for the current system
                                echo '<div class="card-body">';
                                if (mysqli_num_rows($loginResult) > 0) {
                                    while ($loginRow = mysqli_fetch_assoc($loginResult)) {
                                        echo '<p>Client ID: ' . $loginRow['client_id'] . '</p>';
                                        echo '<p>Login Time: ' . $loginRow['login_time'] . '</p>';

                                            // Convert login_timer to HH:MM:SS format
                                            $loginTimerInSeconds = $loginRow['login_timer'];
                                            $formattedLoginTimer = sprintf("%02d:%02d", ($loginTimerInSeconds/60), $loginTimerInSeconds%60);

                                            echo '<p>Login Timer: ' . $formattedLoginTimer . '</p>';
                                            
                                        // echo '<p>Login Timer: ' . $loginRow['login_timer'] . '</p>';
                                        echo '<p>Login Status: ' . $loginRow['login_status'] . '</p>';
                                    }
                                } else {
                                    echo '<p>No login activity found for ' . $systemRow['system_name'] . '.</p>';
                                }
                                echo '</div>';

                                // Close the login activity result set
                                mysqli_free_result($loginResult);

                                echo '</div>';
                                echo '</div>';
                            }
                        } else {
                            // Display a message if no systems are found
                            echo '<div class="col-md-12"><p>No systems found.</p></div>';
                        }

                        // Close the ib_systems result set
                        mysqli_free_result($systemsResult);
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
