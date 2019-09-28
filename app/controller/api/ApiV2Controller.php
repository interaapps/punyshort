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
        
        if (trim($link) != "") {
            if (Str::contains("://", $link)) {
                $existLink = (new ShortlinksTable)
                    ->select('*')
                    ->where("link", $link)
                    ->first();

                if (isset($ULOLE_CONFIG_ENV->domain))
                    $domain = $ULOLE_CONFIG_ENV->domain;
                else
                    $domain = "https://".$_SERVER['SERVER_NAME'];

                if ($existLink["id"] == null) {
                    $newLink = new Link($link);
                    $newLinkLink = $newLink->create();
                    if ($newLinkLink["done"]) {
                        $out["link"] = $newLinkLink["link"];
                        $out["full_link"] = $domain."/".$newLinkLink["link"];
                        $out["error"] = 0;
                    } else {
                        $out["error"] = 3;
                    }
                } else {
                    $out["link"] = $existLink["name"];
                    $out["full_link"] = $domain."/".$existLink["name"];
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
        $out = [
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
                        ->first();
        }
        if ($link["id"] != null) {
            $out["clicks"] = StatsHandler::getClicks($link["id"]);
            $out["click"] = [
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