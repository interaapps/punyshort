<?php
namespace modules\uloleorm;

class Update extends Selector {
    public $that,
           $query,
           $con;
    function __construct($that, $select, $con) {
        $this->that  = $that;
        $this->con   = $con->getObject();
        $this->query = 'UPDATE '.$this->that->_table_name_;
    }

    function set($set, $to) {
        $this->query .= ' SET '.$this->escapeString($set).'="'.$this->escapeString($to).'"';
        return $this;
    }

    function andset($set, $to) {
        $this->query .= ' , '.$this->escapeString($set).'="'.$this->escapeString($to).'"';
        return $this;
    }

    function byVars() {
        $outputString = "";
        foreach ($this->that as $key=>$value) {
            if ($key !== "_table_name_" && $key !== "__databaseObj__" && $key !== "__database__" ) {
                if (isset($value)) {
                    if ($outputString == "") {
                        $outputString .= ' SET ';
                        $outputString .= '`'.$this->escapeString($key).'`="'.$this->escapeString($value).'" ';
                    } else {
                        $outputString .= ', `'.$this->escapeString($key).'`="'.$this->escapeString($value).'" ';
                    }
                }
            }
        }

        $this->query .= $outputString;
        return $this;
    }


}