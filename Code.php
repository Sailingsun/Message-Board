<?php
session_start();
/*验证码*/
//获取随机数
	$num = 4;    //验证码个数
	$type = 2;    //验证码组合方式
	function getCode($num,$type){
		$str = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$t = array('9','35',strlen($str)-1);	
		for($i = 0; $i < $num; $i++){
			$s .= $str[rand('0',$t[$type])];
		}
		return $s;
	}
	$str = getCode($num,$type);
	$_SESSION['code'] = $str;
//	var_dump($str);
//做画布
	$width = $num*20; $height = 30;
	$im = imagecreatetruecolor($width,$height);
//设定颜色
	$bg = imagecolorallocate($im,220,220,220);
	for($i = 0; $i < $num; $i++){
		$c[$i] = imagecolorallocate($im,rand(0,180),rand(0,180),rand(0,180));
	}
//开始绘画
	imagefill($im,0,0,$bg);
	imagerectangle($im,0,0,$width-1,$height-1,$c[0]);
//绘制验证码内容
	for($i = 0; $i < $num; $i++){
		imagettftext($im,18,rand(-40,40),5+18*$i,24,$c[$i],"STXINWEI.TTF",$str[$i]);
	}
//添加干扰项
	for($i = 0; $i < 200; $i++){
		$c = imagecolorallocate($im,rand(0,255),rand(0,255),rand(0,255));
		imagesetpixel($im,rand(0,$width),rand(0,$height),$c);
	}
	for($i = 0; $i < 4; $i++){
		$c = imagecolorallocate($im,rand(0,255),rand(0,255),rand(0,255));
	imageline($im,rand(0,$width),rand(0,$height),rand(0,$width),rand(0,$height),$c);
	}
//输出图片
	ob_clean();
	header("Content-Type:image/png");
	imagepng($im);
//销毁画布	
	imagedestroy($im);

	
?>