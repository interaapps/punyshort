<?php
namespace databases;

use modules\uloleorm\Table;
class DomainsTable extends Table {

    public $id,
           $domain_name,
           $is_default,
           $is_public,
           $created;
    
    public function database() {
        $this->_table_name_ = "domains";
        $this->__database__ = "main";
    }

}
