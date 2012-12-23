<?php
	session_start();
	if(!isset($_POST['submit']))	{
		exit('非法访问');
	}
	var_dump($_POST);
	
	$username = $_POST['username'];
	$passwd = $_POST['passwd'];
	$major = $_POST['major'];
	$email = $_POST['email'];

	$pattern = '/\w+[-_+.]?\w+@(\w+(\.\w+){0,3})/';
	if(!preg_match($pattern,$email,$matches))
		exit('邮箱格式不对！！<a href="javascript:history.back(-1);">返回</a>');
/*	if($matches[1] != "smail.hust.edu.cn")
		exit('请用smail.hust.edu.cn注册，证明你是华科学生！！<a href="javascript:history.back(-1);">返回</a>');
*/
	
	include('setting/dbconf.php');

	$check_query = mysql_query("select * from users where email = '".$email."' limit 1");
	if(mysql_num_rows($check_query))
		exit('该邮箱已被注册！！<a href="javascript:history.back(-1);">返回</a>');

	$check_query = mysql_query("select * from users where username = '".$username."' limit 1");
	if(mysql_num_rows($check_query))
		exit('该用户已被注册，请换个用户名<a href="javascript:history.back(-1);">返回</a>');
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
	$randomstring = "";
	for($i=0;$i<16;$i++)
		$randomstring .= substr($chars, mt_rand(0, strlen($chars) - 1), 1); 
	var_dump($randomstring);
	$rans = addslashes($randomstring);
	var_dump($rans);
	$sql = "insert into users(username, passwd, major, email, verifystring, active) values ('$username', '$passwd', '$major', '$email', '$rans', 0)";
	var_dump($sql);
	$insert_query = mysql_query($sql);
	if($insert_query)	{
		echo "<p>请到注册邮箱中激活自己的账户，然后重新<a href='login.html'>登录</a></p>";
		sendmail($username,$email,$randomstring);
	}
	else
		exit('Sorry， 注册不成功！！');

	function sendmail($username,$to,$rstr)	{
		
	require("include/phpmailer/class.phpmailer.php");

	$mail = new PHPMailer();

        $mail->IsSMTP();                                      // set mailer to use SMTP
        $mail->Host = "smtp.163.com";
        $mail->SMTPAuth = true;     // turn on SMTP authentication
        $mail->Username = "whricky@163.com";  // SMTP username
        $mail->Password = "husteiricky"; // SMTP password

        $mail->From = "whricky@163.com";
        $mail->FromName = "Tiny SE";
        $mail->AddAddress("$to", "$username");
        $mail->AddReplyTo("whricky@163.com", "TinySE");

        $mail->WordWrap = 50;                                 // set word wrap to 50 characters
        $mail->IsHTML(true);                                  // set email format to HTML

	$verifyurl = "http://localhost/anyelectro/verify.php";
	$verifystring = urlencode($rstr);
	$mail_body = "<h2>Hi, $username</h2><p>Please click the following link to verify your account:$verifyurl?email=$to&verify=$verifystring</p>";
        $mail->Subject = "这是Tiny SE发给您的验证邮件";
        $mail->Body    = "$mail_body";
        $mail->AltBody = "This is the body in plain text for non-HTML mail clients";

	if(!$mail->Send())
	{
  		echo "Message could not be sent. <p>";
   		echo "Mailer Error: " . $mail->ErrorInfo;
  	 	exit;
	}

	echo "Message has been sent";
	}
		
?>
		
