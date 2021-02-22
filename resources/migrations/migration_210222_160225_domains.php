<?php
namespace resources\migrations;

use de\interaapps\ulole\orm\Database;
use de\interaapps\ulole\orm\migration\Blueprint;
use de\interaapps\ulole\orm\migration\Migration;

/**
 * CHANGED: Created table
 */
class migration_210222_160225_domains implements Migration {
    public function up(Database $database) {
        return $database->create("domains", function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->string("domain_name");
            $blueprint->string("alias")->nullable(true);
            $blueprint->int("is_default")->default("0");
            $blueprint->int("is_public")->default("1");
            $blueprint->timestamp("created")->currentTimestamp();
        });
    }

    public function down(Database $database) {
        return $database->drop("domains");
        
    }
}