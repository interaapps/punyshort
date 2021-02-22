<?php
namespace resources\migrations;

use de\interaapps\ulole\orm\Database;
use de\interaapps\ulole\orm\migration\Blueprint;
use de\interaapps\ulole\orm\migration\Migration;

/**
 * CHANGED: Created table
 */
class migration_210222_170249_cached_ip_addresses implements Migration {
    public function up(Database $database) {
        return $database->create("cached_ip_addresses", function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->string("ip_address");
            $blueprint->string("country");
            $blueprint->timestamp("created_at")->currentTimestamp();
        });
    }

    public function down(Database $database) {
        return $database->drop("cached_ip_addresses");
        
    }
}