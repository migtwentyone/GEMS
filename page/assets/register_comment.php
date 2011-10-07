<?php
define('TRACK','##$$');
$LOCATION='../login.php?start=home&action=discuss';
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
	if(isset($_POST['comment'])){
	$res=run_query("SELECT `branch_code` FROM `threads` WHERE `threadid`='{$_POST['threadid']}';",$c);
	$res=mysql_fetch_row($res);
	if($res[0]!=$brcode)
		throw new Exception('You are not authorised to post this comment!');
	$content=htmlspecialchars($_POST['comment']);
	$time=time();
	run_query("INSERT INTO `comments` VALUES(NULL,'{$_POST['threadid']}','$content','$time','{$_SESSION['userid']}','0','0','0');",$c);
	run_query("UPDATE `threads` SET `time`='$time' WHERE `threadid` ='{$_POST['threadid']}';",$c);
	if(isset($_POST['commentSubmit']))
		header('Location: ../home.php?discuss='.$_POST['threadid']);
	else
		echo '1';
	} else if(isset($_POST['thread'])){
	
	$thread=htmlspecialchars(filter_var($_POST['thread'],FILTER_SANITIZE_EMAIL));
	$time=time();
	run_query("INSERT INTO `threads` VALUES(NULL,'$brcode','$thread','$time','$time','{$_SESSION['userid']}');",$c);
	$res=run_query("SELECT `threadid` FROM `threads` WHERE `userid`='{$_SESSION['userid']}' AND `created`='$time';",$c);
	$res=mysql_fetch_row($res);
	$res='='.$res[0];
	if(isset($_POST['threadSubmit']))
		header('Location: ../home.php?discuss'.$res);
	else
		echo '1';
	}
} catch(Exception $e){
	echo $e->getMessage();
}
if($c)
	mysql_close($c);
?>