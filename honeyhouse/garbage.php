<?php
/*delete stray session files*/
	$dir=scandir($_SERVER['TMP']);
	echo '<pre>';
	for($i=0;$dir[$i];++$i)
		if(preg_match('/^sess_[A-Za-z0-9]+/',$dir[$i])){
			$files[]=$dir[$i];
			$t=explode('_',$dir[$i],2);
			$sessions[]=$t[1];
			unlink($dir[$i]);
		}
	var_dump($files);
	var_dump($sessions);
?>