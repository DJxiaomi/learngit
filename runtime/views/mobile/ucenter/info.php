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
            <?php $callback = IUrl::creatUrl('/ucenter/index');?>
            <link rel="stylesheet" type="text/css" href="<?php echo $this->getWebSkinPath()."css/ucenter.css";?>" />
            <link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.picker.css";?>" rel="stylesheet" type="text/css" />
            <link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.poppicker.css";?>" rel="stylesheet" type="text/css" />
            <?php $user_ico = $this->user['head_ico']?>
            <div class="mui-card" style="margin-top:52px">
                <form class="mui-input-group" action="<?php echo IUrl::creatUrl("/ucenter/info_edit_act");?>" method="post" enctype='multipart/form-data'>
                	<div class="mui-input-row">
                		<label>姓名</label>
                		<input type="text" placeholder="姓名" value="<?php echo isset($this->memberRow['true_name'])?$this->memberRow['true_name']:"";?>" name="true_name" />
                	</div>
                	<div class="mui-input-row">
                		<label>邮箱</label>
                		<input type="text" placeholder="邮箱" value="<?php echo isset($this->memberRow['email'])?$this->memberRow['email']:"";?>" name="email" />
                	</div>
                	<div class="mui-input-row">
                		<label>手机号</label>
                		<input type="text" placeholder="手机号码" value="<?php echo isset($this->memberRow['mobile'])?$this->memberRow['mobile']:"";?>" name="mobile"<?php if($this->memberRow['mobile'] != ''){?> disabled="disabled"<?php }?> />
                	</div>
                	<div class="mui-input-row" id="region">
                		<label>地区</label>
                		<span id="province"><?php if($this->memberRow['provinceval']){?><?php echo isset($this->memberRow['provinceval'])?$this->memberRow['provinceval']:"";?><?php }else{?>湖南省<?php }?></span>
                		<span id="city"><?php if($this->memberRow['cityval']){?><?php echo isset($this->memberRow['cityval'])?$this->memberRow['cityval']:"";?><?php }else{?>株洲市<?php }?></span>
                		<span id="discrict"><?php if($this->memberRow['discrictval']){?><?php echo isset($this->memberRow['discrictval'])?$this->memberRow['discrictval']:"";?><?php }else{?>市辖区<?php }?></span>
                		<input type="hidden" name="province" id="provinceval" value="<?php if($this->memberRow['areas'][0]){?><?php echo isset($this->memberRow['areas'][0])?$this->memberRow['areas'][0]:"";?><?php }else{?>430000<?php }?>" />
                		<input type="hidden" name="city" id="cityval" value="<?php if($this->memberRow['areas'][1]){?><?php echo isset($this->memberRow['areas'][0])?$this->memberRow['areas'][0]:"";?><?php }else{?>430200<?php }?>" />
                		<input type="hidden" name="area" id="discrictval" value="<?php if($this->memberRow['areas'][2]){?><?php echo isset($this->brandRow['areas'][2])?$this->brandRow['areas'][2]:"";?><?php }else{?>430201<?php }?>" />
                		<i class="icon-angle-right"></i>
                	</div>
                	<div class="mui-input-row">
                		<label>街道地址</label>
                		<input type="text" name="contact_addr" value="<?php echo isset($this->memberRow['contact_addr'])?$this->memberRow['contact_addr']:"";?>" placeholder="请填写街道地址" />
                	</div>
                	<div class="mui-content-padded">
                        <button type="submit" class="mui-btn mui-btn-primary mui-btn-block" 
                        style="width: 90%;margin:10px 10px 10px;padding: 10px 15px;border: 1px solid #5cc2d0;background-color: #5cc2d0;">提交</button>
                    </div>
                </form>
            </div>
            <script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.picker.js";?>"></script>
            <script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.poppicker.js";?>"></script>
    	</div>
    </div>

<script src="<?php echo $this->getWebViewPath()."javascript/mui2/js/mui.min.js";?>"></script>
<script>
	mui.init({swipeBack:true});
	mui('nav').on('tap','a',function(){document.location.href=this.href;});
</script>
</body>
</html>