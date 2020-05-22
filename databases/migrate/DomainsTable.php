<?php
namespace databases\migrate;

use modules\uloleorm\migrate\Migrate;

class DomainsTable extends Migrate {
    public function database() {
        $this->create('domains', function($table) {
            $table->int("id")->ai();
            $table->string("domain_name");
            $table->int("is_default")->default("0");
            $table->int("is_public")->default("1");
            $table->timestamp("created")->currentTimestamp();
        });
    }
}
