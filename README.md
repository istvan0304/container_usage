Konténer túlterhelés riasztás
=============================
Ha konténerben lévő apache szálak száma nagyobb a megadott értéknél, vagy a memória használat nagyobb a megadott értéknél vagy php vagy mysql konténer újraindult

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist attek/container_usage "*"
```

or add

```
"attek/container_usage": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

Set in config file (console.php)
```php
'components' => [
    'container_usage' => [
            'class' => 'attek\container_usage\Usage',            
            'adminEmail' => 'pest.attila@pte.hu',
            'senderEmail' => 'hrdocs-cli@pte.hu',            
            'maxUsers' => 10,
            'memoryUsageInPercent' => 4,
            'phpContainerRebooted' => true,
            'sqlContainerRebooted' => true,
            'sms_service_url = 'https://apps.pte.hu/sms/';
            'sms_auth_user = 'smsservice';
            'sms_auth_pass = 'eC4rTFJ9';            
            'adminPhone' => '+36205320950',
    ]
]
```