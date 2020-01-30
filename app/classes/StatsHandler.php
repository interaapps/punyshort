<?php
namespace app\classes;

use ulole\core\classes\Response;
use \databases\ShortlinksTable;
use \databases\ClicksTable;
use \app\classes\Stats;

class StatsHandler {

    

    public static function getBrowserStats($browser, $linkId) {
        return count( (new ClicksTable)
                        ->select('id')
                        ->where("linkid", $linkId)
                        ->andwhere("browser", $browser)
                        ->get()
                );
    }

    public static function getOSStats($os, $linkId) {
        return count( (new ClicksTable)
                        ->select('id')
                        ->where("linkid", $linkId)
                        ->andwhere("os", $os)
                        ->get()
                );
    }

    public static function getCountryClicks($linkId) {
        $clicks = (new ClicksTable)
                        ->select('country')
                        ->where("linkid", $linkId)
                        ->get();
        $out = [];
        foreach ($clicks as $click) {
            if (!isset($out[$click["country"]]))
                $out[$click["country"]] = 1;
            else
                $out[$click["country"]] += 1;
        }
        if (isset($out[""])) {
            $out["other"] = $out[""];
            unset($out[""]);
        }
        return $out;

    }

    public static function getDayClicks($minusday, $linkId) {
        $day = date('Y-m-d',date(strtotime("-".$minusday."day")));
        return count( (new ClicksTable)
                        ->select('id')
                        ->where("linkid", $linkId)
                        ->andwhere("day", $day)
                        ->get()
                );
    }

    public static function getClicks($linkId) {
        return count( (new ClicksTable)
                        ->select('id')
                        ->where("linkid", $linkId)
                        ->get()
                );
    }

}