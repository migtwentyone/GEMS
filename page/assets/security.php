<?php
if(!defined('TRACK')){
	header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
	echo '<h1>403 Forbidden<h1><h4>You are not authorized to access the page.</h4>';
	echo '<hr/>'.$_SERVER['SERVER_SIGNATURE'];
	exit(1);
}
if(realpath('../config/variables.php'))
	require_once('../config/variables.php');
else
	require_once('../../config/variables.php');
session_set_cookie_params(time()+$TIME,'/');
if(isset($_COOKIE['userid'])){
	$t=$_COOKIE['userid'];
	setcookie('userid',$t,time()+$TIME,'/');
}
$t=$_COOKIE['check'];
setcookie('check',$t,time()+$TIME,'/');
session_start();
if(!isset($_SESSION['TRACKLOGGED']) || $_SESSION['userid']!=$_COOKIE['userid']){
	$_SESSION['TRACKLOGGED']=1098;
	require_once('logout.php');
	die();
}
$a=explode('.',$_SERVER['SERVER_ADDR']);
$q=md5($a[0].$a[1].$_SERVER['HTTP_USER_AGENT'].session_id().$KEY1.$_SESSION['hasher']);
if($_COOKIE['check']!=$q)
	require_once('logout.php');
?>