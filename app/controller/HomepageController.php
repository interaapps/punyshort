<?php
namespace app\controller;

use ulole\core\classes\Response;

class HomepageController {

    public static function page() {
        return view("homepage", [
            "domains"=>(new \databases\DomainsTable)->select("domain_name")->where("is_default", "1")->andwhere("is_public", "1")->get()
        ]);
    }
}