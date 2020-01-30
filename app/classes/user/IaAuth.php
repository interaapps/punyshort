<?php
namespace app\classes\user;

use modules\uloleorm\SQL;
use databases\PunyShortSessionsTable;
use ulole\core\classes\util\Str;

/**
 * InteraAps Auth for Ulole-Framwork
 * 
 * @requires(ULOLE-ORM [uppm: uloleorm] )
 */
class IaAuth {
    
    public $key,
           $id,
           $userdata,
           $session;

    public function __construct($key, $id="") {
        $userData = self::getUserInformation($key);
        $this->key = str_replace('"', '\"', $key);
        $this->id  = $userData->id;
    }
    
    public function login() {
        $connection = SQL::$databases["main"]->con;
        $this->session = Str::random(100);

        $newLogin = new PunyShortSessionsTable;
        $newLogin->session_id = $this->session;
        $newLogin->userid     = $this->id;
        $newLogin->user_key   = $this->key;
        $newLogin->save();
    }
    
    public function getUserData() {
        return getUserInformation($this->key);
    }


    public static function findUser($query) {
        global $ULOLE_CONFIG_ENV;
        $postdata = http_build_query(
            ['key' => $ULOLE_CONFIG_ENV->Auth->interaapps->key,
                "query"=>$query
            ]);
    
        $opts = ['http' =>[
                'method'  => 'POST',
                'header'  => 'Content-Type: application/x-www-form-urlencoded',
                'content' => $postdata
            ]];
        $context  = stream_context_create($opts);
        $result = file_get_contents('https://accounts.interaapps.de/oauth_api/finduser', false, $context);
        $resultJson = json_decode($result);
    
        if ($resultJson->valid)
            return json_decode($result);
        else return false;
    }

    public static function getUserInformation($user) {
        global $ULOLE_CONFIG_ENV;
        $postdata = http_build_query(
            ['key' => $ULOLE_CONFIG_ENV->Auth->interaapps->key,
                'userkey' => $user
            ]);
    
        $context = stream_context_create(['http' =>[
                'method'  => 'POST',
                'header'  => 'Content-Type: application/x-www-form-urlencoded',
                'content' => $postdata
            ]]);
        $result = file_get_contents('https://accounts.interaapps.de/oauth_api/getuserinformation', false, $context);
        $resultJson = json_decode($result);
    
        if ($resultJson->valid)
            return json_decode($result);
        else return false;
    }
    
    public static function loggedIn() {
        $connection = SQL::$databases["main"]->con;
        if (!isset($_COOKIE["InteraApps_auth"])) return false;
        
        $loggedIn = (new PunyShortSessionsTable)
                        ->select('*')
                        ->where("session_id", $_COOKIE["InteraApps_auth"])
                        ->first();   
        return $loggedIn["id"] !== null;
    }
    
    
    public static function getUserObject() {
        $connection = SQL::$databases["main"]->con;
        return self::getUserInformation(    
            (new PunyShortSessionsTable)
                        ->select('*')
                        ->where("session_id", $_COOKIE["InteraApps_auth"])
                        ->first()["user_key"]
        );
    }

    public static function usingIaAuth() {
        global $ULOLE_CONFIG_ENV;
        if (isset($ULOLE_CONFIG_ENV->Auth->using)) {
            return $ULOLE_CONFIG_ENV->Auth->using == "interaapps";
        }
        return false;
    }
    
}