<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$admin_id = $_SESSION['admin_id'];






if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $category_id = $_POST['category_id'];
    $price = $_POST['price'];
    $status = isset($_POST['status']) ? 1 : 0;

    // Handling image upload
    $img_path = '';

    if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {

        
        $folder = "dist/menu_img/";
        $image_file = $_FILES['img']['name'];
        $file = $_FILES['img']['tmp_name'];
        $path = $folder . $image_file;
        $target_file = $folder . basename($image_file);
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

        // Allow only JPG, JPEG, PNG & GIF etc formats
        // if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        //     echo 'Sorry, only JPG, JPEG, PNG & GIF files are allowed';
        //     exit;
        // }

        // // Set image upload size
        // if ($_FILES["img"]["size"] > 1048576) {
        //     echo 'Sorry, your image is too large. Upload less than 1 MB KB in size.';
        //     exit;
        // }

        // Move image to folder
        move_uploaded_file($file, $target_file);
        $img_path = $image_file;
    }

 


    // Insert data into product_list table
    $insert_query = "INSERT INTO product_list (category_id, name, price, img_path, status) VALUES (?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($insert_query);
    $stmt->bind_param('isssi', $category_id, $name, $price, $img_path, $status);
    
    if ($stmt->execute()) {
        echo 'Data inserted successfully';
        header("location: food_menu.php");
    } else {
        echo 'Error inserting data: ' . $stmt->error;
    }

    // $stmt->close();
   
} else {
    echo 'Invalid request';
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

                <!-- <div class="col-lg-12"> -->
                    <div class="row">
                    <!-- FORM Panel -->
                    <div class="col-md-4">
                        <form action="" id="manage-menu" method="post" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header">
                                    Menu Form
                                </div>
                                <div class="card-body">
                                    <!-- Form content... -->
                                    <input type="hidden" name="id">
                                    <div class="form-group">
                                        <label class="control-label">Menu Name</label>
                                        <input type="text" class="form-control" name="name">
                                    </div>

                                            <!-- <div class="form-group">
                                        <label class="control-label">Menu Description</label>
                                        <textarea cols="30" rows="3" class="form-control" name="description"></textarea>
                                    </div> -->
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                        <input type="checkbox" name="status" class="custom-control-input" id="availability" checked>
                                        <label class="custom-control-label" for="availability">Available</label>
                                        </div>
                                    </div>	
                                    <div class="form-group">
                                        <label class="control-label">Category </label>
                                    <select name="category_id" id="" class="custom-select browser-default">
                                                <?php
                                            $cat = $mysqli->query("SELECT * FROM category_list order by name asc ");
                                            while($row=$cat->fetch_assoc()):
                                            ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                                            <?php endwhile; ?>
                                    </select>


                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Price</label>
                                        <input type="number" class="form-control text-right" name="price" step="any">
                                    </div>

                                    <div class="form-group">
                                        <label for=" " class="control-label">Image</label>
                                        <input type="file" class="form-control" name="img" > 
                                    </div>

                                    <div class="form-group">
                                        <img src="<?php echo 'dist/menu_img/'.$cover_img;?>" alt="" id="cimg">
                                    </div>

                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="submit" name="Save" class="btn btn-sm btn-primary col-sm-3 offset-md-3"> Save</button>
                                                <button class="btn btn-sm btn-default col-sm-3" type="button" onclick="$('#manage-menu').get(0).reset()"> Cancel</button>
                                            </div>
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
                                            <th class="text-center">Img</th>
                                            <th class="text-center">Room</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <!-- Table content... -->
                                    <tbody>
								<?php 
								$i = 1;
								$cats = $mysqli->query("SELECT * FROM product_list order by id asc");
								while($row=$cats->fetch_assoc()):
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>

								
									<td class="text-center">
                                        <!-- <img src ="<?php echo  $CFG->wwroot.'dist/menu_img/'.$row['img_path']?>"alt="" id="cimg"> -->
										<img src="<?php echo isset($row['img_path']) ? 'dist/menu_img/'.$row['img_path'] :'' ?>" alt="" id="cimg" class="w-25">
									</td>
									<td class="">
										<p>Name : <b><?php echo $row['name'] ?></b></p>
										
										<p>Price : <b><?php echo "$".number_format($row['price'],2) ?></b></p>
									</td>
									<td class="text-center">
										<!-- <button class="btn btn-sm btn-primary edit_menu" type="button" data-id="<?php echo $row['id'] ?>" data-name="<?php echo $row['name'] ?>" data-status="<?php echo $row['status'] ?>" data-price="<?php echo $row['price'] ?>" data-img_path="<?php echo $row['img_path'] ?>">Edit</button> -->
										<button class="btn btn-sm btn-danger delete_menu" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
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


     



            <!-- </div> -->
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

<script>
$(document).ready(function() {
    // Delete menu function
    $(".delete_menu").on("click", function() {
        var menuId = $(this).data("id");

        // Confirm deletion
        if (confirm("Are you sure you want to delete this menu?")) {
            // Make AJAX request to delete_menu.php
            $.ajax({
                url: "delete_menu.php",
                method: "POST",
                data: { id: menuId },
                success: function(response) {
                    // Reload the page or update the UI as needed
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error("Error deleting menu:", error);
                    // Handle error if needed
                }
            });
        }
    });
});

function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}
</script>

