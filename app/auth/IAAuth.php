<?php

namespace app\auth;


use app\App;
use app\model\Session;
use modules\httprequest\HTTPRequest;

class IAAuth
{

    private static $cachedUsers = [];

    public static function findUser($query, $limit = false)
    {
        $req = HTTPRequest::post("https://accounts.interaapps.de/iaauth/api/finduser")
            ->header("Content-Type: application/x-www-form-urlencoded")
            ->parameter("key", App::getInstance()->getConfig()->get("auth.ia.key"))
            ->parameter("query", json_encode($query));
        return json_decode($req->send()->getData());
    }

    public static function getUserInformation($user, $t = false)
    {
        if (isset(self::$cachedUsers[$user]))
            return self::$cachedUsers[$user];

        $req = HTTPRequest::post("https://accounts.interaapps.de/iaauth/api/getuserinformation")
            ->header("Content-Type: application/x-www-form-urlencoded")
            ->parameter("key", App::getInstance()->getConfig()->get("auth.ia.key"))
            ->parameter('userkey', $user);

        $result = json_decode($req->send()->getData());;

        if ($result->valid) {
            self::$cachedUsers[$user] = $result;
            return $result;
        } else
            return false;
    }

    public static function loggedIn()
    {
        if (!isset($_COOKIE["auth"])) return false;

        $user = Session::table()->where("session_id", $_COOKIE["auth"])->get();
        return $user !== null && IAAuth::getUserInformation($user->user_key) !== false;
    }

    public static function isFriend($username)
    {
        $session = Session::table()
            ->where("session_id", $_COOKIE["auth"])
            ->get();
        if ($session == null)
            return false;

        $req = HTTPRequest::post("https://accounts.interaapps.de/iaauth/api/friends/isfriend")
            ->header("Content-Type: application/x-www-form-urlencoded")
            ->parameter("key", App::getInstance()->getConfig()->get("auth.ia.key"))
            ->parameter('userkey', $session->user_key)
            ->parameter("name", $username);

        $result = json_decode($req->send()->getData());;

        if ($result->valid)
            return $result->is_friend;
        else return false;
    }


    public static function getUser()
    {
        if (!isset($_COOKIE["auth"]))
            return false;
        $session = Session::table()
            ->where("session_id", $_COOKIE["auth"])
            ->get();

        return self::getUserInformation($session->user_key);
    }
}
