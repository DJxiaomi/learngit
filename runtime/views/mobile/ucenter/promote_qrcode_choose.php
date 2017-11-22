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
            <center>
                <div id="slider" class="mui-slider" style="margin-top:52px;width:70%">
    				<div class="mui-slider-group mui-slider-loop">
    					<!-- 额外增加的一个节点(循环轮播：第一个节点是最后一张轮播) -->
    					<div class="mui-slider-item">
    						<a href="#">
    							<img src="/images/mobile/Qr_bg/4.png">
    							<p class="mui-slider-title">样式4</p>
    						</a>
    					</div>
    					<div class="mui-slider-item">
    						<a href="#">
    							<img src="/images/mobile/Qr_bg/1.png">
    							<p class="mui-slider-title">样式1</p>
    						</a>
    					</div>
    					<div class="mui-slider-item">
    						<a href="#">
    							<img src="/images/mobile/Qr_bg/2.png">
    							<p class="mui-slider-title">样式2</p>
    						</a>
    					</div>
    					<div class="mui-slider-item">
    						<a href="#">
    							<img src="/images/mobile/Qr_bg/3.png">
    							<p class="mui-slider-title">样式3</p>
    						</a>
    					</div>
    					<div class="mui-slider-item">
    						<a href="#">
    							<img src="/images/mobile/Qr_bg/4.png">
    							<p class="mui-slider-title">样式4</p>
    						</a>
    					</div>
    					<!-- 额外增加的一个节点(循环轮播：最后一个节点是第一张轮播) -->
    					<div class="mui-slider-item mui-slider-item-duplicate">
    						<a href="#">
    							<img src="/images/mobile/Qr_bg/1.png">
    							<p class="mui-slider-title">样式默认</p>
    						</a>
    					</div>
    				</div>
    				<div class="mui-slider-indicator mui-text-right">
    					<div class="mui-indicator mui-active"></div>
    					<div class="mui-indicator"></div>
    					<div class="mui-indicator"></div>
    					<div class="mui-indicator"></div>
    				</div>
    			</div>
    			

                <div class="mui-content-padded" style="margin-top:18px">
                    <center>
                        <button type="button" class="mui-btn mui-btn-primary mui-btn-block" id="withdraw" onclick="setqr();" 
                        style="width: 70%;margin:10px 10px 10px;padding: 10px 15px;border: 1px solid #5cc2d0;background-color: #5cc2d0;">生成推广二维码</button>
                    </center>
                </div>
            </center>
    
    	</div>


		</div>
    </div>

<script src="<?php echo $this->getWebViewPath()."javascript/mui2/js/mui.min.js";?>"></script>
	<script>
	mui('nav').on('tap','a',function(){document.location.href=this.href;});
		mui.init({
			swipeBack:true //启用右滑关闭功能
		});
		var slider = mui("#slider");
				slider.slider({
					interval: 0
				});
				
	function setqr(){
	    //mui.loading();
	    var x = mui("#slider").slider().getSlideNumber();
	    x = x + 1;
	    $.getJSON("<?php echo IUrl::creatUrl("/ucenter/promote_qrcode_confirm");?>",{"background_id":x},function(data){
	        if(data.done == true){
	            mui.toast('设置成功');
	            document.location.href = '<?php echo IUrl::creatUrl("/ucenter/promote_qrcode");?>';
	        }	        //alert(JSON.stringify(data));
		});
	}
	
	</script>
	
	
	
</body>
</html>