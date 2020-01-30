<?php
namespace databases;

use modules\uloleorm\Table;
class ClicksTable extends Table {

    public $id, 
           $linkid,
           $day,
           $os,
           $browser,
           $country;
    
    public function database() {
        $this->_table_name_ = "clicks";
        $this->__database__ = "main";
    }

}
