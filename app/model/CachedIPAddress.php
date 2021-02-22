<?php

namespace app\model;

use de\interaapps\ulole\orm\ORMModel;

class CachedIPAddress
{
    use ORMModel;

    public $id,
        $ip_address,
        $country,
        $created_at;

    protected $ormSettings = [
        'identifier' => 'id'
    ];
}