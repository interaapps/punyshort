<?php
namespace modules\uloleorm;

class Selector {
    public $alreadyUsedLike = false;

    function andwhere($sel1, $operator, $sel2=null) {
        if ($sel2 == null) {
            $sel2 = $operator;
            $operator = "=";
        }

        $this->query .= ' AND '.$this->escapeString($sel1).' '.$operator.'"'.$this->escapeString($sel2).'"';
        return $this;
    }

    function escapeString($str) {
        if (strlen($str)>0)
        if ($str[strlen($str)-1]=="\\") {
            $str[strlen($str)-1] = "\\";
            $str[strlen($str)] = "\\";
        }
        
        return  str_replace('"', '\"', $str);
    }

    function orwhere($sel1, $operator, $sel2=null) {
        if ($sel2 == null) {
            $sel2 = $operator;
            $operator = "=";
        }

        $this->query .= ' OR '.$this->escapeString($sel1).' '.$operator.'"'.$this->escapeString($sel2).'"';
        return $this;
    }

    function where($sel1, $operator, $sel2=null) {
        if ($sel2 == null) {
            $sel2 = $operator;
            $operator = "=";
        }

        $this->query .= ' WHERE  '.$this->escapeString($sel1).' '.$operator.'"'.$this->escapeString($sel2).'"';
        return $this;
    }

    function like($sel1, $sel2=null) {
        $this->query .= ' '.( !$this->alreadyUsedLike ? "WHERE" : "" ).' '.$this->escapeString($sel1).' LIKE "'.$this->escapeString($sel2).'"';
        $this->alreadyUsedLike = true;
        return $this;
    }

    function or(){
        $this->query .= ' OR ';
        return $this;
    }

    function and(){
        $this->query .= ' AND ';
        return $this;
    }

    function run() {
        return $this->con->query($this->query.';');
    } 

}