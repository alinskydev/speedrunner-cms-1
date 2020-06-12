Yii2 Dot Trasnlation
======================

![Screen Shot](https://github.com/pavlinter/yii2-dot-translation/blob/master/screenshot.png?raw=true)

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist pavlinter/yii2-dot-translation "*"
```

or add

```
"pavlinter/yii2-dot-translation": "*"
```

to the require section of your `composer.json` file.


Configuration
-------------

* Run migration file
    ```php
    yii migrate --migrationPath=@vendor/pavlinter/yii2-dot-translation/migrations
    ```

* Update config file
```php
'bootstrap' => [
   'i18n',
   ...
],
'components' => [
    'i18n' => [
        'class'=>'pavlinter\translation\I18N',
        //'translations' => [
            //'myCategory' => [
                //'class' => 'pavlinter\translation\DbMessageSource',
                //'forceTranslation' => true,
                //'autoInsert' => true, //if message key doesn't exist in the database, message key will be created automatically
                //'dotMode' => null, //default state: show or hide dot
            //],
        //],
        //default settings

        //'dialog' => 'bs', //Bootstrap Modal Or jQuery Dialog (bs or jq)
        //'access' => 'dots-control',  //user permissions or function(){ return true || false; }
        //'nl2br' => true,
        //'dotClass' => 'dot-translation',
        //'dotSymbol' => '&bull;',
        //'nl2br' => true //nl2br filter text
        //languages table
        //'langTable' => '{{%languages}}', //string || null if table not exist
        //'langColCode' => 'code',
        //'langColLabel' => 'name',
        //'langColUpdatedAt' => 'updated_at', //string || null
        //'langWhere' => ['active' => 1], //$query->where(['active' => 1]);
        //'langOrder' => 'weight', //$query->orderBy('weight');

        //'enableCaching' => true, //for langTable cache
        //'durationCaching' => 0, //langTable cache
        //'router' => '/site/dot-translation', //'site' your controller
        //'langParam' => 'lang', // $_GET KEY
    ],
    ...
],
```
* Update controller
```php
//SiteController.php
public function actions()
{
    return [
        'dot-translation' => [
            'class' => 'pavlinter\translation\TranslationAction',
            //'adminLink' => null;  //array|string|function
            //'htmlEncode' => true, //encode new message
            //'access' => null, //default Yii::$app->i18n->access
        ],
        ...
    ];
}

```

Usage
-----

Change language:
```php
/index.php?r=site/index&lang=ru
```

Example:
```php

echo Yii::t('app', 'Hello world.'); used global settings

//individual adjustment
echo Yii::t('app', 'Hi {username}.', ['username' => 'Bob', 'dot' => true]); //enable dot

echo Yii::t('app', 'Hello world.', ['dot' => false , 'nl2br' => false]); //or 'br' => false //disable dot and disable nl2br filter

echo Html::submitInput(Yii::t('app', 'Submit', ['dot' => false])); //disable dot

echo Yii::$app->i18n->getPrevDot(); // show previous dot

// Or

echo Yii::t('app', 'Submit', ['dot' => '.']); //show only dot

```

```php
Yii::$app->i18n->disableDot(); //force disable all dots

echo Yii::t('app', 'Submit'); //hidden dot
echo Yii::t('app', 'Submit', ['dot' => true]); //force enable dot

Yii::$app->i18n->resetDot(); //reset settings
Yii::$app->i18n->enableDot();//OR enable dot
```

```php
//Add description variables to popup.
echo Yii::t('app', 'Count: ', ['dot' => true, 'var' => ['count' => 'Count email', 'owner']]);
```

```php
//render languages
echo \yii\widgets\Menu::widget([
    'items' => Yii::$app->i18n->menuItems(),
    'encodeLabels' => false,
]);
```

```php
//get array with current url
Yii::$app->i18n->getLanguages(true); //true|callable
/*
Array
(
    [1] => Array
    (
        [id] => 1
        [code] => en
        [name] => English
        [image] => /files/en.png
        [weight] => 130
        [active] => 1
        [updated_at] => 1424504802
        [url] => /en/site/index
    )
    ...
)
*/
```
