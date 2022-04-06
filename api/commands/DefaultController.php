<?php
/*
 * @author    Paul Storr <1230840.ps@gmail.com>
 * @package   live-song project
 * @version   1.0
 * @copyright Copyright (c) 2022, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

namespace app\commands;

use Yii;
use yii\console\ExitCode;
use yii\console\Controller;

class DefaultController extends Controller
{

    public function actionIndex() : int
    {
        $this->stdout(Yii::$app->name);
        $this->stdout(PHP_EOL);

        return ExitCode::OK;
    }

}
