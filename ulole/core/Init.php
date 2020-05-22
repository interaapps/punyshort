<?php

/*
    Init.php
    Initializing configs and more
*/

global $ULOLE_CONFIG, $ULOLE_CONFIG_ENV, $SQL_DATABASES, $TESTSERVER;
$ULOLE_CONFIG = json_decode(file_get_contents("conf.json"));
\ulole\Config::$config = $ULOLE_CONFIG;

\ulole\core\classes\Lang::setLang((isset($ULOLE_CONFIG->options->defaultlang)) ? $ULOLE_CONFIG->options->defaultlang : "en");

if (!isset($TESTSERVER) || (isset($TESTSERVER) && $TESTSERVER == false))
    $TESTSERVER = false;

if ((isset($ULOLE_CONFIG->options->detectlanguage) ? $ULOLE_CONFIG->options->detectlanguage : false)) {
    if (\file_exists("resources/languages/".substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2).".json"))
    \ulole\core\classes\Lang::setLang(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
}

if ((isset($ULOLE_CONFIG->options->autoCompileOnDebug) ? $ULOLE_CONFIG->options->autoCompileOnDebug : false) && $TESTSERVER) {
    require "ulole/CLI/Compile.php";
    @ulole\CLI\Compile::compileDir('resources/compile/css/compile.json', "resources/compile/css");
    @ulole\CLI\Compile::compileDir('resources/compile/js/compile.json', "resources/compile/js");
    @ulole\CLI\Compile::compileViews("resources/compile/views/", "resources/views/", false);
}

$SQL_DATABASES = [];

$ULOLE_CONFIG_ENV = "";
if (file_exists("env.json")) {
    $ULOLE_CONFIG_ENV = json_decode(file_get_contents("env.json"));
    \ulole\Config::$env = $ULOLE_CONFIG_ENV;
    if (isset($ULOLE_CONFIG_ENV->databases)) {
        if (file_exists("modules/uloleorm/InitDatabases.php")) {
            if (class_exists("modules\uloleorm\InitDatabases")) {
                foreach ($ULOLE_CONFIG_ENV->databases as $db=> $values) {
                    @modules\uloleorm\InitDatabases::init($db, $values);
                }
            }
        }
    }
}

if (file_exists("initscripts.json")) {
    try {
        $config_plugins = json_decode(file_get_contents("initscripts.json"));
        if (isset($config_plugins->initscripts)) 
            foreach ($config_plugins->initscripts as $script)
                @include($script);
    } catch(Exception $e) {}
}


function defaultValue($var, $default){
    return isset($var) && $var !== NULL && $var !== null ? $var : $default;
}