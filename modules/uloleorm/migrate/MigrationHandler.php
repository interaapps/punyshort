<?php
namespace modules\uloleorm\migrate;

/**
 * Handle Migrations
 * 
 * @author JulianFun123
 */

class MigrationHandler {

    public function handle($object) {
        $object->database();
    }
}