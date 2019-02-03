<?php require_once('Connections/connection.php');
date_default_timezone_set("US/Arizona");
if (!isset($_SESSION))
session_start();
if(!isset($_SESSION['Username']))
header("Location: login.php");
$report=0;
$editFormAction = $_SERVER['PHP_SELF'];
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	$m=$_POST['month'];
	$y=$_POST['year'];
mysql_select_db($database_connection, $connection);
$query_transactions = "SELECT transaction_id,brandName,date,quantity,userName,Price FROM transactionslist where (month(date) ='$m') and (year(date) ='$y') ORDER BY transaction_id ASC";
$transactions = mysql_query($query_transactions, $connection) or die(mysql_error());
$row_transactions = mysql_fetch_assoc($transactions);
$totalRows_transactions = mysql_num_rows($transactions);
$query_report = "SELECT SUM(Price*0.2) as profit,SUM(Price) as purchases FROM transactionslist where (month(date) ='$m') and (year(date) ='$y')";
$report = mysql_query($query_report, $connection) or die(mysql_error());
$row_report= mysql_fetch_assoc($report);
$link="print.php?m=$m&y=$y";
$report=1;
}
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
							<div class="col-sm-12">
								<div class="input-group">
									<span class="input-group-addon">Month:</span>
									<select name="month" class="form-control">
										<option value="1">January</option>
										<option value="2">February</option>
										<option value="3">March</option>
										<option value="4">April</option>
										<option value="5">May</option>
										<option value="6">June</option>
										<option value="7">July</option>
										<option value="8">August</option>
										<option value="9">September</option>
										<option value="10">October</option>
										<option value="11">November</option>
										<option value="12">December</option>
									</select>
									<span class="input-group-addon">Year: </span>
									<select name="year" class="form-control">
										<?php
										date_default_timezone_set("US/Arizona");
										$yearRange = 10;
										$thisYear = date('Y');
										$startYear = ($thisYear - $yearRange);
										foreach (range($thisYear, $startYear) as $year)
										{
										if ( $year == $thisYear) {
										print '<option value="'.$year.'" selected="selected">' . $year . '</option>';
										} else {
										print '<option value="'.$year.'">' . $year . '</option>';
										}
										}
										?>
									</select>
								</div>
							</div>
						</div>
						<button class="btn btn-success" type="submit">Generate report </button>
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
							<div class="col-sm-4">
								From:<br>
								<strong><?php echo $_SESSION['Username']; ?></strong><br><br>
								To:<br>
								<strong>General manager</strong>
							</div>
							<div class="col-sm-4">
								<p>Sales for <?php echo $m."/".$y; ?> </p>
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
							<div class="col-sm-4">
								<a href="<?php echo $link; ?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
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
									<?php $trid=1; do {?>
									<tr>
										<td><?php echo $trid; ?></td>
										<td><?php echo $row_transactions['brandName']; ?></td>
										<td><?php echo $row_transactions['date']; ?></td>
										<td><?php echo $row_transactions['quantity']; ?></td>
										<td>$<?php echo $row_transactions['Price']+$row_transactions['Price']*0.2?></td>
										<td><?php echo $row_transactions['userName']; ?></td>
									</tr>
									<?php $trid=$trid+1; } while ($row_transactions = mysql_fetch_assoc($transactions)); ?>
								</tbody>
							</table>
						</div>
					</div>
				</div><?php }
				elseif ($report==1) { ?>
				<div class="row">
					<div class="col-md-12 animated fadeInDown"> <h3 class="alert alert-warning text-center animated fadeInDown">There is no transactions in this month.</h3>
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