<?php 
  require_once('Connections/connection.php');
  if (!isset($_SESSION))
  session_start();
  if(!isset($_SESSION['Username']))
  header("Location: login.php");
if($_SESSION['Role']!='pharmacist')
    header("Location: dashboard.php");
  include('imports/functions.php');
  mysql_select_db($database_connection, $connection);
  $query_selling = "SELECT * FROM inventorylist WHERE expiryDate >= DATE(now()) ORDER BY id ASC";
  $selling = mysql_query($query_selling, $connection) or die(mysql_error());
  $row_selling = mysql_fetch_assoc($selling);
  $editFormAction = $_SERVER['PHP_SELF'];
  if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $inventoryid=$_POST['medicine'];
  $query_inventory = "SELECT quantity FROM inventorylist where id='$inventoryid' and quantity>0";
  $inventory = mysql_query($query_inventory, $connection) or die(mysql_error());
  $row_inventory = mysql_fetch_assoc($inventory);
  $quan=$row_inventory['quantity'];
  if ($quan>0 && $quan>=$_POST['quantity']) {
    $newquan=$quan-$_POST['quantity'];
  $updateSQL = sprintf("UPDATE inventory SET quantity=%s WHERE id=%s",
  GetSQLValueString($newquan, "int"),
  GetSQLValueString($_POST['medicine'], "int"));
  $Result1 = mysql_query($updateSQL, $connection) or die(mysql_error());
  date_default_timezone_set("US/Arizona");
  $tdate=date("Y-m-d");
  $insertSQL = sprintf("INSERT INTO transactions (id, `date`, quantity, user_id) VALUES (%s, %s, %s, %s)",
  GetSQLValueString($_POST['medicine'], "int"),
  GetSQLValueString($tdate, "date"),
  GetSQLValueString($_POST['quantity'], "int"),
  GetSQLValueString($_SESSION['id'], "int"));
  $Result1 = mysql_query($insertSQL, $connection) or die(mysql_error());
  if (isset($_SERVER['QUERY_STRING'])) {
  $_GET['st']='';
  $msg='New transaction Added,there are '.$newquan." left of this medicine.";
  }
  }
  else{
  $msg='No enough quantity of this medicine';
  }
  }
  if($_GET['st']=='d'){
  $msg='transaction deleted';
  }
  if($_GET['st']=='u'){
  $msg='transaction updated';
  }
  mysql_select_db($database_connection, $connection);
  $query_transactions = "SELECT * FROM transactionslist ORDER BY transaction_id ASC";
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
    <?php include('imports/header.php'); if($msg!=''){?>
    <h3 class=" alert alert-info text-center animated fadeInDown">
    <?php echo $msg; ?>
    </h3><?php } ?>
    <div class="user-dashboard">
      <div class="row">
        <div class="col-md-8 col-md-offset-2 animated fadeInDown">
          <form method="POST" action="<?php echo $editFormAction; ?>" name="form1" class="form-horizontal">
            <h1>Add Transaction</h1>
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
              <div class="col-sm-4">
                <label class="control-label">Quantity</label>
              </div>
              <div class="col-sm-6">
                <input class="form-control" required type="number" min="1" name="quantity">
              </div>
            </div>
            <button class="btn btn-default" type="submit">ADD </button>
            <button class="btn btn-default" type="reset">RESET </button>
            <input type="hidden" name="MM_update" value="form1">
          </form><br>
        </div>
        <div class="row">
          <div class="col-md-12 animated fadeInDown">
            <br><table class="table table-striped table-bordered table-hover" id="dataTables">
              <thead>
                <tr class="info">
                  <th>ID</th>
                  <th>Medicine Name</th>
                  <th>Date</th>
                  <th>Quantity</th>
                  <th>Price</th>
                  <th>User</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php $trid=1; do {?>
                <tr>
                  <td><?php echo $trid; ?></td>
                  <td><?php echo $row_transactions['brandName']; ?></td>
                  <td><?php echo $row_transactions['date']; ?></td>
                  <td><?php echo $row_transactions['quantity']; ?></td>
                  <td>$<?php echo $row_transactions['Price']+$row_transactions['Price']*0.2?></td>
                  <td><?php echo $row_transactions['userName']; ?></td>
                  <td>
                    <a href="updateTransactions.php?transaction_id=<?php echo $row_transactions['transaction_id']; ?>"> <button class="btn btn-success" type="button"><i class="fa fa-pencil"></i></button></a>
                    <a href="deleteTransaction.php?transaction_id=<?php echo $row_transactions['transaction_id']; ?>">
                    <button class="btn btn-danger" type="button"><i class="fa fa-trash-o"></i></button></a>
                  </td>
                </tr>
                <?php $trid=$trid+1; } while ($row_transactions = mysql_fetch_assoc($transactions)); ?>
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
</bod
</html>