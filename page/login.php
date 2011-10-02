<?php
$pc=$_POST['passcode'];
$pw=$_POST['password'];
$rn=$_POST['roll'];
try{
	if(isset($_GET['start']))
		throw new Exception('You must Login First');
	if(!isset($_GET['login']))
		throw new Exception('');
	if($pc==null || $pw==null || $rn==null)
		throw new Exception('Please fill all the fields!');
	if(!preg_match('/^[A-Za-z0-9]*$/',$rn) || strlen($rn)>12){
		unset($rn);
		throw new Exception('You entered an invalid Roll Number!');
	}
	$pc=md5($pc);
	$pw=md5($pw);
	$TRACK=1;
	require_once('connectmysql.php');
	unset($TRACK);
	$c=connectMySQL('../');
	if(!c)
		throw new Exception('Sorry! Some internal database error occured! Please try again later.');
	$res=@mysql_query("SELECT `name` FROM `member_request` WHERE `rollno`='$rn';",$c);
	if(!$res)
		throw new Exception('Sorry! Some internal database error occured! Please try again later.');
	if(mysql_fetch_row($res))
		throw new Exception('The registration request for Roll Number '.$rn.' is Pending. Please retry Logging in after some time.');
	$res=@mysql_query("SELECT `members`.`name`,`members`.`userid`,`br`.`branch_code` FROM `members`,`br` WHERE `members`.`rollno`='$rn' AND `members`.`branch_code`=`br`.`branch_code` AND `br`.`passcode`='$pc' AND `members`.`password`='$pw';",$c);
	if(!$res)
		throw new Exception('Sorry! Some internal database error occured! Please try again later.');
	$res=@mysql_fetch_row($res);
	if(!$res)
		throw new Exception('The Roll Number and Password you entered is not Registered with the associated Branch. Please Check!');
	$t=time();
	if(!@mysql_query("UPDATE `members` SET `time`='$t' WHERE `userid`='{$res[1]}' AND `rollno`='$rn';"))
		throw new Exception('The Login could not be registered! Please try again later.');
	session_set_cookie_params(time()+300);
	session_start();
	$a=explode('.',$_SESSION['SERVER_ADD'],2);
	$b=explode(':',$_SESSION['SERVER_ADD'],2);
	setcookie('check',md5($a[0].$a[1].$b[0].$b[1].$_SERVER['HTTP_USER_AGENT'].session_id().'a65c009b1806d3'),time()+300);
	$_SESSION['TRACK']=1098;
	$_SESSION['user']['id']=$res[1];
	$_SESSION['user']['name']=$res[0];
	$_SESSION['user']['branch']=$res[2];
	$_SESSION['user']['roll']=$rn;
	setcookie('userid',$_SESSION['user']['id'],time()+300);
	header('Location: home.php');
} catch(Exception $e){
	if(($error=$e->getMessage())!='')
	$error='<br/><div id="errordiv">'.$error.'</div><br/>';
}
if($c)
	mysql_close($c);
?>
<html>
<head>
	<title>Log In</title>
	<script type="text/javascript" src="../script/login.js"></script>
</head>
<body onload="bodyLoad()">
<div id="header">
	<h2>
		Login
	</h2>
</div>
<div id="content">
	<h3>Log In</h3>
<?php echo $error; ?>
	<table border=0 >
	<!--https-->
     <form action="<?php echo $_SERVER['PHP_SELF'].'?login'; ?>" method="POST" onsubmit="return loginSubmit()" >
	 <tr>
     <td>Branch Passcode</td>
	 <td><input type="password" name="passcode" /></td>
	 </tr>
	 <tr>
     <td>Roll Number</td>
	 <td><input type="text" name="roll" value="<?php echo $rn; ?>"/></td>
	 </tr>
	 <tr>
	 <td>Password</td>
	 <td><input type="password" name="password" /></td>
	 </tr>
	 <tr>
	 <td><input type="submit" value="Log In" /></td>
	 <td><a href="page/forgotlogin.php" class="loginForm">Forgot your password?</a></td>
	 </tr>
     </form>
    </table>
</div>
</div>
<div id="footer">
</div>
</body>
</html>