<?php
if(isset($_COOKIE['userid']))
	setcookie('userid','!!',time()-2000,'/');
if(isset($_COOKIE['check']))
	setcookie('check','!!',time()-1000,'/');
if (ini_get("session.use_cookies")) {
    $params=session_get_cookie_params();
    setcookie(session_name(),'!!',time()-2000,$params["path"],$params["domain"],$params["secure"],$params["httponly"]);
}
session_start();
session_destroy();
if(!isset($LOCATION))
	$LOCATION='../index.php';
header('Location: '.$LOCATION);
?>