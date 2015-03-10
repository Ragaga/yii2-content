Yii 2 Content
=========

Yii 2 Content - Content module based on nested set tree;

## Features

* Easy install
* Work with seo tags
* Work with images
* Tree

## Installation

* Install package via [composer](http://getcomposer.org/download/) ```"ragaga/yii2-content": "dev-master"```
* Update config file *config/web.php*

```php
// app/config/web.php
return [
    'modules' => [
        'content' => [
                    'class' => 'ragaga\yii2\content\Content',
                    'imageDir' => "@app/web/image", // Image for upload files
                    'imageUrl' => "/image" // Url to images
                ],
    ],
];
```

* Run migration file
    * ```php yii migrate --migrationPath=@vendor/ragaga/yii2-content/migrations```
* Go to your application in your browser
    * ```http://localhost/pathtoapp/content/admin```
* Create your page content
