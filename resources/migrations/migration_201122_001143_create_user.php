<?php
namespace resources\migrations;

use app\helper\factories\UserFactory;
use de\interaapps\ulole\orm\Database;
use de\interaapps\ulole\orm\migration\Blueprint;
use de\interaapps\ulole\orm\migration\Migration;

/**
 * CHANGED: Created table
 */
class migration_201122_001143_create_user implements Migration {
    public function up(Database $database) {
        $creationResult = $database->create("users", function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->string("name")->nullable(true);
            $blueprint->string("password")->nullable(true);
            $blueprint->enum("gender", ["FEMALE", "MALE", "OTHER", "NO_ANSWER"])->default('NO_ANSWER');
            $blueprint->timestamp("created_at")->currentTimestamp();
        });

        // Creating some example users
        UserFactory::run(25);

        return $creationResult;
    }

    public function down(Database $database) {
        return $database->drop("users");
    }
}