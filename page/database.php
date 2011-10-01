<?php
	require_once('page/connectmysql.php');
	$c=connectMySQL('');
	if(!$c)
		die('<br/>Error in connecting: '.mysql_error().' Please try installing again later!');
	
	try{
	$q='CREATE TABLE `members` (`userid` INT(10) NOT NULL AUTO_INCREMENT,`rollno` VARCHAR(12) NOT NULL,`name` VARCHAR(50) NOT NULL,`branch_code` INT(2) NOT NULL,`password` VARCHAR(32) NOT NULL,`year` INT(1) NOT NULL,`course_code` INT(2) NOT NULL,`contact` INT(15),PRIMARY KEY (`userid`),UNIQUE (`rollno`));';
	if(mysql_query($q))
		mysql_query("INSERT INTO `members` VALUES ('1000000000','0','Administrator','0','0','0','0','0');");
	else
		throw new Exception('<br/>Error creating Table members');
	$q='CREATE TABLE `cr_request` (`rollno` VARCHAR(12) NOT NULL,`name` VARCHAR(50) NOT NULL,`branch_code` INT(2) NOT NULL,`password` VARCHAR(32) NOT NULL,`year` INT(1) NOT NULL,`course_name` VARCHAR(50) NOT NULL,`duration` INT(1) NOT NULL,`contact` VARCHAR(15));';
	if(!mysql_query($q))
		throw new Exception('<br/>Error creating Table cr_request');
	$q='CREATE TABLE `member_request` (`rollno` VARCHAR(12) NOT NULL,`name` VARCHAR(50) NOT NULL,`branch_code` INT(2) NOT NULL,`password` VARCHAR(32) NOT NULL,`year` INT(1) NOT NULL,`course_code` INT(2) NOT NULL,`contact` VARCHAR(15));';
	if(!mysql_query($q))
		throw new Exception('<br/>Error creating Table member_request');
	$q='CREATE TABLE `br` (`userid` INT(10) NOT NULL,`branch_code` INT(2) NOT NULL,`branch_name` VARCHAR(70) NOT NULL,`passcode` VARCHAR(32) NOT NULL,UNIQUE (`branch_code`));';
	if(!mysql_query($q))
		throw new Exception('<br/>Error creating Table br');
	$q='CREATE TABLE `cr` (`userid` INT(10) NOT NULL,`course_code` INT(2) NOT NULL,`course_name` VARCHAR(50) NOT NULL,`duration` INT(1) NOT NULL,UNIQUE (`course_code`));';
	if(!mysql_query($q))
		throw new Exception('<br/>Error creating Table cr');
	$q='CREATE TABLE `alumni` (`userid` INT(10) NOT NULL,`company` VARCHAR(100),`post` VARCHAR(100));';
	if(!mysql_query($q))
		throw new Exception('<br/>Error creating Table alumni');
	$q='CREATE TABLE `interest` (`storyid` INT(10) NOT NULL AUTO_INCREMENT,`type` INT(1) NOT NULL,`userid` INT(10),PRIMARY KEY (`storyid`));';
	if(!mysql_query($q))
		throw new Exception('<br/>Error creating Table Interest');
	$q='CREATE TABLE `event` (`eventid` INT(10) NOT NULL AUTO_INCREMENT,`title` VARCHAR(50) NOT NULL,`time` INT(30) NOT NULL,`content` VARCHAR(1000) NOT NULL,`userid` INT(10),PRIMARY KEY (`storyid`));';
	if(!mysql_query($q))
		throw new Exception('<br/>Error creating Table event');
	$q='CREATE TABLE `score` (`storyid` INT(10) NOT NULL AUTO_INCREMENT,`branch_code` INT(2) NOT NULL,`points` INT(5) NOT NULL,`time` INT(30) NOT NULL,`eventid` INT(10),`comments` VARCHAR(200) NOT NULL,PRIMARY KEY (`storyid`));';
	if(mysql_query($q))
		mysql_query("INSERT INTO `score` VALUES('1000001000','0','0','0','0','0');");
	else
		throw new Exception('<br/>Error creating Table score');
	} catch(Exception $e){
		die($e->getMessage());
	}
	mysql_close($c);
	
	/*$q='CREATE TABLE `comments` (`commentid` INT(20) NOT NULL AUTO_INCREMENT,`content` VARCHAR(200) NOT NULL,`time` INT(30) NOT NULL,`likes` INT(10) NOT NULL,`unlikes` INT(10) NOT NULL,`userid` INT(10),PRIMARY KEY (`commentid`));';
	if(!mysql_query($q))
		throw new Exception('<br/>Error creating Table Comments');
	$q='CREATE TABLE `interest` (`commentid` INT(20) NOT NULL AUTO_INCREMENT,`type` INT(1) NOT NULL,`userid` INT(10),PRIMARY KEY (`storyid`));';
	if(!mysql_query($q))
		throw new Exception('<br/>Error creating Table Interest');*/
?>