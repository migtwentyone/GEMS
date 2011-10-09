<?php
define('TRACK','##$$');
$LOCATION='../login.php?start=home&action=discuss';
require_once('security.php');
try{
	$sid=intval($_GET['story']);
	$action=intval($_GET['action']);
	$type=intval($_GET['channel']);
	if(!($sid && $action>=1 && $action<=3 && $type>=1 && $type<=4))
		throw new Exception('Illegal Usage');
	require_once('connectmysql.php');
	$c=connectMySQL('../../');
	if(!$c)
		die('Could not Connect to Database! Please Try again Later.');
	$res=run_query("SELECT `members`.`branch_code` FROM `members`,`br` WHERE `members`.`userid`='{$_SESSION['userid']}' AND `members`.`branch_code`=`br`.`branch_code`;",$c);
	$res=mysql_fetch_row($res);
	$brcode=$res[0];
	switch($type){
	case 1:
		$q="SELECT `comments`.`threadid` FROM `comments`,`threads` WHERE `comments`.`storyid`='$sid' AND `comments`.`threadid`=`threads`.`threadid` AND `threads`.`branch_code`='$brcode';";
		$table='comments';
		$location='../home.php?discuss';
		break;
	case 2:
		$q="SELECT `branch_code` FROM `event` WHERE `storyid`='$sid' AND (`branch_code`='0' OR `branch_code`='$brcode');";
		$table='event';
		$location='../home.php?events';
		break;
	case 3:
		$q="SELECT `branch_code` FROM `score` WHERE `storyid`='$sid' AND (`branch_code`='0' OR `branch_code`='$brcode');";
		$table='score';
		$location='../home.php';
		break;
	case 4:
		$q="SELECT `branch_code` FROM `updates` WHERE `storyid`='$sid' AND (`branch_code`='0' OR `branch_code`='$brcode');";
		$table='updates';
		$location='../home.php';
	}
	$res=run_query($q,$c);
	$res=mysql_fetch_row($res);
	if(!$res[0])
		throw new Exception('The story you are touching does not exist in your domain.');
	else
		$query='='.$res[0];
	$res=run_query("SELECT `activity` FROM `interest` WHERE `storyid`='$sid' AND `type`='$type' AND `userid`='{$_SESSION['userid']}';",$c);
	$res=mysql_fetch_row($res);
	if($res && $res[0]!=$action){
		run_query("UPDATE `interest` SET `activity`='$action' WHERE `storyid`='$sid' AND `type`='$type' AND `userid`='{$_SESSION['userid']}';",$c);
		$r=run_query("SELECT `activity`,COUNT(*) FROM `interest` WHERE `storyid`='$sid' AND `type`='$type' GROUP BY `activity`;",$c);
		while($res=mysql_fetch_row($r))
			switch($res[0]){
			case '1':	$likes=$res[1]; break;
			case '2':	$unlikes=$res[1]; break;
			case '3':	$neutral=$res[1];
			}
		run_query("UPDATE `$table` SET `likes`='$likes',`unlikes`='$unlikes',`neutral`='$neutral' WHERE `storyid`='$sid';",$c);
	} else{
		if($res)
			run_query("DELETE FROM `interest` WHERE `storyid`='$sid' AND `activity`='$action' AND `type`='$type' AND `userid`='{$_SESSION['userid']}';",$c);
		else
			run_query("INSERT INTO `interest` VALUES('$sid','$action','$type','{$_SESSION['userid']}');",$c);
		$field=$action==1?'likes':($action==2?'unlikes':'neutral');
		run_query("UPDATE `$table` SET `$field`=(SELECT COUNT(*) FROM `interest` WHERE `storyid`='$sid' AND `activity`='$action' AND `type`='$type') WHERE `storyid`='$sid';",$c);
	}
	if(isset($_GET['ajax']))
		echo '1';
	else
		header('Location: '.$location.(strrchr($location,'?')?$query:''));
} catch(Exception $e){
	if(isset($_GET['ajax']))
		echo '0';
	else
		echo $e->getMessage();
}
if($c)
	mysql_close($c);
?>