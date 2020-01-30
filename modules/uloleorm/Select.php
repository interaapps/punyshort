<?php
namespace modules\uloleorm;

class Select extends Selector {
    public $that,
           $query,
           $con;
    function __construct($that, $select, $con) {
        $this->that  = $that;
        $this->con   = $con->getObject();
        $this->query = 'SELECT '.$select.' FROM '.$this->that->_table_name_;
    }

  
    function limit($limit) {
        $this->query .= 'LIMIT '.$limit;
        return $this;
    }

    function order($order) {
        $this->query .= 'ORDER BY '.$order;
        return $this;
    }


    function get() {
        return $this->con->query($this->query.';')->fetchAll();        
    }

    function first() {
        return $this->con->query($this->query.';')->fetch();
    }
}