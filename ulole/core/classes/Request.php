<?php 
namespace ulole\core\classes;

class Request {

    public static function routeVar($param=false) {
        global $_ROUTEVAR;
        if ($param === false)
            return $_ROUTEVAR;
        return $_ROUTEVAR[$param];
    }

    public static function POST($param=false) {
        if ($param === false)
            return $_POST;

        if (isset($_POST[$param]))
            return $_POST[$param];
        return null;
    }

    public static function GET($param=false) {
        if ($param === false)
            return $_GET;
        return $_GET[$param];
    }

    public static function getUserAgent() {
        return $_SERVER["HTTP_USER_AGENT"];
    }

    public static function getServerSoftware() {
        return $_SERVER["SERVER_SOFTWARE"];
    }

    public static function getRemotePort() {
        return $_SERVER["SERVER_NAME"];
    }

    /**
     *  You shouldn't use this version! Use getRemoteAddress instead
     */
    public static function getPHPRemoteAddress() {
        return $_SERVER["REMOTE_ADDR"];
    }

    public static function getRemoteAddress() {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            $ip=$_SERVER['HTTP_CLIENT_IP'];
         elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
         else
            $ip=$_SERVER['REMOTE_ADDR'];
        return $ip; 
    }

    public static function getAcceptedLanguages() {
        return $_SERVER["HTTP_ACCEPT_LANGUAGE"];
    }

    public static function getDocumentRoot() {
        return $_SERVER["DOCUMENT_ROOT"];
    }

    public static function getHttpCookie() {
        return $_SERVER["HTTP_COOKIE"];
    }

    public static function getRequestURI() {
        return $_SERVER["REQUEST_URI"];
    }

    public static function getServerName() {
        return $_SERVER["SERVER_NAME"];
    }

    public static function getServerPort() {
        return $_SERVER["SERVER_PORT"];
    }

    public static function getHost() {
        return $_SERVER["HTTP_HOST"];
    }

}