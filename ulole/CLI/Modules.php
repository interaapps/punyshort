<?php
require "ulole/CLI/Custom.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);// */

$CLI = new Custom();

/*function deleteDir($dirPath) {
    if (!is_dir($dirPath))
        throw new InvalidArgumentException("$dirPath must be a directory");
    
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) 
        if (is_dir($file))
            deleteDir($file);
        else 
            unlink($file);
        
    rmdir($dirPath);
}

function install($type, $module) {
    $useNameInstead = false;
    if (strpos($type, ":") !== false) {
        $useNameInstead = "modules/".getStringBetween($type, ":", "");
        $type = str_replace( (":".getStringBetween($type, ":", "")), "", $type);
    }
    
    $opts = [
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: request"
        ]
    ];
    $context = stream_context_create($opts);
    if ($type==strtolower("github")) {
        $link = str_replace("https://github.com/", "", $module);
        $repos = json_decode(file_get_contents("https://api.github.com/repos/".$link, false, $context));;
        $downloadLink = "https://api.github.com/repos/".$link."/zipball/master";
        $enddir = 'modules/'.$repos->name;
    } elseif ($type==strtolower("local")) {
        $downloadLink = $module;
        $enddir = 'modules/'.preg_replace('/\\.[^.\\s]{3,4}$/', '', basename($module));

    } elseif ($type==strtolower("web")) {
        $downloadLink = $module;
        $enddir = 'modules/'.preg_replace('/\\.[^.\\s]{3,4}$/', '', basename($module));
    } else echo "Type not found: ".$type;
    
    if ($useNameInstead !== false)
        $enddir = $useNameInstead; 

    echo "\nDownloading (This may take a while)...\n";
    file_put_contents("temp_module.zip", file_get_contents($downloadLink, false, $context));
    if (class_exists('ZipArchive')) {
        $zip = new ZipArchive;
    $res = $zip->open("temp_module.zip");
    if ($res === true) {
        $zip->extractTo("tempdir");
        $zip->close();
        $files = scandir('tempdir');
        $dirInZip = false;

        $count = (function($files) {
            $counter = 0;
            foreach ($files as $f)
                if ($f != "." && $f != "..")
                    $counter++;
            return $counter;
        })($files);

        if ($count == 1)
            foreach($files as $file)
                if (is_dir("tempdir/".$file))
                    if ($file != "." && $file != "..") {
                        $dirInZip = $file;
                    }    
        if (is_dir($enddir))
            deleteDir($enddir);
        if ($dirInZip !== false) {
            echo "\n\n".$dirInZip."\n\n";
            rename("tempdir/".$dirInZip, $enddir);
        } else
            rename("tempdir", $enddir);
        
        if (is_dir("tempdir"))
            deleteDir("tempdir");
        if (file_exists("temp_module.zip"))
            unlink("temp_module.zip");

        file_put_contents('temp_module.zip', "0");
            
            if (file_exists($enddir."/manifest.json")) {
                $manifest = json_decode(file_get_contents($enddir."/manifest.json"));
                if (isset($manifest->modules))
                    foreach ($manifest->modules as $type=>$branch) {
                        echo "\nThis module needs a module. [".$type.": ".$branch."]. Do you want to download it? Enter yes to accepts: "; 
                        $accepted = readline();
                        if ($accepted == "yes")
                            install($type, $branch);
                        else
                            echo "Didn't accepted!\n";
                    }
            }
        } else {
            echo "Couldn't unpack the zip";
        }
    } else 
        echo "ZipArchive is not installed!";
    return false;
}

function getStringBetween($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    if ($end=="") {
      return substr($string, $ini, strlen($string));
    }
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}*/

$CLI->register("install", function($args) {
  return "Ulole-Framework are not more supported! Use 'php uppm' instead! (php uppm help)";
});
