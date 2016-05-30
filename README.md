Yii PHP Framework Version 2 / NOX Robots.txt Generator Module
=============================================================

Yii2 Module for automatically generating the [robots.txt](http://www.robotstxt.org/) file.

Installation
------------
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

* Either run

```
php composer.phar require --prefer-dist "nox-it/yii2-nox-robots" "*"
```

or add

```json
"nox-it/yii2-nox-robots" : "*"
```

to the `require` section of your application's `composer.json` file.

* Configure the `cache` component of your application's configuration file, for example:

```php
'components' => [
    'cache' => [
        'class' => 'yii\caching\FileCache',
    ],
]
```

* Add a new module in `modules` section of your application's configuration file, for example:

```php
'modules' => [
    'robots' => [
        'class' => 'nox\modules\robots\Module',
        'settings' => [
            'disallowAllRobots' => false,
            'allowAllRobots'    => false,
            'useSitemap'        => true,
            'sitemapFile'       => '/sitemap.xml',
            'robots'            => [],
            'allowRules'        => [
                'all' => [
                    '/uploads'
                ]
            ],
            'disallowRules'     => [
                'all' => [
                    '/assets'
                ]
            ]
        ]
    ]
]
```

* Add a new rule for `urlManager` of your application's configuration file, for example:

```php
'urlManager' => [
    'rules' => [
        ['pattern' => 'robots', 'route' => 'robots/default/index', 'suffix' => '.txt'],
    ],
],
```

![Yii2](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=flat)

