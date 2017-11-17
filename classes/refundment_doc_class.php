<?php 

class Refundment_doc_class 
{
    /**
     * 获取用户退款的订单
     * @param number $user_id
     * @param string $where
     * @param string $fields
     */
    public static function get_refund_orders( $user_id = 0, $where = '1', $fields = '*')
    {
        if ( !$user_id )
            return false;
        
        if ( !$where )
            $where = '1';
        
        if ( !$fields )
            $fields = '*';
        
        $refund_db = new IQuery('refundment_doc');
        $refund_db->where = 'user_id = ' . $user_id . ' and ' . $where;
        $refund_db->fields = $fields;
        return $refund_db->find();
    }
    
    /**
     * 判断订单是否正在进行退款
     * @param unknown $order_id
     */
    public static function is_order_refund( $order_id )
    {
        $refund_db = new IQuery('refundment_doc');
        $refund_db->where = 'order_id = ' . $order_id;
        return ( $refund_db->getOne() ) ? true : false;
    }
    
    public static function get_refund_info( $refund_id = 0 )
    {
        if ( !$refund_id )
            return false;
        
        $refund_db = new IQuery('refundment_doc');
        $refund_db->where = 'id = ' . $refund_id;
        return $refund_db->getOne();
    }            public static function get_refund_list_db($seller_id = 0, $where)    {        $refund_db = new IQuery('refundment_doc as rd');        $refund_db->join = 'left join order as o on rd.order_id = o.id';        $condition = 'rd.if_del = 0';        if ( $seller_id > 0 )        {            $condition .= ' and rd.seller_id = ' . $seller_id;        }        if ( $where != '')        {            $condition .= $where;        }        $refund_db->where = $condition;        $refund_db->order = 'rd.id desc';        $refund_db->fields = 'rd.*,o.*,rd.id as rid,rd.pay_status as r_pay_status';        return $refund_db;    }
}

?>