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

use app\controller\DataTableController;
use app\classes\DataTable;

// Directory for the views
$views_dir      =  "resources/views/";
$templates_dir  =  "resources/views/templates/";

/**
 *      -=-=-
 *   - ROUTING -
 *      -=-=-
 */

$router->get("/", "!HomepageController@page");

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

        $router->get("/domains", "!dashboard\CustomDomainsController@page");
        $router->get("/api/getdomains", "!dashboard\CustomDomainsController@getDomains");
        $router->get("/links", "!dashboard\CreatedLinksController@page");

        $router->delete("/link/([0-9]*)/delete", "!dashboard\CreatedLinksController@deleteLink");
        $router->post("/link/([0-9]*)/edit", "!dashboard\CreatedLinksController@editLink");


        DataTableController::addDataTable("owndomains", (new DataTable(\databases\DomainsTable::class, [
            "id", "domain_name", "created"
        ]))->setExtraDataFunction(function($key, $value, $options){
            if ($key == "id") {
                if (!((new \databases\DomainUsersTable)->count()->where("userid", \app\classes\user\User::$user->id)->andwhere("domainid", $value)->get() > 0))
                    $options->delete = true;
            }
            return [];
        }));

        DataTableController::addDataTable("ownlinks", (new DataTable(\databases\ShortlinksTable::class, [
            "id", "domain", "name", "link", "created"
        ]))->setExtraDataFunction(function($key, $value, $options){
            return [];
        })->customQuery(function($query){
            $query->andwhere("userid", \app\classes\user\User::$user->id);
        }));
    });
});

/**
 * Authentification
 */
$router->get("/ia/auth/user/login", "!auth\IaAuthController@login");


$router->get("/datatable", "!DataTableController@api");

$router->get("/(.*)/info", "!LinkController@info");
$router->get("/info/(.*)", "!LinkController@info");

// Redirector
$router->get("/(.*)", "!LinkController@redirect");

// 404
$router->setPageNotFound("404.php");