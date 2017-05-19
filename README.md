# Компонент выгрузки каталога товаров в Яндекс.Маркет (YML)

[![Build Status](https://travis-ci.org/pastuhov/yii2-yml-catalog.svg)](https://travis-ci.org/pastuhov/yii2-yml-catalog)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/pastuhov/yii2-yml-catalog/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/pastuhov/yii2-yml-catalog/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/pastuhov/yii2-yml-catalog/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/pastuhov/yii2-yml-catalog/?branch=master)
[![Total Downloads](https://poser.pugx.org/pastuhov/yii2-yml-catalog/downloads)](https://packagist.org/packages/pastuhov/yii2-yml-catalog)

## Установка

Via Composer

``` bash
$ composer require pastuhov/yii2-yml-catalog
```

## Features

* легкий
* базируется на официальной документации https://yandex.ru/support/partnermarket/yml/about-yml.xml

## Использование

1. Реализуем интерфейсы (примеры реализации всех классов смотри в директории `tests`)

2. Создаем консольный контроллер:
```php
namespace console\controllers;

use pastuhov\ymlcatalog\actions\GenerateAction;
use yii\console\Controller;

/**
 * Class GenerateController
 */
class YmlController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'generate' => [
                'class' => GenerateAction::className(),
                'enableGzip' => true, # запаковать gzip-ом yml после генерации
                'fileName' => 'yml-test.xml', # желаемое название файла
                'publicPath' => '@runtime/public', # публичная директория (обычно корень веб сервера)
                'runtimePath' => '@runtime', # временная директория
                'keepBoth' => true, # опубликовать yml и .gz
                'shopClass' => 'pastuhov\ymlcatalog\Test\models\Shop',
                'currencyClass' => 'pastuhov\ymlcatalog\Test\models\Currency',
                'categoryClass' => 'pastuhov\ymlcatalog\Test\models\Category',
                'localDeliveryCostClass' => 'pastuhov\ymlcatalog\Test\models\LocalDeliveryCost',
                'offerClasses' => [
                    'pastuhov\ymlcatalog\Test\models\SimpleOffer'
                ],
            ],
        ];
    }
}
```
3. Запускаем из консоли:
```bash
$ yii yml/generate
```

## Скачивание файла самим Яндекс Маркетом

Создаём фронтенд контроллер, который позволяет скачивать сгенерированные через консоль или cron сервис файлы:
```
namespace frontend\controllers;

use pastuhov\ymlcatalog\actions\DownloadAction;
use yii\web\Controller;

/**
 * Class GenerateController
 */
class YmlController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'download' => [
                'class' => DownloadAction::className(),
                'fileName' => 'yml-test.xml.gz', # название сгенерированного файла
                'publicPath' => '@console/runtime', # директория со сгенерированным файлом
            ],
        ];
    }
}
```

При желании можно сделать авторизацию через фильтры контроллера:
```php
...
    public function behaviors()
    {
        return [
            'auth' => [
                'class' => \yii\filters\auth\HttpBasicAuth::className(),
                'auth' => function ($username, $password) {
                    $model = \Yii::createObject(\common\models\LoginForm::className());
                    $model->login = $username;
                    $model->password = $password;

                    if ($model->login()) {
                        return \yii::$app->user->identity;
                    }
                },
            ],
            'accessControll' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['market'],
                    ],
                ],
            ]
        ];
    }
...
```

## Тестирование

```bash
$ composer test
```
или
```bash
$ phpunit
```
Проверить качество сгенерируемого файла можно следующими способами:
1. Официальным валидатором https://old.webmaster.yandex.ru/xsdtest.xml 
2. При помощи `xmllint` (пример: xmllint --valid --noout yml-test.xml)
3. IDE PhpStorm также может помочь

## Security

If you discover any security related issues, please email kirill@pastukhov.su instead of using the issue tracker.

## Credits

- [Kirill Pastukhov](https://github.com/pastuhov)
- [All Contributors](../../contributors)

## License

GNU General Public License, version 2. Please see [License File](LICENSE) for more information.
