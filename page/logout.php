<?php
session_start();
if(!isset($_SESSION['TRACK'])){
	header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
	echo '<h1>403 Forbidden<h1><h4>You are not authorized to access the page.</h4>';
	echo '<hr/>'.$_SERVER['SERVER_SIGNATURE'];
	exit(1);
}
setcookie('userid','',time()-1000);
setcookie('check','',time()-1000);
if (ini_get("session.use_cookies")) {
    $params=session_get_cookie_params();
    setcookie(session_name(),'',time()-42000,$params["path"],$params["domain"],$params["secure"],$params["httponly"]);
}
session_destroy();
header('Location: ../index.php');
?>