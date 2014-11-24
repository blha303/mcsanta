<?php
$siteloc = "http://blha303.com.au/mcsanta";

if (isset($_GET['user']) && $_GET['user'] != "") {
if (!preg_match("/^[\w]{3,16}$/", $_GET['user'])) {
    header("Location: /mcsanta/?error=char");
    die();
}
$user = $_GET['user'];

$handle = curl_init("https://s3.amazonaws.com/MinecraftSkins/$user.png");
curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
$response = curl_exec($handle);
$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
if($httpCode != 200) {
    header("Location: /mcsanta/?error=haspaid");
    curl_close($handle);
    die();
}
curl_close($handle);
if (!file_exists(realpath(dirname(__FILE__)) ."/tmp/$user-santa.png")) {
$skinimage = file_get_contents("https://s3.amazonaws.com/MinecraftSkins/$user.png");
$fp = fopen(realpath(dirname(__FILE__)) ."/tmp/$user.png", "w");
fwrite($fp, $skinimage);
fclose($fp);
$santatemplate = imagecreatefrompng(realpath(dirname(__FILE__)) ."/SantaHatTemplate.png");
imageAlphaBlending($santatemplate, true);
imageSaveAlpha($santatemplate, true);
$userskin = imagecreatefrompng(realpath(dirname(__FILE__)) ."/tmp/$user.png");
imageAlphaBlending($userskin, true);
imageSaveAlpha($userskin, true);
imagecopy($userskin, $santatemplate, 0, 0, 0, 0, imagesx($userskin), imagesy($userskin));
imagepng($userskin, realpath(dirname(__FILE__)) ."/tmp/$user-santa.png");
} ?>
<a href="https://minecraft.net/profile/skin/remote?url=<?php echo $siteloc."/tmp/".$user; ?>-santa.png">Click here to apply your santa-hatted skin!</a><br>(Make sure to <a href="https://s3.amazonaws.com/MinecraftSkins/<?php echo $user; ?>.png">click here first</a> to download your current skin, or you won't be able to get it back.)<br>
<iframe src="skin/?user=<?php echo $user; ?>" title="skin" width="200px" height="200px"></iframe>
<br><small>Skin preview by <a href="http://forums.bukkit.org/threads/web-html5-skin-viewer.4428/">earthiverse</a></small>
<br><a href="<?php echo $siteloc; ?>">Back to homepage</a>
<?php } else { ?>
<h1>Minecraft skin santa hat automater</h1>
<form method="GET">
<input type="text" name="user"><input type="submit">
</form>
<?php if (isset($_GET['error'])) {
  if ($_GET['error'] == "char") { echo "Invalid characters provided."; }
  else if ($_GET['error'] == "haspaid") { echo "No Minecraft skin found for that username."; }
} ?>
<p>May not work properly if your skin doesn't have a transparent background, as the santa hat is overlayed over your existing skin. Tweet at <a href="https://twitter.com/blha303">@blha303</a> or join <a href="irc://irc.esper.net/mcsanta">irc.esper.net #mcsanta</a> for help.
<?php }
