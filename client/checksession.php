<?php
session_start();
$_SESSION['client_id'] = $_GET['client_id'];
include('conf/checklogin.php');
check_login();
header("Location: pages_dashboard.php");