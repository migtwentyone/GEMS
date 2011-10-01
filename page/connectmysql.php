<?php
if(!isset($_SESSION['TRACK']) && !isset($TRACK)){
	header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
	echo '<h1>403 Forbidden<h1><h4>You are not authorized to access the page.</h4>';
	echo '<hr/>'.$_SERVER['SERVER_SIGNATURE'];
	exit(1);
}
/*
connects to the MySQL database using the password and login details given in the "MySQL.ini" file in the SETTING directory
return the connection resource if connection made,
false if connection could not be made
 argument: path to root project folder. takes on after that to locate the config file
*/
function connectMySQL($pathh){
	$mysql=parse_ini_file($pathh.'config/mySQL.ini');
	if(!$mysql['SQLuser'])
		$mysql['SQLuser']=ini_get("mysql.default_user");
	if(!$mysql['SQLpassword'])
		$mysql['SQLpassword']=ini_get("mysql.default_password");
	if(!$mysql['SQLserver'])
		$mysql['SQLserver']='localhost';
	if(!$mysql['SQLport'])
		$mysql['SQLport']=3306;
	$c=@mysql_connect($mysql['SQLserver'].':'.$mysql['SQLport'],$mysql['SQLuser'],$mysql['SQLpassword']);
	if(!$c)
		return false;
	if(!@mysql_select_db($mysql['SQLdatabase'],$c))
		return false;
	return $c;
}
?>