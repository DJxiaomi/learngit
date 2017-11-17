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
				<a class="mui-icon mui-icon-left-nav mui-pull-left" href="<?php echo IUrl::creatUrl("".$this->back_url."");?>"></a>
			<?php }?>
	    <?php if($isctrl){?>
	    <a href="<?php echo IUrl::creatUrl("".$isctrl['url']."");?>" class="mui-btn mui-btn-white mui-btn-link mui-pull-right"><?php echo isset($isctrl['text'])?$isctrl['text']:"";?></a>
	    <?php }?>
	    <h1 class="mui-title"><?php echo mb_substr($this->title,0,16,'utf-8');?></h1>
	</header>
	<?php }?>
	<div class="mui-content">
	<?php
  $user_ico = $this->user['head_ico'];
  $user_ico = ( !$user_ico ) ? '/views/mobile/skin/blue/images/front/user_ico.gif' : $user_ico;
  $user_t = Api::run('getMemberInfo',$this->user['user_id']);
  $user_info = $this->userRow;
  $member_info = $this->memberRow;
?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->getWebSkinPath()."css/ucenter_index.css";?>" />
<?php
  $user_ico = $this->user['head_ico'];
  $user_ico = ( !$user_ico ) ? '/views/mobile/skin/blue/images/front/user_ico.gif' : $user_ico;
  $user_t = Api::run('getMemberInfo',$this->user['user_id']);
  $user_info = $this->userRow;
  $member_info = $this->memberRow;
?>
<ul class="mui-table-view index_header">
  <li class="mui-table-view-cell mui-media">
    <a href="<?php echo IUrl::creatUrl('/ucenter/upload_icon'); ?>">
      <img class="mui-media-object mui-pull-left" src="<?php echo empty($this->user['head_ico'])?'/views/default/skin/default/images/front/user_ico.gif':$this->user['head_ico'] ?>">
    </a>
    <div class="mui-media-body">
      <?php echo $user['username']; ?><br />
    </div>
    <?php if ($_GET['action'] == '' || $_GET['action'] == 'index') { ?>
    <div class="mui-media-header">
      <a href="<?php echo IUrl::creatUrl('/ucenter/setting'); ?>" class="mui-icon mui-icon-gear"></a>
      <a href="<?php echo IUrl::creatUrl('/ucenter/message'); ?>" class="mui-icon mui-icon-chatbubble"></a>
    </div>
    <?php } ?>
  </li>
</ul>

<div class="mui-content">

  <ul class="mui-table-view">
    <li class="mui-table-view-cell">
        个人中心
    </li>
  </ul>

  <ul class="mui-table-view mui-grid-view mui-grid-12">
    <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/ucenter/manual_info");?>">
        <img src="/views/mobile/skin/blue/images/icon_31.png" />
        <div class="mui-media-body">手册信息</div>
      </a>
    </li>
    <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/ucenter/promote");?>">
        <img src="/views/mobile/skin/blue/images/icon_32.png" />
        <div class="mui-media-body">推广详情</div>
      </a>
    </li>
    <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/ucenter/promote_qrcode");?>">
        <img src="/views/mobile/skin/blue/images/icon_19.png" />
        <div class="mui-media-body">推广二维码</div>
      </a>
    </li>
  </ul>

  <ul class="mui-table-view mui-grid-view mui-grid-12">
    <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/simple/cart");?>">
        <img src="/views/mobile/skin/blue/images/icon_1.png" />
        <div class="mui-media-body">购物车</div>
      </a>
    </li>
    <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/ucenter/favorite");?>">
        <img src="/views/mobile/skin/blue/images/icon_2.png" />
        <div class="mui-media-body">收藏夹</div>
      </a>
    </li>
    <!-- <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="javascript:void(0);">
        <img src="/views/mobile/skin/blue/images/icon_3.png" />
        <div class="mui-media-body">足迹</div>
      </a>
    </li> -->
    <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/site/help_list");?>">
        <img src="/views/mobile/skin/blue/images/icon_4.png" />
        <div class="mui-media-body">帮助</div>
      </a>
    </li>
    <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/ucenter/jiance");?>">
        <img src="/views/mobile/skin/blue/images/icon_28.png" />
        <div class="mui-media-body">皮纹检测</div>
      </a>
    </li>
  </ul>

  <ul class="mui-table-view">
    <li class="mui-table-view-cell">
        <a class="mui-navigate-right" href="<?php echo IUrl::creatUrl("/ucenter/order");?>">我的订单<span class='t-right'>查看更多订单</span></a>
    </li>
  </ul>

  <ul class="mui-table-view mui-grid-view mui-grid-12">
    <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/ucenter/order/type/2");?>">
        <img src="/views/mobile/skin/blue/images/icon_5.png" /><?php if($user_wait_pay_order_sum > 0){?><span class="mui-badge mui-badge-danger"><?php echo isset($user_wait_pay_order_sum)?$user_wait_pay_order_sum:"";?></span><?php }?>
        <div class="mui-media-body">待付款</div>
      </a>
    </li>
    <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/ucenter/order/type/1");?>">
        <img src="/views/mobile/skin/blue/images/icon_6.png" /><?php if($user_has_pay_order_sum > 0){?><span class="mui-badge mui-badge-danger"><?php echo isset($user_has_pay_order_sum)?$user_has_pay_order_sum:"";?></span><?php }?>
        <div class="mui-media-body">已付款</div>
      </a>
    </li>
    <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/ucenter/order/type/3");?>">
        <img src="/views/mobile/skin/blue/images/icon_7.png" />
        <div class="mui-media-body">已完成</div>
      </a>
    </li>
    <!-- <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="javascript:void(0);">
        <img src="/views/mobile/skin/blue/images/icon_8.png" />
        <div class="mui-media-body">退款</div>
      </a>
    </li> -->
    <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/ucenter/redpacket");?>">
        <img src="/views/mobile/skin/blue/images/icon_9.png" />
        <div class="mui-media-body">代金券订单</div>
      </a>
    </li>
  </ul>

  <ul class="mui-table-view">
    <li class="mui-table-view-cell">
        个人中心
    </li>
  </ul>
  <ul class="mui-table-view mui-grid-view mui-grid-12">
    <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/ucenter/info");?>">
        <img src="/views/mobile/skin/blue/images/icon_10.png" />
        <div class="mui-media-body">个人信息</div>
      </a>
    </li>
    <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/ucenter/authentication");?>">
        <img src="/views/mobile/skin/blue/images/icon_11.png" />
        <div class="mui-media-body">实名认证</div>
      </a>
    </li>
    <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/ucenter/password");?>">
        <img src="/views/mobile/skin/blue/images/icon_12.png" />
        <div class="mui-media-body">修改登录密码</div>
      </a>
    </li>
    <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/ucenter/update_trade_password_ver");?>">
        <img src="/views/mobile/skin/blue/images/icon_13.png" />
        <div class="mui-media-body">修改交易密码</div>
      </a>
    </li>
  </ul>

  <ul class="mui-table-view">
    <li class="mui-table-view-cell">
        账户中心
    </li>
  </ul>
  <ul class="mui-table-view mui-grid-view mui-grid-12">
    <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/ucenter/account_log");?>">
        <img src="/views/mobile/skin/blue/images/icon_14.png" />
        <div class="mui-media-body">第三课账户</div>
      </a>
    </li>
    <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/ucenter/online_recharge");?>">
        <img src="/views/mobile/skin/blue/images/icon_15.png" />
        <div class="mui-media-body">充值</div>
      </a>
    </li>
    <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/ucenter/integral");?>">
        <img src="/views/mobile/skin/blue/images/icon_16.png" />
        <div class="mui-media-body">积分</div>
      </a>
    </li>
    <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/ucenter/withdraw");?>">
        <img src="/views/mobile/skin/blue/images/icon_17.png" />
        <div class="mui-media-body">提现</div>
      </a>
    </li>
  </ul>

  <ul class="mui-table-view">
    <li class="mui-table-view-cell">
        应用中心
    </li>
  </ul>
  <ul class="mui-table-view mui-grid-view mui-grid-12">
    <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/ucenter/tutor_list");?>">
        <img src="/views/mobile/skin/blue/images/icon_18.png" />
        <div class="mui-media-body">我的家教</div>
      </a>
    </li>
    <?php if($user_info['is_equity'] == 1){?>
    <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/ucenter//ucenter/promote");?>">
        <img src="/views/mobile/skin/blue/images/icon_20.png" />
        <div class="mui-media-body">我的股权</div>
      </a>
    </li>
    <?php }?>
    <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/ucenter/article_list");?>">
        <img src="/views/mobile/skin/blue/images/icon_21.png" />
        <div class="mui-media-body">我的文章</div>
      </a>
    </li>
    <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/ucenter/article_list2");?>">
        <img src="/views/mobile/skin/blue/images/icon_27.png" />
        <div class="mui-media-body">试听报告</div>
      </a>
    </li>
    <?php if($member_info['group_id'] == 2){?>
    <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/ucenter/booking_list");?>">
        <img src="/views/mobile/skin/blue/images/icon_26.png" />
        <div class="mui-media-body">我的预定表</div>
      </a>
    </li>
    <?php }?>
  </ul>

  <ul class="mui-table-view">
    <li class="mui-table-view-cell">
        服务中心
    </li>
  </ul>
  <ul class="mui-table-view mui-grid-view mui-grid-12">
    <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/ucenter/consult");?>">
        <img src="/views/mobile/skin/blue/images/icon_22.png" />
        <div class="mui-media-body">报名咨询</div>
      </a>
    </li>
    <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/ucenter/evaluation");?>">
        <img src="/views/mobile/skin/blue/images/icon_23.png" />
        <div class="mui-media-body">课后评价</div>
      </a>
    </li>
    <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="tel:28308258">
        <img src="/views/mobile/skin/blue/images/icon_24.png" />
        <div class="mui-media-body">联系我们</div>
      </a>
    </li>
    <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/ucenter/complain");?>">
        <img src="/views/mobile/skin/blue/images/icon_25.png" />
        <div class="mui-media-body">站点建议</div>
      </a>
    </li>
  </ul>


</div>

	</div>
	<nav class="mui-bar mui-bar-tab">
	    <a class="mui-tab-item home <?php if($this->getId() == 'site' && ($_GET['action'] == 'index' || $_GET['action'] == '')){?>mui-hot-home<?php }?>" href="<?php echo IUrl::creatUrl("");?>">
	        <span class="mui-tab-label">首页</span>
	    </a>
			<a class="mui-tab-item gift <?php if($this->getId() == 'site' && $_GET['action'] == 'chit1'){?>mui-hot-gift<?php }?>" href="<?php echo IUrl::creatUrl("/site/chit1");?>" id="ztelBtn">
	        <span class="mui-tab-label">短期课</span>
	    </a>
			<a class="mui-tab-item brand <?php if($this->getId() == 'site' && $_GET['action'] == 'manual'){?>mui-hot-brand<?php }?>" href="<?php echo IUrl::creatUrl("/site/manual");?>" id="ztelBtn">
					<span class="mui-tab-label">学习通</span>
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

</script>

<?php if($id == 851){?>
<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/form.css";?>" />
<script>var pid = <?php echo isset($id)?$id:"";?>;</script>
<script language="javascript" src="<?php echo $this->getWebSkinPath()."js/form.js";?>"></script>
<?php }?>
