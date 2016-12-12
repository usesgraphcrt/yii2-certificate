# yii2-certificate-module
Certificates module for Yii2

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist usesgraphcrt/yii2-certificate "*"
```

or add

```
"usesgraphcrt/yii2-certificate": "*"
```

to the require section of your composer.json file.

Make migration
```php
php yii migrate --migrationPath=@vendor/usesgraphcrt/yii2-certificate/migrations/
```

## Usage

You should add module to your config:

```php
'modules' => [
        ...
        'certificate' => [
                    'class' => \usesgraphcrt\certificate\Module::className(),
                    'sourceModels' => [
                    \\list models for certification
                    ]
                ],
    ],
```

It is possible that you have to change minimum stability section of your 
composer.json file to dev
```php
"minimum-stability": "dev",
```
