<?php
$name=$_POST['name'];
$pw=$_POST['password'];
$rn=$_POST['roll'];
$email=$_POST['email'];
$branch=intval($_POST['branch']);
$course=intval($_POST['course']);
$year=intval($_POST['year']);
session_set_cookie_params(time()+30);
session_start();
$cap=$_SESSION['captcha'];
session_destroy();
try{
	if(!isset($_POST['Submit']))
		throw new Exception('');
	//if($name==null || $pw==null || $rn==null || $branch==null || $course==null || $year==null)
		//throw new Exception('Please fill all the fields!');
	if(strcasecmp($cap,$_POST['captcha'])!=0)
		throw new Exception('Please enter the security text correctly.');
	var_dump($_SESSION);
	if(!preg_match('/^[A-Za-z0-9]*$/',$rn) || strlen($rn)>12){
		unset($rn);
		throw new Exception('You entered an invalid Roll Number!');
	}
	if(!preg_match('/^[A-Za-z\.\s0-9]*[A-Za-z\.]$/',$name) || !preg_match('/^[A-Za-z]/',$name) || preg_match('/[\.]{2,}/',$name) || strlen($name)>50){
		unset($name);
		throw new Exception('You entered an invalid Name!');
	}
	if(!preg_match('/^[A-Za-z0-9][A-Za-z0-9.]*@[A-Za-z0-9][A-Za-z0-9.]*\.[A-Za-z]{2,}/',$email) || strlen($email)>70){
		unset($email);
		throw new Exception('You entered an invalid eMail.');
	}
	if(strlen($pw)<8)
		throw new Exception('The password you entered is too short. Please Select another.');
	$pw=md5($pw);
	$TRACK=1;
	require_once('connectmysql.php');
	unset($TRACK);
	$c=connectMySQL('../');
	if(!c)
		throw new Exception('Sorry! Some internal database error occured! Please try again later.');
	$res=@mysql_query("SELECT `name`,`email` FROM `members` WHERE `rollno`='$rn';",$c);
	if($res){
		$res=@mysql_fetch_row($res);
		if($res)
			throw new Exception("The Roll Number you entered is already Registered with the name '{$res[0]}'.");
		if($res[1]==$email){
			unset($email);
			throw new Exception("The email you entered is already associated with an acoount. Please choose another one.");
		}
	}
	else
		throw new Exception('Sorry! Some internal database error occured! Please try again later.');
	$res=@mysql_query("SELECT `name`,`email` FROM `member_request` WHERE `rollno`='$rn';",$c);
	if($res){
		$res=@mysql_fetch_row($res);
		if($res)
			throw new Exception("A request with the roll Number you entered is Pending with the name '{$res[0]}'.");
		if($res[1]==$email){
			unset($email);
			throw new Exception("The email you entered is already associated with another Request. Please choose another one.");
		}
	}
	else
		throw new Exception('Sorry! Some internal database error occured! Please try again later.');
	$res=@mysql_query("SELECT count(*) FROM `cr` WHERE `branch_code`='$branch' AND `course_code`='$course' AND `duration`>=$year;",$c);
	if($res){
		$res=@mysql_fetch_row($res);
		if(!$res[0])
			throw new Exception('The details you have entered are inconsistent. Please Check!');
		else{
			$res=@mysql_query("INSERT INTO `member_request` VALUES ('$rn','$name','$branch','$pw','$year','$course','$email');",$c);
			if(!$res)
				throw new Exception('Sorry! Your request could not be registered! Please try again later.');
			unset($rn);
			unset($name);
			throw new Exception('Your request for roll number '.$rn.' has been registered with the Class Rep! Your account will be now be activated.');
		}
	}
	else
		throw new Exception('Sorry! Some internal database error occured! Please try again later.');
} catch(Exception $e){
	if(($error=$e->getMessage())!='')
	$error='<br/><div id="errordiv">'.$error.'</div><br/>';
}
if($c)
	mysql_close($c);
?>
<html>
<head>
	<title>Register</title>
	<script type="text/javascript" src="../script/register.js"></script>
</head>
<body onload="bodyLoad()">
<div id="header">
	<h2>
		Send registration request to CR
	</h2>
</div>
<div id="content">
	<h3>Log In</h3>
<?php echo $error; ?>
	<table border=0 >
	<!--https-->
     <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" onsubmit="return registerSubmit()" >
	 <tr>
     <td>Roll Number</td>
	 <td><input type="text" name="roll" value="<?php echo $rn; ?>"/></td>
	 </tr>
	 <tr>
     <td>Name</td>
	 <td><input type="text" name="name" value="<?php echo $name; ?>"/></td>
	 </tr>
	 <tr>
	 <td>Password</td>
	 <td><input type="password" name="password" /></td>
	 </tr>
	 <tr>
     <td>eMail</td>
	 <td><input type="text" name="email" value="<?php echo $email; ?>"/></td>
	 </tr>
	 <tr>
	 <td>Branch</td>
	 <td><select size=1 name="branch" title="Select Branch">
	 <option value=""></option>
	 <option value=1>Architecture</option>
	 <option value=2>Chemical Engineering</option>
	 <option value=3>Chemistry</option>
	 <option value=4>Civil Engineering</option>
	 <option value=5>Computer Applications</option>
	 <option value=6>Computer Science and Engineering</option>
	 <option value=7>Electrical and Electronics Engineering</option>
	 <option value=8>Electronics and Communicatons engineering</option>
	 <option value=9>Humanities</option>
	 <option value=10>Instrumentation and Control engineering</option>
	 <option value=11>Management Studies</option>
	 <option value=12>Mathematics</option>
	 <option value=13>Mechanical Engineering</option>
	 <option value=14>Metallurgical and Materials Engineering</option>
	 <option value=15>Physics</option>
	 <option value=16>Production Engineering</option>
	 </select></td>
	 </tr>
	 <tr>
	 <td>Course</td>
	 <td><select size=1 name="course" title="Select Course">
	 <option value=""></option>
	 <option value=1>B. Tech.</option>
	 <option value=2>B. Arch.</option>
	 <option value=3>M. Tech.</option>
	 <option value=4>M. Sc.</option>
	 <option value=5>MCA</option>
	 <option value=6>MBA</option>
	 <option value=7>MS</option>
	 <option value=8>Ph. D.</option>
	 </select></td>
	 </tr>
	 <tr>
	 <td>Year</td>
	 <td><select size=1 name="year" title="Select Year">
	 <option value=""></option>
	 <option value=1>First Year</option>
	 <option value=2>Second Year</option>
	 <option value=3>Third Year</option>
	 <option value=4>Fourth Year</option>
	 <option value=5>Fifth Year</option>
	 <option value=6>Other</option>
	 </select></td>
	 </tr>
	 <tr>
	 <td>Security Verification</td>
	 <td><img src="../module/captcha/captcha.php" alt="Captcha" height=100 width=300 ><br/>
	 <input type="text" name="captcha"</td>
	 </tr>
	 <tr>
	 <td><input type="submit" value="Register" name="Submit"/></td>
	 </tr>
     </form>
    </table>
</div>
</div>
<div id="footer">
</div>
</body>
</html>