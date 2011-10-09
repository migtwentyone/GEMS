<?php
define('TRACK','##$$');
$LOCATION='../login.php';
require_once('security.php');
try{
	require_once('connectmysql.php');
	$c=connectMySQL('../../');
	if(!$c)
		die('Could not Connect to Database! Please Try again Later.');
	$res=run_query("SELECT `members`.`branch_code` FROM `members`,`br` WHERE `members`.`userid`='{$_SESSION['userid']}' AND `members`.`branch_code`=`br`.`branch_code`;",$c);
	$res=mysql_fetch_row($res);
	$brcode=$res[0];
	if(!$brcode)
		throw new Exception('Please retry your request! Processing error occured.');
	$branch=intval($_POST['scope']);
	if($branch==1 || $branch ==0)
		$branch=($branch==1?$brcode:0);
	else
		throw new Exception('Illegal Usage.');
	$content=htmlspecialchars($_POST['update']);
	if(strlen($thread)>500)
		throw new Exception('Too long thread name');
	$time=time();
	run_query("INSERT INTO `updates` VALUES(NULL,'$content','$time','{$_SESSION['userid']}','$branch','0','0','0');",$c);
	if(isset($_POST['updateSubmit']))
		header('Location: ../home.php');
	else
		echo '1';
} catch(Exception $e){
	echo $e->getMessage();
}
if($c)
	mysql_close($c);
?>