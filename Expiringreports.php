<?php require_once('Connections/connection.php');
date_default_timezone_set("US/Arizona");
if (!isset($_SESSION))
session_start();
if(!isset($_SESSION['Username']))
header("Location: login.php");
mysql_select_db($database_connection, $connection);
$query_expiring = "SELECT * FROM inventorylist WHERE (expiryDate < now()) ORDER BY expiryDate";
    $expiring = mysql_query($query_expiring, $connection) or die(mysql_error());
    $row_expiring = mysql_fetch_assoc($expiring);
    $totalRows_expiring = mysql_num_rows($expiring);
$query_report = "SELECT SUM(price*0.2) as loss,SUM(price) as purchases FROM inventorylist where (expiryDate < now())";
$report = mysql_query($query_report, $connection) or die(mysql_error());
$row_report= mysql_fetch_assoc($report);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Home</title>
		<?php include('imports/stylesheet.php'); ?>
	</head>
	<body class="home">
		<?php include('imports/header.php'); ?>
		<div class="user-dashboard">
			<div class="row">
				
				<?php if($totalRows_expiring>=1){?>
				<div class="row">
					<div class="col-md-12 animated fadeInDown">
						<div class="row">
							<div class="col-xs-12">
								<h2 class="page-header">
								Simple PHARMACY
								<small class="pull-right">Date: <?php echo date("d/m/Y"); ?></small>
								</h2>
							</div>
						</div>
						<div class="row" >
							<div class="col-sm-4">
								From:<br>
								<strong><?php echo $_SESSION['Username']; ?></strong><br><br>
								To:<br>
								<strong>General manager</strong>
							</div>
							<div class="col-sm-4">
								<p>Expired medicines for <?php echo date("d/m/Y"); ?> </p>
								<div class="table-responsive">
									<table class="table">
										<tr>
											<th>Purchases:</th>
											<td>$<?php echo $row_report['purchases'];?></td>
										</tr>
										<tr>
											<th>Total loss:</th>
											<td>$<?php echo $row_report['purchases']+$row_report['loss']; ?></td>
										</tr>
									</table>
								</div>
							</div>
							<div class="col-sm-4">
								<a href="Expiringprint.php" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
							</div>
							
							<br><table class="table table-striped table-bordered table-hover">
								<thead>
									<tr class="info">
										<th>ID</th>
										<th>Medicine Name</th>
										<th>Expiration Date</th>
										<th>Quantity</th>
										<th>Price</th>
									</tr>
								</thead>
								<tbody>
									<?php $trid=1; do {?>
									<tr>
										<td><?php echo $trid; ?></td>
										<td><?php echo $row_expiring['brandName']; ?></td>
										<td><?php echo $row_expiring['expiryDate']; ?></td>
										<td><?php echo $row_expiring['quantity']; ?></td>
										<td>$<?php echo $row_expiring['price']+$row_expiring['price']*0.2; ?></td>
									</tr>
									<?php $trid=$trid+1; } while ($row_expiring = mysql_fetch_assoc($expiring)); ?>
								</tbody>
							</table>
						</div>
					</div>
				</div><?php }
				else { ?>
				<div class="row">
					<div class="col-md-12 animated fadeInDown"> <h3 class="alert alert-warning text-center animated fadeInDown">There is no expired medicine.</h3>
					</div></div>
					<?php } ?>
				</div>
			</div>
		</div>
		<?php include('imports/scripts.php'); ?>
		<script>
		$(document).ready(function () {
		$('[data-toggle="offcanvas"]').click(function(){
		$("#navigation").toggleClass("hidden-xs");
		}); });
		</script>
	</body>
</html>