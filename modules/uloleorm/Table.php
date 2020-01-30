<?php
namespace modules\uloleorm;

class Table {
    public $_table_name_, $__database__, $__databaseObj__;

    function save() {

        $con = $this->__databaseObj__->getObject();
        $query_keys = "";
        $query_values = "";
        $preparedValues = [];
        foreach ($this as $a=>$b) {
            if ($a !== "_table_name_" && $a !== "__database__" && $a !== "__databaseObj__")
                if ($query_values=="") {
                    if (isset($b)) {
                        $query_values .= "?";
                        $query_keys .= "`" . $a . "`";
                        array_push($preparedValues, $b);
                    }
                } else {
                    if (isset($b)) {
                        $query_values .= ", ?";
                        $query_keys .= ", `" . $a . "`";
                        array_push($preparedValues, $b);
                    }
                }
        }
        $query = "INSERT INTO `".$this->_table_name_."` (".$query_keys.") VALUES (".$query_values.");";
        
        $statement = $con->prepare($query);
        return $statement->execute($preparedValues);
    }

    public function __construct() {
        $this->__database__ = "main";
        $this->database();
        $this->__databaseObj__ = SQL::$databases[$this->__database__];
    }

    function getObject() {
        return $this->__databaseObj__->getObject();
    }

    function query($query) {
        return $this->__databaseObj__->getObject()->query($query);
    }

    
    function select($select = "*") {
        $con = $this->__databaseObj__->getObject();
        return (new Select($this, $select, $this->__databaseObj__));
    }

    function delete($select = "*") {
        $con = $this->__databaseObj__->getObject();
        return (new Delete($this, $select, $this->__databaseObj__));
    }

    function update($select = "*") {
        $con = $this->__databaseObj__->getObject();
        return (new Update($this, $select, $this->__databaseObj__));
    }
}