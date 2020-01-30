<?php
namespace app\controller\docs;

class DocsV2Controller {
    
    const PAGES = [
        ""=>"app/docs/v2/overview.md",
        "short"=>"app/docs/v2/short.md",
        "error"=>"app/docs/v2/error.md",
        "getinformation"=>"app/docs/v2/getinformation.md"
    ];

    const PAGES_LINKS = [
        "Overview"=>"/docs/v2",
        "Short a link"=>"/docs/v2/short",
        "Get Link Information"=>"/docs/v2/getinformation",

        "Errors"=>"/docs/v2/error"
    ];

    public static function page() {
        global $_ROUTEVAR;

        
        if (isset(self::PAGES[$_ROUTEVAR[1]]) ) {
            $file = (new \modules\parsedown\Parsedown)->text(file_get_contents(self::PAGES[$_ROUTEVAR[1]]));
            return view("docs/v2", [
                "doc"=>$file,
                "pages"=>DocsV2Controller::PAGES_LINKS
            ]);
        }
        
        return view("404");
    }

}