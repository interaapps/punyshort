<?php

namespace app\controller;

use app\helper\StatsHelper;
use app\model\Click;
use app\model\Domain;
use app\model\ShortenLink;
use de\interaapps\ulole\router\Request;
use de\interaapps\ulole\router\Response;

class LinkController
{
    public static function redirect(Request $req, Response $res, $link)
    {
        $domain = $_SERVER['SERVER_NAME'];

        if ($domain == "0.0.0.0")
            $domain = "pnsh.ga";

        $link = ShortenLink::table()
            ->where("name", $link)
            ->where("domain", $domain)
            ->get();

        if ($link !== null && Domain::table()->where("domain_name", $domain)->get() !== null) {
            $stats = new Click;
            $stats->os = StatsHelper::getOS();
            $stats->browser = StatsHelper::getBrowser();
            $stats->country = StatsHelper::getCountry(StatsHelper::getIP());
            $stats->day = date("Y-m-d");
            $stats->linkid = $link->id;
            $stats->save();

            if ($link->blocked == 1) {
                return view("app");
            } else
                return $res->redirect($link->link);
        }
        view("app");
    }
}