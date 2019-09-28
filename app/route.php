<?php
/**
 *   ┏━┓       ┏┳┓┏━┓┏┓       ┏┓
 *   ┃╋┃┏┳┓┏━┳┓┃┃┃┃━┫┃┗┓┏━┓┏┳┓┃┗┓
 *   ┃┏┛┃┃┃┃┃┃┃┣┓┃┣━┃┃┃┃┃╋┃┃┏┛┃┏┫
 *   ┗┛ ┗━┛┗┻━┛┗━┛┗━┛┗┻┛┗━┛┗┛ ┗━┛
 *     - INTERAAPPS 2018-2019 -
 * 
 *  Thanks for using or contributing
 *  to PunyShort! 
 */


// Directory for the views
$views_dir      =  "resources/views/";
$templates_dir  =  "resources/views/templates/";

/**
 *      -=-=-
 *   - ROUTING -
 *      -=-=-
 */

$router->get("/", "homepage.php");

/**
 * API
 */
$router->group("/api/", function($router)
{

    $router->get("jsonapi.php",  "!api\ApiV1Controller@create");
    $router->post("jsonapi.php", "!api\ApiV1Controller@create");
    $router->get("jsonapi",      "!api\ApiV1Controller@create");
    $router->post("jsonapi",     "!api\ApiV1Controller@create");

    $router->group("v2/", function($router) {
        $router->post("short", "!api\ApiV2Controller@post");
        $router->get("getinformation/(.*)", "!api\ApiV2Controller@getInformation");
    });

});

/**
 * Documentations
 */
$router->get("/docs/v1/(.*)", "!docs\DocsV1Controller@page");
$router->get("/docs/v1", function() { return view("docs/v1", ["doc"=>file_get_contents(\app\controller\docs\DocsV1Controller::PAGES[""])]); });

$router->get("/docs/v2/(.*)", "!docs\DocsV2Controller@page");
$router->get("/docs/v2", function() {
    $page = (new \modules\parsedown\Parsedown)->text(file_get_contents(\app\controller\docs\DocsV2Controller::PAGES[""]));
    return view("docs/v2", ["doc"=>$page, "pages"=>\app\controller\docs\DocsV2Controller::PAGES_LINKS]); });


/**
 * Dashboard
 */
$router->middleware("!\app\Middlewares@loggedIn", "!auth\AuthController@redirectToLogin", function($router)
{
    $router->group("/dashboard", function($router) 
    {
        $router->get("",  "!dashboard\DashboardController@index");
        $router->get("/", "!dashboard\DashboardController@index");
    });
});

/**
 * Authentification
 */
$router->get("/ia/auth/user/login", "!auth\IaAuthController@login");

// Redirector
$router->get("/(.*)", "!LinkController@redirect");

// 404
$router->setPageNotFound("404.php");