Yii2 Category
===============
[![Latest Stable Version](https://poser.pugx.org/nullref/yii2-category/v/stable)](https://packagist.org/packages/nullref/yii2-category) [![Total Downloads](https://poser.pugx.org/nullref/yii2-category/downloads)](https://packagist.org/packages/nullref/yii2-category) [![Latest Unstable Version](https://poser.pugx.org/nullref/yii2-category/v/unstable)](https://packagist.org/packages/nullref/yii2-category) [![License](https://poser.pugx.org/nullref/yii2-category/license)](https://packagist.org/packages/nullref/yii2-category)

Module for categories (WIP)

![](https://raw.githubusercontent.com/NullRefExcep/yii2-category/master/docs/assets/screen-demo.gif)

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist nullref/yii2-category "*"
```

or add

```
"nullref/yii2-category": "*"
```

to the require section of your `composer.json` file.

Then You have run console command for install this module:

```
php yii module/install category
```

and module will be added to your application config (`@app/config/installed_modules.php`)

Using with yii2-admin module
----------------------------

You can use this module with [Yii2 Admin](https://github.com/NullRefExcep/yii2-admin) module.

Models overriding
-----------------

```php

    'category' => [
        'class' => 'nullref\category\Module',
        'classMap' => [
            'Category' => 'app\models\Category',
            'CategoryQuery' => 'app\models\CategoryQuery',
        ],
    ],
```