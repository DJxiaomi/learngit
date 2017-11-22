<?php 

$http = 'http://api.sms.cn/mt/';		  //短信接口
$uid = 'lelele999';						  //用户账号
$pwd = 'hnlxshmm';						  //密码
$mobile	 = '17707413901';	              //号码
$mobileids	 = '';	                      //号码唯一编号
$mobile_code = '147852';
$content = '您好，您正在申请修改学校账户密码，验证码为：' . $mobile_code . '。此验证码的有效时间为5分钟，请按时提交。【乐享生活】';		//内容

function sendSMS($mobile,$content,$mobileids='',$time='',$mid='')
{
    global $http, $uid, $pwd;
    $http=$http;
    $uid=$uid;
    $pwd=$pwd;
    $data = array
    (
        'uid'=>$uid, //用户账号
        'pwd'=>md5($pwd.$uid), //MD5位32密码,密码和用户名拼接字符
        'mobile'=>$mobile, //号码
        'content'=>$content, //内容
        'mobileids'=>$mobileids,
        'time'=>$time, //定时发送
        'encode'=>'utf8', //定时发送
    );
    $re= postSMS($http,$data); //POST方式提交
    return $re;
}

function postSMS($url,$data='')
{
    $port="";
    $post="";
    $row = parse_url($url);
    $host = $row['host'];
    $port = isset($row['port']) ? $row['port']:80;
    $file = $row['path'];
    while (list($k,$v) = each($data))
    {
        $post .= rawurlencode($k)."=".rawurlencode($v)."&"; //转URL标准码
    }
    $post = substr( $post , 0 , -1 );
    $len = strlen($post);
    $fp = @fsockopen( $host ,$port, $errno, $errstr, 10);
    if (!$fp) {
        return "$errstr ($errno)\n";
    } else {
        $receive = '';
        $out = "POST $file HTTP/1.1\r\n";
        $out .= "Host: $host\r\n";
        $out .= "Content-type: application/x-www-form-urlencoded\r\n";
        $out .= "Connection: Close\r\n";
        $out .= "Content-Length: $len\r\n\r\n";
        $out .= $post;
        fwrite($fp, $out);
        while (!feof($fp)) {
            $receive .= fgets($fp, 128);
        }
        fclose($fp);
        $receive = explode("\r\n\r\n",$receive);
        unset($receive[0]);
        return implode("",$receive);
    }
}

$result = sendSMS($mobile,$content);
var_dump( $result );
echo 'ok!';

?>