<?php
namespace app\controller\auth;

use ulole\core\classes\Response;

class AuthController
{

    /**
     * Redirecting a user to the Login Page
     */
    public static function redirectToLogin() {
        global $ULOLE_CONFIG_ENV;
        if (isset($ULOLE_CONFIG_ENV->Auth->using)) {
            if (strtolower($ULOLE_CONFIG_ENV->Auth->using) == "interaapps")
                Response::redirect($ULOLE_CONFIG_ENV->Auth->interaapps->redirect);
        }
    }

}