<?php

// Kickstart the framework
$f3=require('../lib/base.php');


$f3->set('DEBUG',1);
if ((float)PCRE_VERSION<7.9)
	trigger_error('PCRE version is out of date');

// Load configuration
$f3->config('../config.ini');

foreach (scandir("../app/") as $file)
    if($file != "." && $file != ".." && $file != "appData" && $file != ".DS_Store")
        require_once "../app/".$file;

$App = new \renickbuettner\App\App($f3);

$f3->run();
