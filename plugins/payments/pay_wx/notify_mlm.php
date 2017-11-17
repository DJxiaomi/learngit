<?php
ini_set('date.timezone','Asia/Shanghai');
error_reporting(E_ERROR);

require_once "lib/WxPay.Api.php";
require_once 'lib/WxPay.Notify.php';


//��¼��־
$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
// logger($postStr);
$res = @simplexml_load_string($postStr,NULL,LIBXML_NOCDATA);
$res = json_decode(json_encode($res),true);
// foreach ($res as $key=>$value)  
// {
    // logger("Key: $key; Value: $value");
// }

//��֤ǩ��
//�������سɹ�����֤ǩ��
logger("��ʼ��֤");
if(!array_key_exists("transaction_id", $res)){
	$msg="������������ȷ";
	logger($msg);
	exit;
}
logger("transaction_id��֤ͨ��");
if($res["return_code"]=="SUCCESS" && $res["result_code"]=="SUCCESS" ){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://www.dsanke.com/index.php?controller=zesheng&action=wxpay_success&order_no=".$res['out_trade_no']."&type=".$res['attach']);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	$msg=curl_exec($ch);
	curl_close($ch);
	logger($res['out_trade_no'].$res['attach']."�ɹ�");
	echo $msg;
	exit;
}
















//��־��¼
function logger($log_content)
{
    $max_size = 100000;
    $log_filename = "log.xml";
    if(file_exists($log_filename) and (abs(filesize($log_filename)) > $max_size)){unlink($log_filename);}
    file_put_contents($log_filename, date('H:i:s')." ".$log_content."\r\n", FILE_APPEND);
}
?>