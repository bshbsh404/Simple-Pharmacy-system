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
  $updateSQL = sprintf("UPDATE inventory SET medicine_id=%s, expiryDate=%s, quantity=%s WHERE id=%s",
  GetSQLValueString($_POST['medicine'], "int"),
  GetSQLValueString($_POST['expiryDate'], "date"),
  GetSQLValueString($_POST['quantity'], "int"),
  GetSQLValueString($_GET['inventoryID'], "int"));
  mysql_select_db($database_connection, $connection);
  $Result1 = mysql_query($updateSQL, $connection) or die(mysql_error());
  if (isset($_SERVER['QUERY_STRING'])) {
  header(sprintf("Location: inventory.php?st=u"));
  }
  }
  $query_inventory = "SELECT * FROM inventorylist WHERE id=$_GET[inventoryID]";
  $inventory = mysql_query($query_inventory, $connection) or die(mysql_error());
  $row_inventory = mysql_fetch_assoc($inventory);
  mysql_select_db($database_connection, $connection);
  $query_medicine = "SELECT * FROM medicine ORDER BY medicine_id ASC";
  $medicine = mysql_query($query_medicine, $connection) or die(mysql_error());
  $row_medicine = mysql_fetch_assoc($medicine);
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Inventory</title>
    <?php include('imports/stylesheet.php'); ?>
  </head>
  <body class="home">
    <?php include('imports/header.php'); ?>
    <div class="user-dashboard">
      <div class="row">
        <div class="col-md-8 col-md-offset-2 animated fadeInDown">
          <form action="<?php echo $editFormAction; ?>" method="POST" name="form1" class="form-horizontal">
            <h1>Update Inventory</h1>
            <div class="form-group">
              <div class="col-sm-4">
                <label class="control-label">Medicine Name</label>
              </div>
              <div class="col-sm-6">
                <select name="medicine" class="form-control">
                  <option value="<?php echo $row_inventory['medicine_id']; ?>">Current: <?php echo $row_inventory['brandName']; ?></option>
                  <?php do { ?>
                  <option value="<?php echo $row_medicine['medicine_id']; ?>"><?php echo $row_medicine['brandName']; ?></option>
                  <?php } while ($row_medicine = mysql_fetch_assoc($medicine)); ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-4">
                <label class="control-label">Expiry Date</label>
              </div>
              <div class="col-sm-6">
                <input class="form-control" required type="date" name="expiryDate" value="<?php echo $row_inventory['expiryDate']; ?>">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-4">
                <label class="control-label" >Quantity</label>
              </div>
              <div class="col-sm-6">
                <input class="form-control" required type="number" min="1" name="quantity" value="<?php echo $row_inventory['quantity']; ?>">
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