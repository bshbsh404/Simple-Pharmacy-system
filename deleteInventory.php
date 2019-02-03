<?php 
	require_once('Connections/connection.php');
	include('imports/functions.php');
	if ((isset($_GET['inventoryID'])) && ($_GET['inventoryID'] != "")) {
	$deleteSQL = sprintf("DELETE FROM inventory WHERE id=%s",
	GetSQLValueString($_GET['inventoryID'], "int"));
	mysql_select_db($database_connection, $connection);
	$Result1 = mysql_query($deleteSQL, $connection) or die(mysql_error());
	header("Location: inventory.php?st=d");  }
?>