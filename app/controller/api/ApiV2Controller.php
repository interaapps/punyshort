<?php
namespace app\controller\api;

use app\classes\Link;
use app\classes\StatsHandler;
use \app\classes\Stats;
use databases\ShortlinksTable;
use ulole\core\classes\Response;
use ulole\core\classes\util\Str;

class ApiV2Controller 
{

    public static function create($link) : array {
        global $ULOLE_CONFIG_ENV;
        $out = [
            "link"=>false,
            "full_link"=>false,
            "error"=>3
        ];

        $domainName = $_SERVER['SERVER_NAME'];
        if (isset($_POST["domain"]))
            $domainName = $_POST["domain"];

        $domain = (new \databases\DomainsTable)->select("id, domain_name, is_public, is_default")->where("domain_name", $domainName)->first();

        if ($domain["id"] === null) {
            $domainName = "";
        } else if (USER_LOGGEDIN && (new \databases\DomainUsersTable)->count()->where("userid", \app\classes\user\User::$user->id)->andwhere("domainid", $domain["id"])->get() > 0) {
            $domainName = $domain["domain_name"];
        } else if ($domain["is_public"] == "0") {
            $domainName = "";
        } 

        $customDomain = $domain["domain_name"] !== null && $domain["domain_name"] == $domainName && $domain["is_default"] == "0" && isset($_POST["name"]) && \trim($_POST["name"]) != "" && preg_match('#^[A-Za-z0-9_/]+$#', $_POST["name"]);

        if (trim($link) != "") {
            if (Str::contains("://", $link)) {
                $existLink = (new ShortlinksTable)
                    ->select('*')
                    ->where("link", $link)
                    ->andwhere("domain", $domainName)
                    ->first();

               

                if ($existLink["id"] == null || $customDomain) {
                    $newLink = new Link($link);

                    if ($customDomain)
                        $newLink->name = $_POST["name"];

                    $newLink->domainName = $domainName;
                    $newLinkLink = $newLink->create();
                    if ($newLinkLink["done"]) {
                        $out["link"] = $newLinkLink["link"];
                        $out["full_link"] = "https://".$domainName."/".$newLinkLink["link"];
                        $out["domain"] = $domainName;
                        $out["error"] = 0;
                    } else {
                        $out["error"] = 3;
                    }
                } else {
                    $out["link"] = $existLink["name"];
                    $out["full_link"] = "https://".$domainName."/".$existLink["name"];
                    $out["domain"] = $domainName;
                    $out["error"] = 0;
                }
            } else
                $out["error"] = 1;
        } else
            $out["error"] = 2;

        return $out;
    }

    public static function post() {
        header('Access-Control-Allow-Origin: *');
        return Response::json(self::create($_POST["link"]));
    }

    public static function getInformation() {
        global $_ROUTEVAR;
        header('Access-Control-Allow-Origin: *');

        $domainName = $_SERVER['SERVER_NAME'];
    
        // TESTING PURPOSES
        if ($domainName == "0.0.0.0")
            $domainName = "pnsh.ga";

        if (isset($_GET["domain"]))
            $domainName = $_GET["domain"];

        $domain = (new \databases\DomainsTable)->select("id, domain_name, is_public")->where("domain_name", $domainName)->first();
        
        if ($domain["id"] === null) {
            $domainName = "";
        } else if (USER_LOGGEDIN && (new \databases\DomainUsersTable)->count()->where("userid", \app\classes\user\User::$user->id)->andwhere("domainid", $domain["id"])->get() > 0) {
            $domainName = $domain["domain_name"];
        } else if ($domain["is_public"] == "0") {
            $domainName = "";
        } 
            
        $out = [
            "id"=>-1,
            "link"=>"",
            "url"=>"",
            "domain"=>"",
            "created"=>"0000-00-00 00:00:00",
            "clicks"=>[],
            "click"=>[],
            "browser"=>[],
            "os"=>[],
            "countries"=>[],
            "error"=>0
        ];

        if ($_ROUTEVAR[1] == ":::MyLinks" && USER_LOGGEDIN) {
            $link = (new ShortlinksTable)
                        ->select('*')
                        ->where("userid", \app\classes\user\User::$user->id)
                        ->first();
        } else {
            $link = (new ShortlinksTable)
                        ->select('*')
                        ->where("name", $_ROUTEVAR[1])
                        ->andwhere("domain", $domainName)
                        ->first();
            $out["id"] = $link["id"];
            $out["link"] = $link["link"];
            $out["url"] = $link["name"];
            $out["domain"] = $link["domain"];
            $out["created"] = $link["created"];
        }
        if ($link["id"] != null) {
            $out["clicks"] = StatsHandler::getClicks($link["id"]);
            $out["click"] = [
                date('Y-m-d',date(strtotime("-24 day")))=>StatsHandler::getDayClicks(24, $link["id"]),
                date('Y-m-d',date(strtotime("-23 day")))=>StatsHandler::getDayClicks(23, $link["id"]),
                date('Y-m-d',date(strtotime("-22 day")))=>StatsHandler::getDayClicks(22, $link["id"]),
                date('Y-m-d',date(strtotime("-21 day")))=>StatsHandler::getDayClicks(21, $link["id"]),
                date('Y-m-d',date(strtotime("-20 day")))=>StatsHandler::getDayClicks(20, $link["id"]),
                date('Y-m-d',date(strtotime("-19 day")))=>StatsHandler::getDayClicks(19, $link["id"]),
                date('Y-m-d',date(strtotime("-18 day")))=>StatsHandler::getDayClicks(18, $link["id"]),
                date('Y-m-d',date(strtotime("-17 day")))=>StatsHandler::getDayClicks(17, $link["id"]),
                date('Y-m-d',date(strtotime("-16 day")))=>StatsHandler::getDayClicks(16, $link["id"]),
                date('Y-m-d',date(strtotime("-15 day")))=>StatsHandler::getDayClicks(15, $link["id"]),
                date('Y-m-d',date(strtotime("-14 day")))=>StatsHandler::getDayClicks(14, $link["id"]),
                date('Y-m-d',date(strtotime("-13 day")))=>StatsHandler::getDayClicks(13, $link["id"]),
                date('Y-m-d',date(strtotime("-12 day")))=>StatsHandler::getDayClicks(12, $link["id"]),
                date('Y-m-d',date(strtotime("-11 day")))=>StatsHandler::getDayClicks(11, $link["id"]),
                date('Y-m-d',date(strtotime("-10 day")))=>StatsHandler::getDayClicks(10, $link["id"]),
                date('Y-m-d',date(strtotime("-9 day")))=>StatsHandler::getDayClicks(9, $link["id"]),
                date('Y-m-d',date(strtotime("-8 day")))=>StatsHandler::getDayClicks(8, $link["id"]),
                date('Y-m-d',date(strtotime("-7 day")))=>StatsHandler::getDayClicks(7, $link["id"]),
                date('Y-m-d',date(strtotime("-6 day")))=>StatsHandler::getDayClicks(6, $link["id"]),
                date('Y-m-d',date(strtotime("-5 day")))=>StatsHandler::getDayClicks(5, $link["id"]),
                date('Y-m-d',date(strtotime("-4 day")))=>StatsHandler::getDayClicks(4, $link["id"]),
                date('Y-m-d',date(strtotime("-3 day")))=>StatsHandler::getDayClicks(3, $link["id"]),
                date('Y-m-d',date(strtotime("-2 day")))=>StatsHandler::getDayClicks(2, $link["id"]),
                date('Y-m-d',date(strtotime("-1 day")))=>StatsHandler::getDayClicks(1, $link["id"]),
                date('Y-m-d',date(strtotime("-0 day")))=>StatsHandler::getDayClicks(0, $link["id"])
            ];

            $out["browser"] = [
                "Chrome"=>StatsHandler::getBrowserStats("Chrome", $link["id"]),
                "Firefox"=>StatsHandler::getBrowserStats("Firefox", $link["id"]),
                "Safari"=>StatsHandler::getBrowserStats("Safari", $link["id"]),
                "Opera"=>StatsHandler::getBrowserStats("Opera", $link["id"]),
                "Netscape"=>StatsHandler::getBrowserStats("Netscape", $link["id"]),
                "Maxthon"=>StatsHandler::getBrowserStats("Maxthon", $link["id"]),
                "Konqueror"=>StatsHandler::getBrowserStats("Konqueror", $link["id"]),
                "Handheld Browser"=>StatsHandler::getBrowserStats("Handheld Browser", $link["id"]),
                "Internet Explorer"=>StatsHandler::getBrowserStats("Internet Explorer", $link["id"]),
                "Unknown"=>StatsHandler::getBrowserStats("Unknown", $link["id"])
            ];

            $out["os"] = [
                "Windows"=>StatsHandler::getOSStats("Windows", $link["id"]),
                "Mac OS"=>StatsHandler::getOSStats("Mac", $link["id"]),
                "Linux"=>StatsHandler::getOSStats("Linux", $link["id"]),
                "ios"=>StatsHandler::getOSStats("ios", $link["id"]),
                "Android"=>StatsHandler::getOSStats("Android", $link["id"]),
                "Other"=>StatsHandler::getOSStats("Other", $link["id"])+StatsHandler::getOSStats("Unknown OS Platform", $link["id"])
            ];

            $out["countries"] = StatsHandler::getCountryClicks($link["id"]);
        } else {
            $out["error"] = 404;
        }
        return Response::json($out);
    }

}