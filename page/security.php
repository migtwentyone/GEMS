<?php
if(!isset($_SESSION['TRACK']) && !isset($TRACK)){
	header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
	echo '<h1>403 Forbidden<h1><h4>You are not authorized to access the page.</h4>';
	echo '<hr/>'.$_SERVER['SERVER_SIGNATURE'];
	exit(1);
}
session_start();
$a=explode('.',$_SESSION['SERVER_ADD'],2);
$b=explode(':',$_SESSION['SERVER_ADD'],2);
$q=md5($a[0].$a[1].$b[0].$b[1].$_SERVER['HTTP_USER_AGENT'].session_id().'a65c009b1806d3');
if($_COOKIE['check']!=$q)
	require_once('logout.php');
else
	setcookie('check',$q,time()+300);
?>