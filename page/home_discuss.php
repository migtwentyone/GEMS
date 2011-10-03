<?php
if(!defined('TRACK')){
	header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
	echo '<h1>403 Forbidden<h1><h4>You are not authorized to access the page.</h4>';
	echo '<hr/>'.$_SERVER['SERVER_SIGNATURE'];
	exit(1);
}
//commentSubmit
?>
<script type="text/javascript" src="../module/wysiwyg/whizzywig.js"></script>
<div id="comments">
<?php
echo '<ul>';
echo '</ul>';
?>
</div>
<div id="commententry">

<form action="register_comment.php" method="post" onsubmit="return registerComment()">
<textarea id="commentarea" name="comment" style="width:400px; height:100px">
</textarea>
<script type="text/javascript" >makeWhizzyWig("commentarea","formatblock fontname fontsize newline bold italic underline  | number bullet | undo redo | color hilite rule | link image table"); </script>
<input type="submit" value="Post" name="commentSubmit" />
</form>
</div>