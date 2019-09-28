<?php
namespace modules\uloleorm;

class Selector {
    function andwhere($sel1, $operator, $sel2=null) {
        if ($sel2 == null) {
            $sel2 = $operator;
            $operator = "=";
        }

        $this->query .= ' AND '.$this->escapeString($sel1).''.$operator.'"'.$this->escapeString($sel2).'"';
        return $this;
    }

    function escapeString($str) {
        return str_replace('"', '\"', $str);
    }

    function orwhere($sel1, $operator, $sel2=null) {
        if ($sel2 == null) {
            $sel2 = $operator;
            $operator = "=";
        }

        $this->query .= ' OR '.$this->escapeString($sel1).''.$operator.'"'.$this->escapeString($sel2).'"';
        return $this;
    }

    function where($sel1, $operator, $sel2=null) {
        if ($sel2 == null) {
            $sel2 = $operator;
            $operator = "=";
        }

        $this->query .= ' WHERE '.$this->escapeString($sel1).''.$operator.'"'.$this->escapeString($sel2).'"';
        return $this;
    }

    function run() {
        return $this->con->query($this->query.';');
    } 

}