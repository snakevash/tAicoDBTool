<!DOCTYPE html>
<html lang="en">
<head>
    <title>艾果智能数据管理系统-主界面</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <link rel="stylesheet" href="/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="/css/bootstrap-responsive.min.css"/>
    <link rel="stylesheet" href="/css/fullcalendar.css"/>
    <link rel="stylesheet" href="/css/unicorn.main.css"/>
    <link rel="stylesheet" href="/css/unicorn.grey.css" class="skin-color"/>

    <link rel="stylesheet" href="/css/colorpicker.css"/>
    <link rel="stylesheet" href="/css/datepicker.css"/>
    <link rel="stylesheet" href="/css/uniform.css"/>
    <link rel="stylesheet" href="/css/select2.css"/>
    <link rel="stylesheet" href="/css/unicorn.grey.css" class="skin-color"/>

    <script src="/js/jquery.min.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>


<div id="header">
    <h1><a href="/">艾果智能数据管理系统</a></h1>
</div>

<div id="search">
    <input type="text" placeholder="搜索..."/>
    <button type="submit" class="tip-right" title="搜索">
        <i class="icon-search icon-white"></i>
    </button>
</div>

<div id="user-nav" class="navbar navbar-inverse">
    <ul class="nav btn-group">
        <li class="btn btn-inverse">
            <a title="" href="#">
                <i class="icon icon-user"></i>
                <span class="text">配置</span>
            </a>
        </li>

        <li class="btn btn-inverse dropdown" id="menu-messages">
            <a href="#" data-toggle="dropdown" data-target="#menu-messages" class="dropdown-toggle">
                <i class="icon icon-envelope"></i>
                <span class="text">消息</span>
                <span class="label label-important">5</span>
                <b class="caret"></b>
            </a>

            <ul class="dropdown-menu">
                <li><a class="sAdd" title="" href="#">新消息</a></li>
                <li><a class="sInbox" title="" href="#">收件箱</a></li>
                <li><a class="sOutbox" title="" href="#">发件箱</a></li>
                <li><a class="sTrash" title="" href="#">垃圾箱</a></li>
            </ul>
        </li>
        <li class="btn btn-inverse">
            <a title="" href="#">
                <i class="icon icon-cog"></i>
                <span class="text">配置</span>
            </a>
        </li>
        <li class="btn btn-inverse">
            <a title="" href="/user/login">
                <i class="icon icon-share-alt"></i>
                <span class="text">退出</span>
            </a>
        </li>
    </ul>
</div>

<div id="sidebar">
    <a href="#" class="visible-phone">
        <i class="icon icon-home"></i> 主界面</a>
    <ul>
        <li class="active">
            <a href="/"><i class="icon icon-home"></i> <span>主界面</span></a>
        </li>
        <li class="submenu <?php if($mainPhp['leftSubMenu']){ echo 'open';}?>">
            <a href="javascript:void(0);">
                <i class="icon icon-th-list"></i>
                <span>文件上传</span>
                <span class="label">3</span>
            </a>
            <ul>
                <li
                    <?php
                        if($mainPhp['isBrand']){
                            echo 'class="active"';
                        }
                    ?>
                    >
                    <a href="/brand/index">品牌上传/更新</a>
                </li>
                <li
                    <?php
                        if($mainPhp['isController']){
                            echo 'class="active"';
                        }
                    ?>
                    >
                    <a href="/controller/index">遥控器上传/更新</a>
                </li>
                <li
                    <?php
                        if($mainPhp['isSerie']){
                            echo 'class="active"';
                        }
                    ?>
                    >
                    <a href="/serie/index">系列上传/更新</a>
                </li>
            </ul>
        </li>
    </ul>
</div>

<div id="style-switcher">
    <i class="icon-arrow-left icon-white"></i>
    <span>风格:</span>
    <a href="#grey" style="background-color: #555555; border-color: #aaaaaa;"></a>
    <a href="#blue" style="background-color: #2D2F57;"></a>
    <a href="#red" style="background-color: #673232;"></a>
</div>

<div id="content">
    <div id="content-header">
        <h1><?php echo $mainPhp['pageName']; ?></h1>

        <div class="btn-group">
            <a class="btn btn-large tip-bottom" title="管理文件">
                <i class="icon-file"></i>
            </a>
            <a class="btn btn-large tip-bottom" title="管理用户">
                <i class="icon-user"></i>
            </a>
            <a class="btn btn-large tip-bottom" title="管理评论">
                <i class="icon-comment"></i>
                <span class="label label-important">5</span>
            </a>
            <a class="btn btn-large tip-bottom" title="管理订单">
                <i class="icon-shopping-cart"></i>
            </a>
        </div>
    </div>

    <div id="breadcrumb">
        <a href="#" title="返回管理界面" class="tip-bottom">
            <i class="icon-home"></i> 管理系统</a>
        <a href="#" class="current">
            <?php echo $mainPhp['navName']; ?>
        </a>
    </div>

    <div class="container-fluid">
        <?php echo $yield; ?>
        <div class="row-fluid">
            <div id="footer" class="span12">
                2014 &copy; Aico.com
            </div>
        </div>
    </div>
</div>

<script src="/js/jquery.ui.custom.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/jquery.peity.min.js"></script>
<script src="/js/unicorn.js"></script>
<script src="/js/unicorn.dashboard.js"></script>
<script src="/js/unicorn.form_common.js"></script>

<script src="/js/bootstrap-colorpicker.js"></script>
<script src="/js/bootstrap-datepicker.js"></script>
<script src="/js/jquery.uniform.js"></script>
<script src="/js/select2.min.js"></script>
</body>
</html>
