<?php
namespace app\controller\api;

use app\auth\IAAuth;
use app\model\Domain;
use app\model\DomainUser;
use app\model\ShortenLink;
use app\helper\StatsHelper;
use de\interaapps\ulole\helper\Str;
use de\interaapps\ulole\orm\UloleORM;
use de\interaapps\ulole\router\Request;
use de\interaapps\ulole\router\Response;

class ApiV2Controller {

    public static function create(Request $req, Response $res) {
        $response = [
            "link"=>false,
            "full_link"=>false,
            "error"=>3
        ];

        $res->setHeader('Access-Control-Allow-Origin', '*');
        $domainName = isset($_GET["domain"]) ? $_GET["domain"] : $_SERVER['SERVER_NAME'];
        if ($domainName == "0.0.0.0")
            $domainName = "pnsh.ga";
        
        $domain = Domain::table()->where("domain_name", $domainName)->get();

        if ($domain !== null) {
            if ($domain->is_public == "1" || (DomainUser::table()->where("domainid", $domain->id)->where("userid", IAAuth::getUser()->id)->count() > 0)) {
                $domainName = $domain->domain_name;
            }
        }

        $url = $req->getParam("link") !== null ? trim($req->getParam("link")) : '';

        if ($url != "") {
            if (strpos($url, "://") !== false) {
                $link = new ShortenLink;
                $link->name = Str::random(8)->str();

                if ($domain->is_public == '0' && $req->getParam("name") !== null && trim($req->getParam("name")) != "")
                    $link->name = $req->getParam("name");

                if (ShortenLink::where("name", $link->name)->where("domain", $domainName)->count() > 0) {
                    $response["error"] = 4;
                } else {
                
                    $link->domain  = $domainName;
                    $link->link    = $url;
                    $link->userid  = 0;
                    $link->blocked = 0;
                    $link->ip      = $req->getRemoteAddress();

                    $link->userid = IAAuth::getUser()->id;
                    if ($link->save()) {
                        $response["link"] = $link->name;
                        $response["full_link"] = "https://".$domainName."/".$link->name;
                        $response["domain"] = $domainName;
                        $response["error"] = 0;
                    } else {
                        $response["error"] = 3;
                    }
                }
            } else
                $response["error"] = 1;
        } else
            $response["error"] = 2;

        return $response;
    }

    public static function getInformation(Request $req, Response $res, $link) {
        $res->setHeader('Access-Control-Allow-Origin', '*');

        $domainName = $_SERVER['SERVER_NAME'];
    
        // TESTING PURPOSES
        if ($domainName == "0.0.0.0")
            $domainName = "pnsh.ga";

        if (isset($_GET["domain"]))
            $domainName = $_GET["domain"];

        $domain = Domain::table()->where("domain_name", $domainName)->get();
        
        if ($domain === null) {
            $domainName = "";
        } else if (IAAuth::loggedIn() && DomainUser::table()->where("userid", IAAuth::getUser()->id)->where("domainid", $domain->id)->count() > 0) {
            $domainName = $domain->domain_name;
        } else if ($domain->is_public == "0") {
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
            "error"=>0,
            "is_mine"=>false
        ];

        if ($link == ":::MyLinks" && IAAuth::loggedIn()) {
            $link = ShortenLink::table()
                        ->where("userid", IAAuth::getUser()->id)
                        ->get();
        } else {
            $link = ShortenLink::table()
                        ->where("name", $link)
                        ->where("domain", $domainName)
                        ->get();
            $out["id"] = $link->id;
            $out["link"] = $link->link;
            $out["url"] = $link->name;
            $out["domain"] = $link->domain;
            $out["created"] = $link->created;
        }
        if ($link != null) {
            $out["is_mine"] = IAAuth::getUser()->id === $link->userid;
            $out["clicks"] = StatsHelper::getClicks($link->id);
            $out["click"] = [
                date('Y-m-d',date(strtotime("-24 day")))=>StatsHelper::getDayClicks(24, $link->id),
                date('Y-m-d',date(strtotime("-23 day")))=>StatsHelper::getDayClicks(23, $link->id),
                date('Y-m-d',date(strtotime("-22 day")))=>StatsHelper::getDayClicks(22, $link->id),
                date('Y-m-d',date(strtotime("-21 day")))=>StatsHelper::getDayClicks(21, $link->id),
                date('Y-m-d',date(strtotime("-20 day")))=>StatsHelper::getDayClicks(20, $link->id),
                date('Y-m-d',date(strtotime("-19 day")))=>StatsHelper::getDayClicks(19, $link->id),
                date('Y-m-d',date(strtotime("-18 day")))=>StatsHelper::getDayClicks(18, $link->id),
                date('Y-m-d',date(strtotime("-17 day")))=>StatsHelper::getDayClicks(17, $link->id),
                date('Y-m-d',date(strtotime("-16 day")))=>StatsHelper::getDayClicks(16, $link->id),
                date('Y-m-d',date(strtotime("-15 day")))=>StatsHelper::getDayClicks(15, $link->id),
                date('Y-m-d',date(strtotime("-14 day")))=>StatsHelper::getDayClicks(14, $link->id),
                date('Y-m-d',date(strtotime("-13 day")))=>StatsHelper::getDayClicks(13, $link->id),
                date('Y-m-d',date(strtotime("-12 day")))=>StatsHelper::getDayClicks(12, $link->id),
                date('Y-m-d',date(strtotime("-11 day")))=>StatsHelper::getDayClicks(11, $link->id),
                date('Y-m-d',date(strtotime("-10 day")))=>StatsHelper::getDayClicks(10, $link->id),
                date('Y-m-d',date(strtotime("-9 day")))=>StatsHelper::getDayClicks(9, $link->id),
                date('Y-m-d',date(strtotime("-8 day")))=>StatsHelper::getDayClicks(8, $link->id),
                date('Y-m-d',date(strtotime("-7 day")))=>StatsHelper::getDayClicks(7, $link->id),
                date('Y-m-d',date(strtotime("-6 day")))=>StatsHelper::getDayClicks(6, $link->id),
                date('Y-m-d',date(strtotime("-5 day")))=>StatsHelper::getDayClicks(5, $link->id),
                date('Y-m-d',date(strtotime("-4 day")))=>StatsHelper::getDayClicks(4, $link->id),
                date('Y-m-d',date(strtotime("-3 day")))=>StatsHelper::getDayClicks(3, $link->id),
                date('Y-m-d',date(strtotime("-2 day")))=>StatsHelper::getDayClicks(2, $link->id),
                date('Y-m-d',date(strtotime("-1 day")))=>StatsHelper::getDayClicks(1, $link->id),
                date('Y-m-d',date(strtotime("-0 day")))=>StatsHelper::getDayClicks(0, $link->id)
            ];

            $out["browser"] = [
                "Chrome"=>StatsHelper::getBrowserStats("Chrome", $link->id),
                "Firefox"=>StatsHelper::getBrowserStats("Firefox", $link->id),
                "Safari"=>StatsHelper::getBrowserStats("Safari", $link->id),
                "Opera"=>StatsHelper::getBrowserStats("Opera", $link->id),
                "Netscape"=>StatsHelper::getBrowserStats("Netscape", $link->id),
                "Maxthon"=>StatsHelper::getBrowserStats("Maxthon", $link->id),
                "Konqueror"=>StatsHelper::getBrowserStats("Konqueror", $link->id),
                "Handheld Browser"=>StatsHelper::getBrowserStats("Handheld Browser", $link->id),
                "Internet Explorer"=>StatsHelper::getBrowserStats("Internet Explorer", $link->id),
                "Unknown"=>StatsHelper::getBrowserStats("Unknown", $link->id)
            ];

            $out["os"] = [
                "Windows"=>StatsHelper::getOSStats("Windows", $link->id),
                "Mac OS"=>StatsHelper::getOSStats("Mac", $link->id),
                "Linux"=>StatsHelper::getOSStats("Linux", $link->id),
                "ios"=>StatsHelper::getOSStats("ios", $link->id),
                "Android"=>StatsHelper::getOSStats("Android", $link->id),
                "Other"=>StatsHelper::getOSStats("Other", $link->id)+StatsHelper::getOSStats("Unknown OS Platform", $link->id)
            ];

            $out["countries"] = StatsHelper::getCountryClicks($link->id);
        } else {
            $out["error"] = 404;
        }
        return $out;
    }
}