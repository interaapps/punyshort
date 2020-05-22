<?php
namespace app\classes;
 
use databases\ShortlinksTable;
use ulole\core\classes\Request;
use ulole\core\classes\util\Str;

class Link {

    public $link,
           $name,
           $domainName = "",
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
            $newLink->domain = $this->domainName;
            
            if ((new \databases\DomainsTable)->select("id")->where("domain_name", $newLink->domain)->first()["id"] === null) {
                $newLink->domain = (new \databases\DomainsTable)->select()->where("is_default", "1")->first()["domain_name"];
            }
            $newLink->save();
            return [
                "done"=>true,
                "domain"=>$newLink->domain,
                "link"=>$this->name
            ];
        }

        return ["done"=>false];
    }

}