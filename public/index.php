<?php
/**
 * 后台管理入口文件
 *
 * User: snake
 * Date: 14-8-12
 * Time: 下午4:03
 */

define('UPLOADPATHBRANDS', __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'brands');
define('UPLOADPATHCODEBASEBEFORE', __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'codebasebefore');
define('UPLOADPATHCODEBASEAFTER', __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'codebaseafter');
define('UPLOADPATHCODEBASEFAIL', __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'codebasefail');
define('UPLOADPATHBRANDAFTER', __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'brandafter');
define('UPLOADPATHBRANDBEFORE', __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'brandbefore');
define('RULEPATH',__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'rulexls');

require_once '../vendor/autoload.php';

# 全局函数
/**
 * 处理单个上传文件
 *
 * @param string $fileTarget
 * @param string $filePath
 * @param string $fileName
 * @return bool
 */
function handlerUploadFile($fileTarget = 'fileupload', $filePath = '', $fileName = '')
{
    if (isset($_FILES[$fileTarget])) {
        # 是否指定名称
        if (empty($fileName)) {
            $fullFilePath = $filePath . DIRECTORY_SEPARATOR . $_FILES['fileupload']['name'];
        } else {
            $fullFilePath = $filePath . DIRECTORY_SEPARATOR . $fileName;
        }
        move_uploaded_file($_FILES[$fileTarget]['tmp_name'], $fullFilePath);
        if (chmod($fullFilePath, 0777)) {
            return $fullFilePath;
        } else {
            return false;
        }
    }
    return false;
}

/**
 * 处理批量文件上传
 *
 * @param string $fileTarget
 * @param string $filePath
 * @return bool
 */
function handlerUploadFiles($fileTarget = 'fileuploads', $filePath = '')
{
    $files = array();
    if (isset($_FILES[$fileTarget])) {
        for ($i = 0; $i < count($_FILES[$fileTarget]['name']); $i++) {
            $fullFilePath = $filePath . DIRECTORY_SEPARATOR . $_FILES['fileupload']['name'][$i];
            move_uploaded_file($_FILES[$fileTarget]['tmp_name'][$i], $fullFilePath);
            if (chmod($fullFilePath, 0777)) {
                $files[] = $fullFilePath;
            } else {
                # todo 如果报错 那么就删除所有已经上传的文件
                return false;
            }
        }
    }
    return $files;
}

# 配置应用
$app = new \Slim\Slim(array(
    'debug' => true,
    'templates.path' => 'templates',
    'mode' => 'development',
    'log.enabled' => true,
    'log.level' => \Slim\Log::DEBUG,
    'log.writer' => new \Slim\LogWriter(fopen("../logs/log.txt", "rw")),
    'view' => '\Slim\LayoutView',
    'layout' => 'layouts/main.php' # 默认布局
));

$app->setName('tAicoDBTool');

# 会话设置
$app->add(new \Slim\Middleware\SessionCookie(array(
    'exipres' => '30 minutes',
    'path' => '/',
    'domain' => 'taicodbtool.com',
    'secure' => true,
    'httponly' => false,
    'name' => 'aico_session',
    'secret' => 'aico',
    'cipher' => MCRYPT_RIJNDAEL_256,
    'cipher_mode' => MCRYPT_MODE_CBC
)));

# 全局配置
$mainPhp = array(
    'isFileUpload' => false,
    'isDashboard' => false,
    'leftSubMenu' => true,
    'isBrand' => false,
    'isController' => false,
    'isSerie' => false,
    'isOptions' => false,
    'is100' => false,
    'isOptionsController100' => false,
    'isOptionsBrand100' => false,
    'pageName' => '主页面',
    'navName' => '主页面',
    'isOptionRequestProtocolClear' => false,
);

# 主页
$app->get('/', function () use ($app, $mainPhp) {
    $mainPhp['leftSubMenu'] = false;
    $mainPhp['isDashboard'] = true;

    $optionsModel = new \Snake\Services\OptionsServices();

    $app->render('index.php', array(
        'mainPhp' => $mainPhp,
        'response' => array('tags' => $optionsModel->getThreeTags())
    ));
});

# 用户登录
$app->get('/user/login', function () use ($app) {
    $app->render('login.php', array('layout' => false));
});

# 品牌上传
$app->get('/brand/index', function () use ($app, $mainPhp) {
    $mainPhp['pageName'] = '品牌';
    $mainPhp['navName'] = '品牌';
    $mainPhp['isBrand'] = true;
    $mainPhp['isFileUpload'] = true;

    $app->render('brand/index.php', array(
        'mainPhp' => $mainPhp
    ));
});

# 品牌上传
$app->post('/brand/deal', function () use ($app, $mainPhp) {
    $mainPhp['pageName'] = '品牌';
    $mainPhp['navName'] = '品牌';
    $mainPhp['isBrand'] = true;
    $mainPhp['isFileUpload'] = true;

    $r = handlerUploadFiles('fileupload', UPLOADPATHBRANDBEFORE);

    # 过滤掉相关

    if (is_array($r) && count($r) > 0) {
        $sBrand = new \Snake\Services\BrandServices();
        $sfiles = \Snake\FileInfo::getFilePathInfo(UPLOADPATHBRANDBEFORE);
        $tempr = array();

        foreach ($sfiles as $file) {
            $tempr[] = $sBrand->runInsertBrandMain($file, true, UPLOADPATHBRANDAFTER);
        }

        if (count($tempr[0]) > 0) {
            $app->render('brand/upload/success.php', array(
                'mainPhp' => $mainPhp,
                'response' => $tempr,
            ));
        } else {
            $app->render('brand/upload/fail.php', array(
                'mainPhp' => $mainPhp,
                'response' => array(array('遥控器数据都存在于数据库 没有增加新的遥控器')),
            ));
        }
    }
});

# 遥控器上传
$app->get('/controller/index', function () use ($app, $mainPhp) {
    $mainPhp['pageName'] = '遥控器';
    $mainPhp['navName'] = '遥控器';
    $mainPhp['isController'] = true;
    $mainPhp['isFileUpload'] = true;

    $app->render('controller/index.php', array(
        'mainPhp' => $mainPhp
    ));
});

# 遥控器上传文件处理
$app->post('/controller/deal', function () use ($app, $mainPhp) {
    $mainPhp['pageName'] = '遥控器';
    $mainPhp['navName'] = '遥控器';
    $mainPhp['isController'] = true;
    $mainPhp['isFileUpload'] = true;

    $r = handlerUploadFiles('fileupload', UPLOADPATHCODEBASEBEFORE);
    $tempr = array();

    if (is_array($r) && count($r) > 0) {
        $tempr[] = '上传文件成功。<br/>';
        $sCodeBaes = new \Snake\Services\CodebaseServices();
        $files = \Snake\FileInfo::getFilePathInfo(UPLOADPATHCODEBASEBEFORE);
        foreach ($files as $file) {
            $r = $sCodeBaes->runInsertCodebaseMain($file, true, UPLOADPATHCODEBASEAFTER);
            $tfilename = \Snake\FileInfo::getFileName($file);
            if ($r['result']) {
                $tempr[] = "文件: {$tfilename} {$r['operationType']} 成功! <br/>";
            } else {
                $tempr[] = "文件: {$tfilename} {$r['operationType']} 失败! <br/>";
            }
        }
    } else {
        $tempr[] = '上传文件失败。<br/>';
    }

    $app->render('controller/upload/success.php', array(
        'mainPhp' => $mainPhp,
        'response' => $tempr,
    ));
});

# 系列上传
$app->get('/serie/index', function () use ($app, $mainPhp) {
    $mainPhp['pageName'] = '系列';
    $mainPhp['navName'] = '系列';
    $mainPhp['isSerie'] = true;
    $mainPhp['isFileUpload'] = true;

    $app->render('serie/index.php', array(
        'mainPhp' => $mainPhp
    ));
});

# 额外功能模块
$app->get('/options/select/controller/limit100', function () use ($app, $mainPhp) {
    $mainPhp['pageName'] = '最近上传的100个遥控器';
    $mainPhp['navName'] = '最近上传的100个遥控器';
    $mainPhp['isOptions'] = true;
    $mainPhp['is100'] = true;
    $mainPhp['leftSubMenu'] = false;
    $mainPhp['isOptionsController100'] = true;

    $db = new \medoo(\DBFileConfig::$dbinfo);
    $s = new \Snake\ControllerDB($db);
    $os = new \Snake\Services\OptionsServices();
    $r = $s->getControllersDescLimit100();

    $t = array_map(function ($e) use ($os) {
        $e['HasNumberPad'] = $e['HasNumberPad'] == 1 ? "有" : "无";
        $e['SourceFrom'] = $os->getSourceFormCN($e['SourceFrom']);
        return $e;
    }, $r);

    $app->render('options/select/controller/limit/100.php', array(
        'mainPhp' => $mainPhp,
        'response' => $t
    ));
});

$app->get('/options/select/brand/limit100', function () use ($app, $mainPhp) {
    $mainPhp['pageName'] = '最近上传的100个品牌';
    $mainPhp['navName'] = '最近上传的100个品牌';
    $mainPhp['isOptions'] = true;
    $mainPhp['is100'] = true;
    $mainPhp['leftSubMenu'] = false;
    $mainPhp['isOptionsBrand100'] = true;

    $db = new \medoo(\DBFileConfig::$dbinfo);
    $s = new \Snake\BrandDB($db);
    $r = $s->getBrandDescLimit100();

    $app->render('options/select/brand/limit/100.php', array(
        'mainPhp' => $mainPhp,
        'response' => $r
    ));
});

$app->get('/options/request/protocol/clear',function() use ($app,$mainPhp){
    $mainPhp['pageName'] = '清理多余的协议关系';
    $mainPhp['navName'] = '清理多余的协议关系';
    $mainPhp['isOptions'] = true;
    $mainPhp['is100'] = true;
    $mainPhp['leftSubMenu'] = false;
    $mainPhp['isOptionRequestProtocolClear'] = true;

    $r = \Snake\Services\ClearProtocol::run(true);

    $app->render('options/request/protocol/clear.php', array(
        'mainPhp' => $mainPhp,
        'response' => $r
    ));
});

# 测试路由
$app->get('/hello/:name', function ($name) use ($app) {
    $app->render('hello.php', array('name' => $name));
});

# 执行web应用
$app->run();