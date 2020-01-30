<?php
namespace modules\uloleorm\migrate;

class MigrationObjects {
    public $queryArray = [];

    public function queryCombinder($obj) {
        $this->queryArray[$obj->fieldName] = $obj;
    }

    public function string(string $field, $length=false) {
        if ($length===false)
            $databaseObject = new DatabaseObject("TEXT", $field);
        else {
            $databaseObject = new DatabaseObject("VARCHAR", $field);
            $databaseObject->length = $length;
        }
        $this->queryCombinder($databaseObject);
        return $databaseObject;
    }

    public function char(string $field) {
        $databaseObject = new DatabaseObject("CHAR", $field);
        $this->queryCombinder($databaseObject);
        return $databaseObject;
    }

    public function varchar(string $field, $length=11) {
        $databaseObject = new DatabaseObject("VARCHAR", $field);
        $databaseObject->length = $length;
        $this->queryCombinder($databaseObject);
        return $databaseObject;
    }

    public function text(string $field) {
        $databaseObject = new DatabaseObject("TEXT", $field);
        $this->queryCombinder($databaseObject);
        return $databaseObject;
    }

    public function enum(string $field, $enums=[]) {
        $databaseObject = new DatabaseObject("ENUM", $field);
        $databaseObject->setEnum($enums);
        $this->queryCombinder($databaseObject);
        return $databaseObject;
    }

    public function tinyint(string $field) {
        $databaseObject = new DatabaseObject("TINYINT", $field);
        $this->queryCombinder($databaseObject);
        return $databaseObject;
    }

    public function smallint(string $field) {
        $databaseObject = new DatabaseObject("SMALLINT", $field);
        $this->queryCombinder($databaseObject);
        return $databaseObject;
    }

    public function mediumint(string $field) {
        $databaseObject = new DatabaseObject("MEDIUMINT", $field);
        $this->queryCombinder($databaseObject);
        return $databaseObject;
    }

    public function int(string $field) {
        $databaseObject = new DatabaseObject("INT", $field);
        $this->queryCombinder($databaseObject);
        return $databaseObject;
    }

    public function bigint(string $field) {
        $databaseObject = new DatabaseObject("BIGINT", $field);
        $this->queryCombinder($databaseObject);
        return $databaseObject;
    }

    public function decimal(string $field) {
        $databaseObject = new DatabaseObject("DECIMAL", $field);
        $this->queryCombinder($databaseObject);
        return $databaseObject;
    }

    public function float(string $field) {
        $databaseObject = new DatabaseObject("FLOAT", $field);
        $this->queryCombinder($databaseObject);
        return $databaseObject;
    }

    public function double(string $field) {
        $databaseObject = new DatabaseObject("DOUBLE", $field);
        $this->queryCombinder($databaseObject);
        return $databaseObject;
    }

    public function real(string $field) {
        $databaseObject = new DatabaseObject("REAL", $field);
        $this->queryCombinder($databaseObject);
        return $databaseObject;
    }
    
    public function bit(string $field) {
        $databaseObject = new DatabaseObject("BIT", $field);
        $this->queryCombinder($databaseObject);
        return $databaseObject;
    }

    public function boolean(string $field) {
        $databaseObject = new DatabaseObject("BOOLEAN", $field);
        $this->queryCombinder($databaseObject);
        return $databaseObject;
    }

    public function serial(string $field) {
        $databaseObject = new DatabaseObject("SERIAl", $field);
        $this->queryCombinder($databaseObject);
        return $databaseObject;
    }



    public function date(string $field) {
        $databaseObject = new DatabaseObject("DATE", $field);
        $this->queryCombinder($databaseObject);
        return $databaseObject;
    }

    public function datetime(string $field) {
        $databaseObject = new DatabaseObject("DATETIME", $field);
        $this->queryCombinder($databaseObject);
        return $databaseObject;
    }

    public function timestamp(string $field) {
        $databaseObject = new DatabaseObject("TIMESTAMP", $field);
        $this->queryCombinder($databaseObject);
        return $databaseObject;
    }

    public function time(string $field) {
        $databaseObject = new DatabaseObject("TIME", $field);
        $this->queryCombinder($databaseObject);
        return $databaseObject;
    }

    public function year(string $field) {
        $databaseObject = new DatabaseObject("YEAR", $field);
        $this->queryCombinder($databaseObject);
        return $databaseObject;
    }



    public function binary(string $field) {
        $databaseObject = new DatabaseObject("BINARY", $field);
        $this->queryCombinder($databaseObject);
        return $databaseObject;
    }

    public function varbinary(string $field) {
        $databaseObject = new DatabaseObject("VARBINARY", $field);
        $this->queryCombinder($databaseObject);
        return $databaseObject;
    }


    public function tinyblob(string $field) {
        $databaseObject = new DatabaseObject("TINYBLOB", $field);
        $this->queryCombinder($databaseObject);
        return $databaseObject;
    }

    public function mediumblob(string $field) {
        $databaseObject = new DatabaseObject("MEDIUMBLOB", $field);
        $this->queryCombinder($databaseObject);
        return $databaseObject;
    }

    public function longblob(string $field) {
        $databaseObject = new DatabaseObject("LONGBLOB", $field);
        $this->queryCombinder($databaseObject);
        return $databaseObject;
    }

    public function blob(string $field) {
        $databaseObject = new DatabaseObject("BLOB", $field);
        $this->queryCombinder($databaseObject);
        return $databaseObject;
    }

    public function custom($type, string $field) {
        $databaseObject = new DatabaseObject($type, $field);
        $this->queryCombinder($databaseObject);
        return $databaseObject;
    }

}