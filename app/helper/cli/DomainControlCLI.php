<?php

namespace app\helper\cli;

use app\model\Domain;
use app\model\DomainUser;
use de\interaapps\ulole\core\cli\CLI;
use de\interaapps\ulole\core\cli\CLIHandler;
use de\interaapps\ulole\core\cli\Colors;

class DomainControlCLI extends CLIHandler
{
    public function registerCommands(CLI $cli)
    {
        $cli->register("domain:add", function ($args) {
            $domainName = $args[2];
            $public = isset($args[3]) ? $args[3] : "0";
            $default = isset($args[4]) ? $args[4] : "0";
            $alias = isset($args[5]) ? $args[5] : null;
            if (!isset($domainName)) {
                Colors::error("Use php cli domain:create <domain_name> [<is_public=0>, <is_default=0>, <alias=null>]");
                die();
            }
            $domain = new Domain();
            $domain->domain_name = $domainName;
            $domain->is_default = $default;
            $domain->is_public = $public;
            $domain->alias = $alias;
            if ($domain->save()) {
                Colors::done("Created a domain with the id of " . $domain->id);
            } else {
                Colors::error("Error while saving.");
            }
        }, "Adds a domain");

        $cli->register("domain:add_user", function ($args) {
            if (!isset($args[2]) || !isset($args[3])) {
                Colors::error("Use php cli domain:add_user <domain_name/id> <user_id>");
                die();
            }
            $domainId = $args[2];

            if (!is_numeric($domainId)) {
                $domainId = Domain::where("domain_name", $domainId)->get()->id;
            }

            $userId = $args[3];
            $domainUser = new DomainUser();
            $domainUser->domainid = $domainId;
            $domainUser->userid = $userId;
            if ($domainUser->save()) {
                Colors::done("Created a user-link with the id of " . $domainUser->id);
            } else {
                Colors::error("Error while saving.");
            }
        }, "Adds a user to a domain");
    }
}