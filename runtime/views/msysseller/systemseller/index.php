<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <title>教学用户管理中心</title>
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">
    <script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.min.css";?>" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.min.js";?>"></script>
    <script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/artdialog/skins/aero.css" />
    <link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/login.css";?>" />
</head>

<body>
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12 column">
                <div class="row clearfix">
                    <div class="col-md-12 column">
                        <h3 class="text-center w700" style="color:#333"><img src="<?php echo $this->getWebSkinPath()."images/login_logo.png";?>" /></h3>
                        <form method="post" name="login" action="<?php echo IUrl::creatUrl("/systemseller/login");?>" autoComplete="off" class="form-horizontal" role="form">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input class="form-control" placeholder="请输入用户名" name="username" style="height:40px;"type="text" />
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input name="password" class="form-control" placeholder="请输入密码"style="height:40px;" type="password" />
                                    <p style="font-size:12px;text-align: right;"><a href="<?php echo IUrl::creatUrl("systemseller/find_password");?>">忘记密码</a></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class=" col-sm-12">
                                    <button type="submit" style="height:40px;line-height:12px;" class="mui-btn mui-btn-primary mui-btn-block">登录</button>
                                </div>
                            </div>
                        </form>

                        <a href="<?php echo IUrl::creatUrl("/simple/seller");?>" type="button" class="btn btn-block btn-info">教学用户注册</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
