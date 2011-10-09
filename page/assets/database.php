<?php
	if(!defined('TRACK')){
	header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
	echo '<h1>403 Forbidden<h1><h4>You are not authorized to access the page.</h4>';
	echo '<hr/>'.$_SERVER['SERVER_SIGNATURE'];
	exit(1);
	}
	require_once('page/assets/connectmysql.php');
	$c=connectMySQL('');
	if(!$c)
		die('<br/>Error in connecting: '.mysql_error().' Please try installing again later!');
	
	try{
	$q='CREATE TABLE `members` (`userid` INT(10) NOT NULL AUTO_INCREMENT,`rollno` VARCHAR(12) NOT NULL,`name` VARCHAR(50) NOT NULL,`branch_code` INT(2) NOT NULL,`password` VARCHAR(32) NOT NULL,`year` INT(1) NOT NULL,`course_code` INT(2) NOT NULL,`time` VARCHAR(15) NOT NULL,`email` VARCHAR(70) NOT NULL,`contact` VARCHAR(15),`type` INT(1) NOT NULL,PRIMARY KEY (`userid`,`rollno`),UNIQUE (`rollno`));';
	//0-admin, 1-BR, 2-CR, 3-alumni, 4-MEM
	run_query($q,$c);
	run_query("INSERT INTO `members` VALUES('1000000000','0','Administrator','0','0','0','0','0','0','0','0');",$c);
	$q='CREATE TABLE `br` (`userid` INT(10) NOT NULL,`branch_code` INT(2) NOT NULL,`branch_name` VARCHAR(70) NOT NULL,`passcode` VARCHAR(32) NOT NULL,PRIMARY KEY (`userid`),UNIQUE (`branch_code`));';
	run_query($q,$c);
	$q='CREATE TABLE `cr` (`userid` INT(10) NOT NULL,`course_code` INT(2) NOT NULL,`course_name` VARCHAR(50) NOT NULL,`branch_code` INT(2) NOT NULL,`duration` INT(1) NOT NULL,PRIMARY KEY (`userid`),UNIQUE (`course_code`));';
	run_query($q,$c);
	$q='CREATE TABLE `alumni` (`userid` INT(10) NOT NULL,`company` VARCHAR(100),`post` VARCHAR(100),PRIMARY KEY (`userid`));';
	run_query($q,$c);
	$q='CREATE TABLE `cr_request` (`rollno` VARCHAR(12) NOT NULL,`name` VARCHAR(50) NOT NULL,`branch_code` INT(2) NOT NULL,`password` VARCHAR(32) NOT NULL,`year` INT(1) NOT NULL,`course_name` VARCHAR(50) NOT NULL,`email` VARCHAR(70) NOT NULL,`duration` INT(1) NOT NULL,`contact` VARCHAR(15));';
	run_query($q,$c);
	$q='CREATE TABLE `member_request` (`rollno` VARCHAR(12) NOT NULL,`name` VARCHAR(50) NOT NULL,`branch_code` INT(2) NOT NULL,`password` VARCHAR(32) NOT NULL,`year` INT(1) NOT NULL,`course_code` INT(2) NOT NULL,`email` VARCHAR(70) NOT NULL);';
	run_query($q,$c);
	$q='CREATE TABLE `interest` (`storyid` INT(10) NOT NULL,`activity` INT(1) NOT NULL,`type` INT(1) NOT NULL,`userid` INT(10) NOT NULL);';
	//types... 1:comments, 2: events 3:scores, 4: update
	run_query($q,$c);
	$q='CREATE TABLE `event` (`storyid` INT(10) NOT NULL AUTO_INCREMENT,`title` VARCHAR(50) NOT NULL,`topic` VARCHAR(50) NOT NULL,`time` VARCHAR(15) NOT NULL,`content` VARCHAR(1000) NOT NULL,`branch_code` INT(2),`likes` INT(10) NOT NULL,`unlikes` INT(10) NOT NULL,`neutral` INT(10) NOT NULL,PRIMARY KEY (`storyid`));';
	run_query($q,$c);
	$q='CREATE TABLE `score` (`storyid` INT(10) NOT NULL AUTO_INCREMENT,`branch_code` INT(2) NOT NULL,`points` INT(5) NOT NULL,`time` VARCHAR(15) NOT NULL,`eventid` INT(10),`comments` VARCHAR(200) NOT NULL,`likes` INT(10) NOT NULL,`unlikes` INT(10) NOT NULL,`neutral` INT(10) NOT NULL,PRIMARY KEY (`storyid`));';
	run_query($q,$c);
	$q='CREATE TABLE `threads` (`threadid` INT(10) NOT NULL AUTO_INCREMENT,`branch_code` INT(2),`thread` VARCHAR(100),`time` VARCHAR(15) NOT NULL,`created` VARCHAR(15) NOT NULL,`userid` INT(10) NOT NULL,PRIMARY KEY (`threadid`));';
	run_query($q,$c);
	$q='CREATE TABLE `comments` (`storyid` INT(10) NOT NULL AUTO_INCREMENT,`threadid` INT(10),`content` VARCHAR(500) NOT NULL,`time` VARCHAR(15) NOT NULL,`userid` INT(10) NOT NULL,`likes` INT(10) NOT NULL,`unlikes` INT(10) NOT NULL,`neutral` INT(10) NOT NULL,PRIMARY KEY (`storyid`));';
	run_query($q,$c);
	$q='CREATE TABLE `updates` (`storyid` INT(10) NOT NULL AUTO_INCREMENT,`content` VARCHAR(500) NOT NULL,`time` VARCHAR(15) NOT NULL,`userid` INT(10) NOT NULL,`branch_code` INT(2),`likes` INT(10) NOT NULL,`unlikes` INT(10) NOT NULL,`neutral` INT(10) NOT NULL,PRIMARY KEY (`storyid`));';
	run_query($q,$c);
	} catch(Exception $e){
		die($e->getMessage());
	}
	mysql_close($c);
?>