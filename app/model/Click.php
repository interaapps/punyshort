<?php

namespace app\model;

use de\interaapps\ulole\core\traits\JSONModel;
use de\interaapps\ulole\orm\ORMHelper;
use de\interaapps\ulole\orm\ORMModel;

class Click
{

    use ORMModel;
    use ORMHelper;
    use JSONModel;

    public $id,
        $linkid,
        $day,
        $os,
        $browser,
        $country;
}