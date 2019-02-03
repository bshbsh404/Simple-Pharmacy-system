<?php require_once('Connections/connection.php');
date_default_timezone_set("US/Arizona");
if (!isset($_SESSION))
session_start();
if(!isset($_SESSION['Username']))
header("Location: login.php");
$report=0;
$editFormAction = $_SERVER['PHP_SELF'];
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
		$generic=$_POST['generic'];
	$supplier=$_POST['supplier'];
	$type=$_POST['type'];
$condition='';
if($generic != '*' || $supplier != '*'){
$condition=' WHERE';
if($generic != '*'){
	$condition.=' medicine_id='.$generic;
	if($supplier != '*'){$condition.=' and supplier_id='.$supplier;}
}
else if($supplier != '*'){
	$condition.=' supplier_id='.$supplier;
	if($generic != '*'){$condition.=' and medicine_id='.$generic;}
}

}

mysql_select_db($database_connection, $connection);
 $query_transactions = "SELECT * FROM medicinelist $condition";
$transactions = mysql_query($query_transactions, $connection) or die(mysql_error());
$row_transactions = mysql_fetch_assoc($transactions);
$totalRows_transactions = mysql_num_rows($transactions);

$report=1; 
}


mysql_select_db($database_connection, $connection);
	$query_suppliers = "SELECT * FROM supplier ORDER BY supplier_id ASC";
	$suppliers = mysql_query($query_suppliers, $connection) or die(mysql_error());
	$row_suppliers = mysql_fetch_assoc($suppliers);

	$query_medicine = "SELECT * FROM medicine ORDER BY medicine_id ASC";
	$medicine = mysql_query($query_medicine, $connection) or die(mysql_error());
	$row_medicine = mysql_fetch_assoc($medicine);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Home</title>
		<?php include('imports/stylesheet.php'); ?>
	</head>
	<body class="home" >
		<?php include('imports/header.php'); ?>
		<div class="user-dashboard">
			<div class="row">
				<div class="col-md-8 col-md-offset-2 animated fadeInDown">
					<form method="POST" name="form1" class="form-horizontal" action="<?php echo $editFormAction; ?>">
								
								<div class="form-group">
									<div class="col-sm-4">
								<label class="control-label">Generic Name</label>
							</div>
							<div class="col-sm-8">
									  <select name="generic" id="Generic" style="width: 100%">
									  <option value="*">All</option>
									  	<?php do { ?>
									<option value="<?php echo $row_medicine['medicine_id']; ?>"><?php echo $row_medicine['genericName']; ?></option>
									<?php } while ($row_medicine = mysql_fetch_assoc($medicine)); ?>
									  </select>
									  </div></div>

									  <div class="form-group">
									<div class="col-sm-4">
								<label class="control-label">Supplier Name</label>
							</div>
							<div class="col-sm-8">
									  <select name="supplier" id="supplier" style="width: 100%">
									  <option value="*">All</option>
									  	<?php do { ?>
									<option value="<?php echo $row_suppliers['supplier_id']; ?>"><?php echo $row_suppliers['supplier_name']; ?></option>
									<?php } while ($row_suppliers = mysql_fetch_assoc($suppliers)); ?>

									  </select>
									  </div></div>
									  

							
						<button class="btn btn-success btn-block" type="submit">Query </button>
						<input type="hidden" name="MM_insert" value="form1">
					</form><br>
				</div>
				<?php if($totalRows_transactions>=1){?>
				<div class="row">
					<div class="col-md-12 animated fadeInDown">
						<div class="row">
							<div class="col-xs-12">
								<h2 class="page-header">
								NRU PHARMACY
								<small class="pull-right">Date: <?php echo date("d/m/Y"); ?></small>
								</h2>
							</div>
						</div>
						<div class="row" >
							<br><table class="table table-striped table-bordered table-hover">
								<thead>
									<tr class="info">
										<th>ID</th>
										<th>Generic Name</th>
										<th>Brand Name</th>
										<th>Type</th>
										<th>Supplier</th>
										<th>Price</th>
									</tr>
								</thead>
								<tbody>
									<?php $trid=1; do {?>
									<tr>
										<td><?php echo $trid; ?></td>
										<td><?php echo $row_transactions['genericName']; ?></td>
										<td><?php echo $row_transactions['brandName']; ?></td>
										<td><?php echo $row_transactions['type']; ?></td>
										<td><?php echo $row_transactions['supplier_name']?></td>
										<td>$<?php echo $row_transactions['price']?></td>
									</tr>
									<?php $trid=$trid+1; } while ($row_transactions = mysql_fetch_assoc($transactions)); ?>
								</tbody>
							</table>
						</div>
					</div>
				</div><?php }
				elseif ($report==1) { ?>
				<div class="row">
					<div class="col-md-12 animated fadeInDown"> <h3 class="alert alert-warning text-center animated fadeInDown">There is no result.</h3>
					</div></div>
					<?php } ?>
				</div>
			</div>
		</div>
		<?php include('imports/scripts.php'); ?>
		<script>
		$(document).ready(function () {
			 $('select').select2();
		$('[data-toggle="offcanvas"]').click(function(){
		$("#navigation").toggleClass("hidden-xs");
		}); });
		</script>
	</body>
</html>