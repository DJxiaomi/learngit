<?php 


class order_tutor_rewards_class
{
    public static function get_order_rewards($order_id = 0 )
    {
        if ( !$order_id )
            return false;
        
        $order_tutor_rewards_db = new IQuery('order_tutor_rewards');
        $order_tutor_rewards_db->where = 'order_id = ' . $order_id;
        $test_rewards = $order_tutor_rewards_db->find();
        
        if ( $test_rewards )
        {
            foreach( $test_rewards as $kk => $vv )
            {
                $test_rewards[$kk]['test_time'] = date('Y-m-d', $vv['test_time']);
            }
        }
        
        return $test_rewards;
    }
    
    public static function get_reward_status_title($status = 1)
    {
        switch($status)
        {
            case 1:
                return '未领取';
                break;
            case 2:
                return '领取中';
                break;
            case 3:
                return '已领取';
                break;
            case 4:
                return '已关闭';
                break;
        }
    }
    
    public static function get_reward_info($id=0)
    {
        if ( !$id )
        {
            return false;
        }
        
        $order_tutor_rewards_db = new IQuery('order_tutor_rewards');
        $order_tutor_rewards_db->where = 'id = ' . $id;
        return $order_tutor_rewards_db->getOne();
    }
    
    public static function can_apply_reward($id = 0)
    {
        $reward_info = self::get_reward_info($id);
        $time = time();
        
        return ( $reward_info && $reward_info['status'] == 1 && $time > strtotime("+7 days", $reward_info['test_time'])) ? true : false;
    }
    
    public static function insert_reward_logs($reward_id = 0, $action = 1, $role = 1, $content = '')
    {
        if ( !$reward_id )
            return false;
        
        $reward_info = self::get_reward_info($reward_id);
        if ( !$reward_info )
            return false;
        
        $order_tutor_rewards_db = new IModel('order_tutor_rewards');
        // 申请领取
        if ( $action == 1)
        {
            $order_tutor_rewards_db->setData(array(
                'status' => 2
            ));
            $order_tutor_rewards_db->update('id = ' . $reward_id);
            
            // 发送短消息给用户
            Mess::sendToUser($reward_info['user_id'],array('title' => '商户领取奖金申请','content' => '商户申请领取奖金，<a href="' . IUrl::creatUrl('/ucenter/handle_reward/id/' . $reward_id) . '">点击处理</a>'));
        } else if ( $action == 2 ) {
            // 拒绝
            $order_tutor_rewards_db->setData(array(
                'status' => 1
            ));
            $order_tutor_rewards_db->update('id = ' . $reward_id);
        } else if ( $action == 3) {
            // 同意
            $order_tutor_rewards_db->setData(array(
                'status' => 3
            ));
            $order_tutor_rewards_db->update('id = ' . $reward_id);
            
            Bill_class::add_sale($reward_info['seller_id'], $reward_info['test_money']);
            
            // 发送短消息给用户
            Mess::sendToUser($reward_info['seller_id'],array('title' => '奖金领取成功','content' => '奖金领取成功，<a href="' . IUrl::creatUrl('/seller/receive_reward/id/' . $reward_id) . '">点击查看</a>'), 2);
        }
        
        $arr = array(
            'reward_id' =>  $reward_id,
            'action'    =>  $action,
            'role'      =>  $role,
            'content'   =>  $content,
            'add_time'  =>  time(),
        );
        
        $order_tutor_rewards_log_db = new IModel('order_tutor_rewards_log');
        $order_tutor_rewards_log_db->setData($arr);
        $order_tutor_rewards_log_db->add();
    }
}

?>