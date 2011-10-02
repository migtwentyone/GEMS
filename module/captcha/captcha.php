<?php
	session_set_cookie_params(time()+30);
	session_start();
	$h=100;
	$w=300;
	$i=imagecreatetruecolor($w,$h);
	$colors[0]=imagecolorallocate($i, 150, 150, 150);	//bg: grey
	$colors[1]=imagecolorallocate($i, 0, 0, 0);			//black
	$colors[3]=imagecolorallocate($i, 200, 50, 50);		//red
	$colors[4]=imagecolorallocate($i, 0, 0, 255);		//blue
	$colors[5]=imagecolorallocate($i, 128, 0, 255);		//violet
	$lcolor=imagecolorallocate($i, 255, 255, 255);	//white
	$ccount=count($colors);
	imagefilledrectangle($i, 0, 0, $w-1, $h-1, $colors[0]);
	
	$charset="23456789ABCDEFGHJKLMNPQRSTUVWXY23456789";
	$charsetsize=strlen($charset);
	$font=mt_rand(1,14).".ttf";
	$fontsize=30;
	$size=mt_rand(5,8);
	
	$tw=imagettfbbox($fontsize, 0, $font, "C");
	$ty=($h+abs($tw[1]-$tw[7]))/2-5;
	$tw=abs($tw[2]-$tw[0]);
	$tx=($w-$tw*($size+1))/2;
	
	for($k=0; $k<10; ++$k)
		imageline($i,mt_rand(0,80),mt_rand(20,80),mt_rand(220,300),mt_rand(20,80),$lcolor);
	for($k=0; $k<$size; ++$k){
		$str=$charset[mt_rand(0,$charsetsize-1)];
		imagettftext($i, $fontsize, mt_rand(-20,20), $tx+$k*$tw, $ty, $colors[mt_rand(1,$ccount)], $font, $str);
		$res.=$str;
	}
	
	$_SESSION['captcha']=$res;
	header('Content-type: image/png');
	$s=imagepng($i);
	imagedestroy($i);
?>