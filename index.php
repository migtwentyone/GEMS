<html>
<head>
 <title>
  Website
 </title>
 <script type="text/javascript" src="script/index.js"></script>
</head>
<body onload="bodyLoad()">
<div id="header">
 <h2>
  Welcome!
 </h2>
</div>
<div id="content">
 <div id="sidebar">
 <!-- contains branch homepages, and external links -->
 </div>
 <div id="scores">
 <!-- contains scores when fest is on, a countdown otherwise -->
 </div>
 <div id="events">
 <!-- contains events and descriptions -->
 </div>
 <div id="login">
 <h3>
	log in
 </h3>
 <table border=0 >
 <!--https-->
     <form action="page/login.php?login" method="POST" onsubmit="return loginSubmit()" >
	 <tr>
     <td>Branch Passcode</td>
	 <td><input type="password" name="passcode" /></td>
	 </tr>
	 <tr>
     <td>Roll Number</td>
	 <td><input type="text" name="roll" /></td>
	 </tr>
	 <tr>
	 <td>Password</td>
	 <td><input type="password" name="password" /></td>
	 </tr>
	 <tr>
	 <td><input type="submit" value="Log In" /></td>
	 <td><a href="page/forgotlogin.php" class="loginForm">Forgot your password?</a></td>
	 </tr>
     </form>
    </table>
 </div>
 <div id="register">
	<a href="page/register.php">Register</a>
 </div>
</div>
<div id="footer">
</footer>
</body>
</html>