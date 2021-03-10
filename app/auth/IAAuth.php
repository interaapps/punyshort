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

        $postdata = [
            'key' => App::getInstance()->getConfig()->get("auth.ia.key"),
            "query"=>json_encode($query)
        ];

        if ($limit !== false)
            $postdata["limit"] = $limit;


        $postdata = http_build_query($postdata);
    
        $opts = ['http' =>[
                'method'  => 'POST',
                'header'  => 'Content-Type: application/x-www-form-urlencoded',
                'content' => $postdata
            ]];
        $context  = stream_context_create($opts);
        $result = file_get_contents('https://accounts.interaapps.de/iaauth/api/finduser', false, $context);
        return json_decode($result);
    }

    public static function getUserInformation($user, $t = false)
    {
        if (isset(self::$cachedUsers[$user]))
        return self::$cachedUsers[$user];

        $postdata = http_build_query([
            'key' => App::getInstance()->getConfig()->get("auth.ia.key"),
            'userkey' => $user
        ]);

        $context = stream_context_create(['http' =>[
                'method'  => 'POST',
                'header'  => 'Content-Type: application/x-www-form-urlencoded',
                'content' => $postdata
            ]]);
        $result = json_decode(file_get_contents('https://accounts.interaapps.de/iaauth/api/getuserinformation', false, $context));

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

        $req = HTTPRequest::post("http://localhost:1337/iaauth/api/friends/isfriend")
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
