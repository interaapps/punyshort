# Ulole Framework (v 1.0.038 Development)

```php
<?php
namespace app\controller;

class WelcomeController {
    /**
     * Hello world page
     * 
     * @return string
     */
    public static function about() {
        return "Hello world!";
    }
}
```

`This is just the development version. If we are ready soon there is a new version! :D`

## Installation
```bash
wget --no-cache https://raw.githubusercontent.com/interaapps/uppm/master/uppm -O uppm
php uppm init:fast
php uppm install ulole-framework
```
or
```bash
bash <(wget -qO- https://pastefy.ga/3dBl06Hs/raw)
```

Update Packages:
```bash
php uppm update
```

## Choosefriendly
You don't want to use Composer or NPM? You don't want to use WebPack? You don't need to! Ulole-Framework don't need any extra PackageManager.
Information: NPM and Composer are preinitialized, you can simply remove them.
Ps. Ulole is build on UlolePHPPackageManager (UPPM). But you dont need to use it!
## Alternatives
We've got some alternatives for useful tools.
We have got to an alternative to WebPack UloleCompile. It's a simple Bundler (And a template engine) that bundels JS Codes into one file and CSS into one file. ([More in docs](/documentation/compile/JS_and_CSS_bundler.md))
We've also got UloleModules. It's a Package Manager made for the UloleFramework [More in docs](/documentation/UloleModules/modules.md))

## Features
- Useful CLI with custom commands support (php cli)
- Build in TestServer (php cli server)
- Database ORM (Multi DB Support, Multible SQL server types usable)
- Database Migration-Tool
- Template Engine
- Ulole Modules
- A Router
- Template Engine
- CSS and JS Combinder
- Easy MultiLanguagesupport implementation
- Object-oriented
- Sessionmanager
- Useful utils
- Fast
- Little folder size (1.4 MB [In version 1.0.28])

## Generate
### database
```bash
php cli generate database testtable
```

### migration
```bash
php cli generate migration testtable
```

## Preview

#### Controller
```php
<?php
namespace app\controller;

class AboutController {
    /**
     * Hello world page
     * 
     * @return string
     */
    public static function about() {
        return "Hello world!";
    }
}
```

#### Orm
```php
<?php
namespace databases;

use modules\uloleorm\Table;

class UserTable extends Table {

    public $id,
           $username, 
           $password;

    public function database() {
        $this->_table_name_ = "user";
        $this->__database__ = "main";
    }

}
```

#### Migration
```php
<?php
namespace databases\migrate;

use modules\uloleorm\migrate\Migrate;

class UserTable extends Migrate {
    public function database() {
        $this->create('user', function($table) {
            $table->int("id")->ai();
            $table->string("username");
            $table->string("password", 155);
        });
    }
}
```

#### Debug
![https://i.imgur.com/W8otsxK.png](https://i.imgur.com/W8otsxK.png)