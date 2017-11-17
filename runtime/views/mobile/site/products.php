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
	<?php    $site_config=new Config('site_config');	$dcommission = $site_config->dcommission;?>
<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/product.css";?>">
<link rel="stylesheet" href="<?php echo IUrl::creatUrl("")."resource/scripts/swiper/swiper.min.css";?>">
<link rel="stylesheet" href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.picker.min.css";?>">
<script type='text/javascript' src="<?php echo IUrl::creatUrl("")."resource/scripts/swiper/swiper.min.js";?>"></script>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/payfor.js";?>"></script>
<script type='text/javascript' src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.picker.min.js";?>"></script>
<script type='text/javascript' src="<?php echo IUrl::creatUrl("")."resource/scripts/layer_mobile/layer.js";?>"></script>

<!-- 推广信息 S -->
<?php if($goods_promotion_commission > 0){?>
<div class="promote_tips"><i></i>推荐好友赚&yen;<?php echo isset($goods_promotion_commission)?$goods_promotion_commission:"";?></div>
<div class="promote_content">
	<div class="promote_info">
		<div class="promote_image">
			<img src="<?php echo IUrl::creatUrl("")."".$photo['0']['img']."";?>" />
		</div>
		<div class="promote_infos">
			<div class="promote_names">
				<div class="promote_name"><?php echo isset($name)?$name:"";?></div>
				<div class="promote_addr"><?php echo isset($seller['address'])?$seller['address']:"";?></div>
				<div class="promote_brief"><?php echo isset($keywords)?$keywords:"";?></div>
				<div class="promote_price">&yen;<?php if($sell_price != $this->hide_price){?><?php echo isset($sell_price)?$sell_price:"";?><?php }else{?><i><?php echo $this->hide_price_str;?></i><?php }?></div>
			</div>
			<div class="promote_qrcode">
					<img src="http://www.dsanke.com/plugins/phpqrcode/index.php?data=http://www.dsanke.com<?php echo isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:"";?>" />
			</div>
		</div>
		<div class="promote_notice">“长按图片发送”或“转发此页面链接”给朋友，朋友购买并使用以后，您将最高可得到<?php echo isset($goods_promotion_commission)?$goods_promotion_commission:"";?>元返利！</div>
	</div>
	<div class="promote_btn">
		<a href="#" class="mui-btn mui-btn-block mui-btn-primary">我知道了</a>
	</div>
</div>
<?php }?>
<!-- 推广信息 E -->

<div class="pro-header goodstab">
	<input type='hidden' id='product_id' alt='课程ID' value='' />
	<a href="javascript:;" class="current">课程</a>
	<a href="#shop-pingjia">评价</a>
	<a href="#shop-talk">咨询</a>
	<a href="#shop-speak">讨论</a>
</div>
<?php if($sell_price != $this->hide_price){?>
<div class="shop-nav-bot<?php if($seller['is_authentication'] == 1){?><?php if($discount <= 0){?> cxd-1<?php }?><?php }else{?> cxd-2<?php }?>">
		<?php if($seller['is_authentication'] == 1){?>
			<a href="javascript: void(0);" onclick="seller_receipt('<?php echo isset($seller[id])?$seller[id]:"";?>');" class="shopbtn">面对面付款</a>
			<a href="javascript: void(0);" onclick="joinCart();" class="add-shop" id="joinCarButton" style="display:none;">加入课表</a>
			<a href="javascript: void(0);" onclick="buy_now();" class="buy-btn" id="buyNowButton">常规课报名</a>
		<?php }else{?>
		<a href="javascript:;" class="shopbtn">学校未认证</a>
		<?php }?>
</div>
<?php }?>
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
	<div class="pro-price goodsprice">
		<?php if($promo == ''){?>
			<?php if($group_price){?>
				<b class="price red2">￥<span class="f30" id="data_groupPrice"><?php echo isset($group_price)?$group_price:"";?></span></b><br />
			<?php }else{?>
				<b class="price red2">￥<span class="f30" id="data_sellPrice"><?php if($sell_price != $this->hide_price){?><?php echo isset($sell_price)?$sell_price:"";?><?php }else{?><i><?php echo $this->hide_price_str;?></i><?php }?></span></b>
			<?php }?>
		<?php }?>

		<!--抢购活动,引入 "_products_time"模板-->
		<?php if($promo == 'time' && isset($time)){?>
		<?php require(ITag::createRuntime("_products_time"));?>
		<?php }?>

		<!--团购活动,引入 "_products_groupon"模板-->
		<?php if($promo == 'groupon' && isset($groupon)){?>
		<?php require(ITag::createRuntime("_products_groupon"));?>
		<?php }?>
	</div>

</div>

<div class="mui-content-padded">
	<?php if($store_nums <= 0){?>
	<h5>该课程已结束</h5>
	<?php }else{?>
			<ul class="spec_list clearfix" id="spec_list_mao">
				<li name="specCols">
					<?php foreach($goods_spec_array['value'] as $key => $spec_value){?>
						<a href="javascript:void(0);" name="specColls" onclick="sele_spec(this);" id="<?php echo isset($spec_value['id'])?$spec_value['id']:"";?>" value='{"id":"<?php echo isset($spec_value['id'])?$spec_value['id']:"";?>","value":"<?php echo isset($spec_value['cusval'])?$spec_value['cusval']:"";?>","classnum":"<?php echo isset($spec_value['classnum'])?$spec_value['classnum']:"";?>","month":"<?php echo isset($spec_value['month'])?$spec_value['month']:"";?>","name":"<?php echo isset($goods_spec_array['name'])?$goods_spec_array['name']:"";?>"}'>
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

		<div class="chit_info"></div>
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

<?php if($dqk_list){?>
<div class="mui-content-padded dqk">
	<div class="hd">
		<div class="t-left">短期课</div>
		<div class="t-right"><a href="<?php echo IUrl::creatUrl("/site/chit1_detail/id/".$seller['id']."");?>">更多</a></div>
	</div>
	<div class="bd">
		<ul>
			<li>
				<a href="<?php echo IUrl::creatUrl("/site/chit1_detail/id/".$seller['id']."");?>">
					<div class="dqk_image"><img src="<?php if($dqk_list['logo'] != ''){?><?php echo IUrl::creatUrl("")."".$dqk_list['logo']."";?><?php }else{?>/views/mobile/skin/blue/images/dqk.png<?php }?>" /></div>
					<div class="dqk_info">
						<div class="dqk_seller_name"><?php echo isset($seller['shortname'])?$seller['shortname']:"";?></div>
						<div class="dqk_goods_name"><?php echo isset($name)?$name:"";?>短期课<?php echo isset($dqk_list['use_times'])?$dqk_list['use_times']:"";?>节</div>
						<div class="dqk_price">&yen;<em><?php echo isset($dqk_list['max_price'])?$dqk_list['max_price']:"";?></em></div>
					</div>
				</a>
			</li>
		</ul>
	</div>
</div>
<?php }?>

<ul class="mui-table-view mui-table-view-chevron">
	<li class="mui-table-view-cell mui-media">
		<a href="<?php echo IUrl::creatUrl("/site/home/id/".$seller['id']."");?>" class="mui-navigate-right">
			<img class="mui-media-object mui-pull-left" src="<?php echo IUrl::creatUrl("")."".$brand['pc_logo']."";?>">
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
		<?php if($brand['certificate_of_authorization']){?>
			<?php foreach($brand['certificate_of_authorization'] as $key => $item){?>
				<img src="<?php echo IUrl::creatUrl("")."".$item."";?>" />
			<?php }?>
		<?php }?>
		<p><?php echo isset($content)?$content:"";?></p>
	</div>
</div>
<div class="mui-content-padded" id="shop-pingjia">
	<h5>评价(<?php echo isset($comments)?$comments:"";?>)</h5>
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
	<h5><a href="<?php echo IUrl::creatUrl("/site/consult/id/".$id."");?>" class="pingjia">咨询(<?php echo isset($refer)?$refer:"";?>)</a></h5>
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
	<h5><a href="<?php echo IUrl::creatUrl("/site/article_discussion/id/".$id."");?>" class="pingjia">讨论(<?php echo isset($discussion)?$discussion:"";?>)</a></h5>
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
<?php if($djq_list){?>
var swiper2 = new Swiper('.swiper-container2', {
    loop : true,
});
<?php }?>

var _is_buy_chit = false;
var _store_nums = <?php echo isset($store_nums)?$store_nums:"";?>;
var _spec_url = '<?php echo IUrl::creatUrl("/site/getProduct");?>';
var _join_url = '<?php echo IUrl::creatUrl("/simple/joinCart");?>';
var _show_cart_url = '<?php echo IUrl::creatUrl("/simple/showCart");?>';
var _goods_id = <?php echo isset($id)?$id:"";?>;
var _promo = '<?php echo isset($promo)?$promo:"";?>';

var _market_price = <?php echo isset($market_price)?$market_price:"";?>;
<?php if($statement == 2){?>
var _parchse_html = '';
var _dprice = <?php if($dprice){?><?php echo isset($dprice)?$dprice:"";?><?php }else{?>0<?php }?>;
var _sell_price = <?php if($sell_price){?><?php echo isset($sell_price)?$sell_price:"";?><?php }else{?>0<?php }?>;
var _min_dprice = 10;
var _max_cprice = <?php if($max_cprice){?><?php echo isset($max_cprice)?$max_cprice:"";?><?php }else{?>0<?php }?>;
var _max_order_chit = <?php if($max_order_chit){?><?php echo isset($max_order_chit)?$max_order_chit:"";?><?php }else{?>0<?php }?>;
<?php }?>
</script>



<script type="text/javascript">

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
	var url = '<?php echo IUrl::creatUrl("/simple/cart2d/id/@id@/num/@buyNums@/type/@type@/statement/2");?>';
		url = url.replace('@id@',id).replace('@buyNums@',buyNums).replace('@type@',type);
	var _input_stime = 1;
	url += '/stime/' + _input_stime;
	url += '/dprice/' + _input_dprice;

	//console.log(url);
	window.location.href = url;
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
		$('[name="specColls"]').each(function(){
			//specArray.push($(this).find('a.current').attr('value'));
			specArray.push($(this).attr('value'));
		});
		var specJSON = '['+specArray.join(",")+']';
		var product_id = $(_self).attr('id');

		//获取货品数据并进行渲染
		$.getJSON(_spec_url,{"goods_id":_goods_id,"product_id":product_id,"specJSON":specJSON,"random":Math.random},function(json){
			if(json.flag == 'success')
			{
				if ( json.data.sell_price != <?php echo $this->hide_price;?>)
				{
					$('#data_goodsNo').text(json.data.products_no);
					$('#data_storeNums').text(json.data.store_nums);$('#data_storeNums').trigger('change');
					$('#data_groupPrice').text(json.data.group_price);
					$('#data_sellPrice').text(json.data.sell_price);
					$('#data_marketPrice').text(json.data.market_price);
					$('#data_weight').text(json.data.weight);
					$('#product_id').val(json.data.id);
					_is_buy_chit = (parseFloat(json.data.chit) > 0) ? true : false;

					//库存监测
					checkStoreNums();
				} else {
					$('#data_sellPrice').html('<i><?php echo $this->hide_price_str;?></i>');
					$('.shop-nav-bot').hide();
				}
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
	//对规格的检查
	if(!checkSpecSelected())
	{
		mui.alert('请选择规格', '提示信息');
		$('body,html').animate({ scrollTop: $('#spec_list_mao').offset().top - 250 }, 500);
		return;
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
	var url = '<?php echo IUrl::creatUrl("/simple/cart2n/id/@id@/num/@buyNums@/type/@type@/promo/".$promo."/active_id/".$active_id."");?>';
	url = url.replace('@id@',id).replace('@buyNums@',buyNums).replace('@type@',type);
	<?php }else{?>
	//普通购买
	var url = '<?php echo IUrl::creatUrl("/simple/cart2n/id/@id@/num/@buyNums@/type/@type@");?>';
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
