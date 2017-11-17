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
	<link href="<?php echo $this->getWebSkinPath()."css/index.css";?>" rel="stylesheet" type="text/css" />
<link href="<?php echo IUrl::creatUrl("")."resource/scripts/swiper/swiper.min.css";?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."resource/scripts/swiper/swiper.min.js";?>"></script>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/index.js";?>"></script>
<script type='text/javascript' src="<?php echo IUrl::creatUrl("")."resource/scripts/layer_mobile/layer.js";?>"></script>

<div class="search_content">
  <div class="search_info">
    <div class="search_form">
      <div class="region">株洲</div>
      <form method="get">
      <input type="text" value="" id="keywords2" placeholder="搜索您感兴趣的内容"/>
      <input type="button" value="" />
      </form>
    </div>
  </div>
</div>

<!-- 搜索弹出窗 start -->
<div class="pop_search_content">
  <div class="search_content">
    <div class="search_info">
      <div class="search_form">
        <form method="get" id="form1" action="<?php echo IUrl::creatUrl("/site/chit1");?>" onSubmit="return check_search();">
        <input type="text" value="" id="keywords" name="keywords" placeholder="搜索您感兴趣的内容"/>
        <input type="button" value="" />
        <a href="javascript:void(0)" onclick="close_pop_search();" class="cancel_search">取消</a>
        </form>
      </div>
    </div>
  </div>
  <div class="search_tab">
    <ul>
      <li><a href="javascript:void(0);" onclick="search_cc('dqk');" class="active">短期课</a></li>
      <li><a href="javascript:void(0);" onclick="search_cc('seller');">学校</a></li>
      <li><a href="javascript:void(0);" onclick="search_cc('goods');">课程</a></li>
    </ul>
  </div>
</div>
<!-- 搜索弹出窗 end -->

<!--轮播-->
<div class="swiper-container" style="margin-top:41px;">
    <div class="swiper-wrapper">
        <?php if($this->index_slide_mobile){?>
            <?php foreach($this->index_slide_mobile as $key => $item){?>
            <div class="swiper-slide">
                <a href="<?php echo IUrl::creatUrl("".$item['url']."");?>"><img width="100%" src="<?php echo IUrl::creatUrl("/pic/thumb/img/".$item['img']."");?>" /></a>
            </div>
            <?php }?>
        <?php }?>
    </div>
    <div class="swiper-pagination"></div>
</div>
<!--轮播-->

<!--栏目-->
<div class="index-category">
    <div class="swiper-wrapper">
        <ul class="clearfix swiper-slide">
            <li>
                <a href="<?php echo IUrl::creatUrl("/site/brand?&cat_id=1");?>">
                    <div class="img"><img src="<?php echo $this->getWebSkinPath()."images/index_icon_1.png";?>" /></div>
                    <div class="ct">婴幼儿</div>
                </a>
            </li>
            <li>
                <a href="<?php echo IUrl::creatUrl("/site/brand?&cat_id=2");?>">
                    <div class="img"><img src="<?php echo $this->getWebSkinPath()."images/index_icon_2.png";?>" /></div>
                    <div class="ct">中小学</div>
                </a>
            </li>
            <li>
                <a href="<?php echo IUrl::creatUrl("/site/brand?&cat_id=4");?>">
                    <div class="img"><img src="<?php echo $this->getWebSkinPath()."images/index_icon_3.png";?>" /></div>
                    <div class="ct">文学艺术</div>
                </a>
            </li>
            <li>
                <a href="<?php echo IUrl::creatUrl("/site/brand?&cat_id=196");?>">
                    <div class="img"><img src="<?php echo $this->getWebSkinPath()."images/index_icon_4.png";?>" /></div>
                    <div class="ct">益智体育</div>
                </a>
            </li>
            <li>
                <a href="<?php echo IUrl::creatUrl("/site/tutor");?>">
                    <div class="img"><img src="<?php echo $this->getWebSkinPath()."images/index_icon_5.png";?>" /></div>
                    <div class="ct">家教辅导</div>
                </a>
            </li>
            <li>
                <a href="<?php echo IUrl::creatUrl("/site/article2");?>">
                    <div class="img"><img src="<?php echo $this->getWebSkinPath()."images/index_icon_10.png";?>" /></div>
                    <div class="ct">试听体验</div>
                </a>
            </li>
            <li>
                <a href="<?php echo IUrl::creatUrl("/site/activity_zhuanti");?>">
                    <div class="img"><img src="<?php echo $this->getWebSkinPath()."images/index_icon_7.png";?>" /></div>
                    <div class="ct">热点专题</div>
                </a>
            </li>
            <li>
                <a href="<?php echo IUrl::creatUrl("/site/article/cid/2");?>">
                    <div class="img"><img src="<?php echo $this->getWebSkinPath()."images/index_icon_10.png";?>" /></div>
                    <div class="ct">新闻资讯</div>
                </a>
            </li>
        </ul>
        <ul class="clearfix swiper-slide">
            <li>
                <a href="<?php echo IUrl::creatUrl("/site/user_tutor_list");?>">
                    <div class="img"><img src="<?php echo $this->getWebSkinPath()."images/index_icon_14.png";?>" /></div>
                    <div class="ct">找学生</div>
                </a>
            </li>
        </ul>
    </div>
    <div class="index-category-pagination"></div>
</div>
<script type="text/javascript">
var swiper = new Swiper('.index-category', {
    pagination: '.index-category-pagination',
    paginationClickable: true,
    loop : false,
    autoplay: false
});
</script>
<!--栏目-->

<!--短期课列表-->
<div class="goodslist dqk_list">
    <div class="hd">
      <div class="title">
        <a href="#"><img src="<?php echo $this->getWebSkinPath()."images/shop_list_hd_bg.png";?>" /></a>短期课
      </div>
      <div class="area_list">
        <ul>
          <?php foreach($dqk_list as $key => $item){?>
          <?php $j++;?>
          <li <?php if($j == 1){?>class="active"<?php }?>><a href="javascript:void(0);" onclick="show_intro_dqk(this,'<?php echo isset($item['id'])?$item['id']:"";?>')"><?php echo isset($item['name'])?$item['name']:"";?></a></li>
          <?php }?>
        </ul>
      </div>
    </div>
    <div class="bd">
      <?php foreach($dqk_list as $key => $item){?>
      <?php $i++;?>
      <ul class="mui-table-view mui-grid-view brand-list" _id="<?php echo isset($item['id'])?$item['id']:"";?>" <?php if($i > 1){?>style="display:none;"<?php }?>>
            <?php foreach($item['list'] as $key => $it){?>
              <li class="mui-table-view-cell mui-media mui-col-xs-6 brand-cell">
                  <a href="<?php echo IUrl::creatUrl("/site/chit1_detail/id/".$it['seller_id']."");?>" class="thumb">
                      <div class="goodsimage">
                        <img class="mui-media-object" src="<?php echo IUrl::creatUrl("".$it['logo']."");?>">
                      </div>

                      <div class="goodsinfo">
                        <div class="goodsname">
                            <?php echo isset($it['seller_name'])?$it['seller_name']:"";?>短期课-<?php echo isset($it['use_times'])?$it['use_times']:"";?>课时
                        </div>
                        <div class="goodsaddr">
                          [<?php if($it['area']){?><?php echo area::getName($it['area']);?><?php }?><?php echo isset($it['address'])?$it['address']:"";?>]
                        </div>
                        <div class="goodsdesc">
                          <?php echo strip_tags($it['content']);?>
                        </div>
                        <div class="goodsprice">
                          <div class="t-left">
                            &yen;<?php echo isset($it['max_price'])?$it['max_price']:"";?>
                            <span class="market_price">
                              原价：<?php echo isset($it['max_order_chit'])?$it['max_order_chit']:"";?>
                            </div>

                            <div class="t-right">
                              已售：<?php echo isset($it['sale'])?$it['sale']:"";?>
                            </div>
                        </div>
                      </div>
                  </a>
              </li>
            <?php }?>
      </ul>
      <?php }?>
    </div>
</div>
<!--短期课列表-->

<!--列表-->
<?php $j = 0; $i = 0;?>
<div class="goodslist">
    <div class="hd">
      <div class="title">
        <a href="#"><img src="<?php echo $this->getWebSkinPath()."images/shop_list_hd_bg.png";?>" /></a>学校推荐
      </div>
      <div class="area_list">
        <ul>
          <?php foreach($area_list as $key => $item){?>
          <?php $j++;?>
          <li <?php if($j == 1){?>class="active"<?php }?>><a href="javascript:void(0);" onclick="show_intro_shop(this,'<?php echo isset($item['area_id'])?$item['area_id']:"";?>')"><?php echo isset($item['area_name'])?$item['area_name']:"";?></a></li>
          <?php }?>
        </ul>
      </div>
    </div>
    <div class="bd">
      <?php foreach($shop_list as $key => $item){?>
      <?php $i++;?>
      <ul class="mui-table-view mui-grid-view brand-list" _id="<?php echo isset($key)?$key:"";?>" <?php if($i > 1){?>style="display:none;"<?php }?>>
            <?php foreach($item as $key => $it){?>
              <li class="mui-table-view-cell mui-media mui-col-xs-6 brand-cell">
                  <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/".$it['id']."");?>" class="thumb">
                      <div class="goodsimage">
                        <img class="mui-media-object" src="<?php echo IUrl::creatUrl("".$it['logo']."");?>">
                      </div>

                      <div class="goodsinfo">
                        <div class="goodsname">
                            <?php if($it['shortname']){?><?php echo isset($it['shortname'])?$it['shortname']:"";?><?php }else{?><?php echo  mb_substr($it['name'], 0, 12,'utf-8');?><?php }?>
                        </div>
                        <div class="goodsdesc">
                          <?php echo isset($it['brief'])?$it['brief']:"";?>
                        </div>
                        <div class="goodsaddr">
                          [<?php if($it['area']){?><?php echo area::getName($it['area']);?><?php }?><?php echo isset($it['address'])?$it['address']:"";?>]
                        </div>
                        <div class="goodssalecount">已售：<?php echo isset($it['sale'])?$it['sale']:"";?></div>
                      </div>
                  </a>
              </li>
            <?php }?>
      </ul>
      <?php }?>
    </div>
</div>
<div class="bl_more"><a href="javascript:;" id="bl_more"></a></div>

<script type="text/javascript">
var swiper = new Swiper('.swiper-container', {
    pagination: '.swiper-pagination',
    paginationClickable: true,
    loop : true,
    autoplay: 3000
});
</script>


<?php if($this->iswechat == 1){?>
<script src="http://res.wx.qq.com/open/js/jweixin-1.1.0.js"> </script>
<script type="text/javascript">
sharedata = <?php echo $this->sharedata;?>;
wx.config({
    //debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
    appId: '<?php echo isset($this->signPackage['appId'])?$this->signPackage['appId']:"";?>', // 必填，公众号的唯一标识
    timestamp: '<?php echo isset($this->signPackage['timestamp'])?$this->signPackage['timestamp']:"";?>' , // 必填，生成签名的时间戳
    nonceStr: '<?php echo isset($this->signPackage['nonceStr'])?$this->signPackage['nonceStr']:"";?>', // 必填，生成签名的随机串
    signature: '<?php echo isset($this->signPackage['signature'])?$this->signPackage['signature']:"";?>',// 必填，签名，见附录1
    jsApiList: [
      'checkJsApi',
  		'onMenuShareTimeline',
  		'onMenuShareAppMessage',
  		'onMenuShareQQ',
  		'onMenuShareWeibo',
  		'hideMenuItems',
  		'showMenuItems',
  		'hideAllNonBaseMenuItem',
  		'showAllNonBaseMenuItem',
  		'translateVoice',
  		'startRecord',
  		'stopRecord',
  		'onRecordEnd',
  		'playVoice',
  		'pauseVoice',
  		'stopVoice',
  		'uploadVoice',
  		'downloadVoice',
  		'chooseImage',
  		'previewImage',
  		'uploadImage',
  		'downloadImage',
  		'getNetworkType',
  		'openLocation',
  		'getLocation',
  		'hideOptionMenu',
  		'showOptionMenu',
  		'closeWindow',
  		'scanQRCode',
  		'chooseWXPay',
  		'openProductSpecificView',
  		'addCard',
  		'chooseCard',
  		'openCard'
    ] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
});
wx.ready(function(){
  wx.onMenuShareAppMessage(sharedata);
  wx.onMenuShareTimeline(sharedata);
  wx.onMenuShareQQ(sharedata);
  wx.onMenuShareWeibo(sharedata);
});
wx.error(function (res) {
  	//alert("调用微信jsapi返回的状态:"+res.errMsg);
});
</script>
<?php }?>

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
