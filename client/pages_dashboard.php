
<?php
// session_start();
// include('conf/config.php');
// include('conf/checklogin.php');
// check_login();
// $client_id = $_SESSION['client_id'];


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

function logout() {
  // do logic and log OUT the user
  // clear the session variable
  unset($_SESSION['logged_in_time']);
}


// Get client ID from session
$client_id = $_SESSION['client_id'];

// Retrieve login time from the database
$query = "SELECT login_time FROM login_activity WHERE client_id = ? AND login_status = 1 ORDER BY login_time DESC LIMIT 1";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('i', $client_id);
$stmt->execute();
$stmt->bind_result($loginTime);
$stmt->fetch();
$stmt->close();

// Check if login time was retrieved successfully
if (!$loginTime) {
  // Handle the case when login time is not available
  die('Error retrieving login time from the database.');
}




// ... rest of your code


/*
get all dashboard analytics 
and numeric values from distinct 
    tables
    */
    
    //return total number of ibank clients
    $result = "SELECT count(*) FROM iB_clients";
    $stmt = $mysqli->prepare($result);
    $stmt->execute();
    $stmt->bind_result($iBClients);
    $stmt->fetch();
    $stmt->close();
    
    //return total number of iBank Staffs
    $result = "SELECT count(*) FROM iB_staff";
    $stmt = $mysqli->prepare($result);
    $stmt->execute();
    $stmt->bind_result($iBStaffs);
    $stmt->fetch();
    $stmt->close();

    //return total number of iBank Account Types
    $result = "SELECT count(*) FROM iB_Acc_types";
    $stmt = $mysqli->prepare($result);
    $stmt->execute();
    $stmt->bind_result($iB_AccsType);
    $stmt->fetch();
    $stmt->close();
    
    //return total number of iBank Accounts
    $result = "SELECT count(*) FROM iB_bankAccounts";
    $stmt = $mysqli->prepare($result);
    $stmt->execute();
    $stmt->bind_result($iB_Accs);
    $stmt->fetch();
    $stmt->close();
    
    //return total number of iBank Deposits
    $client_id = $_SESSION['client_id'];
    $result = "SELECT SUM(transaction_amt) FROM iB_Transactions WHERE  client_id = ? AND tr_type = 'Deposit' ";
    $stmt = $mysqli->prepare($result);
    $stmt->bind_param('i', $client_id);
$stmt->execute();
$stmt->bind_result($iB_deposits);
$stmt->fetch();
$stmt->close();

//return total number of iBank Withdrawals
$client_id = $_SESSION['client_id'];
$result = "SELECT SUM(transaction_amt) FROM iB_Transactions WHERE  client_id = ? AND tr_type = 'Withdrawal' ";
$stmt = $mysqli->prepare($result);
$stmt->bind_param('i', $client_id);
$stmt->execute();
$stmt->bind_result($iB_withdrawal);
$stmt->fetch();
$stmt->close();



//return total number of iBank Transfers
$client_id = $_SESSION['client_id'];
$result = "SELECT SUM(transaction_amt) FROM iB_Transactions WHERE  client_id = ? AND tr_type = 'Transfer' ";
$stmt = $mysqli->prepare($result);
$stmt->bind_param('i', $client_id);
$stmt->execute();
$stmt->bind_result($iB_Transfers);
$stmt->fetch();
$stmt->close();

//return total number of  iBank initial cash->balances
$client_id = $_SESSION['client_id'];
$result = "SELECT SUM(transaction_amt) FROM iB_Transactions  WHERE client_id =?";
$stmt = $mysqli->prepare($result);
$stmt->bind_param('i', $client_id);
$stmt->execute();
$stmt->bind_result($acc_amt);
$stmt->fetch();
$stmt->close();
//Get the remaining money in the accounts
$TotalBalInAccount = ($iB_deposits)  - (($iB_withdrawal) + ($iB_Transfers));


//ibank money in the wallet
$client_id = $_SESSION['client_id'];
$result = "SELECT SUM(transaction_amt) FROM iB_Transactions  WHERE client_id = ?";
$stmt = $mysqli->prepare($result);
$stmt->bind_param('i', $client_id);
$stmt->execute();
$stmt->bind_result($new_amt);
$stmt->fetch();
$stmt->close();
//Withdrawal Computations

?>

<!DOCTYPE html>
<html lang="en">
  <meta http-equiv="content-type" content="text/html;charset=utf-8" />
  <head>
  <style>
    .carousel-caption {
      position: absolute;
      top: 250px;
      left: 800px;
      /* transform: translate(-50%, -50%); */
    }

   

  </style>
  </head>
  <?php include("dist/_partials/head.php"); ?>
  <!-- Log on to codeastro.com for more projects! -->
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
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">User Dashboard</h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Dashboard</li>
                </ol>
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        
        
        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              
              <!--time running status -->
              <?php
$_SESSION['logged_in_time']  = $loginTime;



?>



<script>
  // Function to get the time since login
  function getTimeSinceLogin() {
    
    <?php
        if (isset($_SESSION['logged_in_time'])) {
          $login_time = strtotime($_SESSION['logged_in_time']);
        } else {
          $login_time = strtotime($_SESSION['logged_in_time']);
        }
        ?>
      
      // Calculate time elapsed in seconds
      const timeElapsed = Math.floor((new Date() - new Date('<?= $_SESSION['logged_in_time'] ?>')) / 1000);
      
      // Convert seconds to hours, minutes, and seconds
      const hours = Math.floor(timeElapsed / 3600);
      const minutes = Math.floor((timeElapsed % 3600) / 60);
      const seconds = timeElapsed % 60;
      
      return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
    }

    // Update the timer every second
    function updateTimer() {
        document.getElementById('timer').innerText = getTimeSinceLogin();
    }

    // Initial call to start the timer
   // updateTimer();

    // Update the timer every second
    setInterval(updateTimer, 1000);
    
</script>
        <div class="col-6 col-sm-6 col-md-6">
                <div class="info-box">
                    <span class="info-box-icon bg-success elevation-1"><i class="far fa-clock"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Time Since Login</span>
                        <span class="info-box-number" id="timer">
                         
                            <?php
                            
                            
                            $currentTime = time(); 
                                                     ?>
                        </span>
                    </div>
                </div>
        </div> 
        


           

            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>

           

            <!--Balances-->
            <div class="col-6 col-sm-6 col-md-6">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-purple elevation-1"><i class="fas fa-money-bill-alt"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Wallet Balance</span>
                  <span class="info-box-number">INR <?php echo $TotalBalInAccount; ?></span>
                </div>
              </div>
            </div>
            <!-- ./Balances-->
        


<!-- PHP Script to Fetch Category Menus -->

<?php
// if (isset($_GET['category_id'])) {
//     $categoryId = $_GET['category_id'];
//     // Fetch menus based on $categoryId from the database and echo the HTML content
//     $menus = getMenusByCategoryId($mysqli, $categoryId);
//     // You can use a similar approach as in your category page to fetch and display menus
//     echo '<p>Menus for Category ' . $categoryId . '</p>';
// }
?>
<!-- ------------------------------------------------------------------------------------- -->

<!-- 

<div class="col-6 col-sm-6 col-md-6">
  <a href="User_FoodOrder.php" class="btn btn-primary">ORDER FOOOODDDD!!</a>
</div>

 -->



<div class="container mt-5">
  <div id="carouselExample" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="https://i.ytimg.com/vi/V93sXxkVPE4/maxresdefault.jpg" class="d-block w-100" alt="Slide 1">
        <div class="carousel-caption d-none d-md-block">
          <a href="User_FoodOrder.php"><button type="button" id="orderfood" class="btn btn-primary">Order Food Now....!</button></a>
        </div>
      </div>
      <div class="carousel-item">
        <img src="https://1.bp.blogspot.com/-fRLw35WgaNU/XwhR1SIWPsI/AAAAAAAABYU/6E4zEfPXxGkv88QQyqdeSXnVQr9g3g1zACNcBGAsYHQ/s1600/vada-pav-indian-street-food.jpg" class="d-block w-100" alt="Slide 2">
        <div class="carousel-caption d-none d-md-block">
          <a href="User_FoodOrder.php"><button type="button" id="orderfood" class="btn btn-primary">Order Food Now....!</button></a>
        </div>
      </div>
      <div class="carousel-item">
        <img src="https://1.bp.blogspot.com/-gm1tq71zAu0/XwqAOin6ZfI/AAAAAAAABrM/T7BigjcayFkFhVLFCQP8X5ojrkBRrIaNQCPcBGAsYHg/s1140/image_search_1594481961334.jpg" class="d-block w-100" alt="Slide 3">
        <div class="carousel-caption d-none d-md-block">
          <a href="User_FoodOrder.php"><button type="button" id="orderfood" class="btn btn-primary">Order Food Now....!</button></a>
        </div>
      </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>


          
         

          <!-- Main row -->
         
                        <?php
                       
                        while ($row = $res->fetch_object()) {
                          /* Trim Transaction Timestamp to 
                            *  User Uderstandable Formart  DD-MM-YYYY :
                            */
                          $transTstamp = $row->created_at;
                          //Perfom some lil magic here
                          if ($row->tr_type == 'Deposit') {
                            $alertClass = "<span class='badge badge-success'>$row->tr_type</span>";
                          } elseif ($row->tr_type == 'Withdrawal') {
                            $alertClass = "<span class='badge badge-danger'>$row->tr_type</span>";
                          } else {
                            $alertClass = "<span class='badge badge-warning'>$row->tr_type</span>";
                          }
                        ?>
                          <tr>
                            <td><?php echo $row->tr_code; ?></a></td>
                            <td><?php echo $row->account_number; ?></td>
                            <td><?php echo $alertClass; ?></td>
                            <td> <?php echo $currency.$row->transaction_amt; ?></td>
                            <td><?php echo $row->client_name; ?></td>
                            <td><?php echo date("d-M-Y h:m:s ", strtotime($transTstamp)); ?></td>
                          </tr>

                        <?php } ?>

                      </tbody>
                    </table>
                  </div>
                  <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                  <!-- <a href="pages_transactions_engine.php" class="btn btn-sm btn-info float-left">View All</a> -->
                </div>
                <!-- /.card-footer -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!--/. container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->



    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <?php include("dist/_partials/footer.php"); ?>

  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->

  <script>
  $(document).ready(function(){
    // Activate the carousel with a specified interval
    $('#carouselExample').carousel({
      interval: 1000 // Set the interval in milliseconds (e.g., 2000 = 2 seconds)
    });
  });
</script>
  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  
  <!-- Bootstrap -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.js"></script>

  <!-- OPTIONAL SCRIPTS -->
  <!-- <script src="dist/js/demo.js"></script> -->
  

  <!-- PAGE PLUGINS -->
  <!-- jQuery Mapael -->
  <script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
  <script src="plugins/raphael/raphael.min.js"></script>
  <script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
  <script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
  <!-- ChartJS -->
  <script src="plugins/chart.js/Chart.min.js"></script>

  <!-- PAGE SCRIPTS -->
  <script src="dist/js/pages/dashboard2.js"></script>

  <!--Load Canvas JS -->
  <script src="plugins/canvasjs.min.js"></script>
  <!--Load Few Charts-->


  

</body>

</html>

<!-- JavaScript Function to Load Category Menus -->
