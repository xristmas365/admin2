<?php

/*
 * @author    Paul Storr <1230840.ps@gmail.com>
 * @package   live-song project
 * @version   1.0
 * @copyright Copyright (c) 2022, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

/**
 * Dependency Injection
 */
return [
    'definitions' => [
        'yii\filters\auth\CompositeAuth' => [
            'class'       => 'yii\filters\auth\CompositeAuth',
            'authMethods' => [
                'yii\filters\auth\HttpBearerAuth',
            ],
        ],
    ],
];
