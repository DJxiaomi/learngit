<?php 

class order_tutor_rewards_log_class
{
    public static function get_reward_logs($id = 0)
    {
        if ( !$id)
            return false;
        
        $order_tutor_rewards_log_db = new IQuery('order_tutor_rewards_log');
        $order_tutor_rewards_log_db->where = 'reward_id = ' . $id;
        $order_tutor_rewards_log_db->order = 'add_time desc';
        return $order_tutor_rewards_log_db->find();
    }
    
    public static function get_reward_log_title($log_info = array())
    {
        if (!$log_info)
            return false;
        
        $str = ($log_info['role'] == 1) ? '用户' : '教师';
        switch($log_info['action'])
        {
            case 1:
                $str .= '申请领取奖金';
                break;
            case 2:
                $str .= '拒绝同意';
                break;
            case 3:
                $str .= '发放奖金';
                break;
        }
        
        return $str;
    }
}


?>