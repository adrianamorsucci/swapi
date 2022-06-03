<?php

/**
 * API REST
 * Configuracion principal general para todos los ambientes
 */

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php')
    //require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-apirest',
    'name'=>'API REST',    
    'basePath' => dirname(__DIR__),
    'language' => 'es_AR',
    'controllerNamespace' => 'apirest\controllers',
    'bootstrap' => ['log'],
    'modules' => [
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-apirest',
            'parsers' => [
              'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                /*['class' => 'yii\rest\UrlRule', 
                    'controller' => ['user'],
                    'extraPatterns'=>[
                        'POST login'=>'login',
                    ],
                ],
                ['class' => 'yii\rest\UrlRule', 
                    'controller' => ['categoria'],
                ],
                ['class' => 'yii\rest\UrlRule', 
                    'controller' => ['producto'],
                ],*/
                ['class' => 'yii\rest\UrlRule', 
                    'controller' => ['starship', 'vehicle'],
                    'extraPatterns'=>[
                        'POST <id:\d+>'=>'update',
                    ],
                ],
            ],
        ],
        'formatter' => [
            'defaultTimeZone' => date_default_timezone_get(),
            'nullDisplay' => ' ',
            'dateFormat' => 'short',
            'timeFormat' => 'short',
            'datetimeFormat' => 'php:d/m/Y H:i:s',
            'decimalSeparator' => '.',
            'thousandSeparator' => '',
        ],
        'user' => [
            'identityClass' => 'apirest\models\User',
            //'enableAutoLogin' => true,
            'enableSession' => false,
            'loginUrl'=>null,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'curlClient' => [
            'class' => 'apirest\components\CurlClient',
        ],
    ],
    'params' => $params,
];
