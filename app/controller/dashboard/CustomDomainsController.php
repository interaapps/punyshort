<?php
namespace app\controller\Dashboard;

class CustomDomainsController
{

    public static function page() {
        return view("dashboard/domains", [
            "user"=>\app\classes\user\User::$user
        ]);
    }

    public static function getDomains(){
        if (USER_LOGGEDIN) {
            $out = [];
            
            foreach ((new \databases\DomainUsersTable)->select("domainid")->where("userid", \app\classes\user\User::$user->id)->get() as $domainUser ) {
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

}