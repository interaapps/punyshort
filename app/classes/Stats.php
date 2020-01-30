<?php 
namespace app\classes;

class Stats {

    public static function getIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR']; 
        } else {
            $ip = $_SERVER['REMOTE_ADDR']; 
        } 
        return $ip; 
    }
    
    public static function getOS() {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $os_platform = "Other";
        $os_array    = array(
            '/windows nt 6.2/i' => 'Windows',
            '/windows nt 10.0/i' => 'Windows',
            '/windows nt 6.1/i' => 'Windows',
            '/windows nt 6.0/i' => 'Windows',
            '/windows nt 5.2/i' => 'Windows',
            '/windows nt 5.1/i' => 'Windows',
            '/windows xp/i' => 'Windows',
            '/windows nt 5.0/i' => 'Windows',
            '/windows me/i' => 'Windows',
            '/win98/i' => 'Windows',
            '/win95/i' => 'Windows',
            '/win16/i' => 'Windows',
            '/macintosh|mac os x/i' => 'Mac',
            '/mac_powerpc/i' => 'Mac',
            '/linux/i' => 'Linux',
            '/ubuntu/i' => 'Linux',
            '/iphone/i' => 'ios',
            '/ipod/i' => 'ios',
            '/ipad/i' => 'ios',
            '/android/i' => 'Android',
            '/blackberry/i' => 'Other',
            '/webos/i' => 'Other'
        );
        foreach ($os_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $os_platform = $value;
            }
        }
        return $os_platform;
    }
    public static function getBrowser(){
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $browser       = "Unknown";
        $browser_array = array(
            '/msie/i' => 'Internet Explorer',
            '/firefox/i' => 'Firefox',
            '/safari/i' => 'Safari',
            '/chrome/i' => 'Chrome',
            '/opera/i' => 'Opera',
            '/netscape/i' => 'Netscape',
            '/maxthon/i' => 'Maxthon',
            '/konqueror/i' => 'Konqueror',
            '/mobile/i' => 'Handheld Browser'
        );
        foreach ($browser_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $browser = $value;
            }
        }
        return $browser;
    }

    public static function getCountry($ip) {
        $data = \file_get_contents('https://www.iplocate.io/api/lookup/'.$ip);
        return \json_decode($data)->country;
    }
}