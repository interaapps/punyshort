<?php
namespace databases;

use modules\uloleorm\Table;
class ShortlinksTable extends Table {

    public $id,
           $name,
           $link,
           $userid = "0",
           $ip = "0.0.0.0",
           $blocked = 0,
           $created;
    
    public function database() {
        $this->_table_name_ = "shortlinks";
        $this->__database__ = "main";
    }

}
