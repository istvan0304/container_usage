Konténer figyelő
=============================
A nagios számára rak le egy text fájlt a megadott helyre amit a nagios figyel.

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
            'nagiosFilePath'  => '/nagios',
            'nagiosFileName'  => 'watch.txt',
            'watchThreads'  => true,
            'memoryWatch'  => true,
            'phpContainerRebooted' => true,
            'sqlContainerRebooted' => true,
            'volumes' => []
    ]
]
```

Call command in cli
```php
php yii container_usage/usage
```
