<?php
if(!defined('TRACK')){
	header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
	echo '<h1>403 Forbidden<h1><h4>You are not authorized to access the page.</h4>';
	echo '<hr/>'.$_SERVER['SERVER_SIGNATURE'];
	exit(1);
}
session_start();
if(!isset($_SESSION['TRACKLOGGED']) || $_SESSION['userid']!=$_COOKIE['userid']){
	$_SESSION['TRACKLOGGED']=1098;
	$LOCATION='login.php?start';
	require_once('logout.php');
	die();
}
$a=explode('.',$_SERVER['SERVER_ADDR']);
$q=md5($a[0].$a[1].$_SERVER['HTTP_USER_AGENT'].session_id().'ashj23jkh35jkh35'.$_SESSION['hasher']);
if($_COOKIE['check']!=$q)
	require_once('logout.php');
else
	setcookie('check',$q,time()+300,'/');
?>