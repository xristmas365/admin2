<?php
/*
 * @author    Paul Storr <1230840.ps@gmail.com>
 * @package   live-song project
 * @version   1.0
 * @copyright Copyright (c) 2022, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

namespace app\controllers;

use Yii;
use yii\rest\Controller;

class AuthController extends Controller
{

    public function actionUser()
    {
        return [
            'user' => Yii::$app->user->identity,
        ];
    }

    public function actionUserSave()
    {
        $user = Yii::$app->user->identity;

        if($user->load(Yii::$app->request->post()) && $user->save()) {
            return true;
        }

        Yii::$app->response->statusCode = 422;
        return $user->getErrorSummary(true);


    }

    public function actionLogout()
    {
        return Yii::$app->user->identity->resetAuthKey();
    }
}
