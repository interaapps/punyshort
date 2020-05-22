<?php
namespace app\classes;


use databases\AccountsTable;
use modules\uloleorm\Select;

class DataTable {
    public $rows = [];
    private $table;
    private $extraRowDataFunction;
    private $customQuery;

    public function __construct($reflection, $rows) {
        $this->table = new \ReflectionClass($reflection);
        $this->rows = $rows;
        $this->extraRowDataFunction = function($key, $data){return [];};
        $this->customQuery = function ($select){};
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

    public function getExtraRowDataFunction(): \Closure {
        return $this->extraRowDataFunction;
    }

    public function getTable() {
        return $this->table->newInstance();
    }
}