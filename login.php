<?php 
  require_once('Connections/connection.php'); 
  if (!isset($_SESSION))
  session_start();
  $loginUsername=$_POST['username'];
  mysql_select_db($database_connection, $connection);
  $query_userlogin = "SELECT * FROM `user` WHERE `user`.userName='$loginUsername'";
  $userlogin = mysql_query($query_userlogin, $connection) or die(mysql_error());
  $row_userlogin = mysql_fetch_assoc($userlogin);
  if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['password'];
  mysql_select_db($database_connection, $connection);
  $LoginRS__query=sprintf("SELECT userName, password FROM user WHERE userName='%s' AND password='%s'",
  get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername), get_magic_quotes_gpc() ? $password : addslashes($password));
  $LoginRS = mysql_query($LoginRS__query, $connection) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
  $_SESSION['id'] = $row_userlogin['user_id'];;
  $_SESSION['Username'] = $loginUsername;
  $_SESSION['Role'] = $row_userlogin['role'];
  header("Location: dashboard.php");
  }
  else {
  $msg="Wrong username or password!";
  }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>login</title>
    <?php include('imports/stylesheet.php'); ?>
  </head>
  <body>
    <div class="animated fadeInDown">
      <h1 class="text-uppercase text-center text-info">Simple Pharmacy management system</h1>
    <img class="img-responsive center-block" src="assets/img/logo.png" id="logo"></div>
    <div class="login-card  animated fadeInDown">
      <img src="assets/img/user.png" class="profile-img-card hvr-wobble-horizontal">
      <form class="form-signin" method="POST" name="login" >
        <?php if($msg!=''){ ?><h5 class=" alert alert-danger text-center animated fadeInDown">
        <?php echo $msg; ?>
        </h5><?php } ?>
        <input class="form-control hvr-grow" type="text" required placeholder="Username" name="username">
        <input class="form-control hvr-grow" type="password" required placeholder="Password" name="password">
        <button class="btn btn-primary btn-block btn-lg btn-signin hvr-grow" type="submit">Sign in</button>
      </form>
    </div>
    <?php include('imports/scripts.php'); ?>
  </body>
</html>