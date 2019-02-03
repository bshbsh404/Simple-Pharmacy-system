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
    $insertSQL = sprintf("INSERT INTO supplier (supplier_name,phone,email) VALUES (%s,%s,%s)",
    GetSQLValueString($_POST['name'], "text"),
    GetSQLValueString($_POST['phone'], "text"),
    GetSQLValueString($_POST['email'], "text"));
    mysql_select_db($database_connection, $connection);
    $Result1 = mysql_query($insertSQL, $connection) or die(mysql_error());
    if (isset($_SERVER['QUERY_STRING'])) {
    $_GET['st']='';
    $msg='New supplier Added';
    }
    }
    if($_GET['st']=='d'){
    $msg='supplier deleted';
    }
    if($_GET['st']=='u'){
    $msg='supplier updated';
    }
    mysql_select_db($database_connection, $connection);
    $query_suppliers = "SELECT * FROM supplier ORDER BY supplier_id ASC";
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
    <?php include('imports/header.php'); if($msg!=''){?>
    <h3 class=" alert alert-info text-center animated fadeInDown">
    <?php echo $msg; ?>
    </h3><?php } ?>
    <div class="user-dashboard">
      <div class="row">
        <div class="col-md-8 col-md-offset-2 animated fadeInDown">
          <form method="POST" action="<?php echo $editFormAction; ?>" name="form1" class="form-horizontal">
            <h1>Add Supplier</h1>
            <div class="form-group">
              <div class="col-sm-4">
                <label class="control-label">Supplier name</label>
              </div>
              <div class="col-sm-6">
                <input class="form-control" required type="text" name="name">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-4">
                <label class="control-label">Supplier phone</label>
              </div>
              <div class="col-sm-6">
                <input class="form-control" required type="number" name="phone">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-4">
                <label class="control-label">Supplier email</label>
              </div>
              <div class="col-sm-6">
                <input class="form-control" required type="email" name="email">
              </div>
            </div>
            <button class="btn btn-default" type="submit">ADD </button>
            <button class="btn btn-default" type="reset">RESET </button>
            <input type="hidden" name="MM_insert" value="form1">
          </form><br>
        </div>
        <div class="row">
          <div class="col-md-12 animated fadeInDown">
            <br><table class="table table-striped table-bordered table-hover" id="dataTables">
              <thead>
                <tr class="info">
                  <th>Supplier ID</th>
                  <th>Supplier Name</th>
                  <th>Supplier phone</th>
                  <th>Supplier email</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php $supid=1; do { ?>
                <tr>
                  <td><?php echo $supid; ?></td>
                  <td><?php echo $row_suppliers['supplier_name']; ?></td>
                  <td><?php echo $row_suppliers['phone']; ?></td>
                  <td><?php echo $row_suppliers['email']; ?></td>
                  <td>
                    <a href="updateSuppliers.php?supplier_id=<?php echo $row_suppliers['supplier_id']; ?>"> <button class="btn btn-success" type="button"><i class="fa fa-pencil"></i></button></a>
                    <a href="deleteSupplier.php?supplier_id=<?php echo $row_suppliers['supplier_id']; ?>"><button class="btn btn-danger" type="button"><i class="fa fa-trash-o"></i></button></a>
                  </td>
                </tr>
                <?php $supid=$supid+1; } while ($row_suppliers = mysql_fetch_assoc($suppliers)); ?>
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