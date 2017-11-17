<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>管理后台</title>
	<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/admin.css";?>" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/jquery/jquery-1.12.4.min.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/artdialog/skins/aero.css" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/form/form.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/autovalidate/style.css" />
	<script type='text/javascript' src="<?php echo $this->getWebViewPath()."javascript/admin.js";?>"></script>
</head>

<body style="width:600px;min-height:400px;overflow-y:hidden;">
<div class="pop_win">
	<form action="<?php echo IUrl::creatUrl("/order/order_refundment_doc");?>" method="post">
		<input type="hidden" name="refunds_id" value="<?php echo isset($refunds['id'])?$refunds['id']:"";?>"/>
		<input type="hidden" name="id" value="<?php echo isset($order_id)?$order_id:"";?>"/>
		<input type="hidden" name="order_no" value="<?php echo isset($order_no)?$order_no:"";?>"/>
		<input type="hidden" name="user_id" value="<?php echo isset($user_id)?$user_id:"";?>"/>

		<table width="95%" class="border_table" style="margin:10px auto">
			<colgroup>
				<col width="100px" />
				<col />
			</colgroup>

			<tbody>
				<tr>
					<th>订单号:</th><td align="left"><?php echo isset($order_no)?$order_no:"";?></td>
				</tr>
				<tr>
					<th>下单时间:</th><td align="left"><?php echo isset($create_time)?$create_time:"";?></td>
				</tr>
				<tr>
					<th>订单商品应付金额:</th>
					<td align="left">￥<?php echo isset($payable_amount)?$payable_amount:"";?></td>
				</tr>
				<tr>
					<th>订单商品实付金额:</th>
					<td align="left">￥<?php echo isset($real_amount)?$real_amount:"";?></td>
				</tr>
				<tr>
					<th>订单运费应付金额:</th>
					<td align="left">￥<?php echo isset($payable_freight)?$payable_freight:"";?></td>
				</tr>
				<tr>
					<th>订单运费实付金额:</th>
					<td align="left">￥<?php echo isset($real_freight)?$real_freight:"";?></td>
				</tr>

				<tr>
					<th>订单保价金额:</th>
					<td align="left">￥<?php echo isset($insured)?$insured:"";?></td>
				</tr>

				<?php if($pay_fee > 0){?>
				<tr>
					<th>订单支付手续费金额:</th>
					<td align="left">￥<?php echo isset($pay_fee)?$pay_fee:"";?></td>
				</tr>
				<?php }?>

				<?php if($invoice == 1){?>
				<tr>
					<th>订单税金金额:</th>
					<td align="left">￥<?php echo isset($taxes)?$taxes:"";?></td>
				</tr>
				<?php }?>

				<?php if($promotions > 0){?>
				<tr>
					<th>订单促销活动优惠金额:</th>
					<td align="left">￥<?php echo isset($promotions)?$promotions:"";?></td>
				</tr>
				<?php }?>

				<?php if($discount != 0){?>
				<tr>
					<th>订单价格修改:</th>
					<td align="left">￥<?php echo isset($discount)?$discount:"";?></td>
				</tr>
				<?php }?>

				<tr>
					<th>订单总额:</th>
					<td align="left">￥<?php echo isset($order_amount)?$order_amount:"";?></td>
				</tr>

				<?php $refundRowCount = CountSum::countSellerOrderFee(array($this->data))?>
				<tr>
					<th>订单已退金额:</th>
					<td align="left">￥<?php echo isset($refundRowCount['refundFee'])?$refundRowCount['refundFee']:"";?></td>
				</tr>

				<tr>
					<th>退款商品:</th>
					<td align="left">
					<?php if(isset($refunds)){?>
						<?php $query = new IQuery("order_goods");$query->where = "id in ( $refunds[order_goods_id] )";$items = $query->find(); foreach($items as $key => $item){?>
						<?php $goods = JSON::decode($item['goods_array'])?>
						<?php echo isset($goods['name'])?$goods['name']:"";?> X <?php echo isset($item['goods_nums'])?$item['goods_nums']:"";?>件
						<span class="green">【<?php echo Order_Class::goodsSendStatus($item['is_send']);?>】</span>
						<span class="red">【商品金额：￥<?php echo $item['goods_nums']*$item['real_price'];?>】</span>
						<?php if($refunds['seller_id']){?>
						<a href="<?php echo IUrl::creatUrl("/site/home/id/".$refunds['seller_id']."");?>" target="_blank"><img src="<?php echo $this->getWebSkinPath()."images/admin/seller_ico.png";?>" /></a>
						<?php }?>
						<br />
						<?php }?>
					<?php }else{?>
						<?php foreach(Api::run('getOrderGoodsListByGoodsid',array('#order_id#',$order_id)) as $key => $good){?>
						<?php $good_info = JSON::decode($good['goods_array'])?>
						<?php if($good['is_send'] != 2){?>
						<label>
							<input type="checkbox" name="order_goods_id[]" value="<?php echo isset($good['id'])?$good['id']:"";?>" />
							<a class="blue" href="<?php echo IUrl::creatUrl("/site/products/id/".$good['goods_id']."");?>" target='_blank'><?php echo isset($good_info['name'])?$good_info['name']:"";?><?php if($good_info['value']){?><?php echo isset($good_info['value'])?$good_info['value']:"";?><?php }?> X <?php echo isset($good['goods_nums'])?$good['goods_nums']:"";?>【￥<?php echo $good['real_price']*$good['goods_nums'];?>】</a>
						</label>
						<br />
						<?php }?>
						<?php }?>
					<?php }?>
					</td>
				</tr>
				<tr>
					<th>退款金额流向:</th>
					<td align="left">
						<select name="way">
							<option value="balance" selected="selected">退款到用户余额【默认】</option>
							<option value="other">已通过其他方式退款</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>退款金额:</th>
					<td align="left">
						<label><input type="radio" name="isAuto" onclick="closeCustom();" checked="checked" />自动计算【默认】</label>
						<label>
							<input type="radio" name="isAuto" onclick="openCustom();" />手动填写
							<input type="text" class="small" name="amount" pattern="float" empty disabled="disabled" />
						</label>
					</td>
				</tr>
				<tr>
					<th>说明:</th>
					<td align="left">点击退款后，<退款商品的金额>将直接转入用户的网站余额中，如果订单中所有商品均在未发货的情况下全部退款，那么系统将返还运费等</td>
				</tr>
			</tbody>
		</table>
	</form>
</div>
<script type="text/javascript">
function openCustom()
{
	$('[name="amount"]').prop('disabled',false);
}

function closeCustom()
{
	$('[name="amount"]').prop('disabled',true);
	$('[name="amount"]').val('');
}
</script>
</body>
</html>