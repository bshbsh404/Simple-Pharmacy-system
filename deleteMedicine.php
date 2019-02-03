<?php 
	require_once('Connections/connection.php'); 
	include('imports/functions.php'); 
	if ((isset($_GET['medicine_id'])) && ($_GET['medicine_id'] != "")) {
	 $deleteSQL = sprintf("DELETE FROM medicine WHERE medicine_id=%s",
	 GetSQLValueString($_GET['medicine_id'], "int"));
	 mysql_select_db($database_connection, $connection);
	 $Result1 = mysql_query($deleteSQL, $connection) or die(mysql_error());
	 header("Location: medicine.php?st=d"); }
?>