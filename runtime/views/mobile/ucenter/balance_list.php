<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>康卓商城 我要提现</title>
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
    <script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui2/js/mui.picker.js";?>"></script>
	<link rel="stylesheet" href="<?php echo $this->getWebViewPath()."javascript/weui/weui.css";?>">
	<link rel="stylesheet" href="<?php echo $this->getWebViewPath()."javascript/mui2/css/mui.min.css";?>">
	<link rel="stylesheet" href="<?php echo $this->getWebViewPath()."javascript/mui2/css/icons-extra.css";?>">
	<link rel="stylesheet" type="text/css" href="<?php echo $this->getWebViewPath()."javascript/mui2/css/app.css";?>"/>
	<link rel="stylesheet" type="text/css" href="<?php echo $this->getWebViewPath()."javascript/mui2/css/common.css";?>"/>
	<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."resource/scripts/jquery-3.1.1.min.js";?>"></script>
	<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.min.js";?>"></script>
	<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."resource/scripts/common.js";?>"></script>
</head>

<body>
    <nav class="mui-bar mui-bar-tab">
    	<a class="mui-tab-item" href="/">
    		<span class="mui-icon mui-icon-home"></span>
    		<span class="mui-tab-label">首页</span>
    	</a>
    	<a class="mui-tab-item" href="<?php echo IUrl::creatUrl("/simple/cart");?>">
    		<span class="mui-icon mui-icon-extra mui-icon-extra-cart"></span>
    		<span class="mui-tab-label">购物车</span>
    	</a>
    	<a class="mui-tab-item mui-active" href="<?php echo IUrl::creatUrl("/ucenter");?>">
    		<span class="mui-icon mui-icon-contact"></span>
    		<span class="mui-tab-label">个人中心</span>
    	</a>
    </nav>

    <div class="mui-content">
    	<div id="tabbar-with-contact" class="mui-control-content mui-active">
    		<header class="mui-bar mui-bar-nav" style="background-color: #5cc2d0;">
                <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
    			<h1 class="mui-title" style="color:#fff"><?php echo $this->title;?></h1>
    		</header>

            <div class="mui-content">
                <ul class="mui-table-view mui-table-view-striped mui-table-view-condensed">

                  <?php if(!$member_balance_logs_list){?>
                    <li class="mui-table-view-cell">
                        <div class="mui-table">
                            <div class="mui-table-cell mui-col-xs-10">
                                <h4 class="mui-ellipsis-2">没有相关测试信息action</h4>
                                <h5>没有相关测试信息type</h5>
                                <p class="mui-h6 mui-ellipsis">没有相关测试信息content</p>
                            </div>
                            <div class="mui-table-cell mui-col-xs-2 mui-text-right">
                                <span class="mui-h5">没有相关测试信息time</span>
                                 
                            </div>
                        </div>
                    </li>
                    <li class="mui-table-view-cell">
                        <div class="mui-table">
                            <div class="mui-table-cell mui-col-xs-10">
                                <h4 class="mui-ellipsis-2">没有相关测试信息action</h4>
                                <h5>没有相关测试信息type</h5>
                                <p class="mui-h6 mui-ellipsis">没有相关测试信息content</p>
                            </div>
                            <div class="mui-table-cell mui-col-xs-2 mui-text-right">
                                <span class="mui-h5">没有相关测试信息time</span>
                                 
                            </div>
                        </div>
                    </li>
                  <?php }?>
  
                  <?php foreach($member_balance_logs_list as $key => $item){?>
                    <li class="mui-table-view-cell">
                        <div class="mui-table">
                            <div class="mui-table-cell mui-col-xs-10">
                                <h4 class="mui-ellipsis"><?php echo isset($item['action'])?$item['action']:"";?></h4>
                                <h5><?php echo isset($item['type'])?$item['type']:"";?></h5>
                                <p class="mui-h6 mui-ellipsis"><?php echo isset($item['content'])?$item['content']:"";?></p>
                            </div>
                            <div class="mui-table-cell mui-col-xs-2 mui-text-right">
                                <span class="mui-h5"><?php echo isset($item['addtime'])?$item['addtime']:"";?></span>
                            </div>
                        </div>
                    </li>
                  <?php }?>
                </ul>
            </div>

    	</div>

    </div>

<script src="<?php echo $this->getWebViewPath()."javascript/mui2/js/mui.min.js";?>"></script>
<script>
	mui.init({swipeBack:true});
	mui('nav').on('tap','a',function(){document.location.href = this.href;});
</script>
</body>
</html>