<?php
if(isset($_COOKIE['userid']))
	header('Location: home.php');
session_set_cookie_params(time()+300,'/');
session_start();
define('TRACK','##$$');
$a=explode('.',$_SERVER['SERVER_ADDR']);
$s=$a[0].$a[1].$_SERVER['HTTP_USER_AGENT'].session_id().'ashj23jkh35jkh35';
if(isset($_GET['start']))
	if( in_array($_GET['start'].'.php', array_slice(scandir(realpath('')),3)) )
		$dest=$_GET['start'];
if(isset($_GET['action']))
	if(preg_match('/^[A-Za-z0-9_]+/',$_GET['action']))
		$action=$_GET['action'];
if(!isset($_POST['loginsubmit'])){
	$_SESSION['hasher']=md5(time());
	$_SESSION['parallel']=md5($_SESSION['hasher'].'etwe4654etwt');
	$parallel=$_SESSION['parallel'];
	setcookie('check',md5($s.$_SESSION['hasher']),time()+300,'/');
	if(isset($_GET['start']))
		$error='You must Login First';
}
else{
	if(!isset($_SESSION['hasher']) || $_COOKIE['check']!=md5($s.$_SESSION['hasher']) || ($_SESSION['parallel'] != null && $_POST['parallel']!=$_SESSION['parallel']) )
		header('Location: login.php');
	unset($_SESSION['parallel']);
	try{
	$pc=$_POST['passcode'];
	$pw=$_POST['password'];
	$rn=$_POST['roll'];
	if($pc==null || $pw==null || $rn==null)
		throw new Exception('Please fill all the fields!');
	if(!preg_match('/^[A-Za-z0-9]*$/',$rn) || strlen($rn)>12){
		unset($rn);
		throw new Exception('You entered an invalid Roll Number!');
	}
	$pc=md5($pc);
	$pw=md5($pw);
	require_once('assets/connectmysql.php');
	$c=connectMySQL('../');
	if(!c)
		throw new Exception('Sorry! Some internal database error occured! Please try again later.');
	$res=run_query("SELECT `name` FROM `member_request` WHERE `rollno`='$rn';",$c);
	if(mysql_fetch_row($res))
		throw new Exception('The registration request for Roll Number '.$rn.' is Pending. Please retry Logging in after some time.');
	$res=run_query("SELECT `members`.`name`,`members`.`userid`,`br`.`branch_code` FROM `members`,`br` WHERE `members`.`rollno`='$rn' AND `members`.`branch_code`=`br`.`branch_code` AND `br`.`passcode`='$pc' AND `members`.`password`='$pw';",$c);
	$res=@mysql_fetch_row($res);
	if(!$res)
		throw new Exception('The Roll Number and Password you entered is not Registered with the associated Branch. Please Check!');
	$t=time();
	if(!run_query("UPDATE `members` SET `time`='$t' WHERE `userid`='{$res[1]}' AND `rollno`='$rn';",$c))
		throw new Exception('The Login could not be registered! Please try again later.');
	$_SESSION['TRACKLOGGED']=1098;
	$_SESSION['userid']=$res[1];
	setcookie('userid',$_SESSION['userid'],time()+300,'/');
	if(isset($action))
		$action='?'.$action;
	if(!isset($dest))
		$dest='home';
	header("Location: $dest.php$action");
} catch(Exception $e){
	$error=$e->getMessage();
}}
if($error)
	$error='<br/><div id="errordiv">'.$error.'</div><br/>';
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
<?php
echo $error;
$PATH='';
if(isset($dest)){
	$QUERY='?start='.$dest;
	if(isset($action))
		$QUERY.='&action='.$action;
}
require_once('assets/login_form.php');
?>
</div>
</div>
<div id="footer">
</div>
</body>
</html>