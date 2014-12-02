<?php

	$site_location = "http://blha303.com.au/mcsanta/";
	//$site_location = "http://mcsanta.localhost/mcsanta/";



	// Using Mojang's API since xPaw blocks us :'(
	$status_data = json_decode(file_get_contents("http://status.mojang.com/check"), true);
	$status = "ERROR";

	// Loop through the stuff, since I don't know if it will allways be in
	// the same place in the array
	foreach ($status_data as $key => $value) {	
		if ( array_key_exists('skins.minecraft.net',$status_data[$key]) ) {
			$status = $status_data[$key]['skins.minecraft.net'];
			break; // Stop foreach loop
		}
	}

	$status_code = $status;
	if ($status == "green") {$status = "Online";}
	if ($status == "yellow") {$status = "Unstable";}
	if ($status == "red") {$status = "Offline, site in cache mode";}





	if (isset($_GET['user']) && ! empty($_GET['user'])) {

		$user = $_GET['user'];

		require('skin_work.php');

	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>The Minecraft Hatomator!</title>
    <meta name="description" content="The Minecraft Hatomator. Add a Santa Hat to your Minecraft character easily!">


    <link rel="stylesheet" type="text/css" href="/mcsanta/main.css"
</head>
<body>
	
	<section class="fork-me">
		<a href="https://github.com/blha303/mcsanta">
	   		<img alt="Fork me on GitHub" src="https://s3.amazonaws.com/github/ribbons/forkme_right_darkblue_121621.png" style="">
    	</a>
   	</section>
	
	<section id="container">
		<h1>Minecraft Hatomator!</h1>


		<section id="splash"><noscript>I'm dreaming of a Javascriptless Christmas...</noscript></section>


		<?php

		//Decide what content to show/load


		if (isset($_GET['user']) && $_GET['user'] != "") {

			// Check the suplied username to see if it can be valid
			if (!preg_match("/^[\w]{3,16}$/", $_GET['user'])) {
			    header("Location: /mcsanta/?error=char");
			    die(); // We're redirecting, why would we prosess further ?
			}
			$user = $_GET['user'];


			$error = false;
			
			if ($error !== false)
			{
				echo "SORCERY!!!!! NOOOOOOoooooo<sub>oo<sub>ooooo<sub>oooooooooo</sub></sub></sub>";
				die();
			}

			include './template/skin_show.php';

		}

		else {

			include './template/default.php';
		}



		// Error Handeling

		if (isset($_GET['error'])) {
		  echo '<section id="error">';
			  if ($_GET['error'] == "char") { echo "Invalid characters provided."; }
			  elseif ($_GET['error'] == "haspaid") { echo "No Minecraft skin found for that username."; }
			  elseif ($status_code != "green") {echo "Mojang skin servers seem to be ".$status.". Please try again later";}
			  else { echo "An unknown error has occured, please try again later";}
		  echo '</section>';
		} 
?>
		

		<section id="info">
			<p class="contact">Tweet at <a href="https://twitter.com/blha303">@blha303</a> or join 
			<a href="http://webchat.esper.net/?channels=#mcsanta">irc.esper.net #mcsanta</a> 
			(<a href="irc://irc.esper.net/mcsanta">irc://</a>) for help.</p>

			
		</section>
		

		<section id="ad">
			<?php $ads = array(
								array("http://snw.io", "snw.png", "ShockNetwork"),
                   				array("http://poweredbyawesome.net", "poweredbyawesome.png", "PoweredByAwesome"),
                   				array("http://reddit.com/r/minecraftmario", "mariocraft.png", "MarioCraft")
                   			   );
      		$curad = $ads[array_rand($ads)]; 
      		?>
      			<a target="_blank" href="<?php echo $curad[0]; ?>">
				<img src="<?php echo '/mcsanta/ads/'.$curad[1]; ?>" alt="Sponsor: <?php echo $curad[2]; ?>">
				<br/>
				Supported by <?php echo $curad[2]; ?>
			</a>
		</section>


<a id="twitter" data-url="http://blha303.com.au/mcsanta" data-text="Check out this cool webapp for applying a Santa hat to your Minecraft skin! #mcsanta" href="https://twitter.com/share" data-related="blha303" data-via="blha303" class="twitter-share-button" data-lang="en" data-size="large">Tweet</a></p>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	
			<div id="skincount"><b>Generated skins:</b> <?php include('./count.php'); ?> </div>



		<div class="server-status mc_font">Skin Server Status: <span class="status-<?php echo $status_code; ?>"><?php echo $status; ?></span></span></div>
	
	</section>
	<script type="text/javascript">
		splashlist = [	"It's Christmas, yo.", 
						"Hohoho!", 
						"Getcha Santa hats here!",
						"More fun than what your Grandma got you!",
						"Jingle bells, Batman smells!",
						"Say it with diamond blocks!", 
						"Don we now our red apparel!",
						"At least it isn't socks.", 
						"Tweeted by <a href='https://twitter.com/Marc_IRL'>Marc Watson</a> of Mojang!",
						"missingno", 
						"Front page of /r/Minecraft!",
						"Skindex hates it!", 
						"I'm a span :)",
						"Hey #minecraft!", 
						"Hey #drtshock!", 
						"Hey ShockNetwork!",
						"Hey PoweredByAwesome!",
						"Now with background image!",
						"Open Source!",
						"import * from Splash_Text",
						"Coded by Monkeys",
						"SANTAFY ALL THE THINGS!"
						];

		document.getElementById('splash').innerHTML = splashlist[Math.floor(Math.random() * splashlist.length)];
	</script>
</body>
</html>