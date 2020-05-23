<?php
namespace app\controller\Dashboard;

use ulole\core\classes\util\Str;

class CreatedLinksController
{

    public static function page() {
        return view("dashboard/links", [
            "user"=>\app\classes\user\User::$user
        ]);
    }

    public static function deleteLink(){
        global $_ROUTEVAR;
        $out = ["done"=>false];
        if (USER_LOGGEDIN) {
            $out["done"] = (new \databases\ShortlinksTable)->delete()->where("id", $_ROUTEVAR[1])->andwhere("userid", \app\classes\user\User::$user->id)->run();
        }
        return $out;
    }

    public static function editLink(){
        global $_ROUTEVAR;
        $out = ["done"=>false, "error"=>"Unknown"];
        if (USER_LOGGEDIN) {
            if ($_POST["link"] && trim($_POST["link"]) != "" && Str::contains("://", $_POST["link"])) {
                $update = (new \databases\ShortlinksTable)->update();
                $update->set("link", $_POST["link"]);
                $out["done"] = $update->where("id", $_ROUTEVAR[1])->andwhere("userid", \app\classes\user\User::$user->id)->run();
            } else
                $out["error"] = "Invalid Link";
        }
        return $out;
    }
}