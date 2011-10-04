<?php
define('TRACK','##$$');
$LOCATION='login.php?start=home';
require_once('assets/security.php');
/*

$_SESSION['userid']
	setcookie('userid',$_SESSION['user']['id'],time()+300);echo time();
	
	*/
if(isset($_GET['events']))
	$mode='home_events';
else if(isset($_GET['discuss']))
	$mode='home_discuss';
else if(isset($_GET['dashboard']))
	$mode='home_dashboard';
else if(isset($_GET['edit']))
	$mode='home_editinfo';
else
	$mode='home_default';
require_once('assets/connectmysql.php');
$c=connectMySQL('../');
if(!$c)
	die('Could not Connect to Database! Please Try again Later.');
?>
<html>
</head>
	<title>
		Home
	</title>
	<script type="text/javascript" src="../script/<?php echo $mode; ?>.js"></script>
</head>
<body>
<div id="header">
	Welcome!
</div>
<div id="area">
	<div id="sidebar">
	<ul>
		<li><a href="home.php">Branch Home</a></li>
		<li><a href="home.php?events">Events</a></li>
		<li><a href="home.php?discuss">Forum</a></li>
		<li><a href="home.php?dashboard">Dashboard</a></li>
		<li><a href="home.php?edit">Edit Info</a></li>
	</ul>
	</div>
	<div id="content">
<?php
require_once("assets/$mode.php");
?>
	<div id="account">
		Logged in as <a href="home.php?dashboard"><?php 'name'; ?></a>
		<br/><a href="assets/logout.php">Sign Out</a>
	</div>
	</div>
	<div id="footer">
	</div>
</div>
<div id="footer">
</div>
</body>
</html>