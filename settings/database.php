<?php
	$database = "anyelectro";
	$mysql_user = "root";
	$mysql_password = "123456"; 
	$mysql_host = "localhost";
	$mysql_table_prefix = "";



	$success = mysql_pconnect ($mysql_host, $mysql_user, $mysql_password);
	if (!$success)
		die ("<b>Cannot connect to database, check if username, password and host are correct.</b>");
    mysql_query('set names utf8'); 
    $success = mysql_select_db ($database);
	if (!$success) {
		print "<b>Cannot choose database, check if database name is correct.";
		die();
	}
?>

