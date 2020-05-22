<?php
namespace databases;

use modules\uloleorm\Table;
class DomainUsersTable extends Table {

    public $id,
           $userid,
           $domainid,
           $created;
    
    public function database() {
        $this->_table_name_ = "domains_users";
        $this->__database__ = "main";
    }

}
