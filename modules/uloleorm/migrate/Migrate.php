<?php
namespace modules\uloleorm\migrate;

/**
 * Migrates Databases Schemas
 * 
 * @author JulianFun123
 */
class Migrate {
    public $connection;
    private $executeQuery, $tableName;
    
    public function database() {
        throw new Exception("database method is unset!");
    }

    public function updateFromCLI() {
        $this->migrateFromCLI(2);
        
        $qu = $this->connection->query("SELECT * FROM `".$this->tableName."`;");
        $qu3 = $this->connection->query("SELECT * FROM `".$this->tableName."`;");
        $quFetched = $qu->fetchAll();
        $columns = [];
        for ($i = 0; $i < $qu->columnCount(); $i++) {
            $col = $qu->getColumnMeta($i);
            $columns[$i] = $col['name'];
        }
        $insert = "";
        $insertValues = [];
        foreach ($qu3->fetchAll() as $obj) {
            foreach ($columns as $a=>$b) {
                $insertValues[$a] = $b;
            }
        }
        $this->connection->query("DROP TABLE ".$this->tableName);
        $this->executeQuery = 1;
        $this->database();

        // backup query
        $qu2 = $this->connection->query("SELECT * FROM `".$this->tableName."`;");
        $columns = [];
        $columnNames = [];
        for ($i = 0; $i < $qu2->columnCount(); $i++) {
            $col = $qu2->getColumnMeta($i);
            $columns[$i] = $col['name'];
            array_push($columnNames, $col['name']);
        }
        $insert = "";
        foreach ($quFetched as $obj) {
            $comma = "";
            $insertQueryKeys = "(";
            $insertQueryValues = "(";
            foreach ($insertValues as $key=>$value) {
                if (in_array($value, $columnNames)) {
                    $insertQueryKeys .= $comma."`".$value."`";
                    $insertQueryValues .= $comma."'".str_replace("'", "\'", $obj[$value])."'";
                    $comma = ", ";
                } 
            }
            $insertQueryKeys .= ")";
            $insertQueryValues .= ")";
            
            $insert .= 'INSERT INTO `'.$this->tableName.'` '.$insertQueryKeys.'VALUES'.$insertQueryValues.";";
        }
        $this->connection->query($insert);

        //$this->connection->query($insert);
    }

    public function migrateFromCLI($execute=1) {
        global $SQL_DATABASES, 
               $fromCLI_Database;
        $this->connection = $fromCLI_Database->getObject();
        $this->executeQuery = $execute;
        $this->database();
    }

    public function create($tableName, $function) {
        $migrationObject = new MigrationObjects;
        $function($migrationObject);
        //echo json_encode($migrationObject->queryArray);
        $this->tableName = $tableName;
        $query = "CREATE TABLE IF NOT EXISTS `".$tableName."` (";
        $comma = "";
        if ($this->executeQuery != 2)
        foreach($migrationObject->queryArray as $name=>$obj) {
                
            $query .= $comma."\n    `".$name."` ".$obj->type
                   .(($obj->length!==false)?"(".$obj->length.")":"")
                   .(($obj->ai)?" AUTO_INCREMENT":"")
                   .(($obj->unique)?" UNIQUE":"")
                   .(($obj->currentTimestamp)?" DEFAULT CURRENT_TIMESTAMP":"")

                   .(($obj->default!==null)?" DEFAULT ".$obj->default:"")
                   .(($obj->defaultNull) ? " DEFAULT NULL" : "")
                   .(" ".$obj->custom. " ")
                   .(($obj->ai)?" , \nPRIMARY KEY (`".$name."`)":"");
            $comma = ",";
        }
        
        $query .= "\n)";
        if ($this->executeQuery == 1)
            $this->connection->query($query);
        elseif ($this->executeQuery == 2)
            echo "";
        else
            echo $query;
    }
}