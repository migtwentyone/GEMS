<?php
session_set_cookie_params(time()+300);
session_start();
if(!isset($_SESSION['TRACK'])){
	header('Location: login.php?start');
	die();
}
require_once('security.php');
//var_dump($_SESSION);
/*

$_SESSION['user']['id']=$res[1];
	$_SESSION['user']['name']=$res[0];
	$_SESSION['user']['branch']=$res[2];
	$_SESSION['user']['roll']=$rn;
	setcookie('userid',$_SESSION['user']['id'],time()+300);echo time();
	
	*/
require_once('connectmysql.php');
$c=connectMySQL('../');
if(!$c)
	die('Could not Connect to Database! Please Try again Later.');
?>
<html>
</head>
	<title>
		Home
	</title>
</head>
<body>
<div id="header">
	Welcome!
</div>
<div id="content">
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
if(isset($_GET['events']))
	require_once('home_events.php');
else if(isset($_GET['discuss']))
	require_once('home_discuss.php');
else if(isset($_GET['dashboard']))
	require_once('home_dashboard.php');
else if(isset($_GET['edit']))
	require_once('home_editinfo.php');
else
	require_once('home_default.php');
?>
	<div id="account">
		Logged in as <a href="home.php?dashboard"><?php echo $_SESSION['user']['name']; ?></a>
		<br/><a href="logout.php">Sign Out</a>
	</div>
	</div>
	<div id="footer">
	</div>
</div>
<div id="footer">
</div>
</body>
</html>