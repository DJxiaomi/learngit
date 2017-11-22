<?php  $title = '在线充值';?>
<link href="<?php echo $this->getWebSkinPath()."css/ucenter.css";?>" rel="stylesheet" type="text/css" />

<div class="rechargebox">
  <h3 class="rechargebt">在线充值</h3>
  <div class="rechargenrbox">
     <div class="rechargexzbox clearfix w-bg">
     <p class="paywaybt">请选择充值方式</p>
     <form action='<?php echo IUrl::creatUrl("/block/doPay");?>' method='post'>
     <?php $paymentList=Api::run('getPaymentListByOnline')?>
     <?php if(!empty($paymentList)){?>
		<?php foreach($paymentList as $key => $item){?>
        <p><label class='f14 cf6'><input class="radio" name="payment_id" title="<?php echo isset($item['name'])?$item['name']:"";?>" type="radio" value="<?php echo isset($item['id'])?$item['id']:"";?>" /><?php echo isset($item['name'])?$item['name']:"";?></label>
						<?php echo isset($item['note'])?$item['note']:"";?><span class="f12 orange">，手续费：<?php if($item['poundage_type']==2){?>￥<?php echo isset($item['poundage'])?$item['poundage']:"";?><?php }else{?><?php echo isset($item['poundage'])?$item['poundage']:"";?>%<?php }?></span></p>

        <?php }?>
	  <?php }else{?>
		没有线上支付方式
	  <?php }?>

     </div>

     <div class="rechargejebox w-bg">
        <p class="paywaybt">充值金额</p>
        <div class="paytextbox">
        <p><input type='text' class="paywayip" name="recharge" placeholder="请输入充值的金额" /></p></div>
        <label class="paybtn"><input class="paybut bg-blue" type="submit" value="确定充值" onclick='return check_form();' /></label>
     </div>
     </form>
  </div>
</div>


<script type='text/javascript'>

	function check_form()
	{
		if($('[name="payment_id"]:checked').length == 0)
		{
			alert('请选择支付方式');
			return false;
		}

		if($('[name="recharge"]').val() <= 0)
		{
			alert('要充值的金额必须大于0元');
			return false;
		}
	}
</script>
