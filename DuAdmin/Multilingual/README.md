Examples
--------

Example #1: current language translations are inserted to the model as normal attributes by default.

```php
//Assuming current language is english

$model = Post::findOne(1);
echo $model->title; //echo "English title"

//Now let's imagine current language is french 
$model = Post::findOne(1);
echo $model->title; //echo "Titre en Français"

$model = Post::find()->localized('en')->one();
echo $model->title; //echo "English title"

//Current language is still french here
```

Example #2: if you use `multilingual()` in a `find()` query, every model translation is loaded as virtual attributes (title_en, title_fr, title_de, ...).

```php
$model = Post::find()->multilingual()->one();
echo $model->title_en; //echo "English title"
echo $model->title_fr; //echo "Titre en Français"
```

Installation
------------

Preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist omgdef/yii2-multilingual-behavior
```

or add

```
"omgdef/yii2-multilingual-behavior": "~2.0"
```

to the require section of your `composer.json` file.

Behavior attributes
------------
Attributes marked as bold are required

Attribute | Description
----------|------------
languageField | The name of the language field of the translation table. Default is 'language'
localizedPrefix | The prefix of the localized attributes in the lang table. Is used to avoid collisions in queries. The columns in the translation table corresponding to the localized attributes have to be name like this: ```[prefix]_[name of the attribute]``` and the id column (primary key) like this : ```[prefix]_id```
requireTranslations | If this property is set to true required validators will be applied to all translation models.
dynamicLangClass | Dynamically create translation model class. If true, the translation model class will be generated on runtime with the use of the eval() function so no additionnal php file is needed
langClassName | The name of translation model class. Dafault value is model name + Lang
**languages** | Available languages. It can be a simple array: ```['fr', 'en']``` or an associative array: ```['fr' => 'Français', 'en' => 'English']```
**defaultLanguage** | The default language
**langForeignKey** | Name of the foreign key field of the translation table related to base model table.
**tableName** | The name of the translation table
**attributes** | Multilingual attributes

Usage
-----

Here an example of base 'post' table :

```sql
CREATE TABLE IF NOT EXISTS `post` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `created_at` datetime NOT NULL,
    `updated_at` datetime NOT NULL,
    `enabled` tinyint(1) NOT NULL DEFAULT '1',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

And its associated translation table (configured as default), assuming translated fields are 'title' and 'content':

```sql
CREATE TABLE IF NOT EXISTS `postLang` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `post_id` int(11) NOT NULL,
    `language` varchar(6) NOT NULL,
    `title` varchar(255) NOT NULL,
    `content` TEXT NOT NULL,
    PRIMARY KEY (`id`),
    KEY `post_id` (`post_id`),
    KEY `language` (`language`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

ALTER TABLE `postLang`
ADD CONSTRAINT `postlang_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
```

Attaching this behavior to the model (Post in the example). Commented fields have default values.

```php
public function behaviors()
{
    return [
        'ml' => [
            'class' => MultilingualBehavior::className(),
            'languages' => [
                'ru' => 'Russian',
                'en-US' => 'English',
            ],
            //'languageField' => 'language',
            //'localizedPrefix' => '',
            //'requireTranslations' => false',
            //'dynamicLangClass' => true',
            //'langClassName' => PostLang::className(), // or namespace/for/a/class/PostLang
            'defaultLanguage' => 'ru',
            'langForeignKey' => 'post_id',
            'tableName' => "{{%postLang}}",
            'attributes' => [
                'title', 'content',
            ]
        ],
    ];
}
```

Then you have to overwrite the `find()` method in your model

```php
    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }
```

As this behavior has ```MultilingualTrait```, you can use it in your query classes

```php
namespace app\models;

use yii\db\ActiveQuery;

class MultilingualQuery extends ActiveQuery
{
    use MultilingualTrait;
}
```

Form example:
```php
//title will be saved to model table and as translation for default language
$form->field($model, 'title')->textInput(['maxlength' => 255]);
$form->field($model, 'title_en')->textInput(['maxlength' => 255]);
```

**Hint:** ```$model``` has to be populated with ```translations``` relative data otherwise translations will not be updated after ```$form``` send.
