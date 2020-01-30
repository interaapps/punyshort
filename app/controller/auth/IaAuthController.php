<?php
namespace app\controller\auth;

use ulole\core\classes\Response;
use app\classes\user\IaAuth;
use \databases\ShortlinksTable;
use \databases\ClicksTable;
use \app\classes\Stats;

/**
 * Auth Controller for InteraApps Auth!
 * Not for private use
 */
class IaAuthController {
    /**
     * Login
     * 
     * @response Redirect
     */
    public static function login() {
        if (isset($_GET["userkey"])) {
            if (IaAuth::getUserInformation($_GET["userkey"]) !== false) {
                $key = IaAuth::getUserInformation($_GET["userkey"])->userkey;
                $newUser = new IaAuth($key);
                $newUser->login();
                \setcookie("InteraApps_auth", $newUser->session, time()+1593600, "/");
                
                Response::redirect('/');
            }
        }
    }

}