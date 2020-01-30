<?php
namespace app\controller\docs;

class DocsV1Controller {
    
    const PAGES = [
        ""=>"app/docs/v1/index.html"
    ];

    public static function page() {
        global $_ROUTEVAR;

        
        if (isset(self::PAGES[$_ROUTEVAR[1]]) ) {
            return view("docs/v1", ["doc"=>file_get_contents(self::PAGES[$_ROUTEVAR[1]])]);
        }
        
        return view("404");
    }

}