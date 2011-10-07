<?php
if(!defined('TRACK')){
	header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
	echo '<h1>403 Forbidden<h1><h4>You are not authorized to access the page.</h4>';
	echo '<hr/>'.$_SERVER['SERVER_SIGNATURE'];
	exit(1);
}
?>
<table border=0 >
	<!--https-->
     <form action="<?php echo $PATH.'login.php'.$QUERY; ?>" method="post" onsubmit="return loginSubmit()" >
	 <input type="hidden" name="parallel" value="<?php echo 
	 $parallel; unset($parallel); ?>" />
	 <tr>
     <td>Branch Passcode</td>
	 <td><input type="password" name="passcode" /></td>
	 </tr>
	 <tr>
     <td>Roll Number</td>
	 <td><input type="text" name="roll" value="<?php echo $rn; ?>"/></td>
	 </tr>
	 <tr>
	 <td>Password</td>
	 <td><input type="password" name="password" /></td>
	 </tr>
	 <tr>
	 <td><input type="submit" value="Log In" name="loginsubmit"/></td>
	 <td><a href="<?php echo $PATH; ?>forgotlogin.php" class="loginForm">Forgot your password?</a></td>
	 </tr>
     </form>
    </table>