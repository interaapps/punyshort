<?php

namespace app;

use app\auth\IAAuth;
use app\model\CachedIPAddress;
use app\model\Click;
use app\model\Domain;
use app\model\DomainUser;
use app\model\Session;
use app\model\ShortenLink;
use de\interaapps\ulole\core\jobs\JobModel;
use de\interaapps\ulole\orm\UloleORM;
use de\interaapps\ulole\core\Environment;
use de\interaapps\ulole\core\WebApplication;
use de\interaapps\ulole\core\traits\Singleton;
use de\interaapps\ulole\router\Request;

class App extends WebApplication
{
    private static $instance;

    use Singleton;

    public static function main(Environment $environment)
    {
        self::setInstance((new self()));
        self::$instance->start($environment);
    }

    public function init()
    {
        $this->getConfig()
            ->loadJSONFile("env.json");

        try {
            $this->initDatabase("database");
        } catch (\Exception $e) {
            die("An internal error occured. Please come back later.");
        }
        UloleORM::register("clicks", Click::class);
        UloleORM::register("domains", Domain::class);
        UloleORM::register("domains_users", DomainUser::class);
        UloleORM::register("shortlinks", ShortenLink::class);
        UloleORM::register("punyshort_sessions", Session::class);
        UloleORM::register("cached_ip_addresses", CachedIPAddress::class);

        UloleORM::register("uloleorm_jobs", JobModel::class);
        $this->getJobHandler()->setMode($this->getConfig()->get("jobs.mode", "database"));
    }

    public function run()
    {
        $router = $this->getRouter();


        $router->before("/(.*)", function (Request $req) {
            $req->setAttrib("loggedIn", false);

            if (IAAuth::loggedIn()) {
                $req->setAttrib("user", IAAuth::getUser());
                $req->setAttrib("loggedIn", true);
            }
        });

        $router->post("/api/v2/short", "api\\ApiV2Controller@create");
        $router->get("/api/v2/getinformation/(.*)", "api\\ApiV2Controller@getInformation");

        $router->post("/api/client/edit/(.*)", "api\\ClientAPIController@edit");
        $router->delete("/api/client/delete/(.*)", "api\\ClientAPIController@delete");

        $router->get("/user/links", 'dashboard\LinksController@getLinks');
        $router->get("/user/domains", 'dashboard\DomainsController@getDomains');

        $router->get("/ia/auth/user/login", "auth\\AuthController@login");
        $router->get("/user", "auth\\AuthController@getUser");

        $router->get("/links", "app.php");
        $router->get("/links/(.*)", "app.php");

        $router->get("/(.*)", "LinkController@redirect");
        $router->notFound("app.php");
    }
}
