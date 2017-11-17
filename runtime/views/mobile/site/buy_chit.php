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
	<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/buy_chit.css";?>">
<script language="javascript">
var max_order_chit = <?php echo isset($brand_chit_info['max_order_chit'])?$brand_chit_info['max_order_chit']:"";?>;
var max_price = <?php echo isset($brand_chit_info['max_price'])?$brand_chit_info['max_price']:"";?>;
var rate = <?php echo isset($brand_chit_info['rate'])?$brand_chit_info['rate']:"";?>;
</script>
<div class="mui-content">
  <ul>
    <li class="goods_name">课程：<?php echo isset($goods_info['name'])?$goods_info['name']:"";?></li>
    <li class="goods_price">
      <span class="t-left">课程学费</span>
      <span class="t-right"><input type="number" name="price" value="<?php echo isset($goods_info['sell_price'])?$goods_info['sell_price']:"";?>" />元</span>
    </li>
    <li class="goods_max_order_chit">
      <span class="t-left">可用代金券</span>
      <span class="t-right"><em><?php echo isset($brand_chit_info['max_order_chit'])?$brand_chit_info['max_order_chit']:"";?>元</em></span>
    </li>
    <li class="goods_rest_price">
      <span class="t-left">优惠后应付</span>
      <span class="t-right"><em><?php echo $goods_info['sell_price'] - $brand_chit_info['max_order_chit'];?>元</em></span>
    </li>
  </ul>

  <ul class="page-footer">
    <li class="chit_info">购买代金券<em><?php echo isset($brand_chit_info['max_price'])?$brand_chit_info['max_price']:"";?>元</em></li>
    <li class="button_info nopadding">
      <input type="hidden" name="brand_chit_id" value="" />
      <input type="hidden" name="type" value="<?php echo isset($type)?$type:"";?>" />
      <input type="hidden" name="id" value="<?php echo isset($id)?$id:"";?>" />
      <button class="mui-btn mui-btn-primary mui-btn-block" id="mui-btn-primary">和学校已确认，立即购买代金券</button>
    </li>
    <li class="notice nopadding">备注：<a href="<?php echo IUrl::creatUrl("/site/chit1");?>"><em>短期课</em>课时已抵扣常规课学费不能使用代金券</a></li>
  </ul>
</div>

<script type='text/javascript' src="<?php echo $this->getWebViewPath()."javascript/buy_chit.js";?>"></script>

	</div>
	<nav class="mui-bar mui-bar-tab">
	    <a class="mui-tab-item home <?php if($this->getId() == 'site' && ($_GET['action'] == 'index' || $_GET['action'] == '')){?>mui-hot-home<?php }?>" href="<?php echo IUrl::creatUrl("");?>">
	        <span class="mui-tab-label">首页</span>
	    </a>
			<a class="mui-tab-item gift <?php if($this->getId() == 'site' && $_GET['action'] == 'chit1'){?>mui-hot-gift<?php }?>" href="<?php echo IUrl::creatUrl("/site/chit1");?>" id="ztelBtn">
	        <span class="mui-tab-label">短期课</span>
	    </a>
			<a class="mui-tab-item brand <?php if($this->getId() == 'site' && $_GET['action'] == 'manual'){?>mui-hot-brand<?php }?>" href="<?php echo IUrl::creatUrl("/site/manual");?>" id="ztelBtn">
					<span class="mui-tab-label">教育手册</span>
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
