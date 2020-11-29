<?php
namespace app\controller\dashboard;

use app\auth\IAAuth;
use app\model\Click;
use app\model\ShortenLink;

class LinksController {
    public static function getLinks(){
        $links = [];

        if (IAAuth::loggedIn()) {
            $query = ShortenLink::table()->where("userid", IAAuth::getUser()->id);
            foreach ($query->orderBy("id", true)->all() as $link) {
                array_push($links, [
                    "shorten"=>$link->domain."/".$link->name,
                    "domain"=>$link->domain,
                    "link"=>$link->link,
                    "clicks"=>Click::where("linkid", $link->id)->count(),
                    "name"=>$link->name
                ]);
            }
        } else return '[]';
        return $links;
    }
}