<?php
if(isset($_COOKIE['userid']))
	header('Location: page/home.php');
session_set_cookie_params(time()+300,'/');
session_start();
define('TRACK','##$$');
$a=explode('.',$_SERVER['SERVER_ADDR']);
$s=$a[0].$a[1].$_SERVER['HTTP_USER_AGENT'].session_id().'ashj23jkh35jkh35';
$_SESSION['hasher']=md5(time());
setcookie('check',md5($s.$_SESSION['hasher']),time()+300,'/');
?>
<html>
<head>
 <title>
  Website
 </title>
 <script type="text/javascript" src="script/index.js"></script>
</head>
<body onload="bodyLoad()">
<div id="header">
 <h2>
  Welcome!
 </h2>
</div>
<div id="content">
 <div id="sidebar">
 <!-- contains branch homepages, and external links -->
 </div>
 <div id="scores">
 <!-- contains scores when fest is on, a countdown otherwise -->
 </div>
 <div id="events">
 <!-- contains events and descriptions -->
 </div>
 <div id="login">
 <h3>
	log in
 </h3>
 <?php 
 $PATH='page/';
 require_once('page/login_form.php'); ?>
 </div>
 <div id="register">
	<a href="page/register.php">Register</a>
 </div>
</div>
<div id="footer">
</footer>
</body>
</html>