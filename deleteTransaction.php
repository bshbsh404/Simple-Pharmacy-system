<?php 
	require_once('Connections/connection.php');
	include('imports/functions.php'); 
	if ((isset($_GET['transaction_id'])) && ($_GET['transaction_id'] != "")) {
	 $deleteSQL = sprintf("DELETE FROM transactions WHERE transaction_id=%s",
	 GetSQLValueString($_GET['transaction_id'], "int"));
	 mysql_select_db($database_connection, $connection);
	 $Result1 = mysql_query($deleteSQL, $connection) or die(mysql_error());
	 header("Location: transactions.php?st=d"); }
?>