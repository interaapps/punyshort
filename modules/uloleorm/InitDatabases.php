<?php
namespace modules\uloleorm;

class InitDatabases {
    public static function init($db, $values) {
        SQL::$databases[$db] = new SQL(
            $values->username,
            $values->password,
            $values->database,
            $values->server,
            $values->port,
            $values->driver
        );
    }
}
?>