<?php 
  require_once('Connections/connection.php');
  if (!isset($_SESSION))
  session_start();
  if(!isset($_SESSION['Username']))
  header("Location: login.php");
  if($_SESSION['Role']!='admin')
  header("Location: dashboard.php");
  include('imports/functions.php');
  $editFormAction = $_SERVER['PHP_SELF'];
  if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO user (firstName, lastName, userName, password, `role`) VALUES (%s, %s, %s, %s, %s)",
  GetSQLValueString($_POST['firstname'], "text"),
  GetSQLValueString($_POST['lastname'], "text"),
  GetSQLValueString($_POST['username'], "text"),
  GetSQLValueString($_POST['password'], "text"),
  GetSQLValueString($_POST['role'], "text"));
  mysql_select_db($database_connection, $connection);
  $Result1 = mysql_query($insertSQL, $connection) or die(mysql_error());
  if (isset($_SERVER['QUERY_STRING'])) {
  $_GET['st']='';
  $msg='New user Added';
  }
  }
  if($_GET['st']=='d'){
  $msg='user deleted';
  }
  if($_GET['st']=='u'){
  $msg='user updated';
  }
  mysql_select_db($database_connection, $connection);
  $query_users = "SELECT * FROM `user` ORDER BY user_id ASC";
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
    <?php include('imports/header.php'); if($msg!=''){?>
    <h3 class=" alert alert-info text-center animated fadeInDown">
    <?php echo $msg; ?>
    </h3><?php } ?>
    <div class="user-dashboard">
      <div class="row">
        <div class="col-md-8 col-md-offset-2 animated fadeInDown">
          <form method="POST" action="<?php echo $editFormAction; ?>" name="form1" class="form-horizontal">
            <h1>Add User</h1>
            <div class="form-group">
              <div class="col-sm-4">
                <label class="control-label">First name</label>
              </div>
              <div class="col-sm-6">
                <input class="form-control" required type="text" name="firstname">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-4">
                <label class="control-label">Last name</label>
              </div>
              <div class="col-sm-6">
                <input class="form-control" required type="text" name="lastname">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-4">
                <label class="control-label">Username </label>
              </div>
              <div class="col-sm-6">
                <div class="input-group">
                  <span class="input-group-addon">@</span>
                  <input class="form-control" required type="text" name="username">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-4">
                <label class="control-label">Password </label>
              </div>
              <div class="col-sm-6">
                <input class="form-control" required type="password" name="password">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-4">
                <label class="control-label">Role </label>
              </div>
              <div class="col-sm-6">
                <select name="role" class="form-control">
                  <option value="admin">Admin</option>
                  <option value="pharmacist">Pharmacist</option>
                </select>
              </div>
            </div>
            <button class="btn btn-default" type="submit">ADD </button>
            <button class="btn btn-default" type="reset">RESET </button>
            <input type="hidden" name="MM_insert" value="form1">
          </form>
          <br>
        </div>
        <div class="row">
          <div class="col-md-12 animated fadeInDown">
            <br><table class="table table-striped table-bordered table-hover" id="dataTables">
              <thead>
                <tr class="info">
                  <th>ID</th>
                  <th>First name</th>
                  <th>Last name</th>
                  <th>Username</th>
                  <th>Role</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php $userid=1; do { ?>
                <tr>
                  <td><?php echo $userid; ?></td>
                  <td><?php echo $row_users['firstName']; ?></td>
                  <td><?php echo $row_users['lastName']; ?></td>
                  <td><?php echo $row_users['userName']; ?></td>
                  <td><?php echo $row_users['role']; ?></td>
                  <td>
                    <a href="updateUsers.php?user_id=<?php echo $row_users['user_id']; ?>"> <button class="btn btn-success" type="button"><i class="fa fa-pencil"></i></button></a>
                    <a href="deleteUser.php?user_id=<?php echo $row_users['user_id']; ?>"><button class="btn btn-danger" type="button"><i class="fa fa-trash-o"></i></button></a></td>
                  </tr>
                  <?php $userid=$userid+1; } while ($row_users = mysql_fetch_assoc($users)); ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include('imports/scripts.php'); ?>
<script>
    $(document).ready(function () {
    $('#dataTables').dataTable();
    $('[data-toggle="offcanvas"]').click(function(){
    $("#navigation").toggleClass("hidden-xs");
    }); });
</script>
</body>
</html>