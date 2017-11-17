<?php

class booking_class
{
    public static function get_booking_list_db($user_id = 0, $page = 1,$page_size = 12)
    {
        $booking_db = new IQuery('booking');
        if ( $user_id > 0 )
            $booking_db->where = 'user_id = ' . $user_id;
        else
            $booking_db->where = '1 = 1';
        $booking_db->page = $page;
        $booking_db->pagesize = $page_size;
        $booking_db->order = 'add_time desc';
        return $booking_db;
    }
    
    public static function get_booking_info($id = 0)
    {
        if ( !$id )
            return false;
        
        $booking_db = new IQuery('booking');
        $booking_db->where = 'id = ' . $id;
        return $booking_db->getOne();
    }
    
    public static function get_booking_info_by_order_id($order_id = 0)
    {
        if ( !$order_id )
            return false;
        
        $booking_db = new IQuery('booking');
        $booking_db->where = 'order_id = ' . $order_id;
        return $booking_db->getOne();
    }
    
    /**
     * 匹配预定订单
     * @param number $order_id
     * @return boolean
     */
    public static function match_booking_order($order_id = 0)
    {
        if ( !$order_id )
            return false;
        
        // 读取订单和商户信息
        $order_info = order_class::get_order_info($order_id);
        
        if ( $order_info['statement'] != 1 )
            return false;
        
        if ( !$order_info || !$order_info['pay_status'] )
            return false;
        
        // 分别读取用户信息和商户信息
        $user_info = user_class::get_user_info($order_info['user_id']);
        $seller_info = seller_class::get_seller_info($order_info['seller_id']);
        $add_time = strtotime("-3 days",strtotime($order_info['create_time']));
        
        // 获取课程名称
        $order_goods_list = Order_goods_class::get_order_goods_list($order_id);
        if ( $order_goods_list )
        {
            $order_goods_list = current($order_goods_list);
            $goods_array = json_decode($order_goods_list['goods_array']);
            $goods_name = $goods_array->name;
        }
        
        $booking_db = new IQuery('booking');
        $booking_db2 = new IModel('booking');
        $booking_db->where = "order_id = 0 and add_time >= $add_time and (username = '" . $user_info['username'] . "' or true_name = '" . $order_info['accept_name'] . "' or mobile = '" . $order_info['mobile'] . "')";
        $booking_list = $booking_db->find();
        if ( $booking_list )
        {
            foreach( $booking_list as $kk => $vv )
            {
                $points = 0;
                
                // 匹配商户全称或简称
                if ( $vv['seller_name'] == $seller_info['true_name'] || $vv['seller_name'] == $seller_info['shortname'] )
                    $points++;
                
                // 匹配课程名称
                if ( $vv['goods_name'] == $goods_name && $goods_name != '')
                    $points++;
                
                if ( $points >= 2 )
                {
                    $booking_db2->setData(array('order_id' => $order_info['id']));
                    $booking_db2->update('id = ' . $vv['id'] );
                    return true;
                }
            }
        }
    }
}

?>