<?php
/*Author @mogita
  DO WHATEVER THE FUCK YOU LIKE xD
*/

define("MG_TITLE", "MoGallery - mogita 的单页面 PHP 相册");
define("MG_HEADER", "mogallery");
define("MG_FOOTER", "版权所有 © 2014 <a href=\"http://mogita.com\">Mogita.com</a>。");
define("PIC_DIR", "gallery/*");

$imageDirectory = glob(PIC_DIR, GLOB_ONLYDIR);
$mgGalleryPageContent = "";

foreach($imageDirectory as $eachDirectory) {
	if (!file_exists($eachDirectory.'/thumb/')) mkdir($eachDirectory.'/thumb/');
	
	$mgGalleryPageContent .= '<div class="group clr">'.PHP_EOL."\t\t\t\t".'<div class="title">'.basename($eachDirectory).'</div>'.PHP_EOL."\t\t\t\t";
	
	$imageFile = glob($eachDirectory.'/*.[jJ][pP][gG]');
	if (!$imageFile or empty($imageFile)) {
		$mgGalleryPageContent .= '<div class="no_pic">No pictures</div>'.PHP_EOL."\t\t\t\t";
	} else {
		foreach($imageFile as $eachFile) {
			
		if (isset($_GET['action']) && $_GET['action'] == "rebuild-all") ak_img_resize($eachFile, $eachDirectory."/thumb/".basename($eachFile)."_thumb.jpg", 70, 70, "jpg");
			
		$mgGalleryPageContent .= '<div class="thumb"><table><tr><td><a href="'.$eachFile.'" rel="ibox" title=""><img src="'.$eachDirectory.'/thumb/'.basename($eachFile).'_thumb.jpg" style="max-width: 70px; max-height: 70px;" border="0" alt="" /></a></td></tr></table></div>'.PHP_EOL."\t\t\t\t";
		}
	}
	
	$mgGalleryPageContent .= '</div>'.PHP_EOL.PHP_EOL.PHP_EOL.PHP_EOL.PHP_EOL.PHP_EOL.PHP_EOL.PHP_EOL."\t\t\t\t";
}

// Adam Khoury PHP Image Function Library 1.0
// Function for resizing any jpg, gif, or png image files

function ak_img_resize($original, $new, $width, $height, $extension = "jpg") {
	list($widthOriginal, $heightOriginal) = getimagesize($original);
	$scaleRatio = $widthOriginal / $heightOriginal;
	
	if (($width / $height) > $scaleRatio) {
		$width = $height * $scaleRatio;
	} else {
		$height = $width / $scaleRatio;
	}
	
	$img = "";
	$extension = strtolower($extension);
	
	if ($extension == "gif") {
		$img = imagecreatefromgif($original);
	} elseif ($extension == "png") {
		$img = imagecreatefrompng($original);
	} else {
		$img = imagecreatefromjpeg($original);
	}
	
	$tci = imagecreatetruecolor($width, $height);
	
	imagecopyresampled($tci, $img, 0, 0, 0, 0, $width, $height, $widthOriginal, $heightOriginal);
	imagejpeg($tci, $new, 80);
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="zh-cn">
<head>
	<meta charset="UTF-8">
	<title><?php echo MG_TITLE; ?></title>
	<meta name="keywords" content="MoGallery,图库,相册,影集,图片,mogita,gallery,单文件影集,单文件相册,程序,php" />
	<meta name="description" content="Mogita 的单文件 php 相册程序" />
	<style type="text/css">
		body {
			background: #ffffff;
			font-size: 14px;
			font-family: "Hiragino Sans GB", sans-serif;
			color: #5A5B5A;
		}
		table {
			border-collapse: collapse;
			border-spacing: 0;
		}
		a {
			text-decoration: none;
		}
		th, td {
			border-collapse: collapse;
			vertical-align: top;
		}
		#wrapper {
			margin: 0 auto;
			width: 985px;
		}
		#header {
			height: auto;
			font-size: 4em;
			display: block;
			float: left;
			text-transform:uppercase;
		}
		#header a {
			color: #5A5B5A;
		}
		#header a:hover {
			color: #5A5B5A;
			text-decoration: none;
		}
		#header a:visited {
			color: #5A5B5A;
		}
		#content {
			width: 970px;
		}
		#footer {
			margin: 5px 0 0 0;
			font-size: 0.8em;
		}
		#footer a {
			color: #5A5B5A;
		}
		#footer a:hover {
			color: #5A5B5A;
			text-decoration: none;
		}
		#footer a:visited {
			color: #5A5B5A;
		}
		div.thumb {
			margin: 0px 15px 15px 0px;
			background-color: #F0EEEC;
			display: block;
			float: left;
			width: 76px;
			height: 76px;
			text-align: center;
			vertical-align: middle;			
		}
		div.title {
			margin: 0px 15px 10px 0px;
			width: 100%;
			display: block;
			float: left;
		}
		div.thumb table {
			margin: 0 auto;
			width: 76px;
			height: 76px;
		}
		div.thumb tr {
			
		}
		div.thumb td {
			text-align: center;
			vertical-align: middle;
		}
		div.no_pic {
			display: block;
			float: left;
			height: 76px;
		}
		div.group {
			margin-bottom: 35px;
			padding-left: 25px;
			border-left: 5px solid #EEE8E2;
			height: auto;
			width: 100%;
		}
		.clr {
			display: inline-table;
			min-height: 1%;
		}
	</style>
	<script type="text/javascript" src="js/ibox/ibox.js"></script>
	<link rel="stylesheet" href="js/ibox/skins/lightbox/lightbox.css" type="text/css" 
media="screen"/>

</head>

<body>
	<div id="wrapper">
		<div id="header" class="clr">
			<p><?php echo '<a href="'.$_SERVER['SCRIPT_NAME'].'">'.htmlspecialchars(MG_HEADER, ENT_QUOTES).'</a>'; ?></p>
		</div>
		
		<div id="content" class="clr">
				<?php echo $mgGalleryPageContent; ?>
				
		</div>
		
		<div id="footer" class="clr">
			<p><?php echo MG_FOOTER; ?></p>
		</div>
	</div>
</body>
</html>
