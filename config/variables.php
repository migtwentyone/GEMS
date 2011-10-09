<?php
if(!defined('TRACK')){
	header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
	echo '<h1>403 Forbidden<h1><h4>You are not authorized to access the page.</h4>';
	echo '<hr/>'.$_SERVER['SERVER_SIGNATURE'];
	exit(1);
}

//login security keys
$KEY1='23wedwre23w23';
$KEY2='23r3rf276urd6gu7yru7';

//session persistence time
$TIME=1800;
?>