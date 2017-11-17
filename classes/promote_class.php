<?php 

// 推广统计类
class promote_class
{
    // 1.获取推广的个人用户交易额,交易额以付款成功为依据
    public static function get_user_turnover($promo_code, $month = 0)
    {
        if ( !$promo_code )
            return false;
        
        if ( $month > 0 && $month < 13)
            $time_limit = self::get_month_limit($month);
        
        // 获取所有的推广用户列表
        $user_list = self::get_promote_user_list($promo_code);
        
        $order_db = new IQuery('order');
        $order_db->fields = 'order_amount';
        
        if ( $time_limit )
            $sql = "pay_status = 1 and " . db_create_in($user_list, 'user_id') . " and create_time between '" . $time_limit[0] . "' and '" . $time_limit[1] . "' and order_amount > 0";
        else
            $sql = "pay_status = 1 and " . db_create_in($user_list, 'user_id');

        $order_db->where = $sql;
        $order_list = $order_db->find();
        
        $turnover = 0;
        if ( $order_list )
        {
            foreach($order_list as $kk => $vv )
            {
                $turnover += $vv['order_amount'];
            }
        }
        return $turnover;
    }
    
    // 2.推广的个人用户总数
    public static function get_promote_user_count($promo_code, $month = 0)
    {
        if ( !$promo_code )
            return false;
        
        if ( $month > 0 && $month < 13)
            $time_limit = self::get_month_limit($month);
        
        $user_db = new IQuery('user as u');
        $user_db->join = 'left join member as m on u.id = m.user_id';
        $user_db->fields = 'u.id';
        if ( $time_limit )
            $sql = "u.promo_code = '$promo_code' and m.time between '" . $time_limit[0] . "' and '" . $time_limit[1] . "'";
        else
            $sql = "u.promo_code = '$promo_code'";
        $user_db->where = $sql;
        $user_list = $user_db->find();
        return ($user_list) ? sizeof($user_list) : 0;
    }
    
    // 3.获取推广的商户交易额，交易额以付款成功为依据
    public static function get_seller_turnover($promo_code, $month = 0)
    {
        if ( !$promo_code )
            return false;
    
        if ( $month > 0 && $month < 13)
            $time_limit = self::get_month_limit($month);
    
        // 获取所有的推广用户列表
        $seller_list = self::get_promote_seller_list($promo_code);
    
        $order_db = new IQuery('order');
        $order_db->fields = 'order_amount';
    
        if ( $time_limit )
            $sql = "pay_status = 1 and " . db_create_in($seller_list, 'seller_id') . " and create_time between '" . $time_limit[0] . "' and '" . $time_limit[1] . "' and order_amount > 0";
        else
            $sql = "pay_status = 1 and " . db_create_in($seller_list, 'seller_id');
    
        $order_db->where = $sql;
        $order_list = $order_db->find();
    
        $turnover = 0;
        if ( $order_list )
        {
            foreach($order_list as $kk => $vv )
            {
                $turnover += $vv['order_amount'];
            }
        }
        return $turnover;
    }
    
    // 4.推广的个人商户总数
    public static function get_promote_seller_count($promo_code, $month = 0)
    {
        if ( !$promo_code )
            return false;
    
        if ( $month > 0 && $month < 13)
            $time_limit = self::get_month_limit($month);
    
        $seller_db = new IQuery('seller as s');
        $seller_db->fields = 's.id';
        if ( $time_limit )
            $sql = "s.promo_code = '$promo_code' and s.create_time between '" . $time_limit[0] . "' and '" . $time_limit[1] . "'";
        else
            $sql = "s.promo_code = '$promo_code'";
        $seller_db->where = $sql;
        $seller_db = $seller_db->find();
        return ($seller_db) ? sizeof($seller_db) : 0;
    }
       
    // 获取直接推广用户列表
    public static function get_promote_user_list($promo_code = '')
    {
        if ( !$promo_code )
            return false;
    
        $user_db = new IQuery('user');
        $user_db->fields = 'id';
        $user_db->where = "promo_code = '$promo_code'";
        $user_list = $user_db->find();
        $arr = array();
        if ( $user_list )
        {
            foreach($user_list as $kk => $vv)
            {
                $arr[] = $vv['id'];
            }
        }
        return $arr;
    }
    
    // 获取直接推广用户列表+信息
    public static function get_promote_user_list_info($promo_code = '')
    {
        if ( !$promo_code )
            return false;
    
        $user_db = new IQuery('user as u');
        $user_db->join = 'left join member as m on u.id = m.user_id';
        $user_db->fields = 'm.user_id,u.username,m.time';
        $user_db->where = "promo_code = '$promo_code'";
        
        $user_db->order = 'u.id desc';
        $user_list = $user_db->find();
        return $user_list;
    }
    
    // 获取直接推广商户列表
    public static function get_promote_seller_list($promo_code = '')
    {
        if ( !$promo_code )
            return false;
    
        $seller_db = new IQuery('seller');
        $seller_db->fields = 'id';
        $seller_db->where = "promo_code = '$promo_code'";
        $seller_list = $seller_db->find();
        $arr = array();
        if ( $seller_list )
        {
            foreach($seller_list as $kk => $vv)
            {
                $arr[] = $vv['id'];
            }
        }
        return $arr;
    }
    
    // 获取直接推广商户列表+信息
    public static function get_promote_seller_list_info($promo_code = '')
    {
        if ( !$promo_code )
            return false;
        
        $seller_db = new IQuery('seller');
        $seller_db->fields = 'id,shortname,create_time';
        $seller_db->where = "promo_code = '$promo_code'";
        
        $seller_db->order = 'id desc';
        $seller_list = $seller_db->find();
        return $seller_list;
    }
    
    // 获取下级推广人列表
    public static function get_subordinate_promote_user_list_count($promo_code = '', $month = 0)
    {
        $promote_list = promotor_class::get_my_promotor_list($promo_code, false);
        if ($month > 0 && $month < 13 && $promote_list )
        {
            $time_limit = self::get_month_limit($month);
            $promotor_db = new IQuery('promotors');
            $promotor_db->where = db_create_in( $promote_list, 'promo_code') . ' and create_time >= ' . strtotime($time_limit[0]) . '  and create_time < ' . strtotime($time_limit[1]);
            $promote_list = $promotor_db->find();
        }
        return ($promote_list) ? sizeof($promote_list) : 0;
    }
    
    // 获取时间条件
    public static function get_month_limit($month = 0)
    {
        $month = (!$month) ? date('m') : $month;
        $start_time = date('Y') . '-' . $month . '-01 00:00:00';
        $end_time = date('Y-m-d H:i:s',strtotime('+1 months', strtotime($start_time)));
        return array($start_time,$end_time);
    }
    
    // 获取我的推广码, 用户的推广码为user_id,商户的推广码为s+user_id
    public static function get_promote_code($user_id, $type = 1)
    {
        return ($type == 1) ? $user_id : 's' . $user_id;
    }
    
    // 获取用户的上3级推广人
    public static function get_user_promos_list($user_id = 0, $type = 1)
    {
        if ( !$user_id )
            return false;
        
        $list = array();
        if ( $type == 1)
            $user_db = new IQuery('user');
        else if ( $type == 2)
           $user_db = new IQuery('seller');
        else 
            $user_db = new IQuery('user');
        
        $user_db->where = 'id = ' . $user_id;
        $user_info = $user_db->getOne();
        if ( !$user_info )
            return false;
        
        if ( $user_info['promo_code'] != '' )
        {
            // 第一级推广人信息
            $promo_info = promotor_class::get_promotor_info2($user_info['promo_code']);
            if ( $promo_info )
            {
                $list[] = $promo_info;
                if ( $promo_info['promo_code'] != '' )
                {
                    $promo_info2 = promotor_class::get_promotor_info2($promo_info['promo_code']);
                    if ( $promo_info2 )
                    {
                        $list[] = $promo_info2;
                        if ( $promo_info2['promo_code'] != '')
                        {
                            $promo_info3 = promotor_class::get_promotor_info2($promo_info2['promo_code']);
                            if ( $promo_info3 )
                            {
                                $list[] = $promo_info3;
                            }
                        }
                    }
                }
            }
        }
        
        return $list;
    }
    
    // 获取订单提成中订单推广人的用户ID
    public static function get_order_promos_user($order_id = 0)
    {
        if ( !$order_id )
            return false;
        
        $order_info = order_class::get_order_info($order_id);
        if ( !$order_info || $order_info['pay_status'] != 1 )
            return false;
        
        if ( $order_info['promo_code'] )
        {
            $list[] = array( 'type' => 'user','user_id' => $order_info['promo_code']);
            if ( $order_info && $order_info['promo_code'] > 0 )
            {
                $list = array_merge($list,self::get_user_promos_list($order_info['promo_code'],3));
            }
            if ( $list[1])
            {
                $list[0]['promo_code'] = $list[1]['user_id'];
            }
            $list = array_chunk($list,3);
            return $list[0];
        } else {
            return array();
        }
    }
}

?>