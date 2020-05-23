<?php
namespace databases;

use modules\uloleorm\Table;
class DomainRequestsTable extends Table {

    public $id,
           $domain_name,
           $userid,
           $is_public,
           $code,
           $created;
    
    public function database() {
        $this->_table_name_ = "domains";
        $this->__database__ = "main";
    }

}
