<?php
	$dbhost = "localhost";
	$dbuser = "root";
	$dbpasswd = "123456";
	$dbname = "anyelectro";
	$db_conn = mysql_connect($dbhost, $dbuser, $dbpasswd);
	var_dump($db_conn);
	mysql_select_db($dbname, $db_conn);
	mysql_query("set character set utf8;");
	mysql_query("set names utf8;");
?>


