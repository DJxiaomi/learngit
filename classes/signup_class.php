<?php 
class signup_class
{


    public static function quick_signup()
    {
        $code = $_GET['code'];
        $promote = IFilter::act(IReq::get('promote'));

        //微信快捷登陆
        $wechat = new wechat_class();
        $wechat->token = 'y53na1qnxJ6o1qj1';
        $wechat->appid = 'wx72fc7befef40f55a';
        $wechat->appSecret = '8446dfd26a915aa506567d436ac9db52';
        
        $wechat->valid();

        if(empty($code)){     

            $wechat->authorized('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],'snsapi_userinfo','base');
            exit();
        }
       

        $openInfo = $wechat->getOpenid($code);

        if($openInfo['errcode'] != ''){          
            die("<script>location.href='http://".$_SERVER['HTTP_HOST']."';</script>");
            
        }
        
        $member_db = new IModel('member');
        $member_info = $member_db->getObj('openid="'.$openInfo['openid'].'" and openid != ""');
        
        //dump($_SERVER);
                
        if($member_info){
            $user_id = $member_info['user_id'];
        }else{
            
            $info = $wechat->getUser($openInfo['access_token'],$openInfo['openid']);

            if(!$info){
                die("<script>alert('获取信息失败，请关闭当前页面重新进入！');</script>");
            }
            
            $user_db = new IQuery('user');
            $name = self::filterEmoji($info['nickname']);
            $user_db->where = "username = '$name'";
            $result = $user_db->find();
            if ( $result )
            {
                $passwd = rand(100000,999999);
                $name .= $passwd;
            }
            if ( $name == '')
            {
                $name = '微信用户' . time();
            }

	    $passwd = rand(100000,999999);
            $user_data = array(
                'username' => $name,
                'password' => md5($passwd),
                'head_ico' => $info['headimgurl']
            );
            if ( $promote )
                $user_data['promo_code'] = $promote;
            $passwd = rand(100000,999999);
            $user_db = new IModel('user');
            $user_db->setData($user_data);
            $user_id = $user_db->add();

            if($user_id)
            {
                $member_db->setData(array(
                    'user_id' => $user_id,
                    'openid'  => $info['openid'],
                    'time'    => ITime::getDateTime(),
                    'status'  => 1
                ));
                $member_db->add();
            } else {
                die("<script>alert('获取用户信息失败，请关闭当前页面重新进入！');</script>");
            }

           //$this->redirect('bind_user');
        } 
         
        $userRow = user_class::get_user_info($user_id);
        if ( !$userRow )
        {
            die("<script>alert('新建用户信息失败，请关闭当前页面重新进入！');</script>");
        }
        plugin::trigger("userLoginCallback",$userRow);

        $jump_url = ISafe::get('jump_url');

        if($jump_url){
            die("<script>location.href = '".$jump_url."';</script>"); 
        }else{
            die("<script>location.href = '/ucenter/index';</script>"); 
        }        

    }
    
    // 过滤掉emoji表情
    public static function filterEmoji($str)
    {
        $str = preg_replace_callback(
            '/./u',
            function (array $match) {
                return strlen($match[0]) >= 4 ? '' : $match[0];
            },
            $str);
    
        return $str;
    }




}



?>