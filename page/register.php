<?php
$name=$_POST['name'];
$pw=$_POST['password'];
$rn=$_POST['roll'];
$email=$_POST['email'];
$branch=intval($_POST['branch']);
$course=intval($_POST['course']);
$year=intval($_POST['year']);
define('TRACK','##$$');
require_once('../module/recaptcha/recaptchalib.php');
require_once('../config/recaptcha.php');
try{
	if(!isset($_POST['Submit']))
		throw new Exception('');
	if($name==null || $pw==null || $rn==null || $branch==null || $course==null || $year==null)
		throw new Exception('Please fill all the fields!');
	if(isset($_POST['recaptcha_response_field']))
		$resp=recaptcha_check_answer($private,$_SERVER['REMOTE_ADDR'],$_POST['recaptcha_challenge_field'],$_POST['recaptcha_response_field']);
	else
		throw new Exception('Please fill the security text!');
	if(!$resp->is_valid)
		throw new Exception('Enter the security text correctly!');
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
	require_once('assets/connectmysql.php');
	$c=connectMySQL('../');
	if(!c)
		throw new Exception('Sorry! Some internal database error occured! Please try again later.');
	$res=run_query("SELECT `name`,`email` FROM `members` WHERE `rollno`='$rn';",$c);
	$res=@mysql_fetch_row($res);
	if($res)
		throw new Exception("The Roll Number you entered is already Registered with the name '{$res[0]}'.");
	if($res[1]==$email){
		unset($email);
		throw new Exception("The email you entered is already associated with an acoount. Please choose another one.");
	}
	$res=run_query("SELECT `name`,`email` FROM `member_request` WHERE `rollno`='$rn';",$c);
	$res=@mysql_fetch_row($res);
	if($res)
		throw new Exception("A request with the roll Number you entered is Pending with the name '{$res[0]}'.");
	if($res[1]==$email){
		unset($email);
		throw new Exception("The email you entered is already associated with another Request. Please choose another one.");
	}
	$res=run_query("SELECT count(*) FROM `cr` WHERE `branch_code`='$branch' AND `course_code`='$course' AND `duration`>=$year;",$c);
	$res=@mysql_fetch_row($res);
	if(!$res[0])
		throw new Exception('The details you have entered are inconsistent. Please Check!');
	else{
		$res=run_query("INSERT INTO `member_request` VALUES ('$rn','$name','$branch','$pw','$year','$course','$email');",$c);
		unset($rn);
		unset($name);
		throw new Exception('Your request for roll number '.$rn.' has been registered with the Class Rep! Your account will be now be activated.');
	}
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
	<script type="text/javascript">
		var RecaptchaOptions={ theme : 'blackglass' };
	</script>
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
	<!--https-->
     <form action="" method="post" onsubmit="return registerSubmit()" >
	 <table border=0 >
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
	 </table>
	 <!-- recaptcha doesnt work in tables. I think due to iframes -->
	 <br/>Enter Security Text:<?php echo recaptcha_get_html($public); ?>
	 <input type="submit" value="Register" name="Submit"/></td>
     </form>
</div>
</div>
<div id="footer">
</div>
</body>
</html>