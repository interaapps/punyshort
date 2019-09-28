<?php
/**
 * Not finished yet!
 */
function repl() {
    set_error_handler("error");
    register_shutdown_function("fatal");
    echo Colors::YELLOW."\n| >>>".Colors::BLUE;
    $command = readline(" ");
    echo Colors::ENDC;
    if ($command == "exit") exit();
    try {
        eval("" . $command . ";");
    } catch (Exception $e) { /**/ }
    repl();
}

function error($errno, $errstr, $errfile, $errline) {
    echo Colors::BG_RED.Colors::BLUE." ".$errstr." ".Colors::ENDC;
}

function fatal() {
    set_error_handler("error");
    register_shutdown_function("fatal");
    $error = error_get_last();
    echo Colors::BG_RED.Colors::BLUE." ".$error["message"]." ".Colors::ENDC;
    repl();
}

if ($runRepl) {
    require "ulole/loader.php";
    loadCore();
    repl();
}