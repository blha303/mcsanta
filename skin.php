<?php

// Using API documented at http://wiki.vg/Mojang_API
$time = time(); // Timestamp 
$error = false; // If an error occured somewhere
$ratelimit = false; // Ratelimited
$haspaid = true; // Has Premium account
$err_msg="Unknown Error";  // Default error message

// GET request to the url and set error values if needed
function get($url){
  $content = @file_get_contents($url); // '@' is to suppress error code
  global $error, $ratelimit, $err_msg; // ?
  if (strpos($http_response_header[0], "200")) { // Response OKAY
     return $content;
  } 
  elseif (strpos($http_response_header[0], "429")) { // Response TOO MANY REQUESTS
     $error = true;
     $ratelimit = true;
     $err_msg= "Ratelimited, try again in 1 minute";
      die();  // Can't continue 
   } 
   else{
     $error = true; // Just in case
     die ();  // Cant continue
  }
}

// -------------------------------


// Check if the user has a paid account
$user_haspaid = file_get_contents('http://www.minecraft.net/haspaid.jsp?user='.$user);
if ($user_haspaid == false){
  $haspaid=false;
  $err_msg=$user." is not a Premium Account.";
  die();  // If it is not a valid account, no sence in going on any further
}

// Get uuid of username
$profile = get("https://api.mojang.com/users/profiles/minecraft/".$user."?at=".$time);
$uuid = json_decode($profile)->id;

// Get profile info (including skin url)
$mc_profile = get("https://sessionserver.mojang.com/session/minecraft/profile/".$uuid);
$skin = json_decode($mc_profile);
$skin = base64_decode($skin->properties[0]->value); // 0 is always texture, 1 is cape
$skin = json_decode($skin);
$skin = $skin->textures->SKIN->url; // THIS is what we want, and is used in the
                                    // page that require()'s this.

 if ($skin == "") {
  // No idea why this could happen but just to be safe
  $error = true;
  die(); // Not really needed but you never know;
 }

?>



