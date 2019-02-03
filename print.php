<?php require_once('Connections/connection.php');
date_default_timezone_set("US/Arizona");
if (!isset($_SESSION))
session_start();
if(!isset($_SESSION['Username']))
header("Location: login.php");
	$m=$_GET['m'];
	$y=$_GET['y'];
mysql_select_db($database_connection, $connection);
$query_transactions = "SELECT transaction_id,brandName,date,quantity,userName,Price FROM transactionslist where (month(date) ='$m') and (year(date) ='$y') ORDER BY transaction_id ASC";
$transactions = mysql_query($query_transactions, $connection) or die(mysql_error());
$row_transactions = mysql_fetch_assoc($transactions);
$totalRows_transactions = mysql_num_rows($transactions);
$query_report = "SELECT SUM(Price*0.2) as profit,SUM(Price) as purchases FROM transactionslist where (month(date) ='$m') and (year(date) ='$y')";
$report = mysql_query($query_report, $connection) or die(mysql_error());
$row_report= mysql_fetch_assoc($report);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Month report</title>
		<?php include('imports/stylesheet.php'); ?>
	</head>
	<body class="home" onload="window.print();">
		<div class="user-dashboard">
			<div class="row">
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
								<h2>Sales for <?php echo $m."/".$y; ?> </h2>
								<div class="table-responsive">
									<table class="table">
										<tr>
											<th>Purchases:</th>
											<td>$<?php echo $row_report['purchases'];?></td>
										</tr>
										<tr>
											<th>Total:</th>
											<td>$<?php echo $row_report['purchases']+$row_report['profit']; ?></td>
										</tr>
										<tr>
											<th>Profit:</th>
											<td>$<?php echo $row_report['profit']; ?></td>
										</tr>
									</table>
								</div>
							</div>
							<br><table class="table table-striped table-bordered table-hover">
								<thead>
									<tr class="info">
										<th>ID</th>
										<th>Medicine Name</th>
										<th>Date</th>
										<th>Quantity</th>
										<th>Price</th>
										<th>User</th>
									</tr>
								</thead>
								<tbody>
									<?php do {?>
									<tr>
										<td><?php echo $row_transactions['transaction_id']; ?></td>
										<td><?php echo $row_transactions['brandName']; ?></td>
										<td><?php echo $row_transactions['date']; ?></td>
										<td><?php echo $row_transactions['quantity']; ?></td>
										<td>$<?php echo$row_transactions['Price']+$row_transactions['Price']*0.2?></td>
										<td><?php echo $row_transactions['userName']; ?></td>
									</tr>
									<?php } while ($row_transactions = mysql_fetch_assoc($transactions)); ?>
								</tbody>
							</table>
						</div>
					</div>
				</div></div>
			</div>
			<?php include('imports/scripts.php'); ?>
		</body>
	</html>