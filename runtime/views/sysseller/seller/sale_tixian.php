<?php $seller_id = $this->seller['seller_id'];$seller_name = $this->seller['seller_name'];?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>商家管理后台</title>
	<link type="image/x-icon" href="<?php echo IUrl::creatUrl("")."favicon.ico";?>" rel="icon">
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/jquery/jquery-1.12.4.min.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/artdialog/skins/aero.css" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/form/form.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
	<script type='text/javascript' src="<?php echo $this->getWebViewPath()."javascript/html5.js";?>"></script>
	<script type='text/javascript' src="<?php echo $this->getWebViewPath()."javascript/common.js";?>"></script>
	<!--[if lt IE 9]>
	<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/ie.css";?>" type="text/css" media="screen" />
	<![endif]-->
	<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/admin.css";?>" type="text/css" media="screen" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/autovalidate/style.css" />
</head>
<style>
 header#header h2.section_title{
  width:40%;
 }
</style>
<body>
	<!--头部 开始-->
	<header id="header">
		<hgroup>
			<h1 class="site_title"><a href="<?php echo IUrl::creatUrl("/seller/index");?>"><img src="<?php echo $this->getWebSkinPath()."images/main/logo.png";?>" /></a></h1>
			<h2 class="section_title"></h2>
			<div class="btn_view_site"><a href="http://www.lelele999.net" target="_blank">管理公众号</a></div>
			<div class="btn_view_site"><a href="<?php echo IUrl::creatUrl("");?>" target="_blank">网站首页</a></div>
			<div class="btn_view_site"><a href="<?php echo IUrl::creatUrl("/site/home/id/".$seller_id."");?>" target="_blank">商家主页</a></div>
			<div class="btn_view_site"><a href="<?php echo IUrl::creatUrl("/systemseller/logout");?>">退出登录</a></div>
		</hgroup>
	</header>
	<!--头部 结束-->

	<!--面包屑导航 开始-->
	<section id="secondary_bar">
		<div class="user">
			<p><?php echo isset($seller_name)?$seller_name:"";?></p>
		</div>
	</section>
	<!--面包屑导航 结束-->

	<!--侧边栏菜单 开始-->
	<aside id="sidebar" class="column">
		<?php foreach(menuSeller::init() as $key => $item){?>
		<h3><?php echo isset($key)?$key:"";?></h3>
		<ul class="toggle">
			<?php foreach($item as $moreKey => $moreValue){?>
			<li><a href="<?php echo IUrl::creatUrl("".$moreKey."");?>"><?php echo isset($moreValue)?$moreValue:"";?></a></li>
			<?php }?>
		</ul>
		<?php }?>

		<footer>
			<hr />
			<p><strong>Copyright &copy; 2010-2017</strong></p>
			<p>Powered by <a href="http://www.dsanke.com">dsanke.com</a></p>
		</footer>
	</aside>
	<!--侧边栏菜单 结束-->

	<!--主体内容 开始-->
	<section id="main" class="column">
		<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/my97date/wdatepicker.js"></script>
<style>
input.normal {
	height: 25px;
	line-height: 25px;
	text-indent: 3px;
}
input.send_sms {
	padding: 0 10px;
	height: 28px;
	line-height: 28px;
	display: inline-block;
	background-color: #f2f2f2;
	color: #000;
	border-radius: 3px;
	text-decoration: none;
	border: 1px solid #c5c5c5;
	cursor: pointer;
}
input.disable {
	color: #ccc;
}
.send_sms_notice, .balance_notice {
	margin-top: 10px;
	background: url(/views/mobile/skin/blue/images/right.png) 0 1px no-repeat;
	background-size: 13px 13px;
	padding-left: 18px;
	display: none;
}
.balance_notice {
	display: block;
	color: red;
	background: url(/views/mobile/skin/blue/images/wrong.png) 0 1px no-repeat;
	background-size: 13px 13px;
}
input[type=submit].alt_btn, input[type=button].alt_btn {
	padding: 0 25px;
}
.tabs .alt_btn{padding:0 10px !important;}
.tab_current{background:#24b408 !important;color:#fff !important;}
</style>

<article class="module width_full">
	<header>
		<h3 class="tabs_involved">账户余额</h3>
		<ul class="tabs">
			<li><input type="button" class="alt_btn" onclick="javascript:location.href='/seller/order_list'" value="全款订单" /></li>
			<li><input type="button" class="alt_btn" onclick="javascript:location.href='/seller/order_prop_list'" value="推荐订单" /></li>
			<li><input type="button" class="alt_btn" onclick="javascript:location.href='/seller/order_list2'" value="定金订单" /></li>
			<li><input type="button" class="alt_btn" onclick="javascript:location.href='/seller/order_seat_list'" value="购票订单" /></li>
			<li><input type="button" class="alt_btn tab_current" onclick="javascript:location.href='/seller/sale_tixian'" value="帐务中心" /></li>
			<li><input type="button" class="alt_btn" onclick="window.location.href='<?php echo IUrl::creatUrl("/seller/tixian_list");?>';" value="提现记录" /></li>
		</ul>
	</header>

	<div class="module_content">
		<table class="tablesorter" cellspacing="0">
			<form action="<?php echo IUrl::creatUrl("/seller/sale_withdraw/type/1");?>"  method="post" name="bill_edit">
			<thead></thead>
			<tbody>
				<tr>
					<td>账户余额：<?php echo isset($sellerRow['sale_balance'])?$sellerRow['sale_balance']:"";?>元</td>
				</tr>
				<?php if($sellerRow['sale_balance'] > 0 ){?>
				<tr>
					<td>提 现 金 额 ：<input type="text" pattern="float" name="sale" id="sale" alt="请输入一个正确的数字" class="normal small" placeholder="最多可提<?php echo isset($sellerRow['sale_balance'])?$sellerRow['sale_balance']:"";?>" onchange="check_balance()"> 元</td>
				</tr>
				<tr style="display:none;">
					<td>账 户 类 型 ：<?php if($sellerRow['bank'] == 1){?>银行<?php }else{?>支付宝<?php }?></td>
				</tr>
				<tr>
					<td>银 行 名 称 ：<?php echo isset($sellerRow['account_bank_name'])?$sellerRow['account_bank_name']:"";?></td>
				</tr>
				<tr>
					<td>支 行 名 称 ：<?php echo isset($sellerRow['account_bank_branch'])?$sellerRow['account_bank_branch']:"";?></td>
				</tr>
				<tr>
					<td>收 款 账 号 ：<?php echo isset($sellerRow['account_cart_no'])?$sellerRow['account_cart_no']:"";?></td>
				</tr>
				<tr>
 					<td>账 户 户 名 ：<?php echo isset($sellerRow['account_name'])?$sellerRow['account_name']:"";?></td>
				</tr>
				<tr>
					<td>手机验证码：
						<input type="text" name="mobile_code" id="mobile_code" class="normal small" />
						<input type="button" class="send_sms" value="获取验证码" onclick="sendMessage();" />
						<div class="send_sms_notice">验证码已发送到您的<?php echo substr( $mobile, 0, 3 ) . '****' . substr( $mobile, -3 ); ?>手机，请查收
					</td>
				</tr>
				<tr>
					<td>
							<input type="submit" class="alt_btn" value="确 定"  onclick='return check_form();'/>
					</td>
				</tr>
				<?php }?>
			</tbody>
		</form>
		</table>
	</div>


	<table class="tablesorter" cellspacing="0">
		<colgroup>
			<col />
			<col width="150px" />
			<col width="150px" />
			<col width="100px" />
			<col width="100px" />
			<col width="100px" />
			<col width="105px" />
			<col width="90px" />
			<col width="90px" />
			<col width="90px" />
			<col width="90px" />
		</colgroup>
		<thead>

			<tr>
				<th>课程名称</th>
				<th>学员姓名</th>
				<th>服务保证金</th>
				<th>线下应付费</th>
				<th>课程学费</th>
				<th>完成时间</th>
				<th>未结算金额</th>
				<th>已记账金额</th>
				<th>记账状态</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				$page = (isset($_GET['page'])&&(intval($_GET['page'])>0))?intval($_GET['page']):1;
				$orderGoodsQuery = CountSum::getSellerGoodsFeeQuery($seller_id);
				$orderGoodsQuery->page = $page;
			?>
			<?php foreach($orderGoodsQuery->find() as $key => $item){?>
			<?php $countData = CountSum::countSellerOrderFee(array($item))?>
			<?php $goods_list = Order_Class::get_order_goods_list($item['id'])?>
			<?php $goods = $goods_list[0]?>
			<?php $goods_array = $goods['goods_array']?>
			<?php $countFee = CountSum::countSellerOrderFee(array($item));?>
			<?php if($item['statement'] == 2 && $item['chit_id'] > 0 && $item['order_amount'] <= 0){?>

			<?php }else{?>
			<tr>
				<?php if($item['statement'] == 2 && $item['chit_id'] > 0 ){?>
					<?php $chit_info = brand_chit_class::get_chit_info($item['chit_id'])?>
					<td><a href="<?php echo IUrl::creatUrl("/site/chit_show/id/".$chit_info['id']."");?>" target="_blank"><?php echo brand_chit_class::get_chit_name($chit_info['max_price'], $chit_info['max_order_chit']);?></a></td>
				<?php }elseif($item['statement'] == 4){?>
					<td><?php echo $goods_array->name;?></td>
				<?php }else{?>
					<td><a href="<?php echo IUrl::creatUrl("/site/products/id/".$goods['goods_id']."");?>" target="_blank"><?php echo $goods_array->name;?></a></td>
				<?php }?>
				<td><?php echo isset($item['accept_name'])?$item['accept_name']:"";?></td>
				<td><?php if($item['statement'] == 2 && $item['chit_id'] > 0){?>0<?php }else{?><?php if($item['statement'] != 2){?><?php echo isset($countFee['countFee'])?$countFee['countFee']:"";?><?php }else{?><?php echo $goods['cost_price'] * $goods['goods_nums'] - $item['rest_price'];?><?php }?><?php }?></td>
				<td><?php if($item['statement'] == 2 && $item['chit_id'] > 0){?>0<?php }else{?><?php echo isset($item['rest_price'])?$item['rest_price']:"";?><?php }?></td>
				<td><?php if($item['statement'] == 2 && $item['chit_id'] > 0){?>0<?php }else{?>&yen;<?php echo $goods['cost_price']*$goods['goods_nums'];?><?php }?></td>
				<td><?php echo isset($item['completion_time'])?$item['completion_time']:"";?></td>
				<td><?php echo isset($item['not_settled'])?$item['not_settled']:"";?></td>
				<td><?php echo isset($item['settled'])?$item['settled']:"";?></td>
				<td>
					<?php if($item['is_checkout'] == 1){?>
					<label class="green">已结算</label>
					<?php }elseif($item['is_checkout'] == 2){?>
					<label class="blue">部分结算</label>
					<?php }else{?>
					<label class="orange">未结算</label>
					<?php }?>
				</td>
				<td>
					<?php 
						if( $item['statement'] == 1 )
							$template = 'order_show';
						else if ( $item['statement'] == 2 )
							$template = 'order_show_dai';
						else
							$template = 'order_show_ding';
					?>
					<a href="<?php echo IUrl::creatUrl("/seller/".$template."/id/".$item['id']."");?>">查看订单</a>
				</td>
			</tr>
			<?php }?>
			<?php }?>
		</tbody>
	</table>

	<footer></footer>
	</form>

</article>
<script type='text/javascript'>
	var _sale_balance = <?php echo isset($sellerRow['sale_balance'])?$sellerRow['sale_balance']:"";?>;
	var _mobile = '<?php echo isset($mobile)?$mobile:"";?>';
	var default_time = 60;
	var s_count = 60;
	var send_status = true;

	function check_balance()
	{
		var _input_balance = $('#sale').val();
		if ( _input_balance != '' && parseInt(_input_balance) > _sale_balance )
		{
			alert('可用余额不足');
			$('#sale').val(_sale_balance);
		}
	}
	function check_form()
	{
		var _sale = $('[name="sale"]').val();
		if ( _sale == '')
		{
			alert('请输入提现的金额');
			return false;
		}
		if( _sale > _sale_balance)
		{
			alert('申请提现的金额超出你的账户余额');
			return false;
		}
		if ( $('#mobile_code').val() == '')
		{
			alert('请输入手机验证码');
			return false;
		}
		return true;
	}


	//发送短信码
	function sendMessage()
	{
		<?php if(!$can_tixian){?>
			alert('账户信息不完善，请完善账户信息认证后再重新操作!');
			return false;
		<?php }?>

		if ( s_count == default_time && send_status )
		{
			$.getJSON("<?php echo IUrl::creatUrl("/seller/get_withdraw_code_ajax");?>",{},function(response){
	      if ( response.done !== false )
	      {
	        update_sms_status();
	        time = setInterval(function(){
	          update_sms_status();
	        }, 1000);
	        $('.send_sms').addClass('disable');
	        $('.send_sms_notice').show();
	      } else {
	        alert(response.msg);
	        return;
	      }
			});
		}

	}

	function update_sms_status()
	{
		if ( s_count > 0 )
		{
			s_count--;
			send_status = false;
			$('.send_sms').attr('disabled',"true");
			$('.send_sms').val('重新发送验证码(' + s_count + ' s)');
			$('.send_sms').css('cursor', 'wait');
		} else {
			s_count = default_time;
			send_status = true;
			clearInterval(time);

			$('.send_sms').val('重新发送验证码');
			$('.send_sms').removeAttr("disabled");
			$('.send_sms').removeClass('disable');
			$('.send_sms').css('cursor', 'pointer');
		}
	}

	</script>

	</section>
	<!--主题内容 结束-->

	<script type="text/javascript">
	//菜单图片ICO配置
	function menuIco(val)
	{
		var icoConfig = {
			"管理首页" : "icn_tags",
			"销售额统计" : "icn_settings",
			"货款明细列表" : "icn_categories",
			"货款结算申请" : "icn_photo",
			"商品列表" : "icn_categories",
			"添加商品" : "icn_new_article",
			"平台共享商品" : "icn_photo",
			"商品咨询" : "icn_audio",
			"商品评价" : "icn_audio",
			"商品退款" : "icn_audio",
			"规格列表" : "icn_categories",
			"订单列表" : "icn_categories",
			"团购" : "icn_view_users",
			"促销活动列表" : "icn_categories",
			"物流配送" : "icn_folder",
			"发货地址" : "icn_jump_back",
			"资料修改" : "icn_profile",
		};
		return icoConfig[val] ? icoConfig[val] : "icn_categories";
	}

	$(".toggle>li").each(function()
	{
		$(this).addClass(menuIco($(this).text()));
	});
	</script>
</body>
</html>