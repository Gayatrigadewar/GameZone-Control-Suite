<?php
session_start();
date_default_timezone_set('Asia/Kolkata');
echo "Server Time (Indian Standard Time): " . date('Y-m-d H:i:s');
include('conf/config.php'); //get configuration file
include('script/query.php');


if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $loginTime = date('Y-m-d H:i:s');
  $password = sha1(md5($_POST['password'])); //double encrypt to increase security
  $stmt = $mysqli->prepare("SELECT email, password, client_id  FROM iB_clients   WHERE email=? AND password=?"); //sql to log in user
  $stmt->bind_param('ss', $email, $password); //bind fetched parameters
  $stmt->execute(); //execute bind
  $stmt->bind_result($email, $password, $client_id); //bind result
  $rs = $stmt->fetch();
  
  $_SESSION['client_id'] = $client_id; //assaign session toc lient id

  //$uip=$_SERVER['REMOTE_ADDR'];
  //$ldate=date('d/m/Y h:i:s', time());
//   if ($rs) { //if its sucessfull   
//     header("location:pages_dashboard.php");

//   } else {
//     #echo "<script>alert('Access Denied Please Check Your Credentials');</script>";
//     $err = "Access Denied Please Check Your Credentials";
//   }
// }

if ($rs) { // if it's successful
  // Insert login activity record
  // Assuming the user hasn't logged out yet
  $systemId = getSystemId(); // You need to implement a function to get the system_id
  $loginStatus = 1; // You can set this based on your requirements (1 for login, 0 for logout)
  
  $stmt->close();
  $loginTime = date('Y-m-d H:i:s');

  


  $insertQuery = "INSERT INTO login_activity (client_id, login_time,  system_id, login_status) VALUES (?, ?,  ?, ?)";
  $insertStmt = $mysqli->prepare($insertQuery);

  if ($insertStmt) {
      $insertStmt->bind_param('issi', $client_id, $loginTime,  $systemId, $loginStatus);
      $insertStmt->execute();
      $insertStmt->close();

  } else {
      // Handle the error if the insert statement preparation fails
      die('Error in preparing the insert statement: ' . $mysqli->error);
  }
  
   // Set up JavaScript code for periodic timer update
   echo "<script>
   setInterval(function() {
       var currentTime = new Date();
       console.log('Updating timer:', currentTime);
       $.post('update_timer.php', { client_id: $client_id, login_time: currentTime })
           .done(function(response) {
               console.log('Update successful:', response);
           })
           .fail(function(error) {
               console.error('Update failed:', error);
           });
   }, 60000); // Update every 1 minute
</script>";

  header("location: pages_dashboard.php");
} else {
  $err = "Access Denied. Please Check Your Credentials";
}
}
elseif (isset($_POST['logout'])) {
  // Handle the logout process
  $logoutTime = date('Y-m-d H:i:s');
  $systemId = getSystemId(); // You need to implement a function to get the system_id
  $loginStatus = 0; // Set to 0 for logout
  
  $updateQuery = "UPDATE login_activity SET logout_time=?, login_status=? WHERE client_id=? AND logout_time IS NULL";

  $updateStmt = $mysqli->prepare($updateQuery);
  
  if ($updateStmt) {
      $updateStmt->bind_param('sii', $logoutTime, $loginStatus, $_SESSION['client_id']);
      $updateStmt->execute();
      $updateStmt->close();
  } else {
      // Handle the error if the update statement preparation fails
      die('Error in preparing the update statement: ' . $mysqli->error);
  }

  // Perform any additional logout tasks
  session_destroy(); // For example, destroy the session

  // Redirect to the login page or another appropriate page after logout
  header("location: login.php");
  exit;
}

// Function to get system_id - You need to implement this function based on your requirements
// function getSystemId() {
// // Your implementation to get system_id goes here
// // For example, you might use an API, generate a unique ID based on some criteria, etc.
// return 'your_system_id';
// }

function getSystemId() {
  return gethostname();
}

// Example usage
$systemId = getSystemId();
echo $systemId;


/* Persisit System Settings On Brand */
$ret = "SELECT * FROM `iB_SystemSettings` ";
$stmt = $mysqli->prepare($ret);
$stmt->execute(); //ok
$res = $stmt->get_result();
while ($auth = $res->fetch_object()) {
?>
  <!DOCTYPE html>
  <html>
  <meta http-equiv="content-type" content="text/html;charset=utf-8" />
  <?php include("dist/_partials/head.php"); ?>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <p><?php echo $auth->sys_name; ?></p>
      </div><!-- Log on to codeastro.com for more projects! -->
      <!-- /.login-logo -->
      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">Log In To Start Client Session</p>

          <form method="post">
            <div class="input-group mb-3">
              <input type="email" name="email" class="form-control" placeholder="Email">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="password" name="password" class="form-control" placeholder="Password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-8">
                <div class="icheck-primary">
                  <input type="checkbox" id="remember">
                  <label for="remember">
                    Remember Me
                  </label>
                </div>
              </div>
              <!-- /.col -->
              <div class="col-4">
                <button type="submit" name="login" class="btn btn-success btn-block">Log In</button>
              </div>
              <!-- /.col -->
            </div>
          </form>


          <!-- /.social-auth-links -->

          <!-- <p class="mb-1">
            <a href="pages_reset_pwd.php">I forgot my password</a>
          </p> -->


          <p class="mb-0">
            <a href="pages_client_signup.php" class="text-center">Register a new account</a>
          </p><!-- Log on to codeastro.com for more projects! -->

        </div>
        <!-- /.login-card-body -->
      </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>

  </body>

  </html>
<?php
} ?>