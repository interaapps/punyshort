<?php
chdir('..');

// IMPORTING STANDARD LIBS
require "ulole/loader.php";

loadCore();

// Initializing routings
$router = new Router();
require "app/route.php";
$router->setDirectories($views_dir, $templates_dir);

$router->route();