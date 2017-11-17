<?php 

class dqk_cart_class
{
    public static function get_cart_list($user_id = 0)
    {
        $user_id = (!$user_id) ? $this->user['user_id'] : $user_id;
        if ( !$user_id )
        {
            return false;
        }
        
        $dqk_cart_db = new IQuery('dqk_cart as dc');
        $dqk_cart_db->join = 'left join brand_chit as bc on dc.brand_chit_id = bc.id left join seller as s on bc.seller_id = s.id left join brand as b on s.brand_id = b.id';
        $dqk_cart_db->where = 'dc.user_id = ' . $user_id . ' and bc.category = 2 and s.is_authentication = 1';
        $dqk_cart_db->fields = 'bc.*,dc.user_id,s.shortname,b.logo as seller_logo';
        $list = $dqk_cart_db->find();
        if ( $list )
        {
            foreach($list as $kk => $vv )
            {
                // 获取课程的相关信息
                $goods_info = goods_class::get_goods_info($vv['goods_id']);
                if ( $vv['product_id'] )
                {
                    $product_info = products_class::get_product_info($vv['product_id']);
                }
                $market_price = $vv['max_order_chit'];
                $list[$kk]['market_price'] = floor($market_price);
            }
        }
        return $list;
    }
    
    // 判断是否加入到短期课购物车了
    public static function is_join_cart($id = 0, $user_id = 0)
    {
        if ( !$id || !$user_id )
            return false;
        
        $brand_chit_db = new IQuery('dqk_cart');
        $brand_chit_db->where = 'brand_chit_id = ' . $id . ' and user_id = ' . $user_id;
        $result = $brand_chit_db->getOne();
        return ($result) ? true : false;
    }
    
    public static function remove_dqk($id = 0, $user_id = 0)
    {
        if ( !$id )
            return false;
        
        $dqk_cart_db = new IModel('dqk_cart');
        $dqk_cart_db->del('brand_chit_id = ' . $id . ' and user_id = ' . $user_id);
        return true;
    }
    
    public static function clear_dqk($user_id = 0)
    {
        $dqk_cart_db = new IModel('dqk_cart');
        $dqk_cart_db->del('user_id = ' . $user_id);
        return true;
    }
}

?>