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
	    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
	    <?php if($isctrl){?>
	    <a href="<?php echo IUrl::creatUrl("".$isctrl['url']."");?>" class="mui-btn mui-btn-white mui-btn-link mui-pull-right"><?php echo isset($isctrl['text'])?$isctrl['text']:"";?></a>
	    <?php }?>
	    <h1 class="mui-title"><?php echo mb_substr($this->title,0,16,'utf-8');?></h1>
	</header>
	<?php }?>
	<div class="mui-content">
	<?php  $title = '评价列表';?>
<?php $callback = IUrl::creatUrl('/ucenter/index');?>
<link href="<?php echo $this->getWebSkinPath()."css/ucenter.css";?>" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->getWebSkinPath()."css/ucenter_evaluation.css";?>" rel="stylesheet" type="text/css" />
<script language="javascript">
var _page_count = <?php echo isset($page_count)?$page_count:"";?>;
var _curr_page = <?php echo isset($page)?$page:"";?>;
var _page_size = <?php echo isset($page_size)?$page_size:"";?>;
var _loading = false;
var _ajax_data_url = '<?php echo IUrl::creatUrl("/ucenter/get_isevaluation_ajax");?>';
</script>

<div class="evaluationbox w-bg clearfix">
  <div class="mui-tab">
    <ul>
      <li><a href="<?php echo IUrl::creatUrl("/ucenter/evaluation");?>">未评价</a></li>
      <li class="active">已评价</li>
    </ul>
  </div>
	<?php foreach($result_list as $key => $item){?>

  <!-- <div class="mui-card">
      <div class="mui-card-content">
          <div class="mui-card-content-inner">
              <?php if($item['order_info']['statement'] != 4){?>
              <p class="ordbigbt"><span>课程：</span><a class="goodsty orange" href="<?php echo IUrl::creatUrl("/site/products/id/".$item['goods_id']."");?>" target='_block'><?php echo isset($item['name'])?$item['name']:"";?></a></p>
              <?php }else{?>
              <p class="ordbigbt"><span>课程：</span><?php echo isset($item['name'])?$item['name']:"";?></p>
              <?php }?>
              <p class="ordbigbt"><span>订单编号：</span><?php echo isset($item['order_no'])?$item['order_no']:"";?></p>
              <p class="ordbigbt"><span>购买时间：</span><?php echo isset($item['time'])?$item['time']:"";?></p>
              <p class="ordbigbt"><span>评分：</span><?php echo isset($item['point'])?$item['point']:"";?></p>
              <p class="ordbigbt"><span>评价：</span><?php echo isset($item['contents'])?$item['contents']:"";?></p>
          </div>
      </div>
    </div> -->

    <div class="mui-card">
        <div class="mui-card-header">
          <div class='t-left'><?php echo isset($item['seller_info']['shortname'])?$item['seller_info']['shortname']:"";?> > </div>
          <div class='t-right'><?php echo isset($item['status_str'])?$item['status_str']:"";?></div>
        </div>
        <div class="mui-card-content">
            <ul class="mui-table-view">
                <li class="mui-table-view-cell mui-media">
                    <a href="<?php echo IUrl::creatUrl("/ucenter/order_detail/id/".$item['id']."");?>">
                        <img class="mui-media-object mui-pull-left" src="<?php if($item['statement'] != 2){?><?php echo IUrl::creatUrl("/pic/thumb/img/".$item['goods_list'][0][img]."/w/80/h/80");?><?php }else{?>/views/default/skin/default/images/xuexiquan.jpg<?php }?>">
                        <div class="mui-media-body">
                            <p><?php echo isset($item['name'])?$item['name']:"";?> <?php if($item['statement'] == 3){?>(定金)<?php }?></p>
                            <p><span>课程属性：</span><?php echo isset($item['goods']['value'])?$item['goods']['value']:"";?></p>
                            <p class='price'>
                              <span class='t-left'><?php echo isset($item['goods_list'][0]['market_price'])?$item['goods_list'][0]['market_price']:"";?></span>
                              <span class='t-right'>x <?php echo isset($item['goods_list'][0]['goods_nums'])?$item['goods_list'][0]['goods_nums']:"";?></span>
                            </p>
                        </div>
                    </a>
                </li>
            </ul>
            <div class="mui-media-info">
              共<?php echo sizeof($item['goods_list']);?>件商品 合计：<span class='price'>&yen;<?php echo number_format($item['goods_list'][0]['market_price'] * $item['goods_list'][0]['goods_nums'], 2, '.', '');?></span>
            </div>
        </div>
        <div class="mui-card-footers">
            <a href="<?php echo IUrl::creatUrl("/site/comments/id/".$item['id']."");?>">评价</a>
        </div>
    </div>
  <?php }?>
  <div class="fengex"></div>
  <?php if(!$result_list){?>
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
			$('.evaluationbox').append( result );
			$('#cc').html('');
			_loading = false;
		});
	}
});
</script>

	</div>
	<nav class="mui-bar mui-bar-tab">
	    <a class="mui-tab-item home <?php if($this->getId() == 'site' && ($_GET['action'] == 'index' || $_GET['action'] == '')){?>mui-hot-home<?php }?>" href="<?php echo IUrl::creatUrl("");?>">
	        <span class="mui-tab-label">首页</span>
	    </a>
	    <a class="mui-tab-item gift <?php if($this->getId() == 'site' && $_GET['action'] == 'chit1'){?>mui-hot-gift<?php }?>" href="<?php echo IUrl::creatUrl("/site/chit1");?>" id="ztelBtn">
	        <span class="mui-tab-label">短期课</span>
	    </a>
	    <a class="mui-tab-item money <?php if($this->getId() == 'site' && $_GET['action'] == 'chit2'){?>mui-hot-money<?php }?>" href="<?php echo IUrl::creatUrl("/site/chit2");?>">
	        <span class="mui-tab-label">券</span>
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
