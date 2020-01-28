Konténer túlterhelés riasztás
=============================
Ha konténerben lévő apache szálak száma nagyobb a megadott értéknél, vagy a memória használat nagyobb a megadott értéknél vagy php vagy mysql konténer újraindult

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist istvan0304/usage "*"
```

or add

```
"istvan0304/usage": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

Set in config file (console.php)
```php
'modules' => [
    'container_usage' => [
            'class' => 'istvan0304\usage\Module',                        
            'adminEmail' => '',
            'senderEmail' => '',            
            'maxUsers' => 10,
            'memoryUsageInPercent' => 4,
            'phpContainerRebooted' => true,
            'sqlContainerRebooted' => true,
            'app' => 'ws',
            'sms_service_url' => '',
            'sms_auth_token' => '',
            'sms_auth_user' => '',
            'sms_auth_pass' => '',            
            'sms_operation' => 'pv',            
            'adminPhone' => ''              
    ]
]
```

Call command in cli
```php
php yii container_usage/usage
```
