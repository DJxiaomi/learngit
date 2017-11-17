<?php
	$member_info = member_class::get_member_info($this->user['user_id']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $this->_siteConfig->name;?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link type="image/x-icon" href="<?php echo IUrl::creatUrl("")."favicon.ico";?>" rel="icon">
	<link href="<?php echo IUrl::creatUrl("")."resource/css/font-awesome.min.css";?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.min.css";?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo $this->getWebSkinPath()."css/common.css";?>" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."resource/scripts/jquery-3.1.1.min.js";?>"></script>
	<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.min.js";?>"></script>
	<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."resource/scripts/common.js";?>"></script>
	<script type="text/javascript">mui.init({swipeBack:true});var SITE_URL = '<?php echo IUrl::creatUrl("");?>';</script>
</head>
<body>
	<?php if( ($this->getId() == 'site' && $_GET['action'] == 'index') || ($this->getId() == 'site' && $_GET['action'] == '')){?>
	<?php }else{?>
	<header class="mui-bar mui-bar-nav">
			<?php if(!$this->back_url){?>
	    	<a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
			<?php }else{?>
				<style>
				.mui-icon-back:before, .mui-icon-left-nav:before {color: #fff;}
				</style>
				<a class="mui-icon mui-icon-left-nav mui-pull-left" href="<?php echo IUrl::creatUrl("/site/chit1");?>"></a>
			<?php }?>
	    <?php if($isctrl){?>
	    <a href="<?php echo IUrl::creatUrl("".$isctrl['url']."");?>" class="mui-btn mui-btn-white mui-btn-link mui-pull-right"><?php echo isset($isctrl['text'])?$isctrl['text']:"";?></a>
	    <?php }?>
	    <h1 class="mui-title"><?php echo mb_substr($this->title,0,16,'utf-8');?></h1>
	</header>
	<?php }?>
	<div class="mui-content">
	<link href="<?php echo $this->getWebSkinPath()."css/ucenter.css";?>" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->getWebSkinPath()."css/ucenter_order_detail.css";?>" rel="stylesheet" type="text/css" />
<div class="mui-card student_info">
    <div class="mui-card-content">
        <ul class="mui-table-view">
            <li class="mui-table-view-cell"><span>课程名称：</span><?php echo isset($goods_info['name'])?$goods_info['name']:"";?></li>
            <li class="mui-table-view-cell"><span>代金券可抵用：</span><?php echo isset($brand_chit_info['max_order_chit'])?$brand_chit_info['max_order_chit']:"";?>元</li>
            <li class="mui-table-view-cell"><span>线下需支付：</span><?php echo isset($rest_price)?$rest_price:"";?>元</li>
            <li class="mui-table-view-cell"><span>姓名：</span><?php echo isset($order_info['accept_name'])?$order_info['accept_name']:"";?></li>
            <li class="mui-table-view-cell"><span>手机号：</span><?php echo isset($order_info['mobile'])?$order_info['mobile']:"";?></li>
        </ul>
    </div>
</div>
<?php if($order_info['status'] != 5){?>
<div class="mui-card">
    <div class="mui-card-content">
        <ul class="mui-table-view">
            <div class="mui-input-group">
                <div class="mui-button-row">
                      <a href="javascript:void(0);" class="mui-btn mui-btn-primary confirm">确认线下使用</a>
                </div>
            </div>
        </ul>
    </div>
</div>
<?php }?>

<script language="javascript">
$(document).ready(function(){
    $('.confirm').click(function(){
        mui.confirm('你确认已在线下使用了此代金券吗？', '确认使用', ['取消', '确定'], function(e){
            if(e.index == 1){
                var _post_url = '<?php echo IUrl::creatUrl("/ucenter/redpacket_confirm_use_ajax");?>';
                Lx.common.loading();
                mui.post( _post_url, {order_id: <?php echo isset($order_info['id'])?$order_info['id']:"";?>, id: <?php echo isset($brand_chit_info['id'])?$brand_chit_info['id']:"";?>}, function(data){
                    if ( data == '1'){
                        location.href = '<?php echo IUrl::creatUrl("/ucenter/order_detail/id/".$order_info['id']."");?>';
                    } else if ( data == '-1'){
                        mui.toast('操作不正确');
                    } else {
                      mui.toast(data);
                    }
                })
            }else{
            }
        });
    });
})
</script>

	</div>
	<nav class="mui-bar mui-bar-tab">
	    <a class="mui-tab-item home <?php if($this->getId() == 'site' && ($_GET['action'] == 'index' || $_GET['action'] == '')){?>mui-hot-home<?php }?>" href="<?php echo IUrl::creatUrl("");?>">
	        <span class="mui-tab-label">首页</span>
	    </a>
			<a class="mui-tab-item gift <?php if($this->getId() == 'site' && $_GET['action'] == 'chit1'){?>mui-hot-gift<?php }?>" href="<?php echo IUrl::creatUrl("/site/chit1");?>" id="ztelBtn">
	        <span class="mui-tab-label">短期课</span>
	    </a>
	    <a class="mui-tab-item user <?php if($this->getId() == 'ucenter' || ($this->getId() == 'simple' && $_GET['action'] == 'login')){?>mui-hot-user<?php }?>" href="<?php echo IUrl::creatUrl("/simple/login");?>?callback=/ucenter" id="ltelBtn">
	        <span class="mui-tab-label">我的</span>
	    </a>
      <a class="mui-tab-item service" href="<?php echo IUrl::creatUrl("/site/service");?>" id="ltelBtn">
	        <span class="mui-tab-label">客服</span>
	    </a>
	</nav>
</body>
</html>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.lazyload.js";?>"></script>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.lazyload.img.js";?>"></script>
<script type="text/javascript">
mui('body').on('tap', 'a', function(){
    if(this.href != '#' && this.href != ''){
        mui.openWindow({
            url: this.href
        });
    }
    this.click();
});

(function($) {
	$(document).imageLazyload({
		placeholder: '<?php echo $this->getWebSkinPath()."images/lazyload.jpg";?>'
	});
})(mui);
</script>

<?php if($id == 851){?>
<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/form.css";?>" />
<script>var pid = <?php echo isset($id)?$id:"";?>;</script>
<script language="javascript" src="<?php echo $this->getWebSkinPath()."js/form.js";?>"></script>
<?php }?>
