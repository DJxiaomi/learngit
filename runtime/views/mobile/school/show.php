<!doctype html>

<html>

<head>

	<meta http-equiv="X-UA-Compatible" content="IE=Edge">

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<meta name="viewport" content="target-densitydpi=device-dpi, width=device-width, initial-scale=1, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

	<title><?php echo $siteConfig->name;?></title>

	<link type="image/x-icon" href="favicon.ico" rel="icon">

	<link href="<?php echo IUrl::creatUrl("")."resource/css/font-awesome.min.css";?>" rel="stylesheet" type="text/css" />

	<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.min.css";?>" rel="stylesheet" type="text/css" />

	<link href="<?php echo $this->getWebSkinPath()."css/common.css";?>" rel="stylesheet" type="text/css" />

	<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."resource/scripts/jquery-3.1.1.min.js";?>"></script>

	<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.min.js";?>"></script>

	<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."resource/scripts/common.js";?>"></script>

	<link href="<?php echo $this->getWebSkinPath()."school/css/bootstrap.min.css";?>" rel="stylesheet" type="text/css">

	<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."school/css/lightbox.css";?>" type="text/css" media="all" />

	<link href="<?php echo $this->getWebSkinPath()."school/css/style.css";?>" rel="stylesheet" type="text/css"/>

	<script src="<?php echo $this->getWebSkinPath()."school/js/bootstrap.js";?>"></script>

	<script type="text/javascript" src="<?php echo $this->getWebSkinPath()."school/js/easing.js";?>"></script>

	<script type="text/javascript" src="<?php echo $this->getWebSkinPath()."school/js/TouchSlide.1.1.js";?>"></script>

	<script type="text/javascript">mui.init();var SITE_URL = 'http://<?php echo get_host();?><?php echo IUrl::creatUrl("");?>';</script>

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

	<link href="<?php echo $this->getWebSkinPath()."school/css/bootstrap.min.css";?>" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."school/css/lightbox.css";?>" type="text/css" media="all" />
<link href="<?php echo $this->getWebSkinPath()."school/css/style.css";?>" rel="stylesheet" type="text/css"/>
<script src="<?php echo $this->getWebSkinPath()."school/js/bootstrap.js";?>"></script>
<script type="text/javascript" src="<?php echo $this->getWebSkinPath()."school/js/easing.js";?>"></script>
<script type="text/javascript" src="<?php echo $this->getWebSkinPath()."school/js/responsiveslides.min.js";?>"></script>
<script type="text/javascript" src="<?php echo $this->getWebSkinPath()."school/js/TouchSlide.1.1.js";?>"></script>
<div class="header" id="home">
	<div class="container">
		<div class="navigation">
				<span class="menu"><img src="<?php echo $this->getWebSkinPath()."school/images/menu.png";?>" alt=""/></span>
				<div class="clearfix"> </div>
				<a href="/index.php" class="index_logo">
					<img src="/views/default/skin/default/school/images/logo.png" alt="" title="" style="">
				</a>
				<ul class="nav1">
					<li><a href=" ">专题首页</a></li>
					<li><a class="" href="#school_desc">专题介绍</a></li>
					<?php if($brand_attr_list){?>
						<?php foreach($brand_attr_list as $kk => $item){?>
							<li><a class="" href="#module_<?php echo isset($kk)?$kk:"";?>"><?php echo isset($item['navtitle'])?$item['navtitle']:"";?></a></li>
						<?php }?>
					<?php }?>
					<?php if($goods_list){?><li><a class="" href="#school_classes">专题活动</a></li><?php }?>
					<?php if($teacher_list){?><li><a class="" href="#school_teachers">教师资质</a></li><?php }?>
					<li><a class="" href="#contact_us">联系我们</a></li>
				</ul>
		</div>
		<div class="clearfix"> </div>
	</div>
</div>
<div class="header-banner">
	<!-- Top Navigation -->
		<div class="slider">
				   <div class="callbacks_container" id="slideCell">
						 <div class="hd">
             	<ul>
								<?php if(!$ad_list){?>
								<li></li>
								<li></li>
								<li></li>
								<li></li>
								<?php }else{?>
								<?php foreach($ad_list as $key => $item){?>
								<li></li>
								<?php }?>
								<?php }?>
							</ul>
						</div>
            <div class="bd">
            <ul>
							<?php if(!$ad_list){?>
	            <li>
	            	<div class="pic"><img src="/views/default/skin/default/school/images/slide_1.jpg" /></div>
	            </li>
	            <li>
	            	<div class="pic"><img src="/views/default/skin/default/school/images/slide_2.jpg" /></div>
	            </li>
	            <li>
	            	<div class="pic"><img src="/views/default/skin/default/school/images/slide_3.jpg" /></div>
	            </li>
	            <li>
	            	<div class="pic"><img src="/views/default/skin/default/school/images/slide_4.jpg" /></div>
	            </li>
							<?php }else{?>
							<?php foreach($ad_list as $key => $item){?>
							<li>
	            	<div class="pic"><img src="<?php echo IUrl::creatUrl("")."".$item['content']."";?>" /></div>
	            </li>
							<?php }?>
							<?php }?>
            </ul>
          </div>
				</div>
		</div>
		<script type="text/javascript">
					TouchSlide({slideCell:"#slideCell",mainCell:".bd ul",titCell:".hd li",effect:"leftLoop",autoPlay:true, delayTime:500,titOnClassName:'on'});
		</script>
</div>
<?php if($seller_chits){?>
<?php foreach($seller_chits as $key => $chit){?>
<div class="card-list-box">
    <ul class="mui-table-view">
        <li class="mui-table-view-cell mui-media">
            <div class="mui-media-object mui-pull-left" id="<?php echo isset($chit['id'])?$chit['id']:"";?>">
                <p class="tochit"><em>￥</em><?php echo isset($chit['max_order_chit'])?$chit['max_order_chit']:"";?></p>
                <p class="tobuy">购券<?php echo isset($chit['max_price'])?$chit['max_price']:"";?>可抵扣</p>
            </div>
            <div class="mui-media-body">
                <p><em class="totip">通用券</em><?php if($chit['type'] == 2){?><em class="totip totip-1">免费赠送</em><?php }?><span class="mui-seller"><?php echo isset($this->seller['true_name'])?$this->seller['true_name']:"";?></span></p>
                <p class="tospec">
                    <?php if($chit['limittime']){?>有效期至 <?php echo date('Y-m-d', $chit['limittime']);?><?php }else{?>无限制时间<?php }?>
                </p>
                <p class="tospec">
                	<?php if($chit['limitinfo']){?>
                	<?php echo isset($chit['limitinfo'])?$chit['limitinfo']:"";?>
                	<?php }else{?>
                    <?php if($chit['limitnum']){?>每人限购<?php echo isset($chit['limitnum'])?$chit['limitnum']:"";?>张<?php }else{?>无限制数量<?php }?>
                	<?php }?>
                </p>
                <a class="buycard" onclick="buy_now_ding_card('<?php echo isset($chit['id'])?$chit['id']:"";?>', '<?php echo isset($chit['max_price'])?$chit['max_price']:"";?>')"><?php if($chit['type'] == 2){?>点击领券<?php }else{?>点击购买<?php }?></a>
            </div>
        </li>
    </ul>
</div>
<?php }?>
<?php }?>
<script type="text/javascript">
function imageResize(obj, width, height){
	width = width == '' ? $(obj).parent().width(): width;
	var heights = [];
	$('.imgbrand').each(function(){
		heights.push($(this).height());
	});
	var minHeight = Math.min.apply(null, heights);
	height = height == '' ? minHeight : height;
	$('.imgbrand').css('height', height);
    var hRatio;
    var wRatio;
    var Ratio = 1;
    var w = $(obj).width();
    var h = $(obj).height();
    var t = width / height;
    wRatio = width / w;
    hRatio = height / h;
    if (width ==0 && height==0){
        Ratio = 1;
    }else if (width==0){
        if (hRatio<1) Ratio = hRatio;
    }else if (height==0){
        if (wRatio<1) Ratio = wRatio;
    }else if (wRatio<1 || hRatio<1){
        Ratio = (wRatio<=hRatio?wRatio:hRatio);
    }
    if (Ratio<1){
        w = w * Ratio;
        h = h * Ratio;
    }
    if(h < height && w < width){
        $(obj).height(Math.round(w));
        $(obj).width(Math.round(h));
        $(obj).css('margin-left', Math.round((width - $(obj).width()) / 2));
        $(obj).css('margin-top', Math.round((height - $(obj).height()) / 2));
    }
    if(h < height){
        if($(obj).width() >= width){
            $(obj).height(Math.round(height));
            $(obj).css('margin-left', Math.round((width - $(obj).width()) / 2));
        }
    }
    if(w < width){
        if($(obj).height() >= height){
            $(obj).width(Math.round(width));
            $(obj).css('margin-top', Math.round((height - $(obj).height()) / 2));
        }
    }
    if(h >= height && w >= width){
        $(obj).height(Math.round(h));
        $(obj).width(Math.round(w));
        $(obj).css('margin-left', Math.round((width - $(obj).width()) / 2));
        $(obj).css('margin-top', Math.round((height - $(obj).height()) / 2));
    }
}
</script>
<a name="school_desc"></a>
		<div class="container">
				<style type="text/css">
				.imgbrand{ margin-bottom: 20px;overflow: hidden;}
				.brief{ color: #999; line-height: 24px;padding: 0 5px; }
				</style>
				<!-- <div class="about-bottom"> -->
					<!-- <div class="about-left"> -->
						<!-- <h4><?php echo isset($this->seller['true_name'])?$this->seller['true_name']:"";?></h4> -->
						<!-- <div class="brief"><?php echo isset($seller_info['content'])?$seller_info['content']:"";?></div> -->
					<!-- </div> -->
					<!-- <div class="clearfix"> </div> -->
				<!-- </div> -->
				<?php if($seller_info['brandimg']){?>
				<?php foreach($seller_info['brandimg'] as $key => $item){?>
				<div class="imgbrand"><img width="100%" src="/<?php echo isset($item['imgurl'])?$item['imgurl']:"";?>" /></div>
				<?php }?>
				<?php }?>
		</div>
<?php if($brand_attr_list){?>
	<?php foreach($brand_attr_list as $key => $item){?>
		<a name="module_<?php echo isset($key)?$key:"";?>"></a>
		<div class="classList">
			<div class="containe">
				<span class="biaoti"><?php echo isset($item['navtitle'])?$item['navtitle']:"";?></span>
					<?php foreach($item['img'] as $kk => $val){?>
					<?php  $count = sizeof( $val );?>
					<?php
						if ( $count == 3)
							$width = 342;
						else if ( $count == 2 )
							$width = 513;
						else
							$width = 377;
					?>
						<ul class="classBo clearfix">
								<?php foreach($val as $k => $vv){?>
								<li class="classCon0<?php echo isset($count)?$count:"";?> clearfix">
									<a href="javascript:;" class="classList-img"><img src="<?php echo IUrl::creatUrl("/pic/thumb/img/".$vv."/w/".$width."/h/".$width."");?>" alt="<?php echo isset($val['name'])?$val['name']:"";?>" class=""></a>
									<div class="classDe clearfix">
										<h4><?php echo isset($item['imgtitle'][$kk][$k])?$item['imgtitle'][$kk][$k]:"";?></h4>
										<p class="f12 c9"><?php echo isset($item['imgbrief'][$kk][$k])?$item['imgbrief'][$kk][$k]:"";?></p>
									</div>
								</li>
								<?php }?>
							</ul>
					<?php }?>
			</div>
		</div>
	<?php }?>
<?php }?>
<?php if($goods_list){?>
<a name="school_classes"></a>
<div class="classList">
	<div class="containe">
		<span class="biaoti">课程介绍</span>
			<?php foreach($goods_list as $key => $item){?>
			<?php  $count = sizeof( $item );?>
			<?php
				if ( $count == 3)
					$width = 342;
				else if ( $count == 2 )
					$width = 513;
				else
					$width = 377;
			?>
				<ul class="classBox clearfix">
						<?php foreach($item as $key => $val){?>
						<li class="classCon0<?php echo isset($count)?$count:"";?> clearfix">
							<a href="<?php echo IUrl::creatUrl("/site/products/id/".$val['id']."");?>" class="classList-img"><img src="<?php echo IUrl::creatUrl("/pic/thumb/img/".$val['img']."/w/".$width."/h/".$width."");?>"></a>
							<div class="classDet clearfix">
								<h4><?php echo isset($val['name'])?$val['name']:"";?></h4>
								<p class="f12 c9"><?php echo strip_tags($val['content']);?></p>
								<h2 class="jiage">价格：<span class="jiage"><?php if($val['minprice'] != $val['maxprice']){?><?php echo isset($val['minprice'])?$val['minprice']:"";?>元 - <?php echo isset($val['maxprice'])?$val['maxprice']:"";?>元<?php }else{?><?php echo isset($val['sell_price'])?$val['sell_price']:"";?>元<?php }?></span></h2>
								<a href="javascript:;" class="btn-green" title="<?php echo isset($val['name'])?$val['name']:"";?>" onclick="buy_now('<?php echo isset($val['id'])?$val['id']:"";?>', '<?php echo isset($val['minprice'])?$val['minprice']:"";?>', '<?php echo isset($val['maxprice'])?$val['maxprice']:"";?>')">立即购买</a>
							</div>
						</li>
						<?php }?>
					</ul>
			<?php }?>
	</div>
</div>
<input type="hidden" name="product_id" id="product_id" />
<div class="product-bg"></div>
<div class="product-box">
	<div class="box" id="attrbox">
	</div>
	<a class="gobuy" href="javascript:;">确认提交</a>
</div>
<script type="text/javascript">
function buy_now(id, minprice, maxprice){
	if(minprice != maxprice){
		mui.getJSON('<?php echo IUrl::creatUrl("/school/product/goods_id");?>/' + id + '/id/<?php echo $this->seller_id;?>', {}, function(json){
			var products = json.products;
			var html = '<div class="thumb"><img src="<?php echo IUrl::creatUrl("")."' + json.img + '";?>" width="60" height="60" /></div>';
			html += '<div class="info" id="market_price">' + json.minprice + ' - ' + json.maxprice + '元</div>';
			html += '<h5>课程属性</h5>';
			html += '<div class="attrbox">';
			for(var i in products){
				var spec = '';
				if(products[i].cusval){
					spec += products[i].cusval;
					if(products[i].classnum){
						spec += '/';
					}
				}
				if(products[i].classnum){
					spec += products[i].classnum + '课时';
					if(products[i].month){
						spec += '/';
					}
				}
				if(products[i].month){
					spec += products[i].month + '个月';
				}
				html += '<a href="javascript:;" class="childer" data-id="' + products[i].id + '">' + spec + '</a>';
			}
			html += '</div>';
			$('#attrbox').html(html);
			$('.childer').each(function(){
				$(this).click(function(){
					$(this).siblings().removeClass('active');
					$(this).addClass('active');
					var productid = $(this).attr('data-id');
					mui.getJSON('<?php echo IUrl::creatUrl("/school/getproduct/goods_id");?>/' + id + '/id/<?php echo $this->seller_id;?>/productid/' + productid, {}, function(json){
						$('#product_id').val(productid);
						$('#market_price').html(json.market_price + '元');
					});
				});
			});
		});
		$('.product-bg').show();
		$('.product-box').animate({bottom: 0}, 300);
		mui(document.body).on('tap', '.product-bg', function(){
			$('.product-box').animate({bottom: '-100%'}, 300);
			$('.product-bg').hide();
		});
		mui(document.body).on('tap', '.product-close', function(){
			$('.product-box').animate({bottom: '-100%'}, 300);
			$('.product-bg').hide();
		});
		mui(document.body).on('tap', '.gobuy', function(){
			if($('#product_id').val() == ''){
				mui.toast('请选择属性');
				return false;
			}
			var buyNums  = 1;
			var type = 'goods';
			if($('#product_id').val())
			{
				id = $('#product_id').val();
				type = 'product';
			}
			var url = SITE_URL + '<?php echo IUrl::creatUrl("/simple/cart2/id/@id@/num/@buyNums@/type/@type@");?>';
			url = url.replace('@id@',id).replace('@buyNums@',buyNums).replace('@type@',type);
			//页面跳转
			window.location.href = url;
		});
	}else{
		var buyNums  = 1;
		var type = 'goods';
		if($('#product_id').val())
		{
			id = $('#product_id').val();
			type = 'product';
		}
		var url = SITE_URL + '<?php echo IUrl::creatUrl("/simple/cart2/id/@id@/num/@buyNums@/type/@type@");?>';
		url = url.replace('@id@',id).replace('@buyNums@',buyNums).replace('@type@',type);
		//页面跳转
		window.location.href = url;
	}
}
</script>
<?php }?>
<?php if($teacher_list){?>
<a name="school_teachers"></a>
<div class="classList">
	<div class="containe">
		<span class="biaoti">教师团队</span>
			<?php foreach($teacher_list as $key => $item){?>
			<?php  $count = sizeof( $item );?>
			<?php
				if ( $count == 3)
					$width = 342;
				else if ( $count == 2 )
					$width = 513;
				else
					$width = 377;
			?>
			<ul class="classBox clearfix">
				<?php foreach($item as $key => $val){?>
				<li class="classon0<?php echo isset($count)?$count:"";?><?php if($count == 1){?> clearfix<?php }?>">
					<a href="javascript:void(0);" class="classimg"><img src="<?php echo IUrl::creatUrl("/pic/thumb/img/".$val['icon']."/w/".$width."/h/".$width."");?>" alt=" " class="classimg"></a>
					<div class="classDt clearfix">
						<h4><?php echo isset($val['name'])?$val['name']:"";?></h4>
						<p class="f12 c9"><?php echo  strip_tags($val['description']);?></p>
						<?php if($val['graduate'] != ''){?>
							<p class="f12 c6"><b>毕业于：</b><?php echo isset($val['graduate'])?$val['graduate']:"";?></p>
						<?php }?>
						<?php if($val['teaching_direction'] != ''){?>
							<p class="f12 c6"><b>授课方向：</b><?php echo isset($val['teaching_direction'])?$val['teaching_direction']:"";?></p>
						<?php }?>
					</div>
				</li>
				<?php }?>
			</ul>
			<?php }?>
	</div>
</div>
<?php }?>
<a name="contact_us"></a>
	     <li class="footers">
						<a href="tel:4001155477"><img src="/upload/pic/tel.jpg"></a>

					  <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=2821518520&site=qq&menu=yes"><img src="/upload/pic/qq.jpg"></a>
		</li>
				 <div class="clearfix"></div>
<script type="text/javascript">
mui('body').on('tap', '.mui-pull-left', function(){
    window.location.href = SITE_URL + 'site/chit_show/id/' + this.id;
});
mui('body').on('tap', '.mui-seller', function(){
    window.location.href = SITE_URL + 'school/show/id/' + this.id;
});
function buy_now_ding_card(id, _input_dprice){
	var buyNums  = 1;
	//var type = 'chit';
	var url = '<?php echo IUrl::creatUrl("/simple/cart2/id/5280/num/@buyNums@/type/product/statement/2/ischit/1/chitid/@chitid@");?>';
		url = url.replace('@chitid@',id).replace('@buyNums@',buyNums);
	var _input_stime = 1;
	url += '/stime/' + _input_stime;
	url += '/dprice/' + _input_dprice;
	window.location.href = 'http://www.lelele999.com' + url;
}
</script>
<?php if($this->seller['address']){?>
<script src="http://webapi.amap.com/maps?v=1.3&key=2cd83299402829a3177894489a4cf556" type="text/javascript"></script>
<script type="text/javascript">
var map = new AMap.Map('container', {
  	resizeEnable: true,
    resizeEnable: true,
    center: [116.397428, 39.90923],
    zoom: 13,
    keyboardEnable: false
});
function geocoder() {
	AMap.service('AMap.Geocoder',function(){
	    var geocoder = new AMap.Geocoder();
	    geocoder.getLocation("<?php echo join('',area::name($this->seller['province'],$this->seller['city'],$this->seller['area']));?><?php echo isset($this->seller['address'])?$this->seller['address']:"";?>", function(status, result) {
	        if (status === 'complete' && result.info === 'OK') {
	            geocoder_CallBack(result);
	        }
	    });
	});
}
function addMarker(i, d) {
    var marker = new AMap.Marker({
        map: map,
        position: [ d.location.getLng(),  d.location.getLat()]
    });
    var infoWindow = new AMap.InfoWindow({
        content: d.formattedAddress,
        offset: {x: 0, y: -30}
    });
    marker.on("mouseover", function(e) {
        infoWindow.open(map, marker.getPosition());
    });
}
function geocoder_CallBack(data) {
    var geocode = data.geocodes;
    for (var i = 0; i < geocode.length; i++) {
        addMarker(i, geocode[i]);
    }
    map.setFitView();
}
geocoder();
</script>
<?php }?>

	</div>

	<nav class="mui-bar mui-bar-tab">
	    <a class="mui-tab-item home <?php if($this->getId() == 'site' && ($_GET['action'] == 'index' || $_GET['action'] == '')){?>mui-hot-home<?php }?>" href="http://<?php echo get_host();?><?php echo IUrl::creatUrl("");?>">
	        <span class="mui-tab-label">首页</span>
	    </a>
	    <a class="mui-tab-item gift <?php if($this->getId() == 'site' && $_GET['action'] == 'activity_discount'){?>mui-hot-gift<?php }?>" href="<?php echo IUrl::creatUrl("/school/home/id/365");?>" id="ztelBtn">
	        <span class="mui-tab-label">免费</span>
	    </a>
	    <a class="mui-tab-item money <?php if($this->getId() == 'site' && $_GET['action'] == 'activity_props'){?>mui-hot-money<?php }?>" href="<?php echo IUrl::creatUrl("/school/home/id/366");?>">
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
