<?php
namespace ulole\core\framework;


class ErrorHandling
{
    public static function fatalError()
    {
        $errLast = error_get_last();
        if ($errLast != null) {
            self::error($errLast["type"], $errLast["message"], $errLast["file"], $errLast["line"]);
        }
    }
    
    public static function error($errno=false, $errstr=false, $errfile=false, $errline=false)
    {

        $error = $errstr;
        $line = $errline;
        $file = $errfile;
        $fileContents = file_get_contents($errfile);
        $type = $errno;
        ob_clean();
        // preg_split("/((\r?\n)|(\r\n?))/", $subject
        $fileContentsLines = preg_split("/((\r?\n)|(\r\n?))/", $fileContents);


        if (isset($_GET["ulole_____a"]) ? $_GET["ulole_____a"]=="t" : false) {
            require "frameworkviews/error.php";
            exit();
        } else {
            $tempId = "ULOLE_ERROR__".\rand(0000000000, 9999999999);
            echo $error." in ".$file." on linea ".$line."\n";
            echo '<!-- THIS IS FOR THE FRONTEND ERRORMESSAGE --><div id="'.$tempId.'"></div><script>
var xhr=new XMLHttpRequest(); xhr.open("GET",window.location+"?ulole_____a=t");
xhr.onload=()=>{document.getElementById("'.$tempId.'").innerHTML=xhr.responseText;}
xhr.send();</script>';
        }
    }
}