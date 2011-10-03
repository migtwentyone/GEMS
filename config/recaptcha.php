<?php
if(!defined('TRACK')){
	header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
	echo '<h1>403 Forbidden<h1><h4>You are not authorized to access the page.</h4>';
	echo '<hr/>'.$_SERVER['SERVER_SIGNATURE'];
	exit(1);
}
$public='6LeJusgSAAAAAN7K1g6k4CqTv3rZOPHMR8A-FVyv';
$private='6LeJusgSAAAAAN83HlC8WGPt7vAp4uzMbsXmtMbP';
?>