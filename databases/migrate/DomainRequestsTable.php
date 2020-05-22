<?php
namespace databases\migrate;

use modules\uloleorm\migrate\Migrate;

class DomainRequestsTable extends Migrate {
    public function database() {
        $this->create('domain_requests', function($table) {
            $table->int("id")->ai();
            $table->int("userid");
            $table->string("domain_name");
            $table->int("is_public")->default("1");
            $table->text("code");
            $table->timestamp("created")->currentTimestamp();
        });
    }
}
