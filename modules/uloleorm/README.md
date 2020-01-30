# Ulole ORM
## A PHP ORM

Features:
- Multi Database support
- Supports many SQL Server (MySQL, Postgre)
- Migration System


```php
<?php
modules\uloleorm\InitDatabases::init("main", [
    "driver"  => "mysql",
    "username"=> "USERNAME",
    "password"=> "PASSWORD",
    "database"=> "DATABASE",
    "server"  => "SERVER",
    "port"    => 3306
])
```

### Database
```php
<?php
namespace databases;

use modules\uloleorm\Table;
class TestTable extends Table {

    public $username, 
           $password;
    
    public function database() {
        $this->_table_name_ = "user";
        // The __database__ default value is "main"
        $this->__database__ = "main";
    }

}
```

```php
<?php
// New
$newUser = new databases\TestTable;
$newUser->username = "User";
$newUser->password = "1234";
$newUser->save();

// Select
$user = new databases\TestTable;
foreach ($user->select("*")->where("username", "User")->get() as $row) {
    echo $row["username"];
}

// Select First
$user = new databases\TestTable;
$row = ($user->select("*")->where("username", "User")->first();
echo $row["username"];
```

### Migration
```php
<?php
namespace databases\migrate;

use modules\uloleorm\migrate\Migrate;

class TestTable extends Migrate {
    public function database() {
        $this->create('user', function($table) {
            $table->int("id")->ai();
            $table->string("username");
            $table->string("password", 255);
            $table->enum("enumTest", ["val1","val2"]);
        });
    }
}
```