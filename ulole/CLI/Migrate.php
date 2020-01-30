<?php
require "ulole/CLI/Custom.php";
require "ulole/core/Init.php";
/*
    Here you can register functions for the ULOLE CLI!
    Executing: php ulole run <myFunction> (Here are your arguments (Starting with 3))
*/

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);// */

$CLI = new Custom();
global $fromCLI_Database;




// php cli migrate database <TABLE> <DBNAME>
$CLI->register("database", function($args) {
    if (!isset($args[4]))
        $args[4] = "main";
    if (count($args) == 5) {
        global $fromCLI_Database;
        if (isset(\modules\uloleorm\SQL::$databases[$args[4]])) {
            $fromCLI_Database = \modules\uloleorm\SQL::$databases[$args[4]];
            echo "\n\nSQL Query:\n";
            eval('(new \databases\migrate\\'.$args[3].'Table())->migrateFromCLI($execute=0);');
            echo "\n\nDo you really want to insert into the ".$args[4]." connection the Table? [YES/no]\n";
            $accept = readline();
            
            if (strtolower($accept)=="yes" || strtolower($accept)=="y" || strtolower($accept)=="")
                eval('(new \databases\migrate\\'.$args[3].'Table())->migrateFromCLI();');
            else
                echo "Not executed";
        } else 
            echo "DATABASE ".$args[4]. " NOT FOUND";

    } else {
        echo "err";
    }
    return "";
});

$CLI->register("update", function($args) {
    if (!isset($args[4]))
        $args[4] = "main";
    if (count($args) == 5) {
        global $fromCLI_Database;
        if (isset(\modules\uloleorm\SQL::$databases[$args[4]])) {
            $fromCLI_Database = \modules\uloleorm\SQL::$databases[$args[4]];
            echo "\n\nWARNING!: This Method to update is very experimental. 
            Backup your Table before doing this! The Table that will be affected: ".$args[4]."
            What does it to?:
            It creates a backup query (Just for the rows)
            It drops (removes) the Table
            It remigrates it
            It insert the backup query
            
            [Enter y to accept]\n";
            $accept = readline();
            
            if (strtolower($accept)=="y")
                eval('(new \databases\migrate\\'.$args[3].'Table())->updateFromCLI();');
            else
                echo "Not executed";
        } else 
            echo "DATABASE ".$args[4]. " NOT FOUND";

    } else {
        echo "err";
    }
    return "";
});