<?php 
    // integer starts at 0 before counting
    $i = 0; 
    $dir = './tmp/';
    if ($handle = opendir($dir)) {
        while (($file = readdir($handle)) !== false){
            if (!in_array($file, array('.', '..')) && strpos($file, "-santa") !== FALSE && !is_dir($dir.$file)) 
                $i++;
        }
    }
    echo round($i);
