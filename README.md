Yii PHP Framework Version 2 / NOX Robots.txt Generator Module
=============================================================

Yii2 Module for automatically generating the [robots.txt](http://www.robotstxt.org/) file.

[![Latest Stable Version](https://poser.pugx.org/nyx-solutions/yii2-nyx-robots/v/stable)](https://packagist.org/packages/nyx-solutions/yii2-nyx-robots)
[![Total Downloads](https://poser.pugx.org/nyx-solutions/yii2-nyx-robots/downloads)](https://packagist.org/packages/nyx-solutions/yii2-nyx-robots)
[![Latest Unstable Version](https://poser.pugx.org/nyx-solutions/yii2-nyx-robots/v/unstable)](https://packagist.org/packages/nyx-solutions/yii2-nyx-robots)
[![License](https://poser.pugx.org/nyx-solutions/yii2-nyx-robots/license)](https://packagist.org/packages/nyx-solutions/yii2-nyx-robots)
[![Monthly Downloads](https://poser.pugx.org/nyx-solutions/yii2-nyx-robots/d/monthly)](https://packagist.org/packages/nyx-solutions/yii2-nyx-robots)
[![Daily Downloads](https://poser.pugx.org/nyx-solutions/yii2-nyx-robots/d/daily)](https://packagist.org/packages/nyx-solutions/yii2-nyx-robots)
[![composer.lock](https://poser.pugx.org/nyx-solutions/yii2-nyx-robots/composerlock)](https://packagist.org/packages/nyx-solutions/yii2-nyx-robots)

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

* Either run

```bash
php composer.phar require --prefer-dist "nyx-solutions/yii2-nyx-robots" "*"
```

or add

```json
"nyx-solutions/yii2-nyx-robots": "*"
```

to the `require` section of your application's `composer.json` file.

## Usage

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
        'class' => 'nyx\modules\robots\Module',
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
    ]
]
```

## License

**yii2-nyx-robots** is released under the BSD 3-Clause License. See the bundled `LICENSE.md` for details.

![Yii2](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=flat)

