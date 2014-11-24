<?php

if (isset($_GET['s']) && isset($_GET['auth']) && $_GET['auth'] == "quack") {
  if ( ereg( "\.\./", $_GET['s'] ) || ereg( "\.\.\\\\", $_GET['s'] ) || ereg( "/", $_GET['s'] ) || $_GET['s'] == "") {
    print "Hack attempt, your attempt together with your IP-address has been registered in system logs. Have a nice day.";
    exit();
  }
  $out = system('rm -rf /home/blha/sites/blha303.com.au/mcsanta/tmp/'.escapeshellcmd($_GET['s']).'*');
  header("Location: http://blha303.com.au/mcsanta/?user=".$_GET['s']."&forward");
} else {
  echo "Nope.";
}
