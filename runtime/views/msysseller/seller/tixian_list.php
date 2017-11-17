<!doctype html>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>管理中心</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link type="image/x-icon" href="<?php echo IUrl::creatUrl("")."favicon.ico";?>" rel="icon">
	<link href="/resource/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.min.css";?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo $this->getWebSkinPath()."css/common.css";?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo $this->getWebSkinPath()."css/form.css";?>" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="/resource/scripts/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.min.js";?>"></script>
	<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/jquery.juploader.js";?>"></script>
	<script type="text/javascript" src="/resource/scripts/common.js"></script>
	<script type="text/javascript">mui.init();var SITE_URL = '<?php echo IUrl::creatUrl("");?>';</script>
</head>
<body>
	<?php if( ($this->getId() == 'site' && $_GET['action'] == 'index') || ($this->getId() == 'site' && $_GET['action'] == '')){?>
	<?php }else{?>
	<header class="mui-bar mui-bar-nav">
	    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
	    <?php if($isctrl){?>
	    <a href="<?php echo IUrl::creatUrl("".$isctrl['url']."");?>" class="mui-btn mui-btn-white mui-btn-link mui-pull-right"><?php echo isset($isctrl['text'])?$isctrl['text']:"";?></a>
	    <?php }else{?>
		<a href="" class="mui-btn mui-btn-white mui-btn-link mui-pull-right"></a>
	    <?php }?>
	    <h1 class="mui-title"><?php echo mb_substr($this->title,0,16,'utf-8');?></h1>
	</header>
	<?php }?>
	<div class="mui-content">
	<?php $this->title ='提现记录'; ?>
<link rel="stylesheet" href="/views/msysseller/skin/blue/css/order_list.css">
<style>
.uinn-t-rank {font-size: 80%; }
.uinn-t-rank li { width: 96%; padding-left: 2%; padding-right: 2%; background-color: #fff; margin-bottom: 10px; }
.uinn-t-rank li a { color: #000; text-decoration: none; }
.uinn-t-rank .order_no, .uinn-t-rank .order_static { height: 30px; line-height: 30px; }
.uinn-t-rank .order_action { height: 30px; overflow: hidden; width: 100%; }
.uinn-t-rank .order_action .t-right { width: 50%; text-align: right; }
.uinn-t-rank .order_action a.send { float: right; margin-right: 8px; width: 40%; height: 23px; line-height: 23px; overflow: hidden; background-color: #ff5500; color: #fff; text-align: center; display: block; border-radius: 5px; }
.uinn-t-rank .gray { color: #919090; }
	.uinn-t-rank .black { color: #000; }
.uinn-t-rank .red { color: red; }	.uinn-t-rank .green { color: green; }	.uinn-t-rank .order_goods_list { clear: both; overflow: hidden; }	.uinn-t-rank .order_goods_list .goods_info { margin-top: 5px; margin-bottom: 5px; clear: both; }	.uinn-t-rank .order_static .format { color: #ff5500; }	.uinn-t-rank .order_goods_list .goods_image { float: left; width: 50px; height: 50px; background-color: #f4f4f4; }	.uinn-t-rank .order_goods_list .goods_image img { max-width: 100%; height: 100%; }	.uinn-t-rank .order_goods_list .goods_infos { float: left; margin-left: 2%; line-height: 25px; }	.uinn-t-rank .order_goods_list .goods_amount { float: left; color: #ff5500; margin-left: 3%; line-height: 25px; }	.alt_btn { padding: 5px; }	.module_content { font-size: 80%; padding-top: 8px; padding-bottom: 8px; }	.pages_bar { text-align: center; }	.pages_bar a { color: red; margin-right: 3px; }	fieldset { border: 0px; border-bottom: 1px solid #ccc; padding-bottom: 5px; }
</style>

<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/form/form.js"></script>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/autovalidate/style.css" />
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/artdialog/skins/aero.css" />
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
<div class="ub ub-ver">
  <div class="ub ub-ver uinn-a1">
    <span style="font-size:.8rem;color:red;">提示：处理成功后，预计一个工作日内到账</span>
    <div class="ub-img-rank rank-bg uinn-t-rank">
      <ul>
        <?php foreach($sale_tixian_list as $key => $item){?>
        <li>
          <div class="order_no">
            <div class="t-left">
              申请时间：<span class="gray"><?php echo date('Y-m-d H:m',$item['create_time']);?></span>
            </div>
          </div>
          <div class="order_static">
            <div class="t-left">
              提现金额：<span class="format"><b><?php echo isset($item['num'])?$item['num']:"";?>元</b></span>
            </div>
          </div>
          <div class="order_static">
            处理时间：<?php if($item['end_time']>0){?><?php echo date('Y-m-d H:m',$item['end_time']);?><?php }?>
          </div>
          <div class="order_action">
            <div class="t-left <?php if($item['status']==0){?>black<?php }elseif($item['status']==1){?>green<?php }else{?>red<?php }?>">
              状态：																			<?php if($item['status']==0){?>待处理<?php }elseif($item['status']==1){?>已同意<?php }else{?>已驳回<?php }?>
            </div>
          </div>
        </li>
        <?php }?>
      </ul>
    </div>
  </div>
</div>


	</div>
	<nav class="mui-bar mui-bar-tab">
	    <a class="mui-tab-item" href="<?php echo IUrl::creatUrl("/seller/brand_edit");?>" id="ztelBtn">
	        <i class="mui-icon-my icon-book"></i>
	        <span class="mui-tab-label">页面信息</span>
	    </a>
	    <a class="mui-tab-item" href="<?php echo IUrl::creatUrl("/seller/seller_edit");?>" id="ztelBtn">
	        <i class="mui-icon-my icon-globe"></i>
	        <span class="mui-tab-label">基本信息</span>
	    </a>
	    <!-- <a class="mui-tab-item mui-hot" href="<?php echo IUrl::creatUrl("/seller/chit");?>">
	        <i class="mui-icon-my icon-github-alt"></i>
	        <span class="mui-tab-label">代金券</span>
	    </a> -->
	    <a class="mui-tab-item" href="<?php echo IUrl::creatUrl("/seller/order_list");?>">
	        <i class="mui-icon-my icon-shopping-cart"></i>
	        <span class="mui-tab-label">学校订单</span>
	    </a>
	    <a class="mui-tab-item" href="<?php echo IUrl::creatUrl("/seller/meau_index");?>" id="ltelBtn">
	        <i class="mui-icon-my icon-user"></i>
	        <span class="mui-tab-label">管理中心</span>
	    </a>
	</nav>
</body>
</html>
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
