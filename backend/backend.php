<?php

foreach (scandir("components") as $source)
    require $source;

$App = new \renickbuettner\App\App();
