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

// // Process form data when the form is submitted
if (isset($_POST['Save'])) {
    $name = $_POST['name'];
    // $category_id = $_POST['category_id'];
    
    // Insert data into the database
    $query = "INSERT INTO category_list  (name)  VALUES (?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('s', $name);
    
    if ($stmt->execute()) {
        // Data inserted successfully, you can also return the inserted ID if needed
        $response = array('status' => 'success', 'message' => 'Category added successfully');
        header("location: food_categories.php");
    } else {
        // Failed to insert data
        $response = array('status' => 'error', 'message' => 'Error adding category');
    }

    // $stmt->execute();
    // $stmt->close(); // Close the prepared statement

     // Output JSON response for AJAX
    //  header('Content-Type: application/json');
    //  echo json_encode($response);
    //  exit;
}

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
            <div class="container-fluid">

                <div class="col-lg-12">
                    <div class="row">
                        <!-- FORM Panel -->
                        <div class="col-md-4">
                            <form action="" id="manage-category" method="post">
                                <div class="card">
                                    <div class="card-header">
                                        Category Form
                                    </div>
                                    <div class="card-body">
                                        <input type="hidden" name="id">
                                        <div class="form-group">
                                            <label class="control-label">Category</label>
                                            <input type="text" class="form-control" name="name">
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="submit" name="Save" class="btn btn-sm btn-primary col-sm-3 offset-md-3"> Save</button>
                                                <button class="btn btn-sm btn-default col-sm-3" type="button" onclick="$('#manage-category').get(0).reset()"> Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- FORM Panel -->

                        <!-- Table Panel -->
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $i = 1;
                                           
                                            $cats = $mysqli->query("SELECT * FROM category_list order by id asc");
                                            while($row=$cats->fetch_assoc()):
                                                ?>
                                            <tr>
                                                <td class="text-center"><?php echo $i++ ?></td>
                                                <td class="">
                                                    <?php echo $row['name'] ?>
                                                </td>
                                                <td class="text-center">
                                                    <!-- <button class="btn btn-sm btn-primary edit_cat" type="button" data-id="<?php echo $row['id'] ?>" data-name="<?php echo $row['name'] ?>">Edit</button> -->
                                                    <button class="btn btn-sm btn-danger delete_cat" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
                                                   
                                                </td>
                                            </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Table Panel -->
                    </div>
                </div>	

            </div>
            <style>
                td {
                    vertical-align: middle !important;
                }
            </style>





<!-- Your existing HTML code -->

<!-- ... (your existing HTML code) ... -->




           








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
<!-- Add this script at the end of your HTML file -->
<script>
$(document).ready(function(){
    // Delete Category
    $('.delete_cat').on('click', function(){
        var cat_id = $(this).data('id');
        if(confirm('Are you sure you want to delete this category?')){
            $.ajax({
                type: 'POST',
                url: 'delete_category.php',
                data: {id: cat_id},
                success:function(response){
                    if (response === 'success') {
                        // Deletion successful, reload the page
                        location.reload();
                    } else {
                        // Deletion failed, show an error message or handle it accordingly
                        alert('Error deleting category.');
                    }
                },
                error:function(){
                    // AJAX request failed, show an error message
                    alert('Error deleting category.');
                }
            });
        }
    });
});

</script>