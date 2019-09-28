<?php 
namespace ulole\core\classes;

class Response {
    public static function json($arr) {
        header('Content-Type: application/json');
        echo \json_encode($arr);
    }

    public static function returnJson($arr) {
        header('Content-Type: application/json');
        return \json_encode($arr);
    }

    public static function setContentType($type) {
        header('Content-Type: '.$type);
    }

    public static function setCode($code) {
        http_response_code($code);
    }

    public static function setNotFound() {
        header("HTTP/1.0 404 Not Found");
    }

    public static function setHeader($header, $value=false) {
        if ($value === false)
            header($header);
        else
            header($header.": ".$value);
    }
    
    public static function setHeaders($header) {
        foreach ($header as $name=>$value)
            header($name.": ".$value);
    }

    public static function redirect($link, $code=307) {
        @ob_clean();
        http_response_code($code);
        header("Location: ".$link);
        echo "<title>Redirecting to ".$link."</title>";
		echo '<meta http-equiv="refresh" content="0;url='.$link.'">';
		echo "<script>window.location.replace('",$link,"')</script>";
        echo "<a href='".$link."'>CLICK HERE</title>";
        exit();
    }


}