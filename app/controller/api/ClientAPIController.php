<?php

namespace app\controller\api;

use app\auth\IAAuth;
use app\model\ShortenLink;
use de\interaapps\ulole\router\Request;
use de\interaapps\ulole\router\Response;

class ClientAPIController
{
    public static function edit(Request $req, Response $res, $id)
    {
        if (IAAuth::loggedIn() && $req->getParam("link") !== null) {
            return json_encode(ShortenLink::table()->set("link", $req->getParam("link"))->where("id", $id)->where("userid", IAAuth::getUser()->id)->update());
        }
        return "false";
    }

    public static function delete(Request $req, Response $res, $id)
    {
        if (IAAuth::loggedIn()) {
            return json_encode(ShortenLink::where("id", $id)->where("userid", IAAuth::getUser()->id)->delete());
        }
        return "false";
    }
}