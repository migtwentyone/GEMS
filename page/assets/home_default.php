<?php
if(!defined('TRACK')){
	header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
	echo '<h1>403 Forbidden<h1><h4>You are not authorized to access the page.</h4>';
	echo '<hr/>'.$_SERVER['SERVER_SIGNATURE'];
	exit(1);
}
?>
<script type="text/javascript" src="../module/wysiwyg/whizzywig.js"></script>
<div id="branchinfo">
</div>

<div id="updates">
<h3>
	Updates By people
</h3>
<?php
$r=run_query("SELECT `updates`.*,`members`.`name`,`members`.`year`,`cr`.`course_name`,`br`.`branch_name` FROM `updates`,`members`,`br`,`cr` WHERE `updates`.`branch_code` IN ('0','$brcode') AND `updates`.`userid`=`members`.`userid` AND `br`.`branch_code`=`members`.`branch_code` AND `cr`.`course_code`=`members`.`course_code` ORDER BY `updates`.`time` DESC LIMIT 0,20 ;",$c);
echo '<ul>
';
while($res=mysql_fetch_assoc($r)){
	$content=htmlspecialchars_decode($res['content']);
	$time=date('F j, Y, g:i a',$res['time']);
	switch($res['year']){
	case '1': $year='First Year, '; break;
	case '2': $year='Second Year, '; break;
	case '3': $year='Third Year, '; break;
	case '4': $year='Fourth Year, '; break;
	case '5': $year='Fifth Year, '; break;
	}
	echo "<li><input type=\"hidden\" name=\"storyid\" value=\"{$res['storyid']}\" />
<div>
$content</div><br/>
By: <strong>{$res['name']}</strong> ($year{$res['course_name']}, {$res['branch_name']})<br/>At <em>$time</em><br/>
<a href=\"assets/interest.php?story={$res['storyid']}&action=1&channel=4\">Like</a> #{$res['likes']} <a href=\"assets/interest.php?story={$res['storyid']}&action=2&channel=4\">Unlike</a> #{$res['unlikes']}  <a href=\"assets/interest.php?story={$res['storyid']}&action=3&channel=4\">Neutral</a> #{$res['neutral']}
</li>";
}
echo '
</ul>';
?>
</div>

<div id="postupdates">
<form action="assets/register_update.php" method="post" onsubmit="return registerUpdate)">
	<textarea id="updatearea" name="update"></textarea>
	<script type="text/javascript" >makeWhizzyWig("updatearea","bold italic underline | undo redo | color hilite");</script>
	<br/>Visibility: <select size=1 name="scope" title="Select Visibility">
	<option value=0>All Branches</option>
	<option value=1 SELECTED>Only <?php echo $brname; ?></option>
	</select>
	<br/><input type="submit" value="Post" name="updateSubmit" />
</form>
</div>