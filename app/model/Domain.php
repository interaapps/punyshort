<?php

namespace app\model;

use de\interaapps\ulole\core\traits\JSONModel;
use de\interaapps\ulole\orm\ORMHelper;
use de\interaapps\ulole\orm\ORMModel;

class Domain
{

    use ORMModel;
    use ORMHelper;
    use JSONModel;

    public $id,
        $domain_name,
        $alias,
        $is_default,
        $is_public,
        $created;
}