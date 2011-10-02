<?php
if(isset($_POST['submitMySQL'])){
	$TRACK=1;
	if($f=fopen('config/mySQL.ini','w')){
		$str='SQLuser = ';
		if($_POST['mySQLname']=='')
			$str.=ini_get('mysql.default_user');
		else
			$str.=$_POST['mySQLname'];
		$str.="\nSQLpassword = ";
		if($_POST['mySQLpassword']=='')
			$str.=ini_get('mysql.default_password');
		else
			$str.=$_POST['mySQLpassword'];
		$str.="\nSQLserver = ";
		if($_POST['mySQLserver']=='')
			$str.='localhost';
		else
			$str.=$_POST['mySQLserver']."\n";
		$str.="\nSQLport = ";
		if($_POST['mySQLport']=='')
			$str.=3306;
		else
			$str.=$_POST['mySQLport'];
		$str.="\nSQLdatabase = ";
		if($_POST['mySQLdatabase']=='')
			$str.='test';
		else
			$str.=$_POST['mySQLdatabase'];
		$str.="\n";
		fwrite($f,$str);
		fclose($f);
		require 'page/database.php';
		header('Location: index.php');
	} else
		header('Location: install.php');
	die();
}
?>
<html>
<head>
	<title>
		Installation
	</title>
</head>
<body>
<div id="header">
	<h2>
		Welcome
	</h2>
</div>
<div id="content">
	<div>
		<h3>MySQL Configuration</h3>
		<br/><em>Leave the fields blank for default values.</em>
    <table border=0>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
		<tr>
			<td>Username</td>
			<td><input type="text" name="mySQLname" /></td>
		</tr>
		<tr>
			<td>Password</td>
			<td><input type="password" name="mySQLpassword" /></td>
		</tr>
		<tr>
			<td>Server</td>
			<td><input type="text" name="mySQLserver" /></td>
		</tr>
		<tr>
			<td>Port</td>
			<td><input type="text" name="mySQLport" /></td>
		</tr>
		<tr>
			<td>Database</td>
			<td><input type="text" name="mySQLdatabase" /></td>
		</tr>
		<tr>
			<td colspan=2><input type="submit" name="submitMySQL" value="Complete Install" class="detailFormButton"/></td>
		</tr>
		</form>
		</table>
		</div>
</div>
</body>
</html>