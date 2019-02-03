<?php
	require_once('Connections/connection.php'); 
	include('imports/functions.php'); 
	if ((isset($_GET['user_id'])) && ($_GET['user_id'] != "")) {
	 $deleteSQL = sprintf("DELETE FROM user WHERE user_id=%s",
	 GetSQLValueString($_GET['user_id'], "int"));
	 mysql_select_db($database_connection, $connection);
	 $Result1 = mysql_query($deleteSQL, $connection) or die(mysql_error());
	 header("Location: users.php?st=d"); }
?>