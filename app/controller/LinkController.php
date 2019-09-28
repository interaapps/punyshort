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
        $link = (new ShortlinksTable)
                    ->select("link, id, blocked")
                    ->where("name", $_ROUTEVAR[1])
                    ->first();

        if ($link["id"] !== null) {
            $stats = new ClicksTable;
            $stats->os = Stats::getOS();
            $stats->browser = Stats::getBrowser();
            $stats->country = Stats::getCountry(Stats::getIP());
            $stats->date = date("Y-m-d");
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
        
    }
}