# Modules
UloleModules is a little PackageManager.

## Add module
The simple way: You can choose between three options: github, local, web

### GitHub
Downloads a Zip and unzips it into the /modules folder. The name is the same like the repository

### local
Downloads a Zip and unzips it into the /modules folder. The name is the same like the file (without extension)

### web
Downloads a Zip and unzips it into the /modules folder. The name is the same like the file (without extension)
```json
{
    "name":"MyApp",
    "version": "1.0",
    "authors": [
        {
            "name": "My Name",
            "email": "my@mail.com"
        }
    ],
    "options": {
        "defaultlang": "en",
        "detectlanguage": false
    },
    "modules": {
        "github": "https://github.com/interaapps/haveibeenpwned-ulole-module",
        "local": "mymodule.zip",
        "web": "https://example.com/myzip.zip"
    }

}
```

## Custom name
Do you want to give the output directory a name? Just add after the download type a :
```json
{
    "name":"MyApp",
    "version": "1.0",
    "authors": [
        {
            "name": "My Name",
            "email": "my@mail.com"
        }
    ],
    "options": {
        "defaultlang": "en",
        "detectlanguage": false
    },
    "modules": {
        "github:mymodule": "https://github.com/interaapps/haveibeenpwned-ulole-module"
    }

}
```