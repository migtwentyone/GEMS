<?php
if(!defined('TRACK')){
	header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
	echo '<h1>403 Forbidden<h1><h4>You are not authorized to access the page.</h4>';
	echo '<hr/>'.$_SERVER['SERVER_SIGNATURE'];
	exit(1);
}
//discuss=threadid
//page=pageno
echo '<script type="text/javascript" src="../module/wysiwyg/whizzywig.js"></script>';
$threadid=intval($_GET['discuss']);
echo '<div id="comments">';
try{
	if($threadid){
	
	$res=run_query("SELECT `branch_code`,`thread` FROM `threads` WHERE `threadid`='$threadid';",$c);
	$res=mysql_fetch_row($res);
	if($res[0]!=$brcode)
		throw new Exception('Sorry! You are not authorised to view this thread!');
	$r=run_query("SELECT `comments`.*,`members`.`name`,`members`.`type` FROM `comments`,`members` WHERE `comments`.`threadid`='$threadid' AND `comments`.`userid`=`members`.`userid` ORDER BY `comments`.`time` DESC LIMIT 0,20 ;",$c);
	echo '
<h3><em>Thread:</em>'.htmlspecialchars_decode($res[1]).'</h3><ul>
';
	while($res=mysql_fetch_assoc($r)){
		$content=htmlspecialchars_decode($res['content']);
		$time=date('F j, Y, g:i a',$res['time']);
		switch ($res['type']){
		case 0: $type='Admin'; break;
		case 1: $type='Branch Rep'; break;
		case 2: $type='Class Rep'; break;
		case 3: $type='Alumni'; break;
		case 4: $type='Member';
		}
		echo "<li><input type=\"hidden\" name=\"storyid\" value=\"{$res['storyid']}\" />
<div>
$content</div><br/>
Posted by: <strong>{$res['name']}</strong> ($type) at <em>$time</em><br/>
<a href=\"assets/interest.php?story={$res['storyid']}&action=1&channel=1\">Like</a> #{$res['likes']} <a href=\"assets/interest.php?story={$res['storyid']}&action=2&channel=1\">Unlike</a> #{$res['unlikes']}  <a href=\"assets/interest.php?story={$res['storyid']}&action=3&channel=1\">Neutral</a> #{$res['neutral']}
</li>";
	}
	echo '
</ul>';
	} else {
	$r=run_query("SELECT `threads`.`threadid`,`threads`.`thread`,`threads`.`created`,`members`.`name`,`members`.`type` FROM `threads`,`members` WHERE `threads`.`branch_code`='$brcode' AND `members`.`userid`=`threads`.`userid` ORDER BY `threads`.`time` DESC LIMIT 0,10;",$c);
	echo '<ul>
';
	while($res=mysql_fetch_row($r)){
		$thread=htmlspecialchars_decode($res[1]);
		switch ($res[4]){
		case 0: $type='Admin'; break;
		case 1: $type='Branch Rep'; break;
		case 2: $type='Class Rep'; break;
		case 3: $type='Alumni'; break;
		case 4: $type='Member';
		}
		$time=date('F j, Y, g:i a',$res[2]);
		echo "<li>
<a href=\"home.php?discuss={$res[0]}\">$thread</a><br/>
Created by <strong>{$res[3]}</strong>, <em>$type</em> at $time.
</li>";
	}
	echo '
</ul>';
	}
} catch(Exception $e){
	echo 'An Error Occured: '.$e->getMessage();
}
echo '
</div>
';
if($threadid){ ?>
<div id="newcomment">
<form action="assets/register_comment.php" method="post" onsubmit="return registerComment()">
<input type="hidden" name="threadid" value="<?php echo $threadid; ?>" />
<textarea id="commentarea" name="comment" style="width:400px; height:100px">
</textarea>
<script type="text/javascript" >makeWhizzyWig("commentarea","formatblock fontname fontsize newline bold italic underline  | number bullet | undo redo | color hilite rule | link image table"); </script>
<input type="submit" value="Post" name="commentSubmit" />
</form>
</div>
<?php } else { ?>
<div id="newthread">
<form action="assets/register_comment.php" method="post" onsubmit="return registerThread()">
<input type="text" name="thread" />
<input type="submit" name="threadSubmit" value="Create Thread" />
</form>
</div>
<?php } ?>
