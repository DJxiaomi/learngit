<?php
$ordersn = $this->getParam('ordersn');
$order = C::M('Eatorder')->getOrderByOrderSn($ordersn);
include ROOT . "WxPayPubHelper"."/WxPayPubHelper.php";
$unifiedOrder = new UnifiedOrder_pub();
$unifiedOrder->setParameter("body","订餐支付");//商品描述
//自定义订单号，此处仅作举例
$timeStamp = time();
$out_trade_no = $ordersn;
$money = $order['amount'] * 100;
$unifiedOrder->setParameter("out_trade_no","$out_trade_no");//商户订单号 
$unifiedOrder->setParameter("total_fee",$money);//总金额
$unifiedOrder->setParameter("notify_url","http://www.dsanke.com/block/wxcallback");//通知地址 
$unifiedOrder->setParameter("trade_type","NATIVE");//交易类型
$unifiedOrderResult = $unifiedOrder->getResult();
if ($unifiedOrderResult["return_code"] == "FAIL") 
{
	//商户自行增加处理流程
	echo "通信出错：".$unifiedOrderResult['return_msg']."<br>";
}
elseif($unifiedOrderResult["result_code"] == "FAIL")
{
	//商户自行增加处理流程
	echo "错误代码：".$unifiedOrderResult['err_code']."<br>";
	echo "错误代码描述：".$unifiedOrderResult['err_code_des']."<br>";
}
elseif($unifiedOrderResult["code_url"] != NULL)
{
	//从统一支付接口获取到code_url
	$code_url = $unifiedOrderResult["code_url"];
}
$this->assign('ordersn', $ordersn);
$this->assign('codeurl', $code_url);


//notify
include ROOT . "WxPayPubHelper"."/WxPayPubHelper.php";
include ROOT . "WxPayPubHelper"."/log_.php";
$notify = new Notify_pub();

//存储微信的回调
$xml = $GLOBALS['HTTP_RAW_POST_DATA'];
$notify->saveData($xml);
if($notify->checkSign() == FALSE){
	$notify->setReturnParameter("return_code","FAIL");//返回状态码
	$notify->setReturnParameter("return_msg","签名失败");//返回信息
}else{
	$notify->setReturnParameter("return_code","SUCCESS");//设置返回码
}

if($notify->checkSign() == TRUE)
{
	if ($notify->data["return_code"] == "SUCCESS")
	{
		$out_trade_no = $notify->data["out_trade_no"];
		$order = C::M('Eatorder')->getOrderByOrderSn($out_trade_no);
		if(!$order['id'])
			exit;
		if($order['paystatus'] == 1)
			exit;
		$data = array(
			'ordersn' => $out_trade_no,
			'paystatus' => 1
		);
		
		C::M('Eatorder')->updateByOrderSn($data);
	}
}
?>
<div class="block clearfix">
	<div id="qrcode" style="margin:0 auto; width:150px; height:150px;" />
</div>
<script src="/resource/js/qrcode.js"></script>
<script type="text/javascript">
	var url = "<!--{$codeurl}-->";
	//参数1表示图像大小，取值范围1-10；参数2表示质量，取值范围'L','M','Q','H'
	var qr = qrcode(10, 'M');
	qr.addData(url);
	qr.make();
	var wording=document.createElement('p');
	wording.innerHTML = "扫我，扫我";
	var code=document.createElement('DIV');
	code.innerHTML = qr.createImgTag();
	var element=document.getElementById("qrcode");
	//element.appendChild(wording);
	element.appendChild(code);
	
	$(function(){
		setInterval("checkOrder()", 1000);   
	});
	
	function checkOrder(){
		$.getJSON(SITE_URL + 'card/check', {'ordersn': '<!--{$ordersn}-->'}, function(json){
			if(json.msg == 1){
				window.location.href = SITE_URL + 'card/success';
			}
		});
	}
</script>