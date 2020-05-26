<?php
namespace app\controller;

use ulole\core\classes\Response;

class HomepageController {

    public static function page() {
        if((new \databases\ShortlinksTable)->count()->where("name", "/")->andwhere("domain", $_SERVER['SERVER_NAME'])->get() > 0) {
            global $_ROUTEVAR;
            $_ROUTEVAR[1] = "/";
            \app\controller\LinkController::redirect();
            return;
        }
        return view("homepage", [
            "domains"=>(new \databases\DomainsTable)->select("domain_name")->where("is_default", "1")->andwhere("is_public", "1")->get()
        ]);
    }
}