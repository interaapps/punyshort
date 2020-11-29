<?php
namespace app\model;

use de\interaapps\ulole\core\traits\JSONModel;
use de\interaapps\ulole\orm\ORMHelper;
use de\interaapps\ulole\orm\ORMModel;

class Session {
    
    use ORMModel;
    use ORMHelper;
    use JSONModel;
    
    public $id, 
        $session_id, 
        $userid, 
        $user_key;
}