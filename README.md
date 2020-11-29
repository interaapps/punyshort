# Ulole-Framework v3!

The ulole-framework is a highly customizable PHP-Framework. 

## Based on
- [ulole-core](https://github.com/interaapps/ulole-core)
- [ulole-orm](https://github.com/interaapps/ulole-orm)
- [deverm router](https://github.com/interaapps/deverm-router)

#### Installation
Copy / Clone this repo and
```bash
# Uppm
php uppm.php install
# Or Composer
composer install
```

## Example
#### `app\App.php`
```php
<?php
namespace app;

use app\model\User;
use de\interaapps\ulole\orm\UloleORM;
use de\interaapps\ulole\core\Environment;
use de\interaapps\ulole\core\WebApplication;
use de\interaapps\ulole\core\traits\Singleton;

class App extends WebApplication {
    
    use Singleton;

    public static function main(Environment $environment){    
        self::setInstance( (new self())->start($environment) );
    }

    public function init(){
        $this->getConfig()
            ->loadENVFile(".env"); 
            
        // A ulole-framework helper for UloleORM::database("main", new Database(...))
        $this->initDatabase(/*Config prefix*/ "database", "main");
        UloleORM::register("user", User::class);
    }

    public function run() {
        $this->getRouter()
            ->get("/user/(\d+)", function($req, $res, int $userId){
                $res->json([
                    "user" => User::table()->where("id", $userId)->get()
                ]);
            });
    }
}
```

## Cli

### Serve
```bash
php cli serve
```
A simple serve command (Runs on localhost:8000)
### Repl:
```
$ php cli repl
>>> ["Hello"=>"World",  "Yep" => 1337.1945, "Wait, what?" => null, "Am I allowed to eat chicken?" => true,  "Am I allowed to eat wasps?" => false, "Show me what I am allowed to" => [  "Doing nothing", true,  false, null, 31423 ], "give me user" => \app\model\User::table()->get() ]
...
>>> echo "Hello world :)"
```
![https://i.imgur.com/8DCu9DI.png](https://i.imgur.com/8DCu9DI.png)

Multiline works with a `\`
```bash
$ php cli repl
>>> function test(){\
...   echo "Hello world :)";\
... }

null
>>> test()
Hello world :)
```
We will also check for a `[`, `(`, `{`, `,`
```bash
>>> [
...   "adsfasfd"=>31412341234,
...   "asfdasfd"=>"asfasdfasd"\
... ]

[
   "adsfasfd": 31412341234
   "asfdasfd": "asfasdfasd"
]
``` 

### Create:
There is a helpful tool for creating models and other stuff.
```
$ php cli create:model Test
```
![https://i.imgur.com/62xwkgY.png](https://i.imgur.com/62xwkgY.png)

### Migration
#### Migration up
```bash
$ php cli migrate:up
Migrated resources\migrations\migration_220511_000000_create_users
```

#### Migration down
```bash
$ php cli migrate:down (how many versions down, optionak)
Downgraded resources\migrations\migration_220511_000000_create_users
```

#### Migration status
```bash
$ php cli migrate:status
 model                               | migrated | version
 migration_201122_001143_create_user | YES      | 1
```

![https://i.imgur.com/Se2tGmm.png](https://i.imgur.com/Se2tGmm.pnghttps://i.imgur.com/Se2tGmm.png)

#### DB
This is a tool to just walk around the database and create some sql-queries.
![https://i.imgur.com/bJRM8EW.png](https://i.imgur.com/bJRM8EW.png)








## Extra

### Using other template-engine
#### Example: blade
##### app/helper/helper.php
```php
// composer require jenssegers\blade 
use Jenssegers\Blade\Blade;

$blade = new Blade("resources/views", "cache/views");

function view($view, $vars=[]) {
    global $blade;
    return $blade->render($view, $vars);
}
```