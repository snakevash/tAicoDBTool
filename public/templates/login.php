<!DOCTYPE html>
<html lang="en">
<head>
    <title>艾果智能数据管理系统</title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="/css/bootstrap-responsive.min.css"/>
    <link rel="stylesheet" href="/css/unicorn.login.css"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
<div id="logo">
    <img src="/img/logo.png" alt=""/>
</div>
<div id="loginbox">
    <form id="loginform"
          class="form-vertical"
          action="/user/login/checkpassword"
          method="post">
        <p>请输入凭证</p>

        <div class="control-group">
            <div class="controls">
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-user"></i></span>
                    <input type="text" placeholder="用户名称"/>
                </div>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-lock"></i></span>
                    <input type="password" placeholder="密码"/>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <span class="pull-left">
                <a href="javascript:void(0);" class="flip-link" id="to-recover">忘记密码</a></span>
            <span class="pull-right">
                <input type="submit" class="btn btn-inverse" value="登录"/>
            </span>
        </div>
    </form>

    <form id="recoverform"
          action="/user/recoverpassword"
          class="form-vertical"
          method="post">
        <p>输入邮箱</p>

        <div class="control-group">
            <div class="controls">
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-envelope"></i></span>
                    <input type="text" placeholder="邮箱地址"/>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <span class="pull-left">
                <a href="javascript:void(0);" class="flip-link" id="to-login">&lt; 返回登录</a>
            </span>
            <span class="pull-right">
                <input type="submit" class="btn btn-inverse" value="恢复密码"/>
            </span>
        </div>
    </form>
</div>

<script src="/js/jquery.min.js"></script>
<script src="/js/unicorn.login.js"></script>
</body>
</html>
