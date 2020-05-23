<?php
namespace app\controller;


use app\classes\DataTable;
use modules\uloleorm\Table;

class DataTableController {
    private static $dataTables = [];


    public static function addDataTable($name, DataTable $dataTable){
        self::$dataTables[$name] = $dataTable;
    }

    public static function api(){
        if (isset($_GET["table"]) &&
            isset(self::$dataTables[$_GET["table"]]) &&
            isset($_GET["limit"])      &&
            isset($_GET["sortBy"])     &&
            isset($_GET["sortDesc"])   &&
            isset($_GET["search"])     &&
            isset($_GET["page"])       &&
            is_numeric($_GET["limit"]) &&
            is_numeric($_GET["page"])    ) {

            $splitter = "";
            $selectQuery = "";
            foreach (self::$dataTables[$_GET["table"]]->rows as $dataTable) {
                $selectQuery .= $splitter.$dataTable;
                $splitter = ", ";
            }

            $query = self::$dataTables[$_GET["table"]]
                ->getTable()
                ->select($selectQuery);

            $countQuery = self::$dataTables[$_GET["table"]]
                ->getTable()
                ->count();


            self::$dataTables[$_GET["table"]]->getBeforeSearchQuery()($query);


            $alreadyLike = false;

            $query->alreadyUsedLike = true;
            $countQuery->alreadyUsedLike = true;

            $query->query .= " WHERE ( ";
            $countQuery->query .= " WHERE ( ";

            foreach (self::$dataTables[$_GET["table"]]->rows as $dataTable) {
                if ($alreadyLike) {
                    $query->or();
                    $countQuery->or();
                }

                $query->like($dataTable, "%".$_GET["search"]."%");
                $countQuery->like($dataTable, "%".$_GET["search"]."%");
                $alreadyLike = true;
            }

            $query->query .= " ) ";
            $countQuery->query .= " ) ";


            self::$dataTables[$_GET["table"]]->getCustomQuery()($query);
            self::$dataTables[$_GET["table"]]->getCustomQuery()($countQuery);

            if (!in_array($_GET["sortBy"], self::$dataTables[$_GET["table"]]->rows))
                $_GET["sortBy"] = self::$dataTables[$_GET["table"]]->rows[0];


            $query->order($_GET["sortBy"].($_GET["sortDesc"]=="true" ? " DESC " : ""));
            
            $query->limit($_GET["limit"]);
            if ($_GET["page"] > 0)
                $query->query .= " OFFSET ".($_GET["page"]*$_GET["limit"]);


            

            $data = $query->get();

            $out = [];
            foreach ($data as $keys) {
                $row = [];
                $values = [];
                $extraData = ["_"=>""];
                $options = (object) ["delete"=>false];
                foreach ($keys as $key=>$val) {
                    if (in_array($key, self::$dataTables[$_GET["table"]]->rows))
                        $values[$key] = $val;

                    foreach (self::$dataTables[$_GET["table"]]->getExtraRowDataFunction()($key, $val, $options) as $extraKey => $extraValue) {
                        $extraData[$extraKey] = $extraValue;
                    }
                }
                if (!$options->delete)
                    array_push($out, ["values"=>$values, "extra"=>$extraData]);
            }


            return [
                "count"=>$countQuery->get(),
                "pageRowNum"=> count($data),
                "data"=>$out
            ];
        } else {
            return ["done"=>false];
        }
    }
}