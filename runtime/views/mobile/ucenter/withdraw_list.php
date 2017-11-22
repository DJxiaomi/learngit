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

            <?php  $title = '我要提现';?>
            <?php $callback = IUrl::creatUrl('/ucenter/withdraw');?>
            
            <!--link href="/views/mobile/skin/blue/css/index.css" rel="stylesheet" type="text/css" /-->
            <script language="javascript">
            var _page_count = <?php echo isset($page_count)?$page_count:"";?>;
            var _curr_page = <?php echo isset($page)?$page:"";?>;
            var _page_size = <?php echo isset($page_size)?$page_size:"";?>;
            var _loading = false;
            var _ajax_data_url = '<?php echo IUrl::creatUrl("/ucenter/get_withdraw_list_ajax");?>';
            </script>
            
            <div class="order-box" style="margin-top:46px">
              <div class="zhanghu-box w-bg f16 orange">提现记录</div>
              <?php foreach($withdraw_list as $key => $item){?>
              <ul class="product-con w-bg clearfix" style="margin-top:0;">
                  <h3 class="f12"><?php echo isset($item['time'])?$item['time']:"";?></h3>
                  <li class=""><span>收款人姓名：</span><?php echo isset($item['name'])?$item['name']:"";?></li>
                  <li class=""><span>卡号：</span><?php echo isset($item['cart_no'])?$item['cart_no']:"";?></li>
                  <li class=""><span>银行：</span><?php echo isset($item['bank_name'])?$item['bank_name']:"";?></li>
                  <li class=""><span>管理员备注:</span><?php echo isset($item['re_note'])?$item['re_note']:"";?></li>
                  <li class=""><span>申请提现金额：</span><i class="orange f14"><?php echo isset($item['amount'])?$item['amount']:"";?></i>元</li>
                  <li class=""><span>状态：</span><i class="orange f14"><?php echo AccountLog::getWithdrawStatus($item['status']);?></i></li>
              </ul>
              <?php }?>
            
              <?php if(!$withdraw_list){?>
                <div class="nothing">
                  没有相关信息
                </div>
              <?php }?>
            </div>
            
            <div id="cc"></div>
            
            
            </body>
            
            <script language="javascript">
            var loadi;
            $(window).scroll(function(){
            	var a = $(window).scrollTop();
            	var load_position = $('#cc').offset().top;
            	if( a + $(window).height() > load_position -10 && _loading == false && _curr_page < _page_count )
            	{
            		_loading = true;
            		$('#cc').html("<img src='/views/mobile/skin/new/images/loading2.gif'>&nbsp; 努力加载中...");
            		_curr_page = _curr_page + 1;
            		$.get( _ajax_data_url, {page: _curr_page}, function( result ){
                  //console.log( result );
            			$('.zhanghu-box').append( result );
            			$('#cc').html('');
            			_loading = false;
            		});
            	}
            });
            </script>

    	</div>

    </div>

<script src="<?php echo $this->getWebViewPath()."javascript/mui2/js/mui.min.js";?>"></script>
<script>
	mui.init({swipeBack:true});
	mui('nav').on('tap','a',function(){document.location.href = this.href;});
</script>
</body>
</html>