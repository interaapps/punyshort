<?php
function error($errno, $errstr, $errfile, $errline) {
    echo Colors::BG_RED.Colors::BLUE." ".$errstr." ".Colors::ENDC;
}

function fatal() {
    set_error_handler("error");
    register_shutdown_function("fatal");
    $error = error_get_last();
    echo Colors::BG_RED.Colors::BLUE." ".$error["message"]." ".Colors::ENDC;
    //repl();
}
require "ulole/loader.php";
loadCore();
while(true) {
    set_error_handler("error");
    register_shutdown_function("fatal");
    echo Colors::YELLOW."\n| >>>".Colors::ENDC;
    $command = readline(" ");
    echo Colors::ENDC;
    if ($command == "exit") exit();
    try {
        if ( strpos($command, ";") === false && strpos($command, "return") === false && strpos($command, "echo") === false )
            $command = "return ".$command;
        echo eval("" . $command . ";");
    } catch (Exception $e) { /**/ }
}
