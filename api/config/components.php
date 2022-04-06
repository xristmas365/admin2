<?php
/*
 * @author    Paul Storr <1230840.ps@gmail.com>
 * @package   live-song project
 * @version   1.0
 * @copyright Copyright (c) 2022, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

return [
    'request'    => [
        'cookieValidationKey' => 'didzGQrlO5fMhn9-AaUnHw8RRH5ipFTI',
        'baseUrl'             => '/api/',
        'parsers'             => [
            'application/json' => 'yii\web\JsonParser',
        ],
    ],
    'response'   => [
        'format'     => 'json',
        'formatters' => [
            'json' => [
                'class'         => 'yii\web\JsonResponseFormatter',
                'prettyPrint'   => YII_ENV_DEV,
                'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
            ],
        ],
    ],
    'cache'      => [
        'class' => 'yii\caching\FileCache',
    ],
    'user'       => [
        'identityClass' => 'app\models\User',
        'enableSession' => false,
    ],
    'mailer'     => [
        'class'            => 'yii\swiftmailer\Mailer',
        'useFileTransport' => true,
    ],
    'db'         => [
        'class'             => 'yii\db\Connection',
        'dsn'               =>
            getenv('DB_CONNECTION')
            . ':host='
            . getenv('DB_HOST')
            . ';dbname='
            . getenv('DB_DATABASE'),
        'username'          => getenv('DB_USERNAME'),
        'password'          => getenv('DB_PASSWORD'),
        'charset'           => getenv('DB_CHARSET'),
        'enableSchemaCache' => YII_ENV_PROD,
        'enableLogging'     => YII_ENV_DEV,
        'enableProfiling'   => YII_ENV_DEV,
    ],
    'urlManager' => [
        'enablePrettyUrl' => true,
        'showScriptName'  => false,
        'rules'           => require __DIR__ . '/routes.php',
    ],
    'formatter'  => [
        'defaultTimeZone' => 'Europe/Moscow',
        'nullDisplay'     => '',
        'datetimeFormat'  => 'yyyy-MM-dd HH:mm',
        'dateFormat'      => 'yyyy-MM-dd',
        'currencyCode'    => 'usd',
    ],
];


