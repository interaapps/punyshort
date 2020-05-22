<?php
namespace databases\migrate;

use modules\uloleorm\migrate\Migrate;

class DomainUsersTable extends Migrate {
    public function database() {
        $this->create('domains_users', function($table) {
            $table->int("id")->ai();
            $table->int("userid")->default("0");
            $table->int("domainid")->default("1");
            $table->timestamp("created")->currentTimestamp();
        });
    }
}
