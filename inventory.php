<?php 
	require_once('Connections/connection.php');
	if (!isset($_SESSION))
	session_start();
	if(!isset($_SESSION['Username']))
	header("Location: login.php");
	include('imports/functions.php');
	$editFormAction = $_SERVER['PHP_SELF'];
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	$insertSQL = sprintf("INSERT INTO inventory (medicine_id, expiryDate, quantity) VALUES (%s, %s, %s)",
	GetSQLValueString($_POST['medicine'], "int"),
	GetSQLValueString($_POST['expiryDate'], "date"),
	GetSQLValueString($_POST['quantity'], "int"));
	mysql_select_db($database_connection, $connection);
	$Result1 = mysql_query($insertSQL, $connection) or die(mysql_error());
	if (isset($_SERVER['QUERY_STRING'])) {
	$_GET['st']='';
	$msg='New quantity Added';
	}
	}
	if($_GET['st']=='d'){
	$msg='medicine deleted';
	}
	if($_GET['st']=='u'){
	$msg='medicine updated';
	}
	$query_inventory = "SELECT * FROM inventorylist ORDER BY id ASC";
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
		<?php include('imports/header.php'); if($msg!=''){?>
 <h3 class=" alert alert-info text-center animated fadeInDown">
 <?php echo $msg; ?>
 </h3><?php } ?>
		<div class="user-dashboard">
			<div class="row">
				<div class="col-md-8 col-md-offset-2 animated fadeInDown">
					<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" class="form-horizontal">
						<h1>Add To Inventory</h1>
						<div class="form-group">
							<div class="col-sm-4">
								<label class="control-label">Medicine Name</label>
							</div>
							<div class="col-sm-6">
								<select name="medicine" class="form-control">
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
								<input class="form-control" required type="date" name="expiryDate">
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
						<input type="hidden" name="MM_insert" value="form1">
					</form><br>
				</div>
				<div class="row">
					<div class="col-md-12 animated fadeInDown">
						<table class="table table-striped table-bordered table-hover" id="dataTables">
							<thead>
								<tr class="info">
									<th>ID</th>
									<th>Medicine Name</th>
									<th>Expiry Date</th>
									<th>Quantity</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php $medid=1; do { ?>
								<tr>
									<td><?php echo $medid; ?></td>
									<td><?php echo $row_inventory['brandName']; ?></td>
									<td><?php echo $row_inventory['expiryDate']; ?></td>
									<td><?php echo $row_inventory['quantity']; ?></td>
									<td>
										<a href="updateInventory.php?inventoryID=<?php echo $row_inventory['id']; ?>"> <button class="btn btn-success" type="button"><i class="fa fa-pencil"></i></button></a>
										<a href="deleteInventory.php?inventoryID=<?php echo $row_inventory['id']; ?>"><button class="btn btn-danger" type="button"><i class="fa fa-trash-o"></i></button></a>
									</td>
								</tr>
								<?php $medid=$medid+1; } while ($row_inventory = mysql_fetch_assoc($inventory)); ?>
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