<?php
namespace databases\migrate;

use modules\uloleorm\migrate\Migrate;
/**
 * MIGRATIONS WILL BE ADDED SOON
 */
class PunyShortSessionsTable extends Migrate {
    public function database() {
        $this->create('punyshort_sessions', function($table) {
            $table->string("id")->unique();
            $table->string("session_id");
            $table->int("userid");
            $table->string("user_key");
        });
    }
}
