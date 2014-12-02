<?php

if (isset($_GET['pass']) && !empty($_GET['pass']) && $_GET['pass'] == "pumpkinpie" && isset($_GET['user']) && !empty($_GET['user'])) {
	@unlink(realpath(dirname(__FILE__)) ."/tmp/".$_GET['user']."-santa.png");
	@unlink(realpath(dirname(__FILE__)) ."/tmp/".$_GET['user'].".png");

	// Functions not created by me
	// LINK
	include_once('./skin/backend/rmdir.php'); // Script found on php.net that removes all the files in a folder, then the folder itself
	@rrmdir('./skin/images/skins/'.$_GET['user']);
	header("Location: /mcsanta/?user=".$_GET['user']);
}
else {
	die ('Naughty boys and girls get coals in their stockings!!!');
}