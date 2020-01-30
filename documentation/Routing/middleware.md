# Middlewares 
Middlewares are useful to check if a action happens.
Example:
    You have a Dashboard with a Authsystem. If the user is logged in, you can access, if not you'll be redirected to a loginpage

## app/MiddlewareExample
```php
<?php 
namespace app;
class MiddlewareExample {
    public static function test() {
        return true;
    } 
}
```
## app/route.php
```php
$router->middleware("!\app\MiddlewareExample@test", /* Happens if returns false*/ "homepage.php", function($innerRouter) {
  $innerRouter->get("/dash/test", "!AboutController@about");
});
```