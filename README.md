## Composer

composer.json
```
    "repositories": [{
        "type": "git",
        "url": "https://github.com/YourFrog/Auth.git"
    }]
```

console
```
php composer.phar require yourfrog/auth
```


Dodaj do config/application.config.php
```
'modules' => [
  'Auth'
],
```
