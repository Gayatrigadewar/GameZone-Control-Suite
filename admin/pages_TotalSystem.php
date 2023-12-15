<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$admin_id = $_SESSION['admin_id'];
?>



<!DOCTYPE html>
<html>
<?php include("dist/_partials/head.php"); ?>

<body class="hold-transition sidebar-mini">
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
                            <h1>Total Systems</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="pages_dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="total_system.php">Total Systems</a></li>
                                <li class="breadcrumb-item active">View Systems</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">List of Total Systems</h3>
                            </div>
                            <div class="card-body">
                                <div id="systemTableContainer">
                                    <!-- Systems will be loaded here dynamically using AJAX -->
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->
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
    <script>
        // Function to load systems using AJAX
        function loadSystems() {
            $.ajax({
                url: 'get_systems.php',
                type: 'GET',
                success: function(response) {
                    $('#systemTableContainer').html(response);
                    // Initialize the Bootstrap Toggle plugin for toggle buttons
                    $('.toggle-status').bootstrapToggle();

                    // Attach a change event to handle toggle changes
                    $('.toggle-status').change(function() {
                        var systemId = $(this).data('system-id');
                        var currentStatus = $(this).prop('checked') ? 1 : 0;
                        toggleStatus(systemId, currentStatus);
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        // Load systems on page load
        $(document).ready(function() {
            loadSystems();
        });

        // Function to edit a system
        function editSystem(system_id) {
            // You can redirect to an edit page or show a modal for editing
            console.log("Editing system with ID:", system_id);
        }

        // Function to toggle the status of a system
        function toggleStatus(system_id, currentStatus) {
            $.ajax({
                url: 'toggle_system_status.php',
                type: 'POST',
                data: { system_id: system_id, status: currentStatus },
                success: function(response) {
                    loadSystems();
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
    </script>
</body>

</html>
