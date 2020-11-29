<?php
namespace app\controller\dashboard;

use app\auth\IAAuth;
use app\model\Domain;
use app\model\DomainUser;
use de\interaapps\ulole\router\Request;
use de\interaapps\ulole\router\Response;

class DomainsController {
    public static function getDomains(Request $req, Response $res){
        $out = [];

        foreach (Domain::where("is_default", 1)->all() as $domain) {
            $out[$domain->domain_name] = [
                "isPublic" => $domain->is_public,
                "isDefault" => $domain->is_default,
                "name" =>$domain->alias == null ? $domain->domain_name : $domain->alias
            ];
        }

        if (IAAuth::loggedIn()) {
            foreach (DomainUser::where("userid", IAAuth::getUser()->id)->all() as $domainUser){
                $domain = Domain::where("id", $domainUser->domainid)->get();

                if ($domain !== null) {
                    if (!isset($out[$domain->domain_name]))
                        $out[$domain->domain_name] = [
                            "isPublic" => $domain->is_public,
                            "isDefault" => $domain->is_default,
                            "name" =>$domain->alias == null ? $domain->domain_name : $domain->alias
                        ];
                }
            }
        }

        return $out;
    }
}