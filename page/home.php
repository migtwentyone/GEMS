<?php
define('TRACK','##$$');
if(isset($_GET['events']))
	$mode='events';
else if(isset($_GET['discuss']))
	$mode='discuss';
else if(isset($_GET['dashboard']))
	$mode='dashboard';
else if(isset($_GET['editinfo']))
	$mode='editinfo';
else
	$mode='default';
$LOCATION='login.php?start=home&action='.$mode;
require_once('assets/security.php');
$mode='home_'.$mode;
require_once('assets/connectmysql.php');
$c=connectMySQL('../');
if(!$c)
	die('Could not Connect to Database! Please Try again Later.');

try{
	$res=run_query("SELECT `members`.`name`,`members`.`branch_code`,`br`.`branch_name`,`members`.`type` FROM `members`,`br` WHERE `members`.`userid`='{$_SESSION['userid']}' AND `members`.`branch_code`=`br`.`branch_code`;",$c);
	$res=mysql_fetch_row($res);
	if(!$res)
		throw new Exception('Please retry your request! Processing error occured.');
	$name=$res[0];
	$brcode=$res[1];
	$brname=$res[2];
	$type=$res[3];
} catch(Exception $e){
	$error=$e->getMessage();
	if($error=='mysql')
		$error='Sorry! An internal database error occured! Please try again Later.';
}
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
	Welcome to <?php echo $brname; ?>!
</div>
<div id="area">
	<div id="sidebar">
	<ul>
		<li><a href="home.php">Branch Home</a></li>
		<li><a href="home.php?events">Events</a></li>
		<li><a href="home.php?discuss">Forum</a></li>
		<li><a href="home.php?dashboard">Dashboard</a></li>
		<li><a href="home.php?editinfo">Edit Info</a></li>
	</ul>
	</div>
	<div id="content">
<?php
if(isset($error)){
	echo '<div id="errordiv">'.$error.'</div>';
} else	//$name, $brcode, $brname, $_SESSION['userid'], $type variables already set
	require_once("assets/$mode.php");
if($c)
	mysql_close($c);
?>
	<div id="account">
		Logged in as <a href="home.php?dashboard"><?php echo $name; ?></a>
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