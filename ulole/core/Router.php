<?php

class Router {
  public static $lastViewsDirectory;
  public static $lastTemplatesDirectory;
  public $route;
  public $viewsDirectory;
  public $templatesDirectory;
  public $requestMethod;
  public $initLastDirectoryFunction;
  public $namespace="app\controller\\";

  public static function autoload($dir) {
    $files = scandir($dir);
    foreach($files as $file) {
        if ($file != ".." && $file != ".")
            if (is_dir($dir."/".$file))
                Router::autoload($dir."/".$file);
              else
                include $dir."/".$file;
            }
  }

  public function group(string $prefix, $func) {
    $innerRouter = new Router(false);
    $func($innerRouter);
    $innerRouter->setDirectories($this->viewsDirectory, $this->templatesDirectory);
    foreach ($innerRouter->route as $route=>$routingTo) {
      $this->route[$prefix.$route] = $routingTo;
      $this->requestMethod[$prefix.$route] = $innerRouter->requestMethod[$route];
    }
  }

    /**
     * Check if the $middleware method is true
     *
     * @param string $middleware
     * @param $exceptionView
     * @param $func
     */
  public function middleware(string $middleware, $exceptionView, $func) {
    $innerRouter = new Router(false);
    $func($innerRouter);
    $innerRouter->setDirectories($this->viewsDirectory, $this->templatesDirectory);
    $middlewareStatus = false;
    if (strpos($middleware, "@") !== false)
      $middlewareStatus = call_user_func( Router::get_string_between($middleware, "!", "@").'::'.Router::get_string_between($middleware, "@", "") );
    else
      $middlewareStatus = call_user_func(Router::get_string_between($middleware, "!", ""));
    foreach ($innerRouter->route as $route=>$routingTo) {
      if ($middlewareStatus)
        $this->route[$route] = $routingTo;
      else 
        $this->route[$route] = $exceptionView;  
      $this->requestMethod[$route] = $innerRouter->requestMethod[$route];
    }
  }

  /**
   * Set Request Methods for the array Router
   */
  function setRequestMethods($arr) {
    foreach ($arr as $k1=>$v1) {
      $this->requestMethod[$k1] = $v1;
    }
  }
  
  function addNested($array, $path="") {
    foreach($array as $v1 => $v2) {
      if (is_array($v2)) {
        $this->addNested($v2, $path.$v1."/");
      } else {
        // echo $path.$v1;
        $this->route["/".$path.$v1] = $v2;
        //array_push($this->route, "/".$path.$v1, $v2);
      }
    }
  }

  function __construct($initLastDirectoryFunction = true) {
    $route=[];
    $this->route     =  $route;
    $this->initLastDirectoryFunction = $initLastDirectoryFunction;
  }

  function setDirectories($viewsDirectory, $templatesDirectory="../templatesDirectorys") {
    $this->templatesDirectory  =  $templatesDirectory;
    $this->viewsDirectory =  $viewsDirectory;
    if ($this->initLastDirectoryFunction) {
      self::$lastTemplatesDirectory = $templatesDirectory;
      self::$lastViewsDirectory = $viewsDirectory;
    }
  }

    /**
     * Set the array router
     * @param $array
     */
  function set($array) {
    $this->route = array_merge($this->route, $array);
  }

  function route() {
    global $_ROUTEVAR;
    $route     =  $this->route;
    $templatesDirectory  =  $this->templatesDirectory;
    $viewsDirectory =  $this->viewsDirectory;

    $error404 = false;
    $request = str_replace("?".Router::get_string_between($_SERVER['REQUEST_URI'], "?", ""), "", $_SERVER['REQUEST_URI']);
    $genrequest = $request;

    $method = $_SERVER['REQUEST_METHOD'];

    foreach($route as $url=>$view) {
  
      if(preg_match_all('#^' . $url . '$#', $request, $matches)) {
        foreach ($matches as $key=>$val)
            $_ROUTEVAR[$key] = $val[0];
          
            $methods = ["post", "delete", "put", "connect", "trace", "options"];
            foreach($methods as $meth) {
              if($method===strtoupper($meth) && isset($this->requestMethod[$url][$meth])) {

                $this->load($this->requestMethod[$url][$meth] ,  $viewsDirectory.((!is_callable($this->requestMethod[$url][$meth])) ? $this->requestMethod[$url][$meth] : ""), $this);
                return 0;
              }
            }
            $this->load($view, $viewsDirectory.((!is_callable($view)) ? $view : ""), $this);
            
          return 0;
        

      }
    
    }
    
    if (!array_key_exists($genrequest, $route))
      $error404 = true;
    if($error404) {
      header('HTTP/1.1 404 Not Found');
      include $viewsDirectory.$route["@__404__@"];
      return 404;
    }


  }


    
    public static function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        if ($end=="") {
          return substr($string, $ini, strlen($string));
        }
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
   


    public function load($view, $require, $parent=false) {
	  global $_ROUTEVAR;
	  
      if ($require !== $parent->viewsDirectory."@") {
        if (is_callable($view)) {
			$out = $view();
			if (is_array($out) && function_exists("json_decode")) {
				header('Content-Type: application/json');
				echo json_encode($out);
			} else
				echo $out;
		} else
            if (strpos($view, "!") !== false) {
				$out = "";
              if (strpos($view, "@") !== false)
			  	$out = call_user_func(  $this->namespace.Router::get_string_between($view, "!", "@").'::'.Router::get_string_between($view, "@", "") );
              else
				$out = call_user_func(Router::get_string_between($view, "!", ""));

			  if (is_array($out) && function_exists("json_decode")) {
				header('Content-Type: application/json');
				  echo json_encode($out);
			  } else {
				  echo $out;
			  }
            } else {
              require $require;
            }
        } else {
          if ($parent !== false) {
            header('HTTP/1.1 404 Not Found');
            include $parent->viewsDirectory.$parent->route["@__404__@"];
          }
        }
    }


    function setPageNotFound($func) {
      $this->route["@__404__@"] = $func;
    }

	function all($route, $func) {
		$this->route[$route] = $func;
		return $this;
	}

    function post($route, $func) {
      if (!isset($this->requestMethod[$route])) $this->requestMethod[$route] = [];
      if (!isset($this->route[$route]))
        $this->route[$route] = "@";
		$this->requestMethod[$route]["post"] = $func;
		return $this;
    }
  
    function get($route, $func) {
      if (!isset($this->requestMethod[$route])) $this->requestMethod[$route] = [];
      $this->route[$route] = $func;
	  $this->requestMethod[$route]["get"] = $func;
	  return $this;
    }
  
    function delete($route, $func) {
      if (!isset($this->requestMethod[$route])) $this->requestMethod[$route] = [];
      if (!isset($this->route[$route]))
        $this->route[$route] = "@";
	  $this->requestMethod[$route]["delete"] = $func;
	  return $this;
    }
  
    function put($route, $func) {
      if (!isset($this->route[$route]))
        $this->route[$route] = "@";
      $this->requestMethod[$route] = ["put"=>$func];
	  return $this;
	}
  
    function trace($route, $func) {
      if (!isset($this->route[$route]))
        $this->route[$route] = "@";
      $this->requestMethod[$route] = ["trace"=>$func];
	  return $this;
	}

    function connect($route, $func) {
      if (!isset($this->route[$route]))
        $this->route[$route] = "@";
	  $this->requestMethod[$route] = ["connect"=>$func];
	  return $this;
    }

    public static function view($templatesDirectory_name, $vars=false) {
        if ($vars !== false) {
            foreach($vars as $key=>$val){
                global ${$key};
                ${$key} = $val;
            }
        }
        include Router::$lastViewsDirectory."/".$templatesDirectory_name.".php";
    }

    public static function tmpl($templatesDirectory_name, $vars=false) {
        if ($vars !== false) {
            foreach($vars as $key=>$val){
                global ${$key};
                ${$key} = $val;
            }
        }
        include Router::$lastTemplatesDirectory.$templatesDirectory_name.".php";
    }


}

function tmpl($templatesDirectory_name, $vars=false) {
  Router::tmpl($templatesDirectory_name, $vars);
}

function view($templatesDirectory_name, $vars=false) {
   Router::view($templatesDirectory_name, $vars);
}
