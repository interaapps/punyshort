<?php
namespace databases;

use modules\uloleorm\Table;
class PunyShortSessionsTable extends Table {

    public $id, 
           $session_id,
           $userid,
           $user_key;
    
    public function database() {
        $this->_table_name_ = "punyshort_sessions";
        $this->__database__ = "main";
    }

}
