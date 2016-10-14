Yii PHP Framework Version 2 / NOX Robots.txt Generator Module
=============================================================

Yii2 Module for automatically generating the [robots.txt](http://www.robotstxt.org/) file.

[![Latest Stable Version](https://poser.pugx.org/nox-it/yii2-nox-robots/v/stable)](https://packagist.org/packages/nox-it/yii2-nox-robots)
[![Total Downloads](https://poser.pugx.org/nox-it/yii2-nox-robots/downloads)](https://packagist.org/packages/nox-it/yii2-nox-robots)
[![Latest Unstable Version](https://poser.pugx.org/nox-it/yii2-nox-robots/v/unstable)](https://packagist.org/packages/nox-it/yii2-nox-robots)
[![License](https://poser.pugx.org/nox-it/yii2-nox-robots/license)](https://packagist.org/packages/nox-it/yii2-nox-robots)
[![Monthly Downloads](https://poser.pugx.org/nox-it/yii2-nox-robots/d/monthly)](https://packagist.org/packages/nox-it/yii2-nox-robots)
[![Daily Downloads](https://poser.pugx.org/nox-it/yii2-nox-robots/d/daily)](https://packagist.org/packages/nox-it/yii2-nox-robots)
[![composer.lock](https://poser.pugx.org/nox-it/yii2-nox-robots/composerlock)](https://packagist.org/packages/nox-it/yii2-nox-robots)

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

* Either run

```bash
php composer.phar require --prefer-dist "nox-it/yii2-nox-robots" "*"
```

or add

```json
"nox-it/yii2-nox-robots": "*"
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
    ]
]
```

## License

**yii2-nox-robots** is released under the BSD 3-Clause License. See the bundled `LICENSE.md` for details.

![Yii2](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=flat)

