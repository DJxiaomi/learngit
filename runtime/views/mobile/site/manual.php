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
	<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.picker.css";?>" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.poppicker.css";?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.picker.js";?>"></script>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.poppicker.js";?>"></script>
<script type='text/javascript' src="<?php echo IUrl::creatUrl("")."resource/scripts/layer_mobile/layer.js";?>"></script>
<link href="<?php echo $this->getWebSkinPath()."css/chit1.css";?>" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->getWebSkinPath()."css/manual.css";?>" rel="stylesheet" type="text/css" />
<script language="javascript">
var dqk_detail_url = '<?php echo IUrl::creatUrl("/site/chit1_detail/id/@id@/type/2");?>';
var catdata = <?php if($category_list){?><?php echo isset($category_list)?$category_list:"";?><?php }else{?>new Array()<?php }?>;
</script>
<div class="mui-content" style="position:fixed;top:43px;left:0px;z-index:3;padding-bottom:0px;width:100%;">
	<div class="hd" style="padding-top:0px;">
		<div class="category" id="choose_category">
			全部分类
		</div>
		<div class="search_form" style="margin-top:11px;">
			<form method="get" onsubmit="return check_search();">
				<input type="text" name="keyword" id="keyword" placeholder="搜索您感兴趣的内容" <?php if($keywords != ''){?>value="<?php echo isset($keywords)?$keywords:"";?>"<?php }?>/>
				<input type="button" name="button" id="search_btn" value="" />
				<i></i>
			</form>
		</div>
	</div>
	<div class="bd">
		<input type="hidden" id="pagenum" value="1">
		<input type="hidden" id="cat_id" value="0">
		<input type="hidden" id="type" value="0">
		<div class="mui-chit mui-scroll-wrapper card-list-box" id="goodslist">
			<div class="mui-scroll">
			    <ul class="mui-table-view"></ul>
			</div>
		</div>
	</div>
</div>


<ul class="mui-table-view manual_intro">
  <a href="<?php echo IUrl::creatUrl("/site/manual_info");?>">
    <li>
      <img src="/views/mobile/skin/blue/images/manual_img_1.png" />
    </li>
    <li>
      <img src="/views/mobile/skin/blue/images/manual_img_2.png" />
    </li>
    <li>
      <img src="/views/mobile/skin/blue/images/manual_img_3.png" />
    </li>
    <li>
      <img src="/views/mobile/skin/blue/images/manual_img_4.png" />
    </li>
    <li>
      <img src="/views/mobile/skin/blue/images/manual_img_5.png" />
    </li>
  </a>
</ul>

<a name="result"></a>
<div class="mui-table-view manualo_icon">
	<a href="javascript:void(0);" onclick="filter_result(1);"><img src="/views/mobile/skin/blue/images/manual_icon1.png" /></a>
	<a href="javascript:void(0);" onclick="filter_result(2);"><img src="/views/mobile/skin/blue/images/manual_icon2.png" /></a>
	<a href="<?php echo IUrl::creatUrl("/site/manual_discount");?>"><img src="/views/mobile/skin/blue/images/manual_icon3.png" /></a>
	<a href="<?php echo IUrl::creatUrl("/ucenter/manual_info");?>"><img src="/views/mobile/skin/blue/images/manual_icon4.png" /></a>
</div>

<div class="mui-table-view">
  <?php if($chits){?>
  <ul class="dqk_list">
    <?php foreach($chits as $key => $item){?>
    <li>
      <a href="/site/chit1_detail/id/<?php echo isset($item['seller_id'])?$item['seller_id']:"";?>/type/2">
      	<div class="mui-card" id="<?php echo isset($item['seller_id'])?$item['seller_id']:"";?>">
      		<div class="mui-card-header mui-card-media">
      			<img src="<?php echo IUrl::creatUrl("")."".$item['logo']."";?>">
						<div class="mui-manual-type <?php if($item['commission'] > 0){?>type-discount<?php }?>"></div>
      			<div class="mui-card-bg"></div>
      			<div class="mui-card-info">
      				<div class="t-left">已售：<?php echo isset($item['c_sale'])?$item['c_sale']:"";?></div>
      			     <div class="t-right"><span>原价：<?php echo isset($item['max_order_chit'])?$item['max_order_chit']:"";?></span><i>¥</i><?php echo isset($item['max_price'])?$item['max_price']:"";?></div>
            </div>
          </div>
          <div class="mui-card-content">
            <div class="t-left">
              <img src="<?php echo IUrl::creatUrl("")."".$item['b_logo']."";?>">
            </div>
            <div class="t-right">
              <div class="goods-name"><?php echo isset($item['seller_name'])?$item['seller_name']:"";?>短期课-<?php echo isset($item['use_times'])?$item['use_times']:"";?>课时</div>
              <div class="goods-addr"><?php echo isset($item['address'])?$item['address']:"";?></div>
              <div class="goods-content"><?php echo isset($item['brief'])?$item['brief']:"";?></div>
            </div>
          </div>
        </div>
      </a>
    </li>
    <?php }?>
  </ul>
  <?php }?>
</div>

<div class="manual">
	<div class="manual_bg"></div>
	<div class="manual_info">
		<div class="manual_logo"></div>
		<div class="manual_desc">
			<div class="hd">学习通</div>
			<div class="bd">购买学习通，免费上短期课</div>
		</div>
		<div class="manual_open"><a href="<?php echo IUrl::creatUrl("/site/products/id/1980");?>" style="padding:0 15px;">立即查看</a></div>
		<div class="manual_close"><a href="javasript:void(0);"></a></div>
	</div>
</div>

<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/manual.js";?>"></script>

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
