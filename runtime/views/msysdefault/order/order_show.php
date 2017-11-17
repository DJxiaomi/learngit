<?php $menuData=menu::init($this->admin['role_id']);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>后台管理</title>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/admin.css";?>" />
	<meta name="robots" content="noindex,nofollow">
	<link rel="shortcut icon" href="<?php echo IUrl::creatUrl("")."favicon.ico";?>" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/jquery/jquery-1.12.4.min.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/artdialog/skins/aero.css" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/form/form.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/autovalidate/style.css" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
	<script type='text/javascript' src="<?php echo $this->getWebViewPath()."javascript/common.js";?>"></script>
	<script type='text/javascript' src="<?php echo $this->getWebViewPath()."javascript/admin.js";?>"></script>
</head>
<body>
	<div class="container">
	<span class="zhong"><?php echo isset($this->admin['admin_role_name'])?$this->admin['admin_role_name']:"";?>:<?php echo isset($this->admin['admin_name'])?$this->admin['admin_name']:"";?></span>
		<div id="header">
          <div id="menu">
			<ul name="topMenu">
				<li class="first"> <a href="/index.php?controller=system&amp;action=default">首页</a></li> 

				
				
				
				<li><a hidefocus="true" href="/order/order_list">订单管理</a></li>			
				<li><a hidefocus="true" href="/market/brand_chit_list">新代金券</a></li>
                <li><a hidefocus="true" href="/order/order_collection_list">成交明细</a></li>
                <li><a hidefocus="true" href="/order/refundment_list">退款申请</a></li>				
						<li><a href="/member/withdraw_list">用户提现</a></li>
				<li><a hidefocus="true" href="/market/bill_list">结算申请</a></li>

				<li><a hidefocus="true" href="/goods/goods_list">课程管理</li>
				<li><a hidefocus="true" href="/member/member_list">用户管理</a></li>
				<li><a href="/brand/brand_list">学校资料</a></li>
				<li><a href="/member/seller_list">学校认证</a></li>
				<li><a href="/member/seller_edit">添加认证</a></li>
				<li><a href="/member/teacher_list">教师列表</a></li>
					
				<li><a href="/tools/notice_list">公告管理</a></li>
				<li><a hidefocus="true" href="/tools/article_list">文章管理</a></li>
				<li><a hidefocus="true" href="/tools/ad_list">广告管理</a></li>
				<li><a href="/comment/discussion_list">讨论管理</a></li>
				<li><a href="/comment/refer_list">咨询管理</a></li>
				<li class="last"><a href="/index.php?controller=systemadmin&amp;action=logout">退出</a></li> 
			</ul>
			</div>
			
		</div>

		<div id="admin_left">
			<ul class="submenu">
				<?php $leftMenu=menu::get($menuData,IWeb::$app->getController()->getId().'/'.IWeb::$app->getController()->getAction()->getId())?>
				<?php foreach(current($leftMenu) as $key => $item){?>
				<li>
					<span><?php echo isset($key)?$key:"";?></span>
					<ul name="leftMenu">
						<?php foreach($item as $leftKey => $leftValue){?>
						<li><a href="<?php echo IUrl::creatUrl("".$leftKey."");?>"><?php echo isset($leftValue)?$leftValue:"";?></a></li>
						<?php }?>
					</ul>
				</li>
				<?php }?>
			</ul>
			<div id="copyright"></div>
		</div>

		<div id="admin_right">
			<?php $orderStatus = Order_class::getOrderStatus(array('order_no' => $order_no,'status' => $status,'pay_type' => $pay_type,'distribution_status' => $distribution_status))?>
<?php $orderInstance = new Order_Class();$orderRow = $orderInstance->getOrderShow($id)?>
<?php $is_order_refund = Refundment_doc_class::is_order_refund( $orderRow['id']);?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<div class="headbar clearfix">
	<ul class="tab" name="menu1">
		<li id="li_1"><a href="javascript:selectTab('1');" hidefocus="true">基本信息</a></li>
		<li id="li_2"><a href="javascript:selectTab('2');" hidefocus="true">收退款</a></li>
		<li id="li_4"><a href="javascript:selectTab('4');" hidefocus="true">备注</a></li>
		<li id="li_6"><a href="javascript:selectTab('6');" hidefocus="true">附言</a></li>
	</ul>
</div>

<div id="tab-1" name="table" style="display:none">
	<div class="content">
		<table class="list_table">
			<colgroup>
				<col />
				<col width="90px" />
				<col width="150px" style="display: none;" />
			</colgroup>

			<thead>
				<tr>
					<th>课程</th>
					<th>课程原价</th>
					<th>实际价格</th>
					<th>课程数量</th>
					<th style="display: none;">是否验证</th>
				</tr>
			</thead>
			<tbody>
				<?php $query = new IQuery("order_goods");$query->where = "order_id = $order_id";$items = $query->find(); foreach($items as $key => $item){?>
				<tr>
					<td>
						<?php $goodsRow = JSON::decode($item['goods_array'])?>
						<a href="<?php echo IUrl::creatUrl("/site/products/id/".$item['goods_id']."");?>" target="_blank"><?php echo isset($goodsRow['name'])?$goodsRow['name']:"";?> &nbsp;&nbsp; <?php echo isset($goodsRow['value'])?$goodsRow['value']:"";?></a>
					</td>
					<td>￥<?php echo isset($item['goods_price'])?$item['goods_price']:"";?></td>
					<td>￥<?php echo isset($item['real_price'])?$item['real_price']:"";?></td>
					<td><?php echo isset($item['goods_nums'])?$item['goods_nums']:"";?></td>
					<td style="display: none;">
						<?php echo Order_Class::goodsSendStatus($item['is_send']);?>
						<?php if($item['delivery_id'] && 1 == 0 ){?>
						<button class="btn" onclick="freightLine(<?php echo isset($item['delivery_id'])?$item['delivery_id']:"";?>)">快递跟踪</button>
						<?php }?>
						<?php if(order_class::getOrderStatus( $orderRow ) == 4){?>
							<?php if( $item['verification_code'] != ''){?>
								<input type="button" class="alt_btn" onclick="deliver_with_verifi('<?php echo isset($item['order_id'])?$item['order_id']:"";?>', '<?php echo isset($item['goods_id'])?$item['goods_id']:"";?>')" value="点击发货" style="cursor: pointer;" />
							<?php }else{?>
								<input type="button" class="alt_btn" onclick="delivers('<?php echo isset($item['order_id'])?$item['order_id']:"";?>', '<?php echo isset($item['goods_id'])?$item['goods_id']:"";?>')" value="点击发货" style="cursor: pointer;" />
							<?php }?>
						<?php }?>
					</td>
				</tr>
				<?php }?>
			</tbody>
		</table>

		<table style="width:300px;margin-right:20px;" class="border_table f_l">
			<col width="80px" />
			<col />
			<thead>
				<tr><th colspan="2">订单信息</th></tr>
			</thead>
			<tbody>
				<tr>
					<th>订单号:</th><td><?php echo isset($order_no)?$order_no:"";?></td>
				</tr>
				<tr>
					<th>下单时间:</th><td><?php echo isset($orderRow['create_time'])?$orderRow['create_time']:"";?></td>
				</tr>
				<tr>
					<th>结算方式:</th><td><?php if($orderRow['statement'] == 1){?>全款<?php }elseif($orderRow['statement'] == 2){?>代金券<?php }else{?>定金<?php }?></td>
				</tr>
				<tr>
					<th><?php if($orderRow['statement'] == 1){?>全款<?php }elseif($orderRow['statement'] == 2){?>代金券<?php }else{?>定金<?php }?>:</th><td>￥<?php echo isset($order_amount)?$order_amount:"";?></td>
				</tr>
				<?php if($orderRow['statement'] == 2){?>
				<tr>
					<th>抵用:</th><td>￥<?php echo isset($orderRow['chit'])?$orderRow['chit']:"";?></td>
				</tr>
				<tr>
					<th>尾款:</th><td>￥<?php echo isset($orderRow['rest_price'])?$orderRow['rest_price']:"";?></td>
				</tr>
				<?php }elseif($orderRow['statement'] == 3){?>
				<tr>
					<th>尾款:</th><td>￥<?php echo isset($orderRow['rest_price'])?$orderRow['rest_price']:"";?></td>
				</tr>
				<?php }?>
				<tr>
					<th>支付方式:</th><td><?php echo isset($orderRow['payment'])?$orderRow['payment']:"";?></td>
				</tr>
				<tr>
					<th>订单状态:</th><td><?php echo order_class::orderStatusText(order_class::getOrderStatus($orderRow),3, $orderRow['statement']);?></td>
				</tr>
			</tbody>
		</table>

		<table style="width:300px;margin-right:20px;" class="border_table f_l">
			<col width="80px" />
			<col />
			<thead>
				<tr><th colspan="2">学员信息</th></tr>
			</thead>
			<tbody>
				<tr>
					<th>姓名:</th><td><?php echo isset($accept_name)?$accept_name:"";?></td>
				</tr>
				<tr>
					<th>手机 :</th><td><?php echo isset($mobile)?$mobile:"";?></td>
				</tr>
				<tr>
					<th>用户名:</th><td><?php echo isset($username)?$username:"";?></td>
				</tr>
			</tbody>
		</table>

	</div>
</div>

<div id="tab-2" name="table" style="display:none">
	<div class="content">
		<table style="width:45%;margin-right:20px;" class="border_table f_l">
			<colgroup>
				<col width="120px" />
				<col />
			</colgroup>

			<thead>
				<tr><th colspan="2">收款单据</th></tr>
			</thead>

			<tbody>
				<?php $query = new IQuery("collection_doc as c");$query->join = "left join payment as p on c.payment_id = p.id";$query->where = "c.order_id = $order_id";$query->fields = "c.*,p.name";$collectionData = $query->find(); foreach($collectionData as $key => $item){?>
				<tr>
					<th>付款时间：</th><td><?php echo isset($item['time'])?$item['time']:"";?></td>
				</tr>
				<tr>
					<th>金额：</th><td><?php echo isset($item['amount'])?$item['amount']:"";?></td>
				</tr>
				<tr>
					<th>支付方式：</th><td><?php echo isset($item['name'])?$item['name']:"";?></td>
				</tr>
				<tr>
					<th>付款备注：</th><td><?php echo isset($item['note'])?$item['note']:"";?></td>
				</tr>
				<tr>
					<th>状态：</th><td><?php if($item['pay_status']==0){?>准备中<?php }else{?>支付完成<?php }?></td>
				</tr>
				<tr><th colspan="2"></th></tr>
				<?php }?>
			</tbody>
		</table>

		<table style="width:45%;margin-right:20px;" class="border_table f_l">
			<colgroup>
				<col width="120px" />
				<col />
			</colgroup>

			<thead>
				<tr><th colspan="2">退款单据</th></tr>
			</thead>
			<tbody>
				<?php $query = new IQuery("refundment_doc");$query->where = "order_id = $order_id";$refundmentData = $query->find(); foreach($refundmentData as $key => $item){?>
				<tr>
					<th>课程退款：</th>
					<td>
						<?php $query = new IQuery("order_goods");$query->where = "id in ($item[order_goods_id])";$items = $query->find(); foreach($items as $key => $orderGoods){?>
						<?php $goods = JSON::decode($orderGoods['goods_array'])?>
						<p>
						<a href="<?php echo IUrl::creatUrl("/site/products/id/".$orderGoods['goods_id']."");?>" target="_blank" title="<?php echo isset($goods['name'])?$goods['name']:"";?>"><?php echo IString::substr($goods['name'],28);?> X <?php echo isset($orderGoods['goods_nums'])?$orderGoods['goods_nums']:"";?></a>
						<?php if($item['seller_id']){?>
						<a href="<?php echo IUrl::creatUrl("/site/home/id/".$item['seller_id']."");?>" target="_blank"><img src="<?php echo $this->getWebSkinPath()."images/admin/seller_ico.png";?>" /></a>
						<?php }?>
						</p>
						<?php }?>
					</td>
				</tr>
				<tr>
					<th>退款金额：</th><td><?php echo isset($item['amount'])?$item['amount']:"";?></td>
				</tr>
				<tr>
					<th>申请时间：</th><td><?php echo isset($item['time'])?$item['time']:"";?></td>
				</tr>
				<tr>
					<th>状态：</th><td><?php echo Order_Class::refundmentText($item['pay_status']);?></td>
				</tr>
				<tr>
					<th>退款理由：</th><td><?php echo isset($item['content'])?$item['content']:"";?></td>
				</tr>
				<tr><th colspan="2"></th></tr>
				<?php }?>
			</tbody>
		</table>
	</div>
</div>

<div id="tab-3" name="table" style="display:none">
	<div class="content">
		<table style="width:98%" class="border_table">
			<colgroup>
				<col width="150px" />
				<col width="120px" />
				<col width="120px" />
				<col width="150px" />
				<col width="150px" />
				<col />
			</colgroup>

			<thead>
				<tr>
					<th>配送时间</th>
					<th>配送方式</th>
					<th>物流公司</th>
					<th>物流单号</th>
					<th>收件人</th>
					<th>备注</th>
				</tr>
			</thead>

			<tbody>
				<?php $query = new IQuery("delivery_doc as c");$query->join = "left join delivery as p on c.delivery_type = p.id";$query->fields = "c.*,p.name as pname";$query->where = "c.order_id = $order_id";$deliveryData = $query->find(); foreach($deliveryData as $key => $item){?>
				<tr>
					<td><?php echo isset($item['time'])?$item['time']:"";?></td>
					<td><?php echo isset($item['pname'])?$item['pname']:"";?></td>
					<td><?php $query = new IQuery("freight_company");$query->where = "id = $item[freight_id]";$items = $query->find(); foreach($items as $key => $tempFreight){?><?php echo isset($tempFreight['freight_name'])?$tempFreight['freight_name']:"";?><?php }?></td>
					<td><?php echo isset($item['delivery_code'])?$item['delivery_code']:"";?></td>
					<td><?php echo isset($item['name'])?$item['name']:"";?></td>
					<td><?php echo isset($item['note'])?$item['note']:"";?></td>
				</tr>
				<?php }?>
			</tbody>
		</table>
	</div>
</div>

<div id="tab-4" name="table" style="display:none">
	<div class="content">
		<div class="content form_content">
		<form name="ModelForm" action="<?php echo IUrl::creatUrl("/order/order_note");?>" method="post">
			<input type="hidden" name="order_id" value="<?php echo isset($order_id)?$order_id:"";?>"/>
			<input type="hidden" name="tab" value="6"/>
			<table class="form_table">
				<col width="150px" />
				<col />
				<tbody>
					<tr>
						<th>订单备注:</th>
						<td align="left"><textarea name="note" id="note" rows="8" cols="100"><?php echo isset($note)?$note:"";?></textarea></td>
					</tr>
					<tr>
						<td></td>
						<td align="left"><button type="submit" class="submit"><span>保存</span></button></td>
					</tr>
				</tbody>
			</table>
		</form>
		</div>
	</div>
</div>

<div id="tab-5" name="table" style="display:none">
	<div class="content">
		<table class="border_table" style='width:98%'>
			<colgroup>
				<col width="200px">
				<col width="150px">
				<col width="150px">
				<col width="100px">
				<col />
			</colgroup>
			<thead>
				<tr>
					<th>时间</th>
					<th>操作人</th>
					<th>动作</th>
					<th>结果</th>
					<th>备注</th>
				</tr>
			</thead>
			<tbody>
				<?php $query = new IQuery("order_log as ol");$query->where = "ol.order_id = $order_id";$items = $query->find(); foreach($items as $key => $item){?>
				<tr>
					<td><?php echo isset($item['addtime'])?$item['addtime']:"";?></td>
					<td><?php echo isset($item['user'])?$item['user']:"";?></td>
					<td><?php echo isset($item['action'])?$item['action']:"";?></td>
					<td><?php echo isset($item['result'])?$item['result']:"";?></td>
					<td><?php echo isset($item['note'])?$item['note']:"";?></td>
				</tr>
				<?php }?>
			</tbody>
		</table>
	</div>
</div>

<div id="tab-6" name="table" style="display:none">
	<div class="content">
		<div class="content form_content">
			<table class="form_table">
				<col width="150px" />
				<col />
				<tbody>
					<tr>
						<th>订单附言:</th>
						<td align="left"><?php echo isset($postscript)?$postscript:"";?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="pages_bar">
	<div class="t_c" id="ctrlButtonArea">
		<button type="button" class="submit" id="to_pay" onclick="pay(<?php echo isset($order_id)?$order_id:"";?>);"><span>支付</span></button>
		<button type="button" class="submit" id="to_confirm" onclick="confirm(<?php echo isset($order_id)?$order_id:"";?>);"><span>确认付款</span></button>
		<button type="button" class="submit" id="to_deliver" onclick="deliver(<?php echo isset($order_id)?$order_id:"";?>);" style="display: none;"><span>发货</span></button>
		<button type="button" class="submit" id="to_refundment" onclick="refundment(<?php echo isset($order_id)?$order_id:"";?>);"><span>退款</span></button>
		<button type="button" class="submit" id="to_finish" onclick="complete(<?php echo isset($order_id)?$order_id:"";?>,5)"><span>完成</span></button>
		<button type="button" class="submit" id="to_cancel" onclick="complete(<?php echo isset($order_id)?$order_id:"";?>,4)"><span>作废</span></button>
	</div>
</div>

<script type='text/javascript'>
//DOM加载完毕后运行
$(function()
{
	selectTab(1);
	initButton();
});

// 验证码发货
function deliver_with_verifi( _order_id, _goods_id )
{
	art.dialog("请输入该课程的验证码：<input type='text' class='normal small' name='verification_code' id='verification_code' value='' style='height: 25px; line-height: 25px;' />&nbsp; &nbsp; <input type='button' id='deliver' value='发货' style='background-color:#ff5500; color: #fff;text-shadow: 0;width: 50px; border: 0px;height: 25px; line-height: 25px;cursor: pointer;border-radius: 3px;'/>");
	$('#deliver').click(function(){
		var _verification_code = $('#verification_code').val();
		if ( _verification_code == "")
		{
			alert("请输入验证码");
		} else {
			var _tempUrl = "/order/order_delivery_doc_ajax/id/" + _order_id + '/sendgoods/' + _goods_id + '/verification_code/' + _verification_code;
			$.get( _tempUrl, function(data){
				if ( data == '1')
					window.location.reload();
				else
					alert( data );
			})
		}
	})
}

// 普通发货
function delivers( _order_id, _goods_id )
{
	art.dialog({
		content: '您确认要使用此课程吗？',
		ok:function() {
			var _tempUrl = "/order/order_delivery_doc_ajax/id/" + _order_id + '/sendgoods/' + _goods_id;
			$.get( _tempUrl, function(data){
				if ( data == '1')
					window.location.reload();
				else
					alert( data );
			})
		},
		cancelVal:'取消',
		cancel: true,
	})
}

// 确认订单
function confirm( _order_id )
{
	art.dialog({
		content: '您确定要确认付款吗？',
		ok:function() {
			var _tempUrl = "/order/order_confirm_ajax/id/" + _order_id;
			$.get( _tempUrl, function(data){
				if ( data == '1')
					window.location.reload();
				else {
					if ( data == '-1')
						alert('该订单不存在');
					else
						alert('操作失败');
				}
			})
		},
		cancelVal:'取消',
		cancel: true,
	})
}

/**
 * 订单操作按钮初始化
 */
function initButton()
{
	//全部操作区域的按钮锁定
	$('#ctrlButtonArea button').attr('disabled','disabled');
	$('#ctrlButtonArea button').addClass('inactive');

	//作废
	//$('#to_cancel').removeAttr('disabled');
	//$('#to_cancel').removeClass('inactive');

	//完成
	<?php if(in_array($orderStatus,array(11,3)) || order_class::getOrderStatus( $orderRow ) == 4){?>
	$('#to_finish').removeAttr('disabled');
	$('#to_finish').removeClass('inactive');
	<?php }?>

	//付款
	<?php if(in_array($orderStatus,array(11,2))){?>
	$('#to_pay').removeAttr('disabled');
	$('#to_pay').removeClass('inactive');
	<?php }?>

	//发货
	<?php if(in_array($orderStatus,array(1,4,8,9))){?>
	$('#to_deliver').removeAttr('disabled');
	$('#to_deliver').removeClass('inactive');
	<?php }?>

	//退款
	<?php if(Order_Class::isRefundmentApply($orderRow)){?>
	$('#to_refundment').removeAttr('disabled');
	$('#to_refundment').removeClass('inactive');
	<?php }?>

	// 确认订单
	<?php if(order_class::getOrderStatus( $orderRow ) == 13){?>
	$('#to_confirm').removeAttr('disabled');
	$('#to_confirm').removeClass('inactive');
	<?php }?>
}

//选择当前Tab
function selectTab(curr_tab)
{
	$("div[name='table']").hide();
	$("#tab-"+curr_tab).show();
	$("ul[name=menu1] > li").removeClass('selected');
	$('#li_'+curr_tab).addClass('selected');
}

//完成或作废订单
function complete(id,statusVal)
{
	$.get("<?php echo IUrl::creatUrl("/order/order_complete");?>",{'order_no':"<?php echo isset($order_no)?$order_no:"";?>",'type':statusVal,'id':id}, function(data)
	{
		if(data=='success')
		{
			actionCallback();
		}
		else
		{
			alert('发生错误');
		}
	});
}

//退款
function refundment(id)
{
	<?php if($statement == 2){?>
	var _title = '订单号:<?php echo isset($order_no)?$order_no:"";?>【退还代金券到账户】';
	<?php }else{?>
	var _title = '订单号:<?php echo isset($order_no)?$order_no:"";?>【退款到余额账户】';
	<?php }?>
	var tempUrl = '<?php echo IUrl::creatUrl("/order/order_refundment/id/@id@");?>';
	tempUrl     = tempUrl.replace('@id@',id);
	art.dialog.open(tempUrl,{
		id:'refundment',
		cancelVal:'关闭',
		okVal:'退款',
	    title: _title,
	    ok:function(iframeWin, topWin){
	    	iframeWin.document.forms[0].submit();
	    	return false;
	    },
	    cancel:function(){
	    	return true;
		}
	});
}

//付款
function pay(id)
{
	var tempUrl = '<?php echo IUrl::creatUrl("/order/order_collection/id/@id@");?>';
	tempUrl     = tempUrl.replace('@id@',id);

	art.dialog.open(tempUrl,{
		id:'pay',
	    title: '订单号:<?php echo isset($order_no)?$order_no:"";?>【付款】',
	    cancelVal:'关闭',
		okVal:'付款',
	    ok:function(iframeWin, topWin){
			iframeWin.document.forms[0].submit();
			return false;
	    },
	    cancel:function (){
	    	return true;
		}
	});
}

//发货
function deliver(id)
{
	var tempUrl = '<?php echo IUrl::creatUrl("/order/order_deliver/id/@id@");?>';
	tempUrl     = tempUrl.replace('@id@',id);

	var deliv = art.dialog.open(tempUrl,{
		id:'deliver',
	    title: '订单号:<?php echo isset($order_no)?$order_no:"";?>【发货】',
	    cancelVal:'关闭',
		okVal:'发货',
	    ok:function(iframeWin, topWin){
	    	var checkedNums = $(iframeWin.document).find('[name="sendgoods[]"]:checked').length;
	    	if(checkedNums == 0)
	    	{
	    		alert('请选择要发货的课程');
	    		return false;
	    	}
	    	var isResult = iframeWin.document.forms[0].onsubmit();
	    	if(isResult != false)
	    	{
	    		iframeWin.document.forms[0].submit();
	    	}
	    	return false;
	    },
	    cancel:function (){
	    	return true;
		}
	});
}

//执行回调处理
function actionCallback(msg)
{
	msg ? alert(msg) : window.location.reload();
	window.setTimeout(function()
	{
		var list = art.dialog.list;
		for (var i in list)
		{
		    list[i].close();
		};
	},2500);
}

//操作失败回调
function actionFailCallback(msg)
{
	var alertText = msg ? msg : '操作失败';
	alert(alertText);
}

//快递跟踪
function freightLine(doc_id)
{
	var urlVal = "<?php echo IUrl::creatUrl("/block/freight/id/@id@");?>";
	urlVal = urlVal.replace("@id@",doc_id);
	art.dialog.open(urlVal,{title:'轨迹查询'});
}
</script>

		</div>
	</div>

	<script type='text/javascript'>
	//隔行换色
	$(".list_table tr:nth-child(even)").addClass('even');
	$(".list_table tr").hover(
		function () {
			$(this).addClass("sel");
		},
		function () {
			$(this).removeClass("sel");
		}
	);

	//按钮高亮
	var topItem  = "<?php echo key($leftMenu);?>";
	$("ul[name='topMenu']>li:contains('"+topItem+"')").addClass("selected");

	var leftItem = "<?php echo IUrl::getUri();?>";
	$("ul[name='leftMenu']>li a[href^='"+leftItem+"']").parent().addClass("selected");
	</script>
</body>
</html>
