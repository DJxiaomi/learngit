<?php 

class seller_discount_level_class
{
    // 获取学校折扣列表
    public static function get_seller_discount_level_list($seller_id = 0)
    {
        if (!$seller_id)
            return false;
        
        $seller_discount_level_db = new IQuery('seller_discount_level');
        $seller_discount_level_db->where = 'seller_id = ' . $seller_id;
        $seller_discount_level_db->order = 'discount desc';
        return $seller_discount_level_db->find();
    }
    
    // 根据价格获取商家的折扣金额
    public static function get_seller_discount_by_price($seller_id = 0, $price = 0, $type = 1)
    {
        if ( !$seller_id || !$price )
            return false;
        
        $seller_discount_level_db = new IQuery('seller_discount_level');
        $seller_discount_level_db->where = 'seller_id = ' . $seller_id . ' and start_price <= ' . $price;
        $seller_discount_level_db->order = 'discount desc';
        $discount_info = $seller_discount_level_db->getOne();
        if ( $type == 1)
            return ($discount_info['discount'] > 0) ? $discount_info['discount'] : 0;
        else
            return $discount_info;
    }
}

?>