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
  if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
  }
  if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE supplier SET supplier_name=%s,phone=%s,email=%s WHERE supplier_id=%s",
  GetSQLValueString($_POST['name'], "text"),
  GetSQLValueString($_POST['phone'], "text"),
  GetSQLValueString($_POST['email'], "text"),
  GetSQLValueString($_GET['supplier_id'], "int"));
  mysql_select_db($database_connection, $connection);
  $Result1 = mysql_query($updateSQL, $connection) or die(mysql_error());
  if (isset($_SERVER['QUERY_STRING'])) {
  header(sprintf("Location: suppliers.php?st=u"));
  }
  }
  mysql_select_db($database_connection, $connection);
  $query_suppliers = "SELECT * FROM supplier where supplier_id=$_GET[supplier_id]";
  $suppliers = mysql_query($query_suppliers, $connection) or die(mysql_error());
  $row_suppliers = mysql_fetch_assoc($suppliers);
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Suppliers</title>
    <?php include('imports/stylesheet.php'); ?>
  </head>
  <body class="home">
    <?php include('imports/header.php');
    ?>
    <div class="user-dashboard">
      <div class="row">
        <div class="col-md-8 col-md-offset-2 animated fadeInDown">
          <form action="<?php echo $editFormAction; ?>" method="POST" name="form1" class="form-horizontal">
            <h1>Update Supplier</h1>
            <div class="form-group">
              <div class="col-sm-4 ">
                <label class="control-label">Supplier Name</label>
              </div>
              <div class="col-sm-6 ">
                <input class="form-control" required type="text" name="name" value="<?php echo $row_suppliers['supplier_name']; ?>">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-4 ">
                <label class="control-label" >Supplier phone</label>
              </div>
              <div class="col-sm-6 ">
                <input class="form-control" required type="number" name="phone" value="<?php echo $row_suppliers['phone']; ?>">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-4 ">
                <label class="control-label" >Supplier email</label>
              </div>
              <div class="col-sm-6">
                <input class="form-control" required type="email" name="email" value="<?php echo $row_suppliers['email']; ?>">
              </div>
            </div>
            <button class="btn btn-default" type="submit">UPDATE </button>
            <button class="btn btn-default" type="reset">RESET </button>
            <input type="hidden" name="MM_update" value="form1">
          </form><br>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<?php include('imports/scripts.php'); ?>
</body>
</html>