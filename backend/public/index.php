<?php
session_start();

// Framework laden
$f3=require('../lib/base.php');

// Entwicklungsmodus aktivieren/ deaktivieren
$f3->set('DEBUG',1);

// Syntax für Suchmuster Version prüfen
if ((float)PCRE_VERSION<7.9)
	trigger_error('PCRE version is out of date');

// Konfiguration laden
$f3->config('../config.ini');

// Ordner durchsuchen und alle Klassen laden
foreach (scandir("../app/") as $file)
    if($file != "." && $file != ".." && $file != "appData" && $file != ".DS_Store")
        require_once "../app/".$file;

// Neue Instanz des Backends erzeugen
$App = new \renickbuettner\App\App($f3);

// App ausführen, Request verarbeiten
$f3->run();
