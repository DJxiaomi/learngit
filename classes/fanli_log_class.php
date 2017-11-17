<?php 


class Fanli_log_class
{
    /**
     * 获取用户未完成返利的的信息，为避免当天0时0分出现订单的事情，所以添加 time < $today_time
     * @param array 用户ID组
     * @return array
     */
    public static function get_rebate_log_list( $user_arr = array() )
    {
        if ( !is_array( $user_arr ))
            return array();
        
        $fanli_log_db = new IQuery('fanlilog');
        
        // 该字段未索引
        $today = date('Y-m-d') . ' 00:00:00';
        $today_time = strtotime( $today );
        $fanli_log_db->where = db_create_in( $user_arr, 'user_id') . " and log_type = 1 and status = 0 and seller_id > 0 and time < $today_time and num > 0";
        $fanli_log_db->fields = 'id, user_id, seller_id, status, time, num, rebate_rule, order_no';
        
        return $fanli_log_db->find();
    }
}

?>