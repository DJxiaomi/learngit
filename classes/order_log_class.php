<?php 

class order_log_class
{
    // 添加订单日志
    public static function add_log( $order_id, $action )
    {
        $order_log_db = new IModel('order_log');
        $data = array(
            'order_id'  =>  $order_id,
            'action'    =>  $action,
            'addtime'   =>  ITime::getDateTime(),
        );
        $order_log_db->setData($data);
        $order_log_db->add();
    }
    
    // 读出订单日志
    public static function read_log($log_info = array())
    {
        $str = '';
        switch( $log_info['action'] )
        {
            case 2:
                $str = '订单提交成功';
                break;
            case 13:
                $str = '用户已付款到平台';
                break;
            case 4:
                $str = '用户确认报到，并付款到学校';
                break;
            case 6:
                $str = '学校已确认收款，用户已入学';
                break;
            case 12:
                $str = '申请退款';
                break;
            case 7:
                $str = '退款成功';
                break;
            case 5:
                $str = '订单取消';
                break;
        }
        return $str;
    }
    
    public static function get_order_logs( $order_id = 0 )
    {
        $order_log_db = new IQuery('order_log');
        $order_log_db->where = 'order_id = ' . $order_id;
        $order_log_list = $order_log_db->find();
        return $order_log_list;
    }
}

?>