<?php
namespace resources\migrations;

use de\interaapps\ulole\orm\Database;
use de\interaapps\ulole\orm\migration\Blueprint;
use de\interaapps\ulole\orm\migration\Migration;

/**
 * CHANGED: Created table
 */
class migration_210222_160229_domain_users implements Migration {
    public function up(Database $database) {
        return $database->create("domain_users", function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->int("userid");
            $blueprint->int("domainid");
            $blueprint->timestamp("created")->currentTimestamp();
        });
    }

    public function down(Database $database) {
        return $database->drop("domain_users");
        
    }
}