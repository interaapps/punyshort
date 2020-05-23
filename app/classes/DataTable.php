<?php
namespace app\classes;


use databases\AccountsTable;
use modules\uloleorm\Select;

class DataTable {
    public $rows = [];
    public $queryRows = null;
    private $table;
    private $extraRowDataFunction;
    private $customQuery;
    private $customBeforeSearchQuery;

    public function __construct($reflection, $rows) {
        $this->table = new \ReflectionClass($reflection);
        $this->rows = $rows;
        $this->extraRowDataFunction = function($key, $data){return [];};
        $this->customQuery = function ($select){};
        $this->customBeforeSearchQuery = function ($select){};
    }

    /**
     * @param \Closure $func($key, $value) -> returns array with key and values [""=>""]
     * @return DataTable
     */
    public function setExtraDataFunction(\Closure $func) : DataTable{
        $this->extraRowDataFunction = $func;
        return $this;
    }

    public function customQuery(\Closure $func){
        $this->customQuery = $func;
        return $this;
    }

    public function getCustomQuery(): \Closure{
        return $this->customQuery;
    }

    public function customBeforeSearchQuery(\Closure $func){
        $this->customBeforeSearchQuery = $func;
        return $this;
    }

    public function getBeforeSearchQuery(): \Closure{
        return $this->customBeforeSearchQuery;
    }

    public function getExtraRowDataFunction(): \Closure {
        return $this->extraRowDataFunction;
    }

    public function getTable() {
        return $this->table->newInstance();
    }
}