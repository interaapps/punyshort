<?php
namespace resources\migrations;

use de\interaapps\ulole\orm\Database;
use de\interaapps\ulole\orm\migration\Blueprint;
use de\interaapps\ulole\orm\migration\Migration;

/**
 * CHANGED: Created table
 */
class migration_210222_160234_sessions implements Migration {
    public function up(Database $database) {
        return $database->create("punyshort_sessions", function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->string("session_id");
            $blueprint->int("user_id");
            $blueprint->string("user_key");
        });
    }

    public function down(Database $database) {
        return $database->drop("punyshort_sessions");
        
    }
}