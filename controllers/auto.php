<?php 

class auto extends IController
{
    // 商户订单1星期后自动结算
    public static function auto_checkout()
    {
        $order_db = new IQuery('order');
        $order_db->where = 'pay_status = 1 and status = 5 and is_checkout in ( 0, 2 ) and not_settled > 0 ';
        $order_list = $order_db->find();
        $order_model = new IModel('order');
        
        if ( $order_list )
        {
            foreach( $order_list as $kk => $vv )
            {
                // 读取数据
                $completion_time = $vv['completion_time'];
                $completion_time = strtotime('+7 days', strtotime($completion_time) );
                $not_settled = $vv['not_settled'];
                $now = time();
                
                // 判断是否过了一星期
                if ( $now > $completion_time )
                {
                    $order_id_temp = $vv['id'];
                    $order_info_temp = Order_Class::get_order_info($order_id_temp);
                    $seller_id = $order_info_temp['seller_id'];
                    $start_time = date('Y-m-d', strtotime( $order_info_temp['create_time'] ) );
                    $end_time = $start_time;
                    
                    $billDB = new IModel('bill');
                    $countData['start_time'] = $start_time;
                    $countData['end_time']   = $end_time;
                    $countData['orderNoList'] = array( $order_id_temp );
                    $countData['orderNum'] = 1;
                    $countData['countFee'] = $not_settled;
                    $billString = AccountLog::sellerBillTemplate($countData);
                    $data = array(
                        'seller_id'  => $seller_id,
                        'apply_time' => date('Y-m-d H:i:s'),
                        'apply_content' => IFilter::act(IReq::get('apply_content')),
                        'start_time' => $start_time,
                        'end_time' => $end_time,
                        'log' => $billString,
                        'order_ids' => $order_id_temp,
                    );
                    
                    $billDB->setData($data);
                    $id = $billDB->add();
                    $is_pay = 1;
                    $data = array(
                        'admin_id' => 0,
                        'pay_content' => '',
                        'is_pay' => $is_pay,
                    );
                    
                    $billDB = new IModel('bill');
                    $data['pay_time'] = ($is_pay == 1) ? date('Y-m-d H:i:s') : "";
                    $billRow= $billDB->getObj('id = '.$id);
                    $billDB->setData($data);
                    $billDB->update('id = '.$id);
                    Bill_class::add_sale( $seller_id, $not_settled );
                    
                    $order_model->setData(array('is_checkout' => 1, 'settled' => $order_info_temp['settled'] + $not_settled, 'not_settled' => 0 ));
                    $order_model->update('id = ' . $order_id_temp );
                }
            }
        }
        
        echo 'ok!';
    }
    
    
    // 导入已存在的推广人信息到promotor表
    public static function auto_import_promotors()
    {
        // 过滤所有seller表的promo_code
        $seller_db = new IModel('seller');
        $seller_db->setData(array(
            'promo_code' => '',
        ));
        $seller_db->update('id > 1');
        
        // 过滤user表中001,002的promo_code
        $user_db = new IModel('user');
        $user_db->setData(array(
            'promo_code' => ''
        ));
        $user_db->update("promo_code = '001' or promo_code = '002'");
        
        // 添加user表中真实的promotor到新表
        $user_db = new IQuery('user');
        $user_db->where = "promo_code != ''";
        $user_db->fields = 'distinct(promo_code)';
        $user_list = $user_db->find();
        $arr = array();
        if ( $user_list )
        {
            foreach($user_list as $kk => $vv )
            {
                $arr[] = $vv['promo_code'];
            }
        }
        
        $user_db2 = new IQuery('user as u');
        $user_db2->join = 'left join member as m on u.id = m.user_id';
        $user_db2->fields = 'u.id,u.promo_code,m.time';
        $user_db2->where = db_create_in( $arr, 'id');
        $user_list2 = $user_db2->find();
        if ( $user_list2 )
        {
            foreach($user_list2 as $kk => $vv )
            {
                $promo_code = promote_class::get_promote_code($vv['id']);
                promotor_class::insert_promotor($promo_code,$vv['promo_code']);
            }
        }
        
        echo 'ok!';
    }
    
    // 自动修改所有课程的搜索关键词
    public static function change_goods_search_word()
    {
        $goods_db = new IQuery('goods as g');
        $goods_db->where = '1 = 1 and is_del = 0';
        $goods_list = $goods_db->find();
        
        $category_db = new IQuery('category as c');
        $goods_db2 = new IModel('goods');
        
        if ( $goods_list )
        {
            foreach( $goods_list as $kk => $vv )
            {
                // 获取课程名称
                $search_words = array();
                $search_words[] = $vv['name'];
                
                // 获取课程分类
                $category_db->join = 'left join category_extend as ce on c.id = ce.category_id';
                $category_db->where = 'ce.goods_id = ' . $vv['id'];
                $category_list = $category_db->find();
                if ( $category_list )
                {
                    foreach($category_list as $k => $v )
                    {
                        $search_words[] = $v['name'];
                    }
                }
                
                // 获取学校名称
                $seller_info = seller_class::get_seller_info($vv['seller_id']);
                if ( $seller_info )
                {
                    $search_words[] = $seller_info['true_name'];
                    $search_words[] = $seller_info['shortname'];
                }
                
                // 合并以前存在的关键词、去掉重复/空值
                $goods_search_words = $vv['search_words'];
                $goods_search_words = explode(',', $goods_search_words);
                $goods_search_words = array_merge($goods_search_words, $search_words);
                $goods_search_words = array_filter(array_unique($goods_search_words));
                
                // 更改关键词
                $data = array(
                    'search_words' =>implode(',', $goods_search_words),
                );
                $goods_db2->setData($data);
                $goods_db2->update('id = ' . $vv['id']);
            }
        }
        
        echo 'ok!';
    }
    
    
    // 批量修改商户的交易密码，为商户手机号码的后4位
    public static function change_seller_draw_password()
    {
        $seller_db = new IQuery('seller');
        $seller_db->where = "mobile != ''";
        $seller_list = $seller_db->find();
        
        $ere = '/^[0-9]{11}$/';
        $seller_db2 = new IModel('seller');
        
        $seller_db3 = new IModel('seller');
        $seller_db3->setData(array(
            'draw_password' => '',
        ));
        $seller_db3->update('id > 0');
        
        if ( $seller_list )
        {
            foreach( $seller_list as $kk => $vv )
            {
                $mobile = $vv['mobile'];
                
                if ( strlen($mobile) == 11 && preg_match($ere,$mobile))
                {
                    $draw_password = md5(substr($mobile, -4));
                    $seller_db2->setData(array(
                        'draw_password' =>  $draw_password,
                    ));
                    $seller_db2->update('id = ' . $vv['id']);
                }
            }
        }
        
        echo 'ok!';
    }
    
}

?>