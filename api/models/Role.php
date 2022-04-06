<?php
/*
 * @author    Paul Storr <1230840.ps@gmail.com>
 * @package   live-song project
 * @version   1.0
 * @copyright Copyright (c) 2022, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

namespace app\models;

use Yii;

class Role
{

    const DEVELOPER = 0;
    const ADMIN     = 1;
    const USER      = 2;
    const CUSTOMER  = 3;

    /**
     * Gets List of all Roles
     *
     * @return array
     */
    public static function list() : array
    {
        $list = [];

        foreach(static::config() as $key => $role) {
            $list[$key] = $role['name'];
        }

        return $list;
    }

    /**
     * @param $role
     *
     * @return array
     */
    public static function config($role = null) : array
    {
        $config = [
            static::CUSTOMER  => [
                'name' => 'Subscriber',
            ],
            static::USER      => [
                'name' => 'Artist',
            ],
            static::ADMIN     => [
                'name'   => 'Admin',
                'access' => [Role::USER, Role::CUSTOMER],
            ],
            static::DEVELOPER => [
                'name'   => 'Developer',
                'access' => [Role::ADMIN],
            ],
        ];

        if(Yii::$app->user->identity->role !== Role::DEVELOPER) {
            unset($config[Role::DEVELOPER]);
        }

        return is_null($role) ? $config : $config[$role];
    }
}
