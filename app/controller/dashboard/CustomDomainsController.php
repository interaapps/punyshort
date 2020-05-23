<?php
namespace app\controller\Dashboard;

use \app\classes\user\User;

class CustomDomainsController
{

    public static function page() {
        return view("dashboard/domains", [
            "user"=>User::$user
        ]);
    }

    public static function getDomains(){
        if (USER_LOGGEDIN) {
            $out = [];
            
            foreach ((new \databases\DomainUsersTable)->select("domainid")->where("userid", User::$user->id)->get() as $domainUser ) {
                array_push($out, [
                    "customUrl"=>true,
                    "domain"=>(new \databases\DomainsTable)->select("domain_name")->where("id", $domainUser["domainid"])->first()["domain_name"]
                ]);
            }

            foreach ((new \databases\DomainsTable)->select("domain_name")->where("is_default", "1")->get() as $domain ) {
                array_push($out, [
                    "customUrl"=>false,
                    "domain"=>$domain["domain_name"]
                ]);
            }

            return $out;
        }

        return [];
    }

/*
    public static function requestDomain(){
        $out = [
            "done"=>false
        ];

        if (isset($_POST["domain"]) && (new \databases\DomainRequestsTable)->count()->where("domain_name", $_POST["domain"])->andwhere("userid", User::$user->id)->get() == 0) {
            $domainRequest = new \databases\DomainRequestsTable;
            $domainRequest->save();
        }

        return $out;
    }

    public static function checkDomain(){
        $out = [
            "done"=>false
        ];

        return $out;
    }
*/
}