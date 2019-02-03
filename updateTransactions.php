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
  date_default_timezone_set("Africa/Khartoum");
  $tdate=date("Y-m-d");
  if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE transactions SET id=%s, `date`=%s, quantity=%s WHERE transaction_id=%s",
  GetSQLValueString($_POST['medicine'], "int"),
  GetSQLValueString($tdate, "date"),
  GetSQLValueString($_POST['quantity'], "int"),
  GetSQLValueString($_GET['transaction_id'], "int"));
  mysql_select_db($database_connection, $connection);
  $Result1 = mysql_query($updateSQL, $connection) or die(mysql_error());
  $updateGoTo = "transactions.php?st=u";
  if (isset($_SERVER['QUERY_STRING'])) {
  header(sprintf("Location: transactions.php?st=u"));
  }
  }
  $query_selling = "SELECT * FROM inventorylist ORDER BY id ASC";
  $selling = mysql_query($query_selling, $connection) or die(mysql_error());
  $row_selling = mysql_fetch_assoc($selling);
  mysql_select_db($database_connection, $connection);
  $query_transactions = "SELECT * FROM transactionslist where transaction_id=$_GET[transaction_id]";
  $transactions = mysql_query($query_transactions, $connection) or die(mysql_error());
  $row_transactions = mysql_fetch_assoc($transactions);
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Transactions</title>
    <?php include('imports/stylesheet.php'); ?>
  </head>
  <body class="home">
    <?php include('imports/header.php'); ?>
    <div class="user-dashboard">
      <div class="row">
        <div class="col-md-8 col-md-offset-2  animated fadeInDown">
          <form action="<?php echo $editFormAction; ?>" method="POST" name="form1" class="form-horizontal">
            <h1>Update Transaction</h1>
            <div class="form-group">
              <div class="col-sm-4">
                <label class="control-label">Medicine Name</label>
              </div>
              <div class="col-sm-6">
                <select name="medicine" class="form-control">
                  <?php do {?>
                  <option value="<?php echo $row_selling['id']; ?>"><?php echo $row_selling['brandName']; ?></option>
                  <?php } while ($row_selling = mysql_fetch_assoc($selling)); ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-4 ">
                <label class="control-label">Quantity</label>
              </div>
              <div class="col-sm-6 ">
                <input class="form-control" required type="number" min="1" name="quantity" value="<?php echo $row_transactions['quantity']; ?>">
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