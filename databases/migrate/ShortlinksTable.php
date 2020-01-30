<?php
namespace databases\migrate;

use modules\uloleorm\migrate\Migrate;
/**
 * MIGRATIONS WILL BE ADDED SOON
 */
class TestTable extends Migrate {
    public function database() {
        $this->create('User', function($table) {
            $table->int("id")->ai();
            $table->string("username");
            $table->string("password", 255);
            $table->enum("enumTest", ["val1","val2"]);
        });
    }
}
