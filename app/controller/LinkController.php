<?php
namespace app\controller;

use ulole\core\classes\Response;
use \databases\ShortlinksTable;
use \databases\ClicksTable;
use \app\classes\Stats;

class LinkController {

    /**
     *   Redirects use to the page
     */
    public static function redirect() {
        global $_ROUTEVAR;

        $domain = $_SERVER['SERVER_NAME'];

        // TESTING PURPOSES
        if ($domain == "0.0.0.0")
            $domain = "pnsh.ga";

        $link = (new ShortlinksTable)
                    ->select("link, id, blocked")
                    ->where("name", $_ROUTEVAR[1])
                    ->andwhere("domain", $domain)
                    ->first();
        
        if ($link["id"] !== null && (new \databases\DomainsTable)->select()->where("domain_name", $domain)->first() !== null) {
            $stats = new ClicksTable;
            $stats->os = Stats::getOS();
            $stats->browser = Stats::getBrowser();
            $stats->country = Stats::getCountry(Stats::getIP());
            $stats->day = date("Y-m-d");
            $stats->linkid = $link["id"];
            $stats->save();
            
            if ($link["blocked"] == 1)
                return view("blockedlink", [
                    "link"=>$link["link"]
                ]);
            else
                return Response::redirect($link["link"]);
        }
        return view("404");
    }

    public static function info () {
        global $_ROUTEVAR;

        $domainName = $_SERVER['SERVER_NAME'];
    
        // TESTING PURPOSES
        if ($domainName == "0.0.0.0")
            $domainName = "pnsh.ga";

        if (isset($_GET["domain"]))
            $domainName = $_GET["domain"];

        if ((new \databases\DomainsTable)->select("id")->where("domain_name", $domainName)->andwhere("is_public", "1")->first()["id"] === null)
            $domainName = (new \databases\DomainsTable)->select()->where("is_default", "1")->first()["domain_name"];

        $link = (new ShortlinksTable)
                    ->select("link, name, id, blocked")
                    ->where("name", $_ROUTEVAR[1])
                    ->andwhere("domain", $domainName)
                    ->first();

        if ($link["id"] !== null) {
            view("linkinfo", [
                "id"=>$link["id"],
                "link"=>$link["link"],
                "domain"=>$domainName,
                "name"=>$link["name"]
            ]);
        } else 
            view("404");
    }
}