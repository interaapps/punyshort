<?php
/*
 *   Usage: loadCore()
 *   Description: Just loads the core scripts
 *
 */

spl_autoload_register(function($class) {
    if (file_exists("./".str_replace("\\","/",$class).".php"))
        @include_once "./".str_replace("\\","/",$class).".php";
});

//   Autoloading for app/controller   //
spl_autoload_register(function($class) {
    if (file_exists("./app/controller/".str_replace("\\","/",$class).".php"))
        @include_once "./app/controller/".str_replace("\\","/",$class).".php";
});

if(file_exists("conf.json")) {
    $conf = @json_decode(file_get_contents("conf.json"));
    if (isset($conf->debug)) {
        if ($conf->debug === true || ($conf->debug === "justtestserver" && php_sapi_name() == 'cli-server')) {
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
            set_error_handler("ulole\\core\\framework\\ErrorHandling::error");
            register_shutdown_function("ulole\\core\\framework\\ErrorHandling::fatalError");
        } elseif ($conf->debug = "php") {
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        }
    }
}


function loadCore() {
    require "ulole/core/Router.php";
    require "ulole/core/Init.php";
}
