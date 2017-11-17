<?php

class wechat_class
{
	public $token = '';
	public $appid = '';
	public $appSecret = '';

	public function __construct()
	{
        $this->valid();        
        $this->responseMsg();        

    }

    /**
     *  初次校验
     */
    public function valid()
    {
        $echoStr = $_GET["echostr"];

        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

    /**
	 * 返回信息
	 * @return [type] [description]
	 */
    public function responseMsg(){
        $postStr = $GLOBALS['HTTP_RAW_POST_DATA'];      
        $postObj = simplexml_load_string($postStr,'SimpleXMLElement',LIBXML_NOCDATA);

        if(trim($postObj->Content) == 'tw'){
            $arr = array(
                array(
                    'title' => '标题',
                    'description' => '内容',
                    'picurl' => 'https://www.baidu.com/img/bd_logo1.png',
                    'url' => ""
                ),
                array(
                    'title' => '标题',
                    'description' => '内容',
                    'picurl' => 'https://www.baidu.com/img/bd_logo1.png',
                    'url' => ""
                )
            );
        
            $this->responseNews($postObj,$arr);

        }else{
            $content = '欢迎关注！';
            $this->responseText($postObj,$content);
        }         
    }


    /**
     * 网页授权 ---- 待修改
     * @param  [type] $scope [description]
     * @param  [type] $state [description]
     * @param  [type] $id    [description]
     * @param  [type] $uid   [description]
     * @return [type]        [description]
     */
    public function authorized($jump_url,$scope,$state){
        $appid = $this->appid;

        $redirect_uri = urlencode($jump_url);

        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".$redirect_uri."&response_type=code&scope=".$scope."&state=".$state."#wechat_redirect";
        header('Location:'.$url);
    }

    /**
     *  校验签名
     */
    private function checkSignature()
	{
               
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		$token = $this->token;
		$tmpArr = array($token, $timestamp, $nonce);
        
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}


	

    /**
     * 纯文本回复
     * @param  Object $postObj xml对象
     * @param  String $content 回复文本
     * @return String          回复拼装格式文本
     */
	private function responseText($postObj,$content){
		$fromUserName = $postObj->FromUserName;
		$toUserName = $postObj->ToUserName;
		$time = time();
		$msgType = 'text';
        $tpl = "<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[%s]]></MsgType>
                <Content><![CDATA[%s]]></Content>
                <MsgId>0</MsgId>
                </xml>";        
		
		$str = sprintf($tpl,$fromUserName,$toUserName,$time,$msgType,$content);
        // echo $str;
		return $str;
	}

	/**
	 * 回复图文
	 * @param  Object $postObj xml对象
	 * @param  Array  $arr     回复内容数组
	 * @return String          回复拼装格式文本
	 */
	private function responseNews($postObj,$arr){
		$fromUserName = $postObj->FromUserName;
		$toUserName = $postObj->ToUserName;
		$time = time();
		$msgType = 'news';
		$num = count($arr);
        $tpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[%s]]></MsgType>
                    <ArticleCount>".$num."</ArticleCount>
                    <Articles>";
        foreach($arr as $v){
        	$tpl.= "<item>
                <Title><![CDATA[".$v['title']."]]></Title> 
                <Description><![CDATA[".$v['description']."]]></Description>
                <PicUrl><![CDATA[".$v['picurl']."]]></PicUrl>
                <Url><![CDATA[".$v['url']."]]></Url>
                </item>";
        }        
        $tpl.= "</Articles>
                </xml>";
		
		$str = sprintf($tpl,$fromUserName,$toUserName,$time,$msgType);
        // echo $str;
		return $str;
	}

	/**
	 * 刷新access_token
	 * @param  [type] $_accessToken  [description]
	 * @param  [type] $_openid       [description]
	 * @param  [type] $_refreshToken [description]
	 * @return [type]                [description]
	 */
    public function refreshToken($_accessToken,$_openid,$_refreshToken){        
        /*if(empty($_accessToken) || empty($_openid) || empty($_refreshToken)){
            return false;
        }*/
        //检验access_token是否有效
        $url = "https://api.weixin.qq.com/sns/auth?access_token=".$_accessToken."&openid=".$_openid;
        $checkArr = $this->http_curl($url);

        //刷新access_token
        $appid = $this->appid;
        if($checkArr['errmsg'] != "ok"){
            $url = "https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=".$appid."&grant_type=refresh_token&refresh_token=".$_refreshToken;
            $result = $this->http_curl($url);
            return $result;
        }else{
            return 1;
        }
    }

    /**
     * 获取openid
     * @param  [type] $code [description]
     * @return [type]       [description]
     */
    public function getOpenid($code){
        if(empty($code)){
            return false;
        }
        $appid = $this->appid;
        $appSecret = $this->appSecret;
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$appSecret."&code=".$code."&grant_type=authorization_code";

        $result = $this->http_curl($url);
        return $result;
    }

    /**
     * 分解getUserInfo
     * @param  [type] $_accessToken [description]
     * @param  [type] $_openid      [description]
     * @return [type]               [description]
     */
    public function getUser($_accessToken,$_openid){        
        if(empty($_accessToken) || empty($_openid)){
            return false;
        }
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$_accessToken."&openid=".$_openid."&lang=zh_CN";        
        $result = $this->http_curl($url);
        return $result;
    }

    /**
     * curl处理
     * @param  [type] $url [description]
     * @return [type]      [description]
     */
    public function http_curl($url){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        $res = curl_exec($ch);
        curl_close($ch);
        return json_decode($res,true);
    }

    /**
     * 分享给朋友
     * @param  String $url 分享链接
     * @return Array       返回分享参数
     */
    public function shareMsg($url){
        $appid = $this->appid;
        $timestamp = time();
        $noncestr = $this->getRandChar();
        $jsapi_ticket = $this->getJsapiTicket();
        $str = 'jsapi_ticket='.$jsapi_ticket.'&noncestr='.$noncestr.'&timestamp='.$timestamp.'&url='.$url;
        $signature = sha1($str);
        return array(
            'appid' => $appid,
            'timestamp' => $timestamp,
            'noncestr' => $noncestr,
            'signature' => $signature
        );
    }

    
    /**
     * 获取全局access_token
     * @return String 全局access_token
     */
    public function getAccessToken(){
        if($_SESSION['access_token'] && time() < $_SESSION['access_token_expires_time']){
            $access_token = $_SESSION['access_token'];
        }else{
            $appid = $this->appid;
            $appsecret = $this->appSecret;
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;        
            $res = $this->http_curl($url);
            $_SESSION['access_token'] = $access_token = $res['access_token'];
            $_SESSION['access_token_expires_time'] = time() + 7200;
        }        
        return $access_token;
    }

    
    /**
     * 获取jsapi_ticket临时票据
     * @return String jsapi_ticket临时票据
     */
    public function getJsapiTicket(){
        if($_SESSION['jsapi_ticket'] && time() < $_SESSION['jsapi_ticket_expires_time']){
            $jsapi_ticket = $_SESSION['jsapi_ticket'];
        }else{
            $access_token = $this->getAccessToken();
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$access_token."&type=jsapi";
            $res = $this->http_curl($url);

            if($res['errmsg'] == 'ok'){
                $_SESSION['jsapi_ticket'] = $jsapi_ticket = $res['ticket'];
                $_SESSION['jsapi_ticket_expires_time'] = time() + 7200;
            }
        }
        return $jsapi_ticket;
    }


    /**
     * 生成*位随机字符串，默认16位，包含大小写字母及数字
     * @param  integer $length 字符串长度
     * @return String          随机字符串
     */
    function getRandChar($length=16){
        $strPool = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        $max = strlen($strPool)-1;
        $tmpStr = '';
        for($i=0;$i < $length;$i++){
            $tmpStr .= $strPool[rand(0,$max)];
        }
        return $tmpStr;
    }

    
}

?>