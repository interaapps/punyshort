<?php
namespace app\controller\Dashboard;

class CreatedLinksController
{

    public static function page() {
        return view("dashboard/links", [
            "user"=>\app\classes\user\User::$user
        ]);
    }

}