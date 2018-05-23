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
php yii module/install nullref/yii2-category
```

and module will be added to your application config (`@app/config/installed_modules.php`)

Pay attention that if you don't use our [application template](https://github.com/NullRefExcep/yii2-boilerplate) 
it needs to change config files structure to have ability run commands that show above.

Please check this [documentation section](https://github.com/NullRefExcep/yii2-core#config-structure)

![](https://raw.githubusercontent.com/NullRefExcep/yii2-category/master/docs/assets/core-install.gif)


Module integration
------------------

If you need additional information about integration current module with your project, please check [example folder](https://github.com/NullRefExcep/yii2-category/tree/master/docs/examples)

Using with admin module
----------------------------

You can use this module with modules:
- [Yii2 Admin](https://github.com/NullRefExcep/yii2-admin).
- [Yii2 Full Admin](https://github.com/NullRefExcep/yii2-full-admin).

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

Also you have to add module to bootstrap list of application:

```php
...
'bootstrap' => ['category',...],
...
```

