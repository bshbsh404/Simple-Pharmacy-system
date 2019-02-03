<?php require_once('Connections/connection.php'); 
if (!isset($_SESSION))
session_start();
if(!isset($_SESSION['Username']))
header("Location: login.php");
if($_SESSION['Role']!='admin')
header("Location: dashboard.php");
include('imports/functions.php'); 
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE user SET firstName=%s, lastName=%s, userName=%s, password=%s, `role`=%s WHERE user_id=%s",
                       GetSQLValueString($_POST['firstname'], "text"),
                       GetSQLValueString($_POST['lastname'], "text"),
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['role'], "text"),
                       GetSQLValueString($_GET['user_id'], "int"));
  mysql_select_db($database_connection, $connection);
  $Result1 = mysql_query($updateSQL, $connection) or die(mysql_error());
  if (isset($_SERVER['QUERY_STRING'])) {
    header(sprintf("Location: users.php?st=u"));
  }
  
}
mysql_select_db($database_connection, $connection);
$query_users = "SELECT * FROM `user` where user_id=$_GET[user_id]";
$users = mysql_query($query_users, $connection) or die(mysql_error());
$row_users = mysql_fetch_assoc($users);
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Users</title>
    <?php include('imports/stylesheet.php'); ?>
  </head>
  <body class="home">
    <?php include('imports/header.php'); ?>
    <div class="user-dashboard">
      <div class="row">
        <div class="col-md-8 col-md-offset-2 animated fadeInDown">
          <form action="<?php echo $editFormAction; ?>" method="POST" name="form1" class="form-horizontal">
            <h1>Update User</h1>
            <div class="form-group">
              <div class="col-sm-4">
                <label class="control-label">First name</label>
              </div>
              <div class="col-sm-6">
                <input class="form-control" required type="text" name="firstname" value="<?php echo $row_users['firstName']; ?>">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-4">
                <label class="control-label">Last name</label>
              </div>
              <div class="col-sm-6">
                <input class="form-control" required type="text" name="lastname" value="<?php echo $row_users['lastName']; ?>">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-4">
                <label class="control-label">Username </label>
              </div>
              <div class="col-sm-6">
                <div class="input-group">
                  <span class="input-group-addon">@</span>
                  <input class="form-control" required type="text" name="username" value="<?php echo $row_users['userName']; ?>">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-4">
                <label class="control-label">Password </label>
              </div>
              <div class="col-sm-6">
                <input class="form-control" required type="password" name="password" value="<?php echo $row_users['password']; ?>">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-4">
                <label class="control-label">Role </label>
              </div>
              <div class="col-sm-6">
                <select name="role" class="form-control">
                  <option value="<?php echo $row_users['role']; ?>">Current: <?php echo $row_users['role']; ?></option>
                  <option value="admin">Admin</option>
                  <option value="pharmacist">Pharmacist</option>
                </select>
              </div>
            </div>
            <button class="btn btn-default" type="submit">UPDATE </button>
            <button class="btn btn-default" type="reset">RESET </button>
            <input type="hidden" name="MM_update" value="form1">
          </form>
          <br>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<?php include('imports/scripts.php'); ?>
</body>
</html>