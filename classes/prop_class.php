<?php 

class prop_class
{
    // 获取代金券列表
    public static function get_prop_list_db($page_size = 10, $page = 1, $user_id = 0, $where = '', $order = 'id desc')
    {
        $condition = '';
        if ( $user_id )
            $condition .= ' user_id = ' . $user_id;
        if ( $where )
            $condition .= ( $condition ) ? ' and ' . $where : $where;
        $condition .= ( $condition ) ? ' and is_pay = 1 and is_send = 1 ': 'is_pay = 1 and is_send = 1 ';
        
        $order = ( !$order ) ? 'id desc' : $order;
        $prop_db = new IQuery('prop as p');
        $prop_db->join ='left join user as u on p.user_id = u.id';
        $prop_db->fields = 'p.*,u.username';
        $prop_db->where = $condition;
        $prop_db->pagesize = $page_size;
        $prop_db->page = $page;
        $prop_db->order = $order;
        return $prop_db;
    }
        
    // 添加代金券操作
    public static function add_prop( $value = 0, $user_id = 0, $goods_id = 0, $product_id = 0, $chit_id = 0 )
    {
        $prop_db = new IModel('prop2');
        $arr = array(
            'value'         =>  $value,
            'is_close'      =>  2,
            'is_used'      =>  0,
            'goods_id'     =>  $goods_id,
            'product_id'    =>  $product_id,
            'user_id'       =>  $user_id,
			'brand_chit_id' => $chit_id,
        );
        $prop_db->setData($arr);
        return $prop_db->add();
    }
    
    // 订单取消时重置代金券状态
    public static function reset_prop( $prop_id = '' )
    {
        if ( !$prop_id )
            return false;
        
        $prop_ids = explode(',', $prop_id);
        
        $prop_db = new IModel('prop');
        $prop_db->setData(array(
            'is_close'   =>  0,
            'is_send'    =>  1,
            'is_used'   =>  0,
            'seller_id'   =>  0,
        ));
        $prop_db->update(db_create_in( $prop_ids, 'id'));
    }
    
    // 订单支付成功后，更新代金券支付状态
    public static function update_prop_pay_status( $prop_id = '')
    {
        if ( !$prop_id )
            return false;
        
        $prop_ids = explode(',', $prop_id);
        $prop_db = new IModel('prop2');
        $prop_db->setData(array(
            'is_pay'    =>  1,
            'is_close'  =>  0,
        ));
        $prop_db->update(db_create_in( $prop_ids, 'id'));
    }

    // 订单验证后，更新代金券使用状态，代金券下一步将完成
    public static function update_prop_use_status( $prop_id = '')
    {
        if ( !$prop_id )
            return false;
        
        $prop_ids = explode(',', $prop_id);
        $prop_db = new IModel('prop2');
        $prop_db->setData(array(
            'is_used'    =>  1,
        ));
        $prop_db->update(db_create_in( $prop_ids, 'id'));
    }
    
    
    // 订单完成后，更新代金券的状态
    public static function finish_prop( $prop_id = '' )
    {
        if ( !$prop_id )
            return false;
        
        $prop_ids = explode(',', $prop_id);
        $prop_db = new IModel('prop');
        $prop_db->setData(array(
            'is_close'    =>  1,
        ));
        $prop_db->update(db_create_in( $prop_ids, 'id'));
    }
    
    // 获取代金券详情
    public static function get_prop_info( $prop_id = 0 , $user_id = 0 )
    {
        if ( !$prop_id )
            return false;
        
        $where = '';
        $prop_db = new IQuery('prop2');
        $where = "id = " . $prop_id;
        if ( $user_id )
            $where .= " and user_id = " . $user_id;
        $prop_db->where = $where;
        
        return $prop_db->getOne();
    }
    
    // 代金券返现到余额
    public static function check_out_prop( $prop_id = 0 )
    {
        $prop_db = new IQuery('prop2');
        $prop_db->where = 'id = ' . $prop_id . ' and is_checkout = 1 and is_send = 1 and is_used = 0 and is_pay = 1';
        $prop_info = $prop_db->getOne();
        
        if ( $prop_info )
        {
            $value = $prop_info['value'];
            $user_id = $prop_info['user_id'];
            if ( $value > 0 && $user_id > 0 )
            {
                $log = new AccountLog();
                $config = array(
                    'user_id'  => $user_id,
                    'event'    => 'recharge', //withdraw:提现,pay:余额支付,recharge:充值,drawback:退款到余额
                    'num'      => $value, //整形或者浮点，正为增加，负为减少
                );
                if ($log->write($config))
                {
                    $prop_db = new IModel('prop2');
                    $prop_db->setData(array(
                        'is_close'  =>  1,
                        'is_checkout'   =>  2,
                    ));
                    $prop_db->update('id = ' . $prop_id);
                    return true;
                }
            }
        }
        return false;
    }
    
    // 验证代金券是否已使用
    public static function check_prop_is_used( $prop_id = '' )
    {
        if ( !$prop_id )
            return false;
        
        $return = false;
        $prop_ids = explode(',', $prop_id);
        $prop_db = new IQuery('prop2');
        $prop_db->where = db_create_in( $prop_ids, 'id' );
        $prop_list = $prop_db->find();
        if ( $prop_list )
        {
            foreach( $prop_list as $kk => $vv )
            {
                if ( $vv['is_used'] )
                    return true;
            }
        }
        
        return false;
    }
    
    public static function get_prop_by_product_id($user_id = 0,$goods_id = 0, $product_id = 0)
    {
        if ( !$user_id || !$goods_id || !$product_id )
            return false;
       
        $prop_db = new IQuery('prop2');
        $prop_db->where = 'user_id = ' . $user_id . ' and goods_id = ' . $goods_id . ' and product_id = ' . $product_id . ' and is_close = 0 and is_pay = 1 and is_used = 0';
        $prop_info = $prop_db->getOne();
        return $prop_info;
    }
    
    // 订单由商户或者系统主动取消后，修改代金券状态为可退款
    public static function update_prop_checkout_status( $prop_id = '', $type = 1)
    {
        if ( !$prop_id )
            return false;
    
        $prop_ids = explode(',', $prop_id);
        $prop_db = new IModel('prop');
        $prop_db->setData(array(
            'is_checkout'    =>  $type,
        ));
        $prop_db->update(db_create_in( $prop_ids, 'id'));
    }
    
    // 通过使用的数量获取相对应的代金券
    public static function get_prop_by_cprice( $user_id = 0 , $cprice = 0 )
    {
        $prop_db = self::get_prop_list_db(500, 1, $user_id, '', 'value asc');
        $prop_list = $prop_db->find();
        if ( !$prop_list )
            return false;
        
        $prop_arr = array();
        $prop_num = 0;
        foreach( $prop_list as $kk => $vv )
        {
            $prop_arr[] = $vv['id'];
            $prop_num += $vv['value'];
            if ( $prop_num >= $cprice )
            {
                return $prop_arr;
            }
        }
        return $prop_arr;
    }
    
    public static function get_user_prop_count( $user_id = 0 )
    {
        if ( !$user_id )
            return false;
        
        $user_prop_db = new IQuery('prop');
        $user_prop_db->where = ' user_id = ' . $user_id . ' and is_used = 0 and is_close = 0 and is_pay = 1 and is_send = 1 ';
        $user_prop_list = $user_prop_db->find();
        $user_prop_count = 0;
        if ( $user_prop_list )
        {
            foreach( $user_prop_list as $kk => $vv )
            {
                $user_prop_count += $vv['value'];
            }
        }
        
        /**
        $user_prop_count = 0;
        $user_prop_db = new IQuery('order as o');
        $user_prop_db->where = ' o.user_id = ' . $user_id . ' and o.if_del = 0 and o.pay_status = 1 and o.is_confirm = 0 and o.statement = 2 ';
        $user_prop_db->join = 'left join brand_chit as bc on o.chit_id = bc.id';
        $user_prop_db->fields = 'o.*,bc.max_order_chit';
        $user_prop_list = $user_prop_db->find();
        $user_prop_count = 0;
        if ( $user_prop_list )
        {
            foreach( $user_prop_list as $kk => $vv )
            {
                $user_prop_count += $vv['max_order_chit'];
            }
        }
        **/
        
        return $user_prop_count;
    }

    public static function get_user_prop_count_num( $user_id = 0 )
    {
        if ( !$user_id )
            return false;
        $user_prop_count = 0;
        $user_prop_db = new IQuery('order');
        $order_goods_db = new IModel('order_goods');
        $user_prop_db->where = ' user_id = ' . $user_id . ' and if_del = 0 and pay_status = 1 and is_confirm = 0 and statement = 2 ';
        $user_prop_list = $user_prop_db->find();
        $user_prop_count = 0;
        if ( $user_prop_list )
        {
            foreach( $user_prop_list as $kk => $vv )
            {
                $num = $order_goods_db->getObj("order_id = '$vv[id]'", 'goods_nums');
                $user_prop_count += $num['goods_nums'];
            }
        }
        
        return $user_prop_count;
    }
    
    public static function get_user_prop_list_on_cart($user_id = 0, $seller_id = 0, $order_amount = 0)
    {
        if ( !$user_id || !$seller_id || !$order_amount )
            return false;
        
        $query = new IQuery('order as o');
        //$query->where = "o.user_id =" . $user_id . " and o.seller_id = " . $seller_id . " and bc.max_order_amount <= $order_amount and o.if_del= 0 and o.statement = 2 and status = 2 and pay_status = 1 and p.is_used = 0 and p.is_close = 0 and p.is_pay = 1";
        $query->where = "o.user_id =" . $user_id . " and o.seller_id = " . $seller_id . " and o.if_del= 0 and o.statement = 2 and status = 2 and pay_status = 1 and p.is_used = 0 and p.is_close = 0 and p.is_pay = 1";
        $query->join = 'left join prop as p on p.id = o.prop left join brand_chit as bc on o.chit_id = bc.id';
        $query->fields = 'o.*, p.id as prop_id,p.value as prop_value,bc.max_price,bc.max_order_chit,bc.max_order_amount';
        $list = $query->find();
        return $list;
    }
    
    public static function get_max_prop_by_cprice($cprice = 0, $seller_id = 0)
    {
        if ( !$cprice || !$seller_id )
            return false;
        
        $seller_info = seller_class::get_seller_info($seller_id);
        if ( !$seller_info || !$seller_info['is_support_props'] )
            return false;
        
        $brand_chit_list = brand_chit_class::get_chit_list_by_seller_id($seller_id);
        if ( !$brand_chit_list )
        {
            $brand_chit_list = brand_chit_class::get_chit_list_by_seller_id(366);
        }
        if ( !$brand_chit_list )
            return false;
        
        $chit = 0;
        foreach($brand_chit_list as $kk => $vv )
        {
            if ( $cprice >= $vv['max_order_amount'] && $vv['max_order_chit'] > $chit )
                $chit = $vv['max_order_chit'];
        }
        return $chit;
    }
}

?>