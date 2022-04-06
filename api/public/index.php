
<?php

use Dotenv\Dotenv;
use yii\helpers\VarDumper;

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

function dd($var)
{
    VarDumper::dump($var, 5, true);
    die;
}

/**
 * .env Project support
 */
(Dotenv::createImmutable(__DIR__.'/../../'))->load();

$config = require __DIR__ . '/../config/main.php';

$app = new yii\web\Application($config);

$app->run();
