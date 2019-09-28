<?php
namespace app\controller\Dashboard;

class DashboardController
{

    public static function index() {
        return view("dashboard/index", [
            "user"=>\app\classes\user\User::$user
        ]);
    }

}