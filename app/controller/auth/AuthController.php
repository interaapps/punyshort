<?php
namespace app\controller\auth;


use app\App;
use app\auth\IAAuth;
use app\model\Session;
use de\interaapps\ulole\helper\Str;
use de\interaapps\ulole\router\Request;
use de\interaapps\ulole\router\Response;

class AuthController
{
    public static function login(Request $req, Response $res)
    {
        if (isset($_GET["userkey"])) {
            $auth = IAAuth::getUserInformation($_GET["userkey"]);
            if ($auth !== false) {
                $session = new Session();
                $session->session_id = Str::random(150)->str();
                $session->userid = $auth->id;
                $session->user_key = $auth->userkey;
                if ($session->save())
                    \setcookie("auth", $session->session_id, time()+10593600, "/");
                else
                    die("ERROR WHILE SAVING SESSION!");
                $res->redirect('/');
                return "";
            }
        }
        $res->redirect("https://accounts.interaapps.de/iaauth/".App::getInstance()->getConfig()->get("auth.ia.id"));
    }

    public static function getUser(Request $req) {
        $out = ["loggedIn" => false];
        if (IAAuth::loggedIn()) {
            $out["loggedIn"] = true;
            $user = IAAuth::getUser();
            $out["name"] = $user->username;
            $out["email"] = $user->email;
            $out["profilePicture"] = $user->profilepic;
            $out["color"] = $user->color;
        }
        return $out;
    }
}