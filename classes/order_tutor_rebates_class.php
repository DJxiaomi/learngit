<?php 


class order_tutor_rebates_class
{
    // 获取用户冻结待返还给商户的金额总数
    public static function get_user_rebate_amount($user_id = 0 )
    {
        if ( !$user_id )
            return 0;
        
        $order_tutor_rebates_db = new IQuery('order_tutor_rebates');
        $order_tutor_rebates_db->wehre = 'user_id = ' . $user_id . ' and is_pay = 0';
        $order_tutor_rebates_db->fields = 'sum(price) as c_count';
        $count = $order_tutor_rebates_db->getOne();
        return ( $count['c_count'] ) ? $count['c_count'] : 0;
    }
    
    // 获取商户待返还的金额总数
    public static function get_seller_rebate_amount($seller_id = 0)
    {
        if ( !$seller_id )
            return 0;
        
        $order_tutor_rebates_db = new IQuery('order_tutor_rebates');
        $order_tutor_rebates_db->wehre = 'seller_id = ' . $seller_id . ' and is_pay = 0';
        $order_tutor_rebates_db->fields = 'sum(price) as c_count';
        $count = $order_tutor_rebates_db->getOne();
        return ( $count['c_count'] ) ? $count['c_count'] : 0;
    }
}

?>