<?php
require "ulole/CLI/Custom.php";

use ulole\core\classes\util\File;
use ulole\core\classes\util\JSON;
use ulole\core\classes\util\Str;
/*
    Here you can register functions for the ULOLE CLI!
    Executing: php ulole run <myFunction> (Here are your arguments (Starting with 3))
*/

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);// */

$CLI = new Custom();
$CLI->showArgsOnError = true;

$CLI->register("migration", function($args) {
    
    if (count($args) == 4) {
        $fileName = $args[3];
        $fileName[0] = strtoupper($args[3][0]);
        $fileName = $fileName."Table";
        $replaceWith = ["%classname%"=>$fileName, "%tablename%"=>$args[3]];
        File::write("databases/migrate/".$fileName.".php", 
        (new Str(File::get("ulole/CLI/GeneratorTemplates/Migration.tphp")))->replace($replaceWith)  );
        return "\033[92m᮰ Done\033[0m: Done!\n";
    } else 
        return "\033[91m᮰ ERROR\033[0m: php cli generate migration <TableName>\n";
}, "Generates a migration class in the database/migrate Folder");

$CLI->register("database", function($args) {
    
    if (count($args) == 4) {
        $fileName = $args[3];
        $fileName[0] = strtoupper($args[3][0]);
        $fileName = $fileName."Table";
        $replaceWith = ["%classname%"=>$fileName, "%tablename%"=>$args[3]];
        File::write("databases/".$fileName.".php", 
        (new Str(File::get("ulole/CLI/GeneratorTemplates/DatabaseTable.tphp")))->replace($replaceWith)  );
        return "\033[92m᮰ Done\033[0m: Done!\n";
    } else 
        return "\033[91m᮰ ERROR\033[0m: php cli generate database <TableName>\n";
}, "Generates a database class in the database Folder");

$CLI->register("webpack", function($args) {
        File::write("webpack.config.js", File::get("ulole/CLI/GeneratorTemplates/Webpack.tjs"));
        echo "WRITING INTO THE package.json\n";
        if (file_exists("package.json")) {
            $packagejson = JSON::parse(File::get("package.json"));
            $packagejson->devDependencies->{"css-loader"} = "^3.0.0";
            $packagejson->devDependencies->{"extract-text-webpack-plugin"} = "^v4.0.0-alpha.0";
            $packagejson->devDependencies->{"node-sass"} = "^4.12.0";
            $packagejson->devDependencies->{"sass-loader"} = "^7.1.0";
            $packagejson->devDependencies->{"webpack"} = "4.35.0";
            $packagejson->devDependencies->{"webpack-cli"} = "^3.3.4";
            File::write("package.json", json_encode($packagejson, JSON_PRETTY_PRINT));
        } else
            echo "package.json not found! Init it yourself!";
        return "\033[92m᮰ Done\033[0m: Done!\n";
}, "Generates a database class in the database Folder");
