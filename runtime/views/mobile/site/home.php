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
	<?php    $site_config=new Config('site_config');	$dcommission = $site_config->dcommission;?>
<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/product.css";?>">
<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/home.css";?>">
<link rel="stylesheet" href="<?php echo IUrl::creatUrl("")."resource/scripts/swiper/swiper.min.css";?>">
<link rel="stylesheet" href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.picker.min.css";?>">
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate.js"></script>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
<script type='text/javascript' src="<?php echo IUrl::creatUrl("")."resource/scripts/swiper/swiper.min.js";?>"></script>
<script type='text/javascript' src="<?php echo IUrl::creatUrl("")."resource/scripts/layer_mobile/layer.js";?>"></script>
<script type='text/javascript' src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.picker.min.js";?>"></script>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/openqq.js";?>"></script>
<script type="text/javascript">
	var _goods_list = <?php echo isset($seller_info['goods_list_json'])?$seller_info['goods_list_json']:"";?>;
	var _goods_id = 0;
	var _spec_id = 0;
	var _action = '';
	var _seller_id = <?php echo isset($seller_info['id'])?$seller_info['id']:"";?>;
</script>
<input type='hidden' id='product_id' alt='课程ID' value='' />
<div class="shop-nav-bot<?php if($seller_info['is_authentication'] == 1){?><?php if($discount <= 0){?> cxd-1<?php }?><?php }else{?> cxd-2<?php }?>">
		<?php if($seller_info['is_authentication'] == 1){?>
			<a<?php if($seller_info['nextid']){?> href="<?php echo IUrl::creatUrl("/site/home/id/".$seller_info['nextid']."");?>"<?php }else{?> href="javascript:;" onclick="alert('没有其他学校')"<?php }?> class="shopbtn">下一学校</a>
			<a href="javascript: void(0);" onclick="joinCart();" class="add-shop" id="joinCarButton">加入课表</a>
			<a href="javascript: void(0);" onclick="buy_now();" class="buy-btn" id="buyNowButton" >立即报名</a>
		<?php }else{?>
		<a href="javascript:;" class="shopbtn">学校未认证</a>
		<?php }?>
</div>
<div class="swiper-container">
	<div class="swiper-wrapper">
		<?php if($seller_info['photo']){?>
  		<?php foreach($seller_info['photo'] as $key => $item){?>
  		<div class="swiper-slide">
  			<img width="100%" src="<?php echo IUrl::creatUrl("")."".$item."";?>" />
  		</div>
  		<?php }?>
		<?php }?>
	</div>
	<div class="swiper-pagination"></div>
</div>
<div class="shop_name"><?php echo isset($seller_info['shortname'])?$seller_info['shortname']:"";?></div>

<?php if($djq_list){?>
<div class="swiper-container2" style="height:100px;">
	<div class="mui-content-padded swiper-wrapper" style="background-color:#ebeff2;">
		<?php foreach($djq_list as $key => $it){?>
		<ul class="djq_list c1 swiper-slide">
				<?php foreach($it as $key => $item){?>
				<li>
						<a href="<?php echo IUrl::creatUrl("/simple/cart2d/id/5280/num/1/type/product/chitid/".$item['id']."");?>">
							<div class="djq_info">
								<div class="t-left">&yen;<em><?php echo isset($item['max_order_chit'])?$item['max_order_chit']:"";?></em></div>
								<div class="t-right">
									<div class="name">代金券</div>
									<div class="subname">限指定课程使用</div>
								</div>
							</div>
							<div class="djq_btn">立即领取</div>
						</a>
				</li>
				<?php }?>
		</ul>
		<?php }?>
	</div>
</div>
<?php }?>

<div class="mui-content-padded">
	<h5><?php echo isset($name)?$name:"";?></h5>
	<div class="pro-price goodsprice" <?php if($seller_info['price_level'] == 0){?>style="display:none;"<?php }?>>
		<?php if($promo == ''){?>
		&yen;<i><?php echo isset($seller_info['price_level'])?$seller_info['price_level']:"";?></i>
		<?php }else{?>
		&yen;<?php if($minSellPrice != $maxSellPrice){?><?php echo isset($minSellPrice)?$minSellPrice:"";?> - <?php echo isset($maxSellPrice)?$maxSellPrice:"";?><?php }else{?><?php echo isset($sell_price)?$sell_price:"";?><?php }?>
		<?php }?>
		<?php if($promo == 'time'){?>
			<?php if(isset($promotion) && $promotion){?>
			<?php $item=Api::run('getPromotionRowById',array('#id#',$active_id))?>
			<?php $free_time = ITime::getDiffSec($item['end_time']);?>
			<div class="pro-discount">抢购价：<span>&yen;<?php echo isset($promotion['award_value'])?$promotion['award_value']:"";?></span></br> <p id="rtime" endtime="<?php echo isset($item['end_time'])?$item['end_time']:"";?>"><i>距离抢购结束还有</i><i class="discount-time"><?php echo floor($free_time/3600);?></i>时<i class="discount-time"><?php echo floor(($free_time%3600)/60);?></i>分<i class="discount-time"><?php echo $free_time%60;?></i>秒</p>
			<?php }?>
			<script type="text/javascript">var promo = 'time';getRTime();</script>
		<?php }?>
		<?php if($promo == 'groupon'){?>
			<?php if(isset($regiment) && $regiment){?>
			<?php $item=Api::run('getRegimentRowById',array('#id#',$active_id))?>
			<?php $free_time = ITime::getDiffSec($item['end_time']);?>
			<div class="pro-discount">团购价：<span>&yen;<?php echo isset($regiment['regiment_price'])?$regiment['regiment_price']:"";?></span></br> <p id="rtime" endtime="<?php echo isset($item['end_time'])?$item['end_time']:"";?>"><i>距离团购结束还有</i><i class="discount-time"><?php echo floor($free_time/3600);?></i>时<i class="discount-time"><?php echo floor(($free_time%3600)/60);?></i>分<i class="discount-time"><?php echo $free_time%60;?></i>秒</p>
			<?php }?>
			<script type="text/javascript">var promo = 'groupon';getRTime();</script>
		<?php }?>
	</div>
   <div class="tickett" style="display:none;">
     <p>本课程可用第三课代金券抵<span class="ticket_prop"></span>现金，享受折上折优惠！<a href="javascript:void(0);" class="receive">点我领券</a></p>
   </div>
</div>

<?php if($statement == 2 && $max_cprice >= $this->min_cprice && $max_order_chit > $this->min_order_chit && !$promo && !$active_id){?>
<div class="mui-content-padded">
	<div class="card clearfix" id="data_dprice" onclick="buy_now_ding('<?php echo isset($statement)?$statement:"";?>');">
		<span>优惠</span>
		<div class="cardbox">
			<p class="card-info-1">购券<em class="buy">￥<?php echo isset($max_cprice)?$max_cprice:"";?></em> 可抵扣<em class="chit">￥<?php echo isset($max_order_chit)?$max_order_chit:"";?></em></p>
		</div>
		<i class="icon-chevron-right"></i>
	</div>
</div>
<?php }?>

<div class="mui-content-padded">
		<?php if($seller_info['goods_list']){?>
			<ul class="spec_list clearfix" id="spec_list_mao">
				<li name="specCols">
					<?php foreach($seller_info['goods_list'] as $key => $item){?>
						<a href="javascript:void(0);" onclick="sele_goods(this);" _id=<?php echo isset($item['id'])?$item['id']:"";?>>
							<?php echo isset($item['name'])?$item['name']:"";?>
						</a>
					<?php }?>
				</li>
			</ul>
		<?php }?>

    <p class="spec_list_row">
      属性：<div class="specs"></div>
    </p>

		<p class="numberbox clearfix">
			<span>人数：</span>
			<a class="reduce" onclick="setAmount.reduce('#qty_item_1')" href="javascript:void(0)">
			-</a>
			<input type="text" name="qty_item_1" value="1" id="qty_item_1" onkeyup="setAmount.modify('#qty_item_1')" class="text">
			<a class="add" onclick="setAmount.add('#qty_item_1')" href="javascript:void(0)">
			+</a>
			人
		</p>
		<p class="selected_spec"><span></span></p>
</div>

<?php if($dqk_list){?>
<div class="mui-content-padded dqk">
	<div class="hd">
		<div class="t-left">短期课</div>
		<div class="t-right"><a href="<?php echo IUrl::creatUrl("/site/chit1");?>">更多</a></div>
	</div>
	<div class="bd">
		<ul>
			<?php foreach($dqk_list as $key => $item){?>
			<li>
				<a href="<?php echo IUrl::creatUrl("/site/create_brand_chit_zuhe/ids/".$item['id']."");?>">
					<div class="dqk_image"><img src="<?php if($item['logo'] != ''){?><?php echo IUrl::creatUrl("")."".$item['logo']."";?><?php }else{?>/views/mobile/skin/blue/images/dqk.png<?php }?>" /></div>
					<div class="dqk_info">
						<div class="dqk_goods_name"><?php echo isset($item['name'])?$item['name']:"";?>短期课<?php echo isset($item['use_times'])?$item['use_times']:"";?>节</div>
						<div class="dqk_price">&yen;<em><?php echo isset($item['max_price'])?$item['max_price']:"";?></em></div>
					</div>
				</a>
			</li>
			<?php }?>
		</ul>
	</div>
</div>
<?php }?>

<div class="mui-content-padded" style="padding: 10px 0;">


  <div class="desc_content">
    <div class="module">

      <div class="module_bd">

        <div class="shop_info">
          <div class="shop_info_list">
            <ul>
              <li class="times_list">上课时间：<br />
                <?php foreach($attrArr as $key => $item){?>
                <div><?php echo isset($item)?$item:"";?></div>
                <?php }?>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="module">
      <div class="module_hd module_hd2">
          课程介绍
      </div>
      <div class="module_bd module_bd2">
        <?php if($seller_info['brand_info']['class_desc_img']){?>
        <div class="class_desc_img">
          <?php foreach($seller_info['brand_info']['class_desc_img'] as $key => $item){?>
            <img src="<?php echo IUrl::creatUrl("")."".$item."";?>" />
          <?php }?>
        </div>
        <?php }?>
        <div class="class_list">
          <div class="class_list_hd">
            <img src="<?php echo $this->getWebSkinPath()."images/class_list_top_bg.png";?>" />
          </div>
          <div class="class_list_bd">
            <table cellspacing="0">
              <tr>
                <th width="30%">课程</th>
                <th>简介</th>
              </tr>
              <?php foreach($seller_info['goods_list'] as $key => $item){?>
              <tr>
                <td><?php echo isset($item['name'])?$item['name']:"";?></td>
                <td><?php echo isset($item['goods_brief'])?$item['goods_brief']:"";?></td>
              </tr>
              <?php }?>
            </table>
          </div>
        </div>
        <?php if($seller_info['brand_info']['shop_desc_img'][1]){?>
        <div class="shop_desc">
            <img src="<?php echo IUrl::creatUrl("")."".$seller_info['brand_info']['shop_desc_img'][1]."";?>" />
        </div>
        <?php }?>
        <div class="content">
          <?php echo isset($seller_info['content'])?$seller_info['content']:"";?>
        </div>
        <div class="class_list_desc">
          <div class="class_list_desc_hd">
            <img src="<?php echo $this->getWebSkinPath()."images/class_list_desc.jpg";?>" />
          </div>
          <?php if($seller_info['goods_list']){?>
            <?php $index = 1?>
            <?php foreach($seller_info['goods_list'] as $key => $item){?>
              <div class="class_list_desc_bd class_list_style_<?php echo isset($index)?$index:"";?>">
                <div class="class_title">
                  <?php echo isset($item['name'])?$item['name']:"";?><span><?php echo isset($item['class_target'])?$item['class_target']:"";?></span>
                </div>
                <div class="clear"></div>
                <?php if($item['content']){?>
                <div class="class_description">
                  <?php echo isset($item['content'])?$item['content']:"";?>
                </div>
                <?php }?>

                <?php if($item['class_details']){?>
                <div class="class_description_list">
                  <ul>
                    <?php foreach($item['class_details'] as $key => $it){?>
                    <?php $i++;?>
                    <?php $j = $i % 4;?>
                    <li class="<?php if($j == 1 || $j == 0){?>t1<?php }else{?>t2<?php }?>">
                        <div class="desc_image"><!-- <img src="<?php echo $this->getWebSkinPath()."images/class_description_$j.png";?>" /> --></div>
                        <div class="desc_str">
                          <?php echo isset($it)?$it:"";?>
                        </div>
                    </li>
                    <?php }?>
                  </ul>
                </div>
                <?php }?>
              </div>
              <?php if($index == 9){?>
                <?php $index = 1?>
              <?php }else{?>
                <?php $index++?>
              <?php }?>
            <?php }?>
          <?php }?>
        </div>
      </div>
    </div>

    <?php if($seller_info['teacher_list']){?>
    <div class="module">
      <div class="module_hd module_hd3">
        名师介绍
      </div>
      <div class="module_bd">
        <div class="teacher_list">
          <ul>
            <?php foreach($seller_info['teacher_list'] as $key => $item){?>
            <li>
              <div class="teacher_logo">
                <img src="<?php echo IUrl::creatUrl("")."".$item['icon']."";?>" onerror="javascript:this.src='/views/default/skin/default/images/avatar.jpg';" />
              </div>
              <div class="teacher_desc">
								<div style="font-size:16px;font-weight:600;"><?php echo isset($item['name'])?$item['name']:"";?></div>
                <p><?php echo isset($item['description'])?$item['description']:"";?></p>
              </div>
            </li>
            <?php }?>
          </ul>
        </div>
      </div>
    </div>
    <?php }?>

    <?php if($seller_info['album']){?>
    <div class="module">
      <div class="module_hd module_hd4">
        学校展示
      </div>
      <div class="module_bd">
        <div class="shop_image_list">
          <ul>
            <?php foreach($seller_info['album'] as $key => $item){?>
              <li><img src="<?php echo IUrl::creatUrl("")."".$item."";?>" /></li>
            <?php }?>
          </ul>
        </div>
      </div>
    </div>
    <?php }?>

	<div class="module">
    <div class="module_hd">
        商家位置
    </div>
  </div>
	<?php if($seller_info['address']){?>
	 <div class="shop_map">
	   <div id="container"></div>
	   </div>
	<?php }?>
	<div class="font">
	<li>地址：<?php echo join(' ',area::name($seller_info['province'],$seller_info['city'],$seller_info['area']));?> <?php echo isset($seller_info['address'])?$seller_info['address']:"";?></li>
  </div>
 </div>
</div>

<div class="pop_content">
	<div class="pop_contents">
        <div class="goods_info">
            <div class="goods_image">
                <img src="<?php echo IUrl::creatUrl("")."".$seller_info['photo'][0]."";?>" />
            </div>
            <div class="goods_price">
	            <i><?php echo isset($seller_info['price_level'])?$seller_info['price_level']:"";?></i><br />
                交易：<?php echo isset($seller_info['sale'])?$seller_info['sale']:"";?><br />
                评价：<?php echo isset($seller_info['comments'])?$seller_info['comments']:"";?><br />
            </div>
        </div>
        <div class="goods_list">
        	<div class="hd">课程类型:</div>
            <div class="bd">
                <?php foreach($seller_info['goods_list'] as $key => $item){?>
                    <a href="javascript:void(0);" onclick="sele_goods(this);" _id=<?php echo isset($item['id'])?$item['id']:"";?>>
                        <?php echo isset($item['name'])?$item['name']:"";?>
                    </a>
                <?php }?>
            </div>
        </div>
        <div class="spec_list">
        	<div class="hd">课程属性:</div>
            <div class="bd"><br  /></div>
        </div>
        <div class="input_num">
            <p class="numberbox clearfix">
                <span>人数：</span>
                <a class="reduce" onclick="setAmount.reduce('#qty_item_1')" href="javascript:void(0)">
                -</a>
                <input type="text" name="qty_item_2" value="1" id="qty_item_2" onkeyup="setAmount.modify('#qty_item_1')" class="text">
                <a class="add" onclick="setAmount.add('#qty_item_1')" href="javascript:void(0)">
                +</a>
                人
            </p>
        </div>
        <div class="pay_btn">
        	<input type="button" value="确定" onclick="save();" />
        </div>
    </div>
</div>

<!-- 弹窗 -->
<div class="quan" style="display:none;">
  <div class="quan_inner">
    <div class="card_left">
      <input type="hidden" class="prop" name="prop" <?php if($chit_list){?>id="<?php echo isset($seller_info['id'])?$seller_info['id']:"";?>"<?php }?> />
      <p class="tochit"><span><?php echo isset($ticket['prop'])?$ticket['prop']:"";?></span></p>
    </div>
    <div class="card_right">
      <p class="totip"><em>专用券</em><span class="tobuy"><span><?php echo isset($ticket['prop'])?$ticket['prop']:"";?></span>元抢券</span></p>
			<p class="limittime"><span>此代金券仅限该课程使用</span></p>
      <a class="buycard" onclick="buy_now_ding_card('90', '25')">点击购买</a>
    </div>
  </div>
</div>

<script type='text/html' id='spec_list_template'>
	<a href="javascript:void(0);" onclick="sele_spec(this)" _spec="<%=id%>">
		<%if(cusval != ''){%><%=cusval%><%}%> <%if(classnum){%><%=classnum%>课时<%}%> <%if(month){%><%=month%>个月<%}%>
	</a>
</script>

<?php if($seller_info['address']){?>
<script type="text/javascript">
var _shop_address = "<?php echo join('',area::name($seller_info['province'],$seller_info['city'],$seller_info['area']));?><?php echo isset($seller_info['address'])?$seller_info['address']:"";?>";
</script>
<script src="http://webapi.amap.com/maps?v=1.3&key=2cd83299402829a3177894489a4cf556" type="text/javascript"></script>
<script type='text/javascript' src="/views/default/javascript/school_show_map.js"></script>
<?php }?>
<script type='text/javascript' src="<?php echo $this->getWebViewPath()."javascript/home.js";?>"></script>

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
