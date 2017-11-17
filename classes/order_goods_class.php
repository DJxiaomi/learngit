<?php 

class Order_goods_class
{
    public static function get_verification_code()
    {
        $db = IDBFactory::getDB();
        $sql = "SELECT FLOOR( 10000000 + RAND() * (99999999 - 10000000)) as `verification_code` from `iwebshop_order_goods` where verification_code not in ( select verification_code from `iwebshop_order_goods` where verification_code > 0  ) limit 1";
        $verification_code = $db->query( $sql );
        
        if ( !$verification_code[0]['verification_code'] )
        {
            return mt_rand(10000000,99999999);
        } else {
            return $verification_code[0]['verification_code'];
        }
        
    }
    
    public static function get_order_goods_list( $order_id )
    {
        $order_goods_db = new IQuery('order_goods');
        $order_goods_db->where = 'order_id = ' . $order_id;
        return $order_goods_db->find();
    }
}

?>