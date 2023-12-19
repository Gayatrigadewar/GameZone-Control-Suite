<?php
session_start();
date_default_timezone_set('Asia/Kolkata');
include('conf/config.php'); //get configuration file
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $loginTime = date('Y-m-d H:i:s');
    $password = sha1(md5($_POST['password'])); //double encrypt to increase security
    $stmt = $mysqli->prepare("SELECT email, password, client_id  FROM iB_clients   WHERE email=? AND password=?"); //sql to log in user
    $stmt->bind_param('ss', $email, $password); //bind fetched parameters
    $stmt->execute(); //execute bind
    $stmt->bind_result($email, $password, $client_id); //bind result
    $rs = $stmt->fetch();
    $stmt->close();
    // Check if the user is already logged in
    if($rs){
      $checkLoginQuery = "SELECT client_id, login_status FROM login_activity WHERE client_id = ? AND login_status IN (1, 2) AND logout_time IS NULL";
      $checkLoginStmt = $mysqli->prepare($checkLoginQuery);
      $checkLoginStmt->bind_param('i',  $client_id);
      $checkLoginStmt->execute();
      $checkLoginStmt->bind_result($existingClientId, $existingLoginStatus);
      $checkLoginStmt->fetch();
      $checkLoginStmt->close();
      
      if ($existingClientId && ($existingLoginStatus == 1 || $existingLoginStatus == 2)) {
        // User is already logged in on another device
        $err =  "Already logged in another device.";
        //header("location: pages_client_index.php");
      } else {
        // Continue with the login process
          // Insert login activity record
          // Assuming the user hasn't logged out yet
          $systemId = getSystemId(); // You need to implement a function to get the system_id
          $loginStatus = 1; // You can set this based on your requirements (1 for login, 0 for logout)
          
         
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
          
          $_SESSION['client_id'] = $client_id;
          header("location: pages_dashboard.php");
      }
  } else {
    $err = "Access Denied. Please Check Your Credentials";
  }
}




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
<?php } ?>