<?php

// For when they try to run it from the browser ... 
if( ! isset($user)) {die('Naughty children dont get christmas presents!'); /* We dont want people loading this file by itself */}

$c = curl_init();

// Set some options
curl_setopt_array($c, array(
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_URL => "http://skins.minecraft.net/MinecraftSkins/".$user.".png",
    CURLOPT_FOLLOWLOCATION=> true
));
$skin = curl_exec($c);

$httpCode = curl_getinfo($c, CURLINFO_HTTP_CODE);

curl_close($c);


if($httpCode != 200) {
    header("Location: /mcsanta/?error=haspaid");
    die('t');
}

if (empty($user)){
	header("Location: /mcsanta/?error=nicetry");
   die('u');
}

if (isset($_GET['refresh']) && $user != "") {
  unlink(realpath(dirname(__FILE__)) ."/tmp/$user-santa.png");
  unlink(realpath(dirname(__FILE__)) ."/tmp/$user.png");
}

if ( ! file_exists(  realpath(dirname(__FILE__))."/tmp/".$user."-santa.png")  ) { 
	
	$file = fopen(  realpath(dirname(__FILE__))."/tmp/$user.png"  , "w");
	fwrite($file, $skin);
	fclose($file);


	$santatemplate = imagecreatefrompng(  realpath(dirname(__FILE__))."/SantaHatTemplate.png"  );
	imageAlphaBlending($santatemplate, true);
	imageSaveAlpha($santatemplate, true);
	$userskin = imagecreatefrompng(realpath(dirname(__FILE__)) ."/tmp/$user.png");
	imageAlphaBlending($userskin, true);
	imageSaveAlpha($userskin, true);
	imagecopy($userskin, $santatemplate, 0, 0, 0, 0, imagesx($userskin), imagesy($userskin));
	imagepng($userskin, realpath(dirname(__FILE__))."/tmp/$user-santa.png");
}

?>