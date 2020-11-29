<?php
namespace app\model;

use de\interaapps\ulole\core\traits\JSONModel;
use de\interaapps\ulole\orm\ORMHelper;
use de\interaapps\ulole\orm\ORMModel;

class ShortenLink {
    
    use ORMModel;
    use ORMHelper;
    use JSONModel;
    
    public $id,
           $name,
           $link,
           $userid,
           $domain,
           $ip,
           $blocked,
           $created;
}