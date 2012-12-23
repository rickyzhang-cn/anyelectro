<?php
	session_start();
//	if(!isset($_POST['submit']))
//		exit('非法访问');
	var_dump($_POST);
	include("setting/dbconf.php");
	$username = $_POST['username'];
	$passwd = $_POST['passwd'];
	$sql = "select * from users where username = '".$username."' and passwd = '".$passwd."' and active=1 limit 1;";
	var_dump($sql);
	$chk_query = mysql_query($sql);
	if(mysql_num_rows($chk_query))	{
		if($username=="admin")	{
			$_SESSION['username'] = $username;
			$_SESSION['isadmin'] = 1;
			header("Location:admin.php");
		}
		else	{
			$_SESSION['username'] = $username;
			$_SESSION['islogin'] = 1;
			header("Location:../index.php");
		}
	}
	else
		exit('登录失败！！<a href="javascript:history.back(-1);">返回重试</a>');
?>
