		<a class="changeskin" href="https://minecraft.net/profile/skin/remote?url=<?php echo $site_location."tmp/".$user; ?>-santa.png">
				Click here to apply your santa-hatted skin!
		</a>
		<p class="backup">(Make sure to <a href="<?php echo $site_location.'tmp/'.$user; ?>.png">
		 download your current skin</a>, or you won't be able to get it back)</p>
		
		<div id="frame">
			<iframe src="/mcsanta/skin/?user=<?php echo $user; ?>" title="skin" width="200px" height="200px" id="preview"></iframe>
			<br><small>Skin preview by <a href="http://forums.bukkit.org/threads/web-html5-skin-viewer.4428/">earthiverse</a></small>
		</div>

		<p id="disclaimer">This service is only good for ONE skin conversion per username. If you want to use this site again after changing 
			your skin, you'll need to <a href="http://webchat.esper.net/?channels=#mcsanta">come in IRC and follow the instructions provided</a>.
			 Thanks for your understanding. :)</p>
		<p id="disclaimer">If the skin preview is invisible (or the head is black), your skin is incompatible with this site. You'll need to 
			<a href="SantaHatTemplate.png">download the Santa Hat template</a> and apply it yourself using an <a href="http://www.getpaint.net/">offline editor</a>.</p>
		<p id="backtohomepage"><a href="<?php echo $site_location; ?>">Back to homepage</a></p>