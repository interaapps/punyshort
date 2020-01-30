<?php
namespace databases;

use modules\uloleorm\Table;
class ShortlinksTable extends Table {

    public $id,
           $name,
           $link,
           $userid,
           $ip,
           $blocked,
           $created;
    
    public function database() {
        $this->_table_name_ = "shortlinks";
        $this->__database__ = "main";
    }

}
