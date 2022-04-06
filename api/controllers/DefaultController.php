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
use yii\web\Response;
use app\models\Login;
use yii\rest\Controller;
use yii\filters\VerbFilter;
use yii\filters\RateLimiter;
use yii\filters\ContentNegotiator;

class DefaultController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class'   => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'verbFilter'        => [
                'class'   => VerbFilter::class,
                'actions' => $this->verbs(),
            ],
            'rateLimiter'       => [
                'class' => RateLimiter::class,
            ],
        ];
    }

    public function actionIndex() : string
    {
        return Yii::$app->name;
    }

    public function actionLogin() : array
    {
        $login = new Login;

        if($login->load(Yii::$app->request->post(), '') && $login->in()) {
            return [
                'token' => $login->token,
            ];
        }

        Yii::$app->response->statusCode = 422;

        return $login->getErrorSummary(true);
    }
}
