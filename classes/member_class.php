<?php 
/**
 * @copyright (c) 2016 dsanke.com
 * @file Member_class.php
 * @brief 处理用户相关操作
 * @author jack
 * @date 2016-07-06
 * @version 1.0
 */
class Member_class
{
    /**
     * 获取单个用户信息
     * @param int 用户ID
     * @param string 返回字段, 默认为*
     * @return array
     */
    public static function get_member_info( $user_id = 0, $fields = '*' )
    {
        if ( !$user_id )
            return array();
        
        $member_db = new IQuery('member');
        $member_db->where = 'user_id = ' . $user_id;
        $member_db->files = ( $fields ) ? $fields : '*';
        return $member_db->getOne();
    }
    
    public static function get_member_info_by_mobile( $mobile )
    {
        if ( !$mobile )
            return false;
        
        $member_db = new IQuery('member');
        $member_db->where = "mobile = '$mobile'";
        return $member_db->getOne();
    }
    
    /**
     * 获取所有需要返利的用户信息. user_all_fanli > 0 冻结待返回的返利金额大于0
     * @return array
     */
    public static function get_rebate_member_list()
    {
        $member_db = new IQuery('member');
        $member_db->fields = 'user_id, user_real_fanli, user_all_fanli';
        
        // 该字段没有设置索引，此操作会引发全表搜索
        $member_db->where = 'user_all_fanli > 0';
        return $member_db->find();
    }
    
    // 通过代金券查找所属的用户
    public static function get_user_info_by_prop_id( $prop_id = 0 )
    {
        if ( !$prop_id )
            return false;
        
        $member_db = new IQuery('member');
        $member_db->where = "FIND_IN_SET($prop_id, prop)";
        return $member_db->getOne();
    }        
    
    public static function is_set_trade_passwd($user_id = 0 )    
    {        
        if ( !$user_id )            
            return false;                
        
        $user_db = new IQuery('user');        
        $user_db->fields = 'trade_password';        
        $user_db->where = 'id = ' . $user_id;        
        $user_info = $user_db->getOne();        
        return ( isset( $user_info['trade_password']) && $user_info['trade_password'] != '') ? true : false;    
    }        
    
    public static function get_user_trade_passwd( $user_id = 0 )    
    {        
        if ( !$user_id )            
            return false;                
        
        $user_db = new IQuery('user');        
        $user_db->fields = 'trade_password';        
        $user_db->where = 'id = ' . $user_id;        
        $user_info = $user_db->getOne();        
        return ( isset( $user_info['trade_password']) && $user_info['trade_password'] != '') ? $user_info['trade_password'] : false;
    }
    
    public static function reset_user_trade_password($user_id)
    {
        $user_db = new IQuery('user');
        $user_db->where = 'id = ' . $user_id;
        $user_info = $user_db->getOne();
        
        if ( !$user_info )
        {
            return false;
        }
        
        $user_db = new IModel('user');
        $user_db->setData(array('trade_password' => $user_info['password']));
        return  ( $user_db->update('id = ' . $user_id )) ? true : false;
    }

    public static function get_user_name_by_uid($user_id)
    {
        $user_db = new IQuery('user');
        $user_db->where = 'id = ' . $user_id;
        $user_info = $user_db->getOne();
        
        if ( !$user_info )
        {
            return false;
        }

        return  $user_info['username'];
    }

    //获取当月成交
    public static function getPromoteListOrderByCode($promo_code, $this_month = 1)
    {
        $firstday=date('Y-m-01', strtotime(date("Y-m-d")));
        if ( !$this_month )
            $firstday = date('Y-m-d',strtotime('-1 month', strtotime($firstday)));
        $lastday=date('Y-m-d', strtotime("$firstday +1 month -1 day"));
        
        $order_db = new IModel('order');
        $user_db = new IQuery('user as u');
        $user_db->join = "left join order AS o on o.user_id = u.id left join order_goods AS og on o.id = og.order_id left join seller as s on o.seller_id = s.id";
        $user_db->fields = "u.id as user_id,u.username,og.goods_array,o.order_amount,o.create_time,o.id,o.statement,o.chit_id";
        $user_db->where = "(u.promo_code = '$promo_code' or s.promo_code = '$promo_code' or o.promo_code = '$promo_code') AND o.order_amount != '' AND o.pay_status = 1 and (o.create_time between '$firstday' and '$lastday')";
        $user_db->order = "u.id DESC";
        $user_db->limit = 12;
        $promotelist = $user_db->find();

        $user_id = 0;
        $user_ere = '/^[0-9]+$/';
        if ( preg_match($user_ere, $promo_code) )
        {
            $user_id = $promo_code;
            $user_type = 1;
        } else {
            $seller_ere = '/^[sS]([0-9]+)$/';
            preg_match_all($seller_ere, $promo_code, $result);
            if ( $result[1][0] )
            {
                $user_id = $result[1][0];
                $user_type = 2;
            }
        }
        
        $prom_commission_db = new IQuery('prom_commission');
        foreach($promotelist AS $idx => $promote)
        {
            if ( $promote['statement'] == 2 && $promote['chit_id'] > 0)
            {
                $chit_info = brand_chit_class::get_chit_info($promote['chit_id'] );
                $promotelist[$idx]['goods_name'] = brand_chit_class::get_chit_name($chit_info['max_price'], $chit_info['max_order_chit']);
            } else {
                $goods = json_decode($promote['goods_array']);
                $promotelist[$idx]['goods_name'] = $goods->name;
            }
            
            if ( $user_type == 1 )
            {
                $prom_commission_db->where = 'order_id = ' . $promote['id'] . ' and user_id = ' . $user_id;
            } else {
                $prom_commission_db->where = 'order_id = ' . $promote['id'] . ' and seller_id = ' . $user_id;
            }
            //$prom_commission_db->fields = 'count(commission) as count';
            //$prom_commission_info = $prom_commission_db->getOne();
            //$promotelist[$idx]['commission'] = $prom_commission_info['count'];
            
            $commission_list = order_class::get_order_promo_commission_detail($promote['id']);
            $commission = 0;
            if ( $commission_list )
            {
                if($commission_list['user'])
                {
                    foreach($commission_list['user'] as $kk => $vv )
                    {
                        $user_type_str = ($user_type == 1) ? 'user' : 'seller';
                        if ( $vv['type'] == $user_type_str && $vv['user_id'] == $user_id )
                            $commission += $vv['commission'];
                    }
                }
                
                if($commission_list['seller'])
                {
                    foreach($commission_list['seller'] as $kk => $vv )
                    {
                        $user_type_str = ($user_type == 1) ? 'user' : 'seller';
                        if ( $vv['type'] == $user_type_str && $vv['user_id'] == $user_id )
                            $commission += $vv['commission'];
                    }
                }
                
                if($commission_list['order'])
                {
                    foreach($commission_list['order'] as $kk => $vv )
                    {
                        $user_type_str = ($user_type == 1) ? 'user' : 'seller';
                        if ( $vv['type'] == $user_type_str && $vv['user_id'] == $user_id )
                            $commission += $vv['commission'];
                    }
                }
            }
            $promotelist[$idx]['commission'] = $commission;
        }

        return $promotelist;
    }

    //获取当月推广
    public static function getPromoteListByCode($promo_code, $this_month = 1)
    {
        $firstday=date('Y-m-01', strtotime(date("Y-m-d")));
        if ( !$this_month )
            $firstday = date('Y-m-d',strtotime('-1 month', strtotime($firstday)));
        $lastday=date('Y-m-d', strtotime("$firstday +1 month -1 day"));
        
        $order_db = new IModel('order');
        $user_db = new IQuery('user as u');
        $user_db->join = "left join member as m on u.id = m.user_id";
        $user_db->fields = "u.id,u.username,m.time AS create_time";
        $user_db->where = "u.promo_code = '$promo_code' and ( m.time between '$firstday' and '$lastday')";
        $user_db->order = "u.id DESC";
        $promotelist = $user_db->find();
        foreach($promotelist AS $idx => $promote)
        {
            $promotelist[$idx]['type'] = '个人';
            $promotelist[$idx]['times'] = order_class::get_user_pay_count($promote['id']);
        }

        $seller_db = new IQuery('seller as s');
        $seller_db->fields = "s.id,s.seller_name AS username,s.true_name,s.mobile,s.create_time";
        $seller_db->where = "s.promo_code = '$promo_code' and (s.create_time between '$firstday' and '$lastday')";
        $seller_db->order = "s.id DESC";
        $sellerpromotelist = $seller_db->find();
        foreach($sellerpromotelist AS $idx => $spromote)
        {
            $sellerpromotelist[$idx]['type'] = '商户';
            $sellerpromotelist[$idx]['times'] = order_class::get_seller_order_count($spromote['id']);
        }

        return array_merge($sellerpromotelist, $promotelist);
    }

    //获取推广的商户
    public static function getPromoteSellerByCode($promo_code)
    {
        $seller_db = new IQuery('seller as s');
        $seller_db->fields = "s.id,s.seller_name AS username,s.true_name,s.mobile,s.create_time";
        $seller_db->where = "s.promo_code = '$promo_code'";
        $seller_db->order = "s.id DESC";
        $sellerpromotelist = $seller_db->find();
        if ( $sellerpromotelist )
        {
            foreach( $sellerpromotelist as $kk => $vv )
            {
                $sellerpromotelist[$kk]['times'] = order_class::get_seller_order_count($vv['id']);
            }
        }

        return $sellerpromotelist;
    }

    //获取推广的个人
    public static function getPromotePersonByCode($promo_code)
    {
        $user_db = new IQuery('user as u');
        $user_db->join = "left join member as m on u.id = m.user_id";
        $user_db->fields = "u.id,u.username,m.mobile,m.true_name,m.time AS create_time";
        $user_db->where = "u.promo_code = '$promo_code'";
        $user_db->order = "u.id DESC";
        $promotelist = $user_db->find();
        if ( $promotelist )
        {
            foreach( $promotelist as $kk => $vv )
            {
                $promotelist[$kk]['times'] = order_class::get_user_pay_count($vv['id']);
            }
        }

        return $promotelist;
    }
}

?>