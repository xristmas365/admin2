<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

$config = [
    'id'                  => 'admin-nuxt',
    'name'                => 'Nuxt Admin Template',
    'basePath'            => dirname(__DIR__),
    'controllerNamespace' => 'app\commands',
    'components'          => [
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\DbTarget',
                    'levels' => ['error'],
                ],
            ],
        ],
        'db'  => [
            'class'             => 'yii\db\Connection',
            'dsn'               => getenv('DB_DSN'),
            'username'          => getenv('DB_USERNAME'),
            'password'          => getenv('DB_PASSWORD'),
            'charset'           => getenv('DB_CHARSET'),
            'enableSchemaCache' => getenv('APP_ENV') === 'prod',
        ],
    ],
];

if(YII_ENV_DEV) {
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
