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
<link rel="stylesheet" href="<?php echo IUrl::creatUrl("")."resource/scripts/swiper/swiper.min.css";?>">
<link rel="stylesheet" href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.picker.min.css";?>">
<script type='text/javascript' src="<?php echo IUrl::creatUrl("")."resource/scripts/swiper/swiper.min.js";?>"></script>
<script type='text/javascript' src="<?php echo $this->getWebViewPath()."javascript/payfor.js";?>"></script>
<script type='text/javascript' src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.picker.min.js";?>"></script>
<div class="pro-header goodstab">
	<input type='hidden' id='product_id' alt='课程ID' value='' />
	<a href="javascript:;" class="current">课程</a>
	<a href="#shop-pingjia">评价</a>
	<a href="#shop-talk">咨询</a>
	<a href="#shop-speak">讨论</a>
</div>
<div class="shop-nav-bot<?php if($seller['is_authentication'] == 1){?><?php if($discount <= 0){?> cxd-2<?php }?><?php }else{?> cxd-2<?php }?>">
		<?php if($seller['is_authentication'] == 1){?>
			<?php if(!$is_purchase){?>
				<a href="javascript:;" class="shopbtn">课程未上架</a>
			<?php }else{?>
				
				<a href="javascript: void(0);" onclick="buy_now();" class="buy-btn" id="buyNowButton">立即购买</a>
			<?php }?>
		<?php }else{?>
		<a href="javascript:;" class="shopbtn">学校未认证</a>
		<?php }?>
</div>
<div class="swiper-container">
	<div class="swiper-wrapper">
		<div class="swiper-slide">
			<img width="100%" src="<?php echo IUrl::creatUrl("")."".$img."";?>" />
		</div>
		<?php if($photo){?>
		<?php foreach($photo as $key => $item){?>
		<div class="swiper-slide">
			<img width="100%" src="<?php echo IUrl::creatUrl("")."".$item['img']."";?>" />
		</div>
		<?php }?>
		<?php }?>
	</div>
	<div class="swiper-pagination"></div>
</div>
<div class="mui-content-padded">
	<h5><?php echo isset($name)?$name:"";?></h5>
	<div class="pro-price goodsprice">
		<?php if($promo == ''){?>
		&yen;<?php if($productnum > 1){?><i><?php echo isset($t_market_price)?$t_market_price:"";?></i><?php }else{?><i><?php echo isset($market_price)?$market_price:"";?></i><?php }?>
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
</div>

<div class="mui-content-padded"  style="display:none;">
	<?php if($store_nums <= 0){?>
	<h5>该课程已结束</h5>
	<?php }else{?>
		<?php if($goods_spec_array['name']){?>
			<ul class="spec_list clearfix" id="spec_list_mao">
				<li name="specCols">
					<?php foreach($goods_spec_array['value'] as $key => $spec_value){?>
						<a href="javascript:void(0);" onclick="sele_spec(this);" value='{"id":"<?php echo isset($spec_value['id'])?$spec_value['id']:"";?>","value":"<?php echo isset($spec_value['cusval'])?$spec_value['cusval']:"";?>","classnum":"<?php echo isset($spec_value['classnum'])?$spec_value['classnum']:"";?>","month":"<?php echo isset($spec_value['month'])?$spec_value['month']:"";?>","name":"<?php echo isset($goods_spec_array['name'])?$goods_spec_array['name']:"";?>"}'>
							<?php if($spec_value['cusval']){?>
								<?php echo isset($spec_value['cusval'])?$spec_value['cusval']:"";?><?php if($spec_value['classnum'] || $spec_value['month']){?>/<?php }?>
							<?php }?>
							<?php if($spec_value['classnum']){?>
								<?php echo isset($spec_value['classnum'])?$spec_value['classnum']:"";?>课时<?php if($spec_value['month']){?>/<?php }?>
							<?php }?>
							<?php if($spec_value['month']){?><?php echo isset($spec_value['month'])?$spec_value['month']:"";?>个月<?php }?>
						</a>
					<?php }?>
				</li>
			</ul>
		<?php }?>
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
	<?php }?>
</div>
<ul class="mui-table-view mui-table-view-chevron">
	<li class="mui-table-view-cell mui-media">
		<a href="<?php echo IUrl::creatUrl("/school/show/id/".$seller['id']."");?>" class="mui-navigate-right">
			<img class="mui-media-object mui-pull-left" src="<?php echo IUrl::creatUrl("")."".$seller['logo']."";?>">
			<div class="mui-media-body">
				<?php echo isset($seller['shortname'])?$seller['shortname']:"";?>
				<p class="mui-ellipsis"><?php echo isset($seller['location'][$seller['province']])?$seller['location'][$seller['province']]:"";?><?php echo isset($seller['location'][$seller['city']])?$seller['location'][$seller['city']]:"";?><?php echo isset($seller['location'][$seller['area']])?$seller['location'][$seller['area']]:"";?><?php echo isset($seller['address'])?$seller['address']:"";?></p>
			</div>
		</a>
	</li>
</ul>
<div class="mui-content-padded">
	<div class="content">
		<dl class="clearfix">
			<dt>课程：</dt>
			<dd><?php echo isset($name)?$name:"";?></dd>
		</dl>
		<?php if($category){?>
		<dl class="clearfix">
			<dt>课程分类：</dt>
			<dd><?php echo isset($catname)?$catname:"";?></dd>
		</dl>
		<?php }?>
		<?php if($teacher_info){?>
		<dl class="clearfix">
			<dt>授课导师：</dt>
			<dd><?php echo isset($teacher_info['name'])?$teacher_info['name']:"";?></dd>
		</dl>
		<?php }?>
		<dl class="clearfix">
			<dt>联系电话：</dt>
			<dd><?php echo isset($seller['phone'])?$seller['phone']:"";?></dd>
		</dl>

		<p><?php echo isset($content)?$content:"";?></p>
	</div>
</div>
<div class="mui-content-padded" id="shop-pingjia">
	<h5>评价（<?php echo isset($comments)?$comments:"";?>）</h5>
	<ul>
	 	<?php foreach(Comment_Class::getCommentsList($id) as $key => $item){?>
	  	<li class="pingjia-list clearfix">
			<i class="clearfix"><?php echo isset($item['username'])?$item['username']:"";?></i>
			<div class="pingjia-left">
					<p class=""><?php echo isset($item['contents'])?$item['contents']:"";?></p>
			</div>
			<span class="pl-time"><?php echo isset($item['time'])?$item['time']:"";?></span>
		</li>
		<?php }?>
 	</ul>
</div>
<div class="mui-content-padded" id="shop-talk">
	<h5><a href="<?php echo IUrl::creatUrl("/site/consult/id/".$id."");?>" class="pingjia">咨询</a></h5>
	<?php if($referlist){?>
	<ul>
	 	<?php foreach($referlist as $key => $item){?>
	  	<li class="pingjia-list clearfix">
			<i class="clearfix"><?php echo Member_class::get_user_name_by_uid($item['user_id']);?></i>
			<div class="pingjia-left">
					<p class=""><?php echo isset($item['question'])?$item['question']:"";?></p>
			</div>
			<span class="pl-time"><?php echo isset($item['time'])?$item['time']:"";?></span>
		</li>
		<?php }?>
 	</ul>
	<?php }?>
</div>
<div class="mui-content-padded mui-content-padded-last-child" id="shop-speak">
	<h5><a href="<?php echo IUrl::creatUrl("/site/article_discussion/id/".$id."");?>" class="pingjia">讨论</a></h5>
	<?php if($discussionlist){?>
	<ul>
	 	<?php foreach($discussionlist as $key => $item){?>
	  	<li class="pingjia-list clearfix">
			<i class="clearfix"><?php echo Member_class::get_user_name_by_uid($item['user_id']);?></i>
			<div class="pingjia-left">
					<p class=""><?php echo isset($item['content'])?$item['content']:"";?></p>
			</div>
			<span class="pl-time"><?php echo date('Y-m-d H:i:s', $item['add_time']);?></span>
		</li>
		<?php }?>
 	</ul>
	<?php }?>
</div>
<div class="card-list-bg"></div>
<div class="card-list-box">
	<div class="box"><h5>购券 <a href="javascript:;" class="card-list-close close">关闭</a></h5></div>
	<div class="mui-inner-wrap">
		<div id="chitscroll" class="mui-content mui-scroll-wrapper">
			<div class="mui-scroll">
				<ul class="mui-table-view">
					<?php if($goods_spec_array['name']){?>
					<?php foreach($goods_spec_array['value'] as $key => $spec_value){?>
					<li class="mui-table-view-cell mui-media">
						<div class="mui-media-object mui-pull-left">
							<p class="tochit"><em>￥</em><?php echo isset($spec_value['max_order_chit'])?$spec_value['max_order_chit']:"";?></p>
							<p class="tobuy">购券<?php echo isset($spec_value['max_cprice'])?$spec_value['max_cprice']:"";?>可抵扣</p>
						</div>
						<div class="mui-media-body">
							<p><em class="totip">乐享学习券</em><?php echo isset($name)?$name:"";?></p>
							<p class="tospec" id="spec<?php echo isset($spec_value['id'])?$spec_value['id']:"";?>">
								<?php if($spec_value['cusval']){?>
									<?php echo isset($spec_value['cusval'])?$spec_value['cusval']:"";?><?php if($spec_value['classnum'] || $spec_value['month']){?>/<?php }?>
								<?php }?>
								<?php if($spec_value['classnum']){?>
									<?php echo isset($spec_value['classnum'])?$spec_value['classnum']:"";?>课时<?php if($spec_value['month']){?>/<?php }?>
								<?php }?>
								<?php if($spec_value['month']){?><?php echo isset($spec_value['month'])?$spec_value['month']:"";?>个月<?php }?>
							</p>
							<a class="buycard" onclick="buy_now_ding_card('<?php echo isset($spec_value['max_cprice'])?$spec_value['max_cprice']:"";?>')">点击购买</a>
						</div>
					</li>
					<?php }?>
					<?php }else{?>
					<li class="mui-table-view-cell mui-media">
						<div class="mui-media-object mui-pull-left">
							<p class="tochit"><em>￥</em>10140</p>
							<p class="tobuy">购券200可抵扣</p>
						</div>
						<div class="mui-media-body">
							<p><em class="totip">乐享学习券</em><?php echo isset($name)?$name:"";?></p>
							<p class="tospec">48课时</p>
							<a class="buycard">点击购买</a>
						</div>
					</li>
					<?php }?>
				</ul>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
var swiper = new Swiper('.swiper-container', {
    loop : true,
    autoHeight: true
});

var _store_nums = <?php echo isset($store_nums)?$store_nums:"";?>;
var _spec_url = '<?php echo IUrl::creatUrl("/site/getProduct");?>';
var _join_url = '<?php echo IUrl::creatUrl("/simple/joinCart");?>';
var _show_cart_url = '<?php echo IUrl::creatUrl("/simple/showCart");?>';
var _goods_id = <?php echo isset($id)?$id:"";?>;
var _promo = '<?php echo isset($promo)?$promo:"";?>';

var _market_price = <?php echo isset($market_price)?$market_price:"";?>;
<?php if($statement == 2){?>
var _parchse_html = '';
var _dprice = <?php echo isset($dprice)?$dprice:"";?>;
var _sell_price = <?php echo isset($sell_price)?$sell_price:"";?>;
var _min_dprice = 10;
var _max_cprice = <?php echo isset($max_cprice)?$max_cprice:"";?>;
var _max_order_chit = <?php echo isset($max_order_chit)?$max_order_chit:"";?>;
<?php }?>
</script>



<script type="text/javascript">

<?php if($statement == 2){?>
// 异步更新提示
function update_parchse()
{
	if (check_parchse_param())
	{
		var _input_dprice = $('.input_dprice').val();
		var _input_stime = $('.input_stime').val();
		var _url = '<?php echo IUrl::creatUrl("/site/get_dprice_info_ajax/dprice/@dprice@/stime/@stime@/sell_price/@sell_price@");?>';
		_url = _url.replace('@dprice@', _input_dprice);
		_url = _url.replace('@stime@', _input_stime);
		_url = _url.replace('@sell_price@', _sell_price);
		$.getJSON(_url, function(data){
			if ( data.done )
			{
				$('.purchase .notice .price_1').html(data.retval.dprice);
				$('.purchase .notice .price_2').html(data.retval.chit);
				$('.purchase .notice .price_3').html(data.retval.rest_price);
				$('.purchase .notice').show();
			} else {
				mui.alert('最多可购买' + data.msg + '元', '提示信息');
				return;
			}
		})
	}
}

function check_parchse_param(_input_dprice, _input_stime){
	if ( _input_dprice < _min_dprice )
	{
		mui.alert('券最小面值为' + _min_dprice + '元', '提示信息');
		$('.input_dprice').val(_max_cprice);
		return false;
	}	else if ( _input_dprice > _max_cprice )	{
		mui.alert('最多可购券' + _max_cprice + '元', '提示信息');
		$('.input_dprice').val(_max_cprice);
		return false;
	}	else if ( _input_dprice % 10 != 0 )	{
		mui.alert('券值必须为10的倍数!', '提示信息');
		$('.input_dprice').val(_max_cprice);
		$('.input_dprice').focus();
		return false;
	}	else if ( _input_stime == '0')	{
			mui.alert('请选择上课时间', '提示信息');
			return false;
		}
	return true;
}
<?php }?>
function get_deposit_price()
{
	var buyNums  = parseInt($.trim($('#qty_item_1').val()));
	return parseFloat( _market_price * <?php echo isset($dcommission)?$dcommission:"";?> / 100 * buyNums );
}
function buy_now_ding_card(_input_dprice){
	var buyNums  = parseInt($.trim($('#qty_item_1').val()));
	var id = <?php echo isset($id)?$id:"";?>;
	if($('#product_id').val())
	{
		id = $('#product_id').val();
		type = 'product';
	} else {
		type = 'goods';
	}
	var url = '<?php echo IUrl::creatUrl("/simple/cart2/id/@id@/num/@buyNums@/type/@type@/statement/2");?>';
		url = url.replace('@id@',id).replace('@buyNums@',buyNums).replace('@type@',type);
	var _input_stime = 1;
	url += '/stime/' + _input_stime;
	url += '/dprice/' + _input_dprice;

	//console.log(url);
	window.location.href = url;
}
// 购券支付
function buy_now_ding(statement)
{
	if(statement != 2){
		mui.alert('该课程不能预定', '提示信息');
		return false;
	}
	if($('#product_id').val()){
		$('#spec' + $('#product_id').val()).addClass('active');
	}
	$('.card-list-bg').show();
	$('.card-list-box').animate({bottom: 0}, 300);
	mui(document.body).on('tap', '.card-list-bg', function(){
		$('.card-list-box').animate({bottom: '-100%'}, 300);
		$('.card-list-bg').hide();
	});

	mui(document.body).on('tap', '.card-list-close', function(){
		$('.card-list-box').animate({bottom: '-100%'}, 300);
		$('.card-list-bg').hide();
	});

	mui('#chitscroll').scroll();

	return;

	var btnArray = ['取消', '购买'];
	mui.prompt('学习券购买', _max_cprice, '购买', btnArray, function(e) {
		if (e.index == 1) {
			if ( !check_parchse_param(e.value, 1))
			{
				return false;
			}
			if(!checkSpecSelected())
			{
				mui.alert('请选择规格', '提示信息');
				return;
			}
			var buyNums  = parseInt($.trim($('#qty_item_1').val()));
			var id = <?php echo isset($id)?$id:"";?>;

			if($('#product_id').val())
			{
				id = $('#product_id').val();
				type = 'product';
			} else {
				type = 'goods';
			}

			<?php if($promo){?>
			//有促销活动（团购，抢购）
			var url = '<?php echo IUrl::creatUrl("/simple/cart2/id/@id@/num/@buyNums@/type/@type@/promo/".$promo."/active_id/".$active_id."");?>';
			url = url.replace('@id@',id).replace('@buyNums@',buyNums).replace('@type@',type);
			<?php }else{?>
			//普通购买
			var url = '<?php echo IUrl::creatUrl("/simple/cart2/id/@id@/num/@buyNums@/type/@type@/statement/2");?>';
			url = url.replace('@id@',id).replace('@buyNums@',buyNums).replace('@type@',type);
			<?php }?>

			//页面跳转
			var _input_dprice = e.value;
			var _input_stime = 1;
			url += '/stime/' + _input_stime;
			url += '/dprice/' + _input_dprice;

			//console.log(url);
			window.location.href = url;
		} else {
			//mui.alert('购买取消', '提示信息');
		}
	});
}

function buy_now_ding2()
{
	if($('[name="specCols"]').length == 1){
		if(!checkSpecSelected())
		{
			mui.alert('请选择规格', '提示信息');
			$('body,html').animate({ scrollTop: $('#spec_list_mao').offset().top - 250 }, 500);
			return;
		}
	}

	var _deposit_price = get_deposit_price();
	if ( _deposit_price <= 0 )
	{
		mui.alert('请选择规格', '提示信息');
		return false;
	}

	var btnArray = ['取消', '支付'];
	mui.prompt('请选择入学日期', '', '定金', btnArray, function(e) {
		if(e.index == 1){
			var buyNums  = parseInt($.trim($('#qty_item_1').val()));
			var id = <?php echo isset($id)?$id:"";?>;

			if($('#product_id').val())
			{
				id = $('#product_id').val();
				type = 'product';
			} else {
				type = 'goods';
			}

			<?php if($promo){?>
			//有促销活动（团购，抢购）
			var url = '<?php echo IUrl::creatUrl("/simple/cart2/id/@id@/num/@buyNums@/type/@type@/promo/".$promo."/active_id/".$active_id."");?>';
			url = url.replace('@id@',id).replace('@buyNums@',buyNums).replace('@type@',type);
			<?php }else{?>
			//普通购买
			var url = '<?php echo IUrl::creatUrl("/simple/cart2/id/@id@/num/@buyNums@/type/@type@/statement/3");?>';
			url = url.replace('@id@',id).replace('@buyNums@',buyNums).replace('@type@',type);
			<?php }?>

			//页面跳转
			url += '/dprice/' + _deposit_price;
			url += '/choose_date/' + e.value;

			window.location.href = url;
		}
	});

	mui('.mui-popup-input').on('tap', 'input', function(e){
		var optionsJson = '{"type":"date","beginYear":2016,"endYear":2020}';
		var options = JSON.parse(optionsJson);
		var picker = new mui.DtPicker(options);
		picker.show(function(rs) {
			mui('.mui-popup-input input')[0].value = rs.text;
			picker.dispose();
		});
	});
}

/**
 * 规格的选择
 * @param _self 规格本身
 */
function sele_spec(_self)
{
	$('.tospec').removeClass('active');
  var _parent = $(_self).parent().find('a').removeClass('current');
  $(_self).addClass('current');
  if ( _promo == '')
  {
    $('.pro-price i').html('');
  } else if ( _promo == 'time') {
    $('.pro-discount span').html('');
  } else if ( _promo == 'groupon') {
    $('.pro-discount span').html('');
  }

	//检查规格是否选择符合标准
	if(checkSpecSelected())
	{
		//整理规格值
		var specArray = [];
		$('[name="specCols"]').each(function(){
			specArray.push($(this).find('a.current').attr('value'));
		});
		var specJSON = '['+specArray.join(",")+']';

		//获取货品数据并进行渲染
		$.getJSON(_spec_url,{"goods_id":_goods_id,"specJSON":specJSON,"random":Math.random},function(json){
			if(json.flag == 'success')
			{
        var _sell_price = json.data.sell_price;
        if ( _promo == '')
        {
            $('.pro-price i').html(json.data.market_price);
        } else if ( _promo == 'time') {
          $('.pro-discount span').html('&yen;' + _sell_price);
        } else if ( _promo == 'groupon') {
          $('.pro-discount span').html('&yen;' + _sell_price);
        }

				<?php if($statement == 2){?>
				_dprice = parseFloat(json.data.dprice);
					_rprice = parseFloat(json.data.rprice);
					$('.input_dprice').val(_dprice);
					_max_cprice = json.data.max_cprice;
					_max_order_chit = json.data.max_order_chit;
					calculation_cprice();
				<?php }?>
				_market_price = json.data.market_price;
				_sell_price = json.data.sell_price;

				_store_nums = json.data.store_nums;
				$('#product_id').val(json.data.id);

        //var _spec_array = json.data.spec_array;
        eval("var _spec_array = " + json.data.spec_array );
        _spec_array = _spec_array[0];
        $('.selected_spec span').html( _spec_array.name + ':' + _spec_array.value);

				//库存监测
				checkStoreNums();
			} else {
				mui.alert(json.message, '提示信息');
				closeBuy();
			}
		});
	}
}


//立即购买按钮
function buy_now()
{
	if($('[name="specCols"]').length == 1){
		//对规格的检查
		if(!checkSpecSelected())
		{
			mui.alert('请选择课程规格', '提示信息');
			$('body,html').animate({ scrollTop: $('#spec_list_mao').offset().top - 250 }, 500);
			return;
		}
	}

	//设置必要参数
	var buyNums  = parseInt($.trim($('#qty_item_1').val()));
	var id = <?php echo isset($id)?$id:"";?>;
	var type = 'goods';

	if($('#product_id').val())
	{
		id = $('#product_id').val();
		type = 'product';
	}

	<?php if($promo){?>
	//有促销活动（团购，抢购）
	var url = '<?php echo IUrl::creatUrl("/simple/cart2/id/@id@/num/@buyNums@/type/@type@/promo/".$promo."/active_id/".$active_id."");?>';
	url = url.replace('@id@',id).replace('@buyNums@',buyNums).replace('@type@',type);
	<?php }else{?>
	//普通购买
	var url = '<?php echo IUrl::creatUrl("/simple/cart_virtual/id/@id@/num/@buyNums@/type/@type@");?>';
	url = url.replace('@id@',id).replace('@buyNums@',buyNums).replace('@type@',type);
	<?php }?>

	//页面跳转
	window.location.href = url;
}

function calculation_cprice()
{
	var _num = parseInt($.trim($('#qty_item_1').val()));
	$('#data_dprice .buy').html('￥' + _max_cprice * _num);
	var _chit = _max_order_chit * _num;
	_chit = _chit.toFixed(2);
	$('#data_dprice .chit').html('￥' + _chit);
}
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

<?php if($id == 851){?>
<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/form.css";?>" />
<script>var pid = <?php echo isset($id)?$id:"";?>;</script>
<script language="javascript" src="<?php echo $this->getWebSkinPath()."js/form.js";?>"></script>
<?php }?>
