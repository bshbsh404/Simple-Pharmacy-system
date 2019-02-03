<?php
	require_once('Connections/connection.php');
	if (!isset($_SESSION))
	session_start();
	if(!isset($_SESSION['Username']))
	header("Location: login.php");
	include('imports/functions.php');
	$editFormAction = $_SERVER['PHP_SELF'];
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	$insertSQL = sprintf("INSERT INTO medicine (genericName, brandName, price, supplier_id, type) VALUES (%s, %s, %s, %s, %s)",
	GetSQLValueString($_POST['genericName'], "text"),
	GetSQLValueString($_POST['brandName'], "text"),
	GetSQLValueString($_POST['price'], "double"),
	GetSQLValueString($_POST['supplierName'], "int"),
	GetSQLValueString($_POST['type'], "text"));
	mysql_select_db($database_connection, $connection);
	$Result1 = mysql_query($insertSQL, $connection) or die(mysql_error());
	if (isset($_SERVER['QUERY_STRING'])) {
	$_GET['st']='';
	$msg='New medicine Added';
	}
	}
	if($_GET['st']=='d'){
	$msg='medicine deleted';
	}
	if($_GET['st']=='u'){
	$msg='medicine updated';
	}
	$query_medicine = "SELECT * FROM medicinelist ORDER BY medicine_id ASC";
	$medicine = mysql_query($query_medicine, $connection) or die(mysql_error());
	$row_medicine = mysql_fetch_assoc($medicine);
	mysql_select_db($database_connection, $connection);
	$query_suppliers = "SELECT * FROM supplier ORDER BY supplier_id ASC";
	$suppliers = mysql_query($query_suppliers, $connection) or die(mysql_error());
	$row_suppliers = mysql_fetch_assoc($suppliers);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Medicine</title>
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
						<h1>Add Medicine</h1>
						<div class="form-group">
							<div class="col-sm-4">
								<label class="control-label">Generic Name</label>
							</div>
							<div class="col-sm-6">
								<input class="form-control" required type="text" name="genericName">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-4">
								<label class="control-label">Brand Name</label>
							</div>
							<div class="col-sm-6">
								<input class="form-control" required type="text" name="brandName">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-4">
								<label class="control-label">Price</label>
							</div>
							<div class="col-sm-6">
								<div class="input-group">
									<span class="input-group-addon">$</span>
									<input class="form-control" required type="number" name="price">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-4">
								<label class="control-label">Type</label>
							</div>
							<div class="col-sm-6">
								<select name="type" class="form-control">
									<option value="digestive system">Digestive System</option>
									<option value="cardiovascular system">Cardiovascular System</option>
									<option value="central nervous system">Central nervous System</option>
									<option value="pain">Pain</option>
									<option value="consciousness">Consciousness</option>
									<option value="musculo-skeletal system">Musculo-skeletal System</option>
									<option value="eye">Eye</option>
									<option value="ear,nose and oropharynx">Ear,nose and oropharynx</option>
									<option value="respiratory system">Respiratory System</option>
									<option value="endocrine system">Endocrine System</option>
									<option value="urinary system">Urinary System</option>
									<option value="contraception">Contraception</option>
									<option value="obstetrics and gynecology">Obstetrics and gynecology</option>
									<option value="skin">Skin</option>
									<option value="infections and infestations">Infections and infestations</option>
									<option value="immune system">Immune System</option>
									<option value="allergic system">Allergic System</option>
									<option value="nutrition">Nutrition</option>
									<option value="neoplastic disorders">Neoplastic disorders</option>
									<option value="diagnostics">Diagnostics</option>
									<option value="euthanasia">Euthanasia</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-4">
								<label class="control-label">Supplier Name</label>
							</div>
							<div class="col-sm-6">
								<select name="supplierName" class="form-control">
									<?php do { ?>
									<option value="<?php echo $row_suppliers['supplier_id']; ?>"><?php echo $row_suppliers['supplier_name']; ?></option>
									<?php } while ($row_suppliers = mysql_fetch_assoc($suppliers)); ?>
								</select>
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
									<th>Medicine ID</th>
									<th>Generic Name</th>
									<th>Brand Name</th>
									<th>Price</th>
									<th>Type</th>
									<th>Supplier Name</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php $medid=1; do { ?>
								<tr>
									<td><?php echo $medid; ?></td>
									<td><?php echo $row_medicine['genericName']; ?></td>
									<td><?php echo $row_medicine['brandName']; ?></td>
									<td>$<?php echo $row_medicine['price']; ?></td>
									<td><?php echo $row_medicine['type']; ?></td>
									<td><?php echo $row_medicine['supplier_name']; ?></td>
									<td>
										<a href="updateMedicine.php?medicine_id=<?php echo $row_medicine['medicine_id']; ?>"> <button class="btn btn-success" type="button"><i class="fa fa-pencil"></i></button></a>
										<a href="deleteMedicine.php?medicine_id=<?php echo $row_medicine['medicine_id']; ?>"><button class="btn btn-danger" type="button"><i class="fa fa-trash-o"></i></button></a>
									</td>
								</tr>
								<?php $medid=$medid+1; } while ($row_medicine = mysql_fetch_assoc($medicine)); ?>
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