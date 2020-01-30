<?php

use \app\classes\user\IaAuth;

$userObject = false;
if (IaAuth::usingIaAuth()) {
    if (IaAuth::loggedIn()) {
        $userObject = IaAuth::getUserObject();
    }
}

\app\classes\user\User::$user = $userObject;
define("USER_LOGGEDIN", $userObject!==false);