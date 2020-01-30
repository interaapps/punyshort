<?php
namespace app\classes;
 
use databases\ShortlinksTable;
use ulole\core\classes\Request;
use ulole\core\classes\util\Str;

class Link {

    public $link,
           $name,
           $id;

    public function __construct($link) {
        $this->link = $link;
    }

    public function create() {
        
        $this->name = Str::random(rand(6, 9));

        $link = (new ShortlinksTable)
                ->select('*')
                ->where("name", $this->name)
                ->first();

        if ($link["id"] == null) {
            $newLink = new ShortlinksTable;
            $newLink->name = $this->name;
            $newLink->link = $this->link;
            $newLink->ip   = Request::getRemoteAddress();
            $newLink->save();
            return [
                "done"=>true,
                "link"=>$this->name
            ];
        }

        return ["done"=>false];
    }

}