<?php 

class Test extends IController
{
    // 去掉无谓课程在前台显示, seller_id = 385
    function index()
    {
        $goods_db = new IQuery('goods');
        $goods_db->where = 'seller_id = 385';
        $goods_list = $goods_db->find();
        
        $commend_goods_db = new IModel('commend_goods');
        if ( $goods_list )
        {
            foreach($goods_list as $kk => $vv )
            {
                $commend_goods_db->del('commend_id = 1 and goods_id = ' . $vv['id']);
            }
        }
        
        echo 'ok!';
    }
    
    
        /**
     * 修改课程的展示页面
     */
    function change_goods_brand_id()
    {
        $goods_db = new IQuery('goods');
        $goods_db->where = '1=1 and seller_id > 0 ';
        $goods_list = $goods_db->find();
        
        $goods_db2 = new IModel('goods');
        if ( $goods_list )
        {
            foreach( $goods_list as $kk => $vv )
            {
                if ( $vv['seller_id'] > 0 )
                {
                    $seller_info = seller_class::get_seller_info($vv['seller_id']);
                    if ( $seller_info && $seller_info['brand_id'] > 0 )
                    {
                        $goods_db2->setData(array(
                            'brand_id'  =>  $seller_info['brand_id'],
                        ));
                        $goods_db2->update('id = ' . $vv['id']);
                    }
                }
            }
        }
        
        echo 'ok!';
    }
    
    /**
     * 修改课程的价格,market_price => sell_price
     */
    function change_goods_price()
    {
        $goods_db = new IQuery('goods');
        $goods_db->where = 'sell_price <= 0';
        $goods_list = $goods_db->find();
        
        $goods_db2 = new IModel('goods');
        if ( $goods_list )
        {
            foreach( $goods_list as $kk => $vv )
            {
                if ( $vv['market_price'] > 0 )
                {
                    $market_price = $vv['market_price'];
                    $goods_db2->setData(array(
                        'sell_price' => $market_price,
                    ));
                    $goods_db2->update('id = ' . $vv['id']);
                }
            }
        }
        
        
        $products_db = new IQuery('products');
        $products_db->where = 'sell_price <= 0';
        $products_list = $products_db->find();
        
        $products_db2 = new IModel('products');
        if ( $products_list )
        {
            foreach( $products_list as $kk => $vv )
            {
                if ( $vv['market_price'] > 0 )
                {
                    $market_price = $vv['market_price'];
                    $products_db2->setData(array(
                        'sell_price' => $market_price,
                    ));
                    $products_db2->update('id = ' . $vv['id']);
                }
            }
        }
        
        echo 'ok!';
    }
    
    // 修改微信用户的用户名
    function change_username()
    {
        $user_db = new IQuery('user as u');
        $user_db->join = 'left join member as m on u.id = m.user_id';
        $user_db->where = "m.openid != '' and u.username != '' and u.id not in (29783,9203,8158)";
        $user_db->order = 'id desc';
        $user_db->fields = 'u.id,u.username';
        $list = $user_db->find();
        
        $user_db2 = new IModel('user as u');
        $user_db3 = new IQuery('user as u');
        if ($list)
        {
            foreach($list as $kk => $vv )
            {
                $username = $vv['username'];
                $id = $vv['id'];
                if ($this->is_base64($username))
                {
                    $user_name = base64_decode($username);
                    $user_name = $this->filterEmoji($user_name);
                    $user_name = mysql_real_escape_string($user_name);
                    $user_db3->where = "username = '" . $user_name . "' and id != $id";
                    $result = $user_db3->getOne();
                    
                    if ( $user_name != '' && !$result )
                    {
                        $data = array(
                            'username'  => $user_name ,
                        );
                        $user_db2->setData($data);
                        $res = $user_db2->update('id=' . $id);
                    }
                }
            }
        }
        
        echo 'ok!';
    }
    
    private function is_base64($str)
    {
        if($str==base64_encode(base64_decode($str)))
        {
            return true;
        }else{
            return false;
        }
    }
    
    // 过滤掉emoji表情
    function filterEmoji($str)
    {
        $str = preg_replace_callback(
            '/./u',
            function (array $match) {
                return strlen($match[0]) >= 4 ? '' : $match[0];
            },
            $str);
    
        return $str;
    }
    
    function get_order_profit()
    {
        $order_id = 2080;
        $order_info = order_class::get_order_info($order_id);
        dump(order_class::get_order_profit($order_info));
    }
    
    function t()
    {
        $time = '2017-08-02 10:20:49';
        echo strtotime($time);
    }
    
    function a()
    {
        $str = 'a:39:{s:15:"REDIRECT_STATUS";s:3:"200";s:9:"HTTP_HOST";s:14:"www.dsanke.com";s:12:"HTTP_REFERER";s:51:"http://www.dsanke.com/seller/order_show_dqk/id/1927";s:11:"HTTP_COOKIE";s:1014:"iweb_safecode=e032112dce6ae6ae42NTAxODYxMDkxMDAxMzU2NDFnOjMzN2BmN2JkazA2NGEwZTBiPTkxMjA1Njo0NzRiNjJlPDo1NmJiM2ZmNDM%2BMQ; bdshare_firstime=1501754035408; iweb_admin_role_name=d1e333634cf90e75d6AFYIAgYDAVQGAQAFBlMHUVEBVAIFB1NXBVBUA1IHAlXRhMGD7JY; iweb_admin_id=f62b3d3f2f90372bdcBwgHAwMACVUCCAAIBFFeDFwBUABQVVJRDlNXBldZUwUA; iweb_admin_name=bef87e2fba4068e79bVQlWAAVRUlFUCAcJUV9TAARRDwNXVQUBBFNUXVZQV1cHXkVeUw; iweb_admin_pwd=b116bbf827c387f6c1VQcBVAQBA1VRAgRTVQdQVlILBQ8LUFIAV1gOUQpQBwUHUAdYAQALAVcNAFNXDARUVVQHDlYHAQdRBVQCWlsGBg; iweb_lastInfo=7d6e7f1677de12ed1dVlQBBwFUBFZVB1UDDlVRAVMGUlAEAgVVD1QFAlIBBFIfWUVRVEQXDRRSA0ZsWFlAQw; iweb_seller_id=3178594c8b66f6eee8A1IABwlRCFNSAF0IA1pWXQMDUlFTUVBQV1BcAANTVwEEDgA; iweb_seller_name=7334d650cd38779cc9AlIDVgBTBQdSU1BRBl5WB1NUVVsHVAJVXg4NVlFVUAPRxZja%2FIDXqITRkL8; iweb_seller_pwd=4a543e70405816a8afCQlRVAdUBFQGU1QBBQ1QUloCBFJVAAFdAgVbV1NQB1dWBFZRVlZQX1ILUgUGDlFWBwFTAlwBBwJSUQJTWggHUw; iweb_captcha=175aa8e50177e18d24UwIAAFQDBlZSBAIHWFULVwIEAVNWBwgJCwBWUQ0HC1BfClERUA";s:14:"HTTP_X_REAL_IP";s:14:"222.245.25.209";s:15:"HTTP_CONNECTION";s:5:"close";s:14:"CONTENT_LENGTH";s:2:"20";s:11:"HTTP_ACCEPT";s:3:"*/*";s:11:"HTTP_ORIGIN";s:21:"http://www.dsanke.com";s:21:"HTTP_X_REQUESTED_WITH";s:14:"XMLHttpRequest";s:15:"HTTP_USER_AGENT";s:127:"Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.221 Safari/537.36 SE 2.X MetaSr 1.0";s:12:"CONTENT_TYPE";s:48:"application/x-www-form-urlencoded; charset=UTF-8";s:20:"HTTP_ACCEPT_LANGUAGE";s:14:"zh-CN,zh;q=0.8";s:4:"PATH";s:29:"/sbin:/usr/sbin:/bin:/usr/bin";s:16:"SERVER_SIGNATURE";s:0:"";s:15:"SERVER_SOFTWARE";s:6:"Apache";s:11:"SERVER_NAME";s:14:"www.dsanke.com";s:11:"SERVER_ADDR";s:9:"127.0.0.1";s:11:"SERVER_PORT";s:2:"80";s:11:"REMOTE_ADDR";s:14:"222.245.25.209";s:13:"DOCUMENT_ROOT";s:33:"/www/web/lelele999com/public_html";s:14:"REQUEST_SCHEME";s:4:"http";s:14:"CONTEXT_PREFIX";s:0:"";s:21:"CONTEXT_DOCUMENT_ROOT";s:33:"/www/web/lelele999com/public_html";s:12:"SERVER_ADMIN";s:15:"you@example.com";s:15:"SCRIPT_FILENAME";s:43:"/www/web/lelele999com/public_html/index.php";s:11:"REMOTE_PORT";s:5:"60210";s:12:"REDIRECT_URL";s:25:"/seller/update_dqk_status";s:17:"GATEWAY_INTERFACE";s:7:"CGI/1.1";s:15:"SERVER_PROTOCOL";s:8:"HTTP/1.0";s:14:"REQUEST_METHOD";s:4:"POST";s:12:"QUERY_STRING";s:0:"";s:11:"REQUEST_URI";s:25:"/seller/update_dqk_status";s:11:"SCRIPT_NAME";s:10:"/index.php";s:9:"PATH_INFO";s:25:"/seller/update_dqk_status";s:15:"PATH_TRANSLATED";s:62:"redirect:/index.php/seller/update_dqk_status/update_dqk_status";s:8:"PHP_SELF";s:35:"/index.php/seller/update_dqk_status";s:18:"REQUEST_TIME_FLOAT";d:1506047012.332;s:12:"REQUEST_TIME";i:1506047012;}';
        $str = unserialize($str);
        dump($str);
    }
    
    function b()
    {
        $order_id = 2081;
        order_class::handle_order_promo_commission($order_id);
    }
    
    function aa()
    {
        $str = '{s:8:"attr_7_0";s:1:"0";s:8:"attr_7_1";s:1:"0";s:8:"attr_7_2";s:1:"0";s:8:"attr_7_3";s:1:"0";s:8:"attr_7_4";s:1:"0";s:8:"attr_7_5";s:1:"0";s:8:"attr_7_6";s:1:"0";s:8:"attr_7_7";s:1:"0";s:8:"attr_7_8";s:1:"0";}';
        $str = unserialize($str);
        dump($str);
    }
    
    function abc()
    {
        $file = "data.txt";
        $content = file($file);
        if ( $content )
        {
            foreach( $content as $kk => $vv )
            {
                $content[$kk] = explode(',', $vv);
            }
        }
        dump($content);
    }
}

?>