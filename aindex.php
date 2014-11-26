<?php
$data = json_decode(file_get_contents("http://xpaw.ru/mcstatus/status.json"), true);
if ($data["report"]["skins"]["status"] == "down") {
    $isup = "<a href='http://xpaw.ru/mcstatus'><span style='color: red; font-weight: bold'>Skins server is down, site is in cache-only mode</span></a>";
} else {
    $isup = "<sup><a href='http://xpaw.ru/mcstatus'><span style='color: green'>Skins server is ".$data["report"]["skins"]["status"]."</span></a></sup>";
}
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="amain.css">
  </head>
  <body>
<!--    <a href="https://github.com/blha303/mcsanta">
      <img alt="Fork me on GitHub" src="https://s3.amazonaws.com/github/ribbons/forkme_right_darkblue_121621.png" style="position: absolute; top: 0; right: 0; border: 0;">
    </a> -->
    <div id="container">
 <h1 style="padding:5px;margin:5px">Minecraft Hatomator<sup><sup><a target="_blank" style="font-size: 5pt; text-decoration: none; color: black" href="http://www.reddit.com/r/Minecraft/comments/1rwuwo/i_made_a_site_to_easily_add_a_santa_hat_to_your/cds793d">[x]</a></sup></sup></h1>
      <span id="splash"><noscript>I'm dreaming of a Javascriptless Christmas...</noscript></span>
      <p id="skinsrvrstatus"><?php echo $isup; ?></p>
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
if (isset($_GET['refresh'])) {
  unlink(realpath(dirname(__FILE__)) ."/tmp/$user-santa.png");
  unlink(realpath(dirname(__FILE__)) ."/tmp/$user.png");
}
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
<p id="applyp"><a id="applylink" href="https://minecraft.net/profile/skin/remote?url=<?php echo $siteloc."/tmp/".$user; ?>-santa.png">Click here to apply your santa-hatted skin!</a><br>(Make sure to <a href="https://s3.amazonaws.com/MinecraftSkins/<?php echo $user; ?>.png" id="backuplink">click here first</a> to download your current skin, or you won't be able to get it back.)</p>
<div id="frame"><iframe src="skin/?user=<?php echo $user; ?>" title="skin" width="200px" height="200px" id="preview"></iframe>
<br><small>Skin preview by <a href="http://forums.bukkit.org/threads/web-html5-skin-viewer.4428/">earthiverse</a></small></div>
<p id='disclaimer'>This service is only good for ONE skin conversion per username. If you want to use this site again after changing your skin, you'll need to <a href="http://webchat.esper.net/?channels=#mcsanta">come in IRC and follow the instructions provided</a>. Thanks for your understanding. :) (The preview will not update, but the skin will be changed)</p>
<p id='disclaimer'>If the skin preview is invisible (or the head is black), your skin is incompatible with this site. You'll need to <a href="SantaHatTemplate.png">download the Santa Hat template</a> and apply it yourself using an <a href="http://www.getpaint.net/">offline editor</a>.</p>
<p id="backtohomepage"><a href="<?php echo $siteloc; ?>">Back to homepage</a></p>
<?php } else { ?>
<form method="GET">
<label for="user">Username</label>
<input id="user" type="text" name="user"><input type="submit" id="submit">
</form>
<?php if (isset($_GET['error'])) {
  echo '<div id="error">';
  if ($_GET['error'] == "char") { echo "Invalid characters provided."; }
  else if ($_GET['error'] == "haspaid") { echo "No Minecraft skin found for that username."; }
  echo '</div>';
} ?>
<p id="maynotwork">Tweet at <a href="https://twitter.com/blha303">@blha303</a> or join <a href="http://webchat.esper.net/?channels=#mcsanta">irc.esper.net #mcsanta</a> (<a href="irc://irc.esper.net/mcsanta">irc://</a>) for help.</p>
<?php } ?>
<p id="skincount"><b>Generated skins:</b> <?php include('tmp/count.php'); ?> <small>(<i><a href="https://twitter.com/blha303/status/411252299281858560">approx</a></i>)</small>&nbsp;&nbsp;
<a id="twitter" data-url="http://blha303.com.au/mcsanta" data-text="Check out this cool webapp for applying a Santa hat to your Minecraft skin! #mcsanta" href="https://twitter.com/share" data-related="blha303" data-via="blha303" class="twitter-share-button" data-lang="en" data-size="large">Tweet</a></p>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<script type="text/javascript">
splashlist = ["It's Christmas, yo.", "Hohoho!", "Getcha Santa hats here!",
"More fun than what your Grandma got you!", "Jingle bells, Batman smells!",
"Say it with diamond blocks!", "Don we now our red apparel!",
"At least it isn't socks.", "Tweeted by <a href='https://twitter.com/Marc_IRL'>Marc Watson</a> of Mojang!",
"missingno", "Front page of /r/Minecraft!", "Skindex hates it!", "I'm a span :)",
"Hey #minecraft!", "Hey #drtshock!", "Hey ShockNetwork!", "Hey PoweredByAwesome!",
"Now with background image!"];
document.getElementById('splash').innerHTML = splashlist[Math.floor(Math.random() * splashlist.length)];
</script>
<?php $ads = array(array("http://snw.io", "snw.png", "ShockNetwork"),
                   array("http://poweredbyawesome.net", "poweredbyawesome.png", "PoweredByAwesome"),
                   array("http://reddit.com/r/minecraftmario", "mariocraft.png", "MarioCraft"));
      $curad = $ads[array_rand($ads)]; ?>
<div class="ad" style="padding-top:5px; margin-left:auto; margin-right:auto; width:600px;"><center><a target="_blank" href="<?php echo $curad[0]; ?>" style="font-size: 8pt; text-decoration: none; color: black;"><img src="<?php echo $curad[1]; ?>" alt="Sponsor: <?php echo $curad[2]; ?>"><br>Supported by <?php echo $curad[2]; ?></a></a></div>
</div>
</body>
</html>
