<?php
namespace resources\migrations;

use de\interaapps\ulole\orm\Database;
use de\interaapps\ulole\orm\migration\Blueprint;
use de\interaapps\ulole\orm\migration\Migration;

/**
 * CHANGED: Created table
 */
class migration_210222_160240_shortenlinks implements Migration {
    public function up(Database $database) {
        return $database->create("shortlinks", function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->string("name");
            $blueprint->string("link");
            $blueprint->int("userid");
            $blueprint->string("domain");
            $blueprint->string("ip");
            $blueprint->int("blocked");
            $blueprint->timestamp("created")->currentTimestamp();
        });
    }

    public function down(Database $database) {
        return $database->drop("shortlinks");
        
    }
}