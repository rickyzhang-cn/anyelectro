<?php
	include("dbconf.php");
	var_dump($_GET);
	if(isset($_GET['verify']))	{
		$vstring = $_GET['verify'];
	}
	if(isset($_GET['email']))
		$vemail = $_GET['email'];
	if(isset($vstring) && isset($vemail))	{
		
		$vsql = "select id from users where verifystring = '$vstring' and email = '$vemail';";
		var_dump($vsql);

		$vresult = mysql_query($vsql);
		if(mysql_num_rows($vresult))	{
			$row = mysql_fetch_assoc($vresult);
			var_dump($row);
			$usql = "update users set active = 1 where id = ".$row['id'];
			mysql_query($usql);
			$_SESSION['username'] = $username;
			$_SESSION['islogin'] = 1;
			header("Location:index.php");
		}
	}
?>
