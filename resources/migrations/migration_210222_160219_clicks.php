<?php
namespace resources\migrations;

use de\interaapps\ulole\orm\Database;
use de\interaapps\ulole\orm\migration\Blueprint;
use de\interaapps\ulole\orm\migration\Migration;

/**
 * CHANGED: Created table
 */
class migration_210222_160219_clicks implements Migration {
    public function up(Database $database) {
        return $database->create("clicks", function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->timestamp("day");
            $blueprint->string("linkid");
            $blueprint->string("os");
            $blueprint->string("browser");
            $blueprint->string("country");
        });
    }

    public function down(Database $database) {
        return $database->drop("clicks");
        
    }
}