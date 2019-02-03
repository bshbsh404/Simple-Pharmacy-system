<?php 
	require_once('Connections/connection.php'); 
	include('imports/functions.php'); 
	if ((isset($_GET['supplier_id'])) && ($_GET['supplier_id'] != "")) {
	 $deleteSQL = sprintf("DELETE FROM supplier WHERE supplier_id=%s",
	 GetSQLValueString($_GET['supplier_id'], "int"));
	 mysql_select_db($database_connection, $connection);
	 $Result1 = mysql_query($deleteSQL, $connection) or die(mysql_error());
	 header("Location: suppliers.php?st=d");  }
?>