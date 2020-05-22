<?php
namespace app\controller\api;

use app\classes\Link;

class ApiV1Controller
{

    /**
     * This is the old version of the PunyShort API
     * This is deprecated! - Don't use it
     * 
     * @deprecated
     */
    public static function create() {
        return "Deprecated";
/*
        if (isset($_GET["shortlink"]))
            $shortlink = $_GET["shortlink"];

        if (isset($_POST["shortlink"])) 
            $shortlink = $_POST["shortlink"];

        header('Content-type: application/json');
        header('Access-Control-Allow-Origin: *');
        if (!isset($_GET["get_informations"])) {
            if (isset($shortlink)) {
                if ($shortlink != "") {

                $linkt = $shortlink;
                    if (strpos(strtolower($shortlink), "https://") !== false || strpos(strtolower($shortlink), "http://") !== false) {

                        $linkQuery = (new \databases\ShortlinksTable)
                                        ->select('*')
                                        ->where("link", $linkt)
                                        ->first();

                        if ($linkQuery["link"] == null) {

                            $newLink = new Link($linkt);
                            $newLinkLink = $newLink->create();

                            if ($newLinkLink["done"]) {
                                    echo '
                                        {
                                        "url": "'.$newLinkLink["link"].'",
                                        "clicks": "0",
                                        "new": "true",
                                        "error": "none"
                                        }
                                    ';
                            } else {
                                echo '
                                    {
                                    "url": "!error!",
                                    "clicks": "0",
                                    "new": "error",
                                    "error": "err"
                                    }
                                ';
                            }
                        } else {
                            $clicks = count(
                                (new \databases\ClicksTable)
                                    ->select('id')
                                    ->where("linkid", $linkQuery["id"])
                                    ->get() );

                            echo '
                                {
                                    "url": "'.$linkQuery["name"].'",
                                    "clicks": "'.$clicks.'",
                                    "new": "false",
                                    "error": "none"
                                }
                            ';
                        }

                    } else {
                        echo '
                            {
                            "url": "!error!",
                            "clicks": "0",
                            "new": "error",
                            "error": "HttpOrHttpsMissing"
                            }
                        ';

                    }
                } else {
                    echo '
                        {
                        "url": "!error!",
                        "clicks": "0",
                        "new": "error",
                        "error": "Unset"
                        }
                    ';

                }





            } else {

                echo '
                    {
                    "url": "!error!",
                    "clicks": "0",
                    "new": "error",
                    "error": "Unset"
                    }
                ';
            }
        }


        if (isset($_GET["get_informations"])) {

        $linkname = $_GET["get_informations"];

            $linkObject = (new \databases\ShortlinksTable)
                            ->select('*')
                            ->where('name', $linkname)
                            ->first();

            $clicks2 = count((new \databases\ClicksTable)
                            ->select('*')
                            ->where("linkid", $linkObject['id'])
                            ->get());

                        echo '{
"url": "'.$linkObject["link"].'",
"clicks": "'.$clicks2.'",
"new": "false",
"error": "none"
}';
        }
        */
    }

}
