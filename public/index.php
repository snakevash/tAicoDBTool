<?php
/**
 * 后台管理入口文件
 *
 * User: snake
 * Date: 14-8-12
 * Time: 下午4:03
 */

require_once '../vendor/autoload.php';

# 配置应用
$app = new \Slim\Slim(array(
    'debug' => true,
    'templates.path' => 'templates',
    'mode' => 'development',
    'log.enabled' => true,
    'log.level' => \Slim\Log::DEBUG,
    'log.writer' => new \Slim\LogWriter(fopen("../logs/testlog.txt", "rw")),
));

$app->setName('tAicoDBTool');

# 会话设置
$app->add(new \Slim\Middleware\SessionCookie(array(
    'exipres' => '30 minutes',
    'path' => '/',
    'domain' => 'tAicoDBTool.com',
    'secure' => true,
    'httponly' => false,
    'name' => 'aico_session',
    'secret' => 'aico',
    'cipher' => MCRYPT_RIJNDAEL_256,
    'cipher_mode' => MCRYPT_MODE_CBC
)));

# 处理的路由
$app->get('/', function () use ($app) {
    $app->render('../index.html');
});

$app->get('/hello/:name', function ($name) use ($app) {
    $app->render('hello.php', array('name' => $name));
});

# 执行web应用
$app->run();