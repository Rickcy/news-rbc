<?php

use Dotenv\Dotenv;
use yii\web\Application;

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
Dotenv::createImmutable(dirname(__DIR__,1))->load();
$config = require __DIR__ . '/../config/web.php';

(new Application($config))->run();
