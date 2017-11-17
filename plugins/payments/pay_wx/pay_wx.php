<?php

ini_set("date.timezone","Asia/Shanghai");
require_once "lib/WxPay.Api.php";
require_once "WxPay.JsApiPay.php";
$tools = new JsApiPay();

$openId = $tools->GetOpenid();
// if(file_exists("/www/web/lelele999/public_html/./source/plugin/it618_credits/pay_wx/ajax3.php")&&isset($_GET['code'])){
	// $result=unlink("/www/web/lelele999/public_html/./source/plugin/it618_credits/pay_wx/ajax3.php");
// }

$input = new WxPayUnifiedOrder();
$input->SetBody("第三课");
$input->SetAttach($_GET["type"]);
$input->SetOut_trade_no($_GET["trade_no"]);
$input->SetTotal_fee($_GET["real_amount"]);
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag("第三课");
$input->SetNotify_url('http://dsanke.com/plugins/payments/pay_wx/notify_mlm.php');
$input->SetTrade_type("JSAPI");
$input->SetOpenid($openId);
$order = WxPayApi::unifiedOrder($input);
$jsApiParameters = $tools->GetJsApiParameters($order);

?>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/> 
    <title>第三课</title>
    <script type="text/javascript">

	function jsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			<?php echo $jsApiParameters; ?>,
			function(res){
				//WeixinJSBridge.log(res.err_msg);
				//alert(res.err_code+res.err_desc+res.err_msg);
				location.href='http://www.dsanke.com';
			}
		);
	}

	function callpay()
	{
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
		        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		    }
		}else{
		    jsApiCall();
		}
	}
	
	callpay();
	</script>
<!-- dsanke.com Baidu tongji analytics -->
<script>
var _hmt = _hmt || [];
(function() {
var hm = document.createElement("script");
hm.src = "//hm.baidu.com/hm.js?66b57dd0f5dae4ae1fac8884feef8d10";
var s = document.getElementsByTagName("script")[0];
s.parentNode.insertBefore(hm, s);
})();
</script>
</head>
</html>
