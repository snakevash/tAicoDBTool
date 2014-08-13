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
    'view' => '\Slim\LayoutView',
    'layout' => 'layouts/main.php' # 默认布局
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

# 全局配置
$mainPhp = array(
    'leftSubMenu' => true,
    'isBrand' => false,
    'isController' => false,
    'isSerie' => false,
    'pageName' => '主页面',
    'navName' => '主页面',
);

# 主页
$app->get('/', function () use ($app,$mainPhp) {
    $mainPhp['leftSubMenu'] = false;
    $app->render('index.php', array(
        'mainPhp' => $mainPhp
    ));
});

# 用户登录
$app->get('/user/login', function () use ($app) {
    $app->render('login.php',array('layout'=>false));
});

# 品牌上传
$app->get('/brand/index', function () use ($app,$mainPhp) {
    $mainPhp['pageName'] = '品牌';
    $mainPhp['navName'] = '品牌';
    $mainPhp['isBrand'] = true;

    $app->render('brand/index.php', array(
        'mainPhp' => $mainPhp
    ));
});

# 遥控器上传
$app->get('/controller/index', function () use ($app,$mainPhp) {
    $mainPhp['pageName'] = '遥控器';
    $mainPhp['navName'] = '遥控器';
    $mainPhp['isController'] = true;

    $app->render('controller/index.php', array(
        'mainPhp' => $mainPhp
    ));
});

# 系列上传
$app->get('/serie/index', function () use ($app,$mainPhp) {
    $mainPhp['pageName'] = '系列';
    $mainPhp['navName'] = '系列';
    $mainPhp['isSerie'] = true;

    $app->render('serie/index.php', array(
        'mainPhp' => $mainPhp
    ));
});

# 测试路由
$app->get('/hello/:name', function ($name) use ($app) {
    $app->render('hello.php', array('name' => $name));
});

# 执行web应用
$app->run();