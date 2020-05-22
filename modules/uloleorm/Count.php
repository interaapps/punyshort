<?php
namespace modules\uloleorm;


class Count extends Selector {
    public $that,
        $query,
        $con;

    function __construct($that, $con) {
        $this->that  = $that;
        $this->con   = $con->getObject();
        $this->query = 'SELECT COUNT(*) as count FROM '.$this->that->_table_name_;
    }

    function get() {
        return $this->con->query($this->query.';')->fetch()["count"];
    }

}