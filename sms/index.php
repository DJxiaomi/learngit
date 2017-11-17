<?php 

header("Content-type:text/html;charset=utf-8");
//include 'smsapi.class.php';
include 'smsapi.fun.php';

//接口账号
$uid = 'lelele999';

//登录密码
$pwd = 'hnlxshmm';

/**
 * 实例化接口
 *
 * @param string $uid 接口账号
 * @param string $pwd 接口密码
 */

/*
 * 变量模板发送示例
 * 模板内容：您的验证码是：{$code}，对用户{$username}操作绑定手机号，有效期为5分钟。如非本人操作，可不用理会。【云信】
 * 变量模板ID：100003
 */
 

//发送的手机 多个号码用,英文逗号隔开

$mobile = '17707413901,18373337995,15080701933';

//短信内容参数
$content = '这是测试短信【乐享生活】';

//发送变量模板短信
$res = sendSMS($uid,$pwd,$mobile,$content);

if($res['stat']=='100')
{
    echo '发送成功';
}
else
{
    echo '发送失败:'.$res['stat'].'('.$res['message'].')';
}
?>