<?php 

class manual_use_list_class
{
    public function get_manual_use_list($user_id = 0)
    {
        if ( !$user_id )
            return false;
        
        $manual_use_list_db = new IQuery('manual_use_list');
        $manual_use_list_db->where = 'user_id = ' . $user_id;
        $manual_use_list = $manual_use_list_db->find();
        return $manual_use_list;
    }
    
    
    // 验证能否使用手册
    public function get_manual_use_list_by_seller_id($user_id = 0,$manual_id = 0, $seller_id = 0)
    {
        if ( !$user_id || !$manual_id || !$seller_id )
        {
            return false;
        }
        
        $manual_use_list_db = new IQuery('manual_use_list');
        $manual_use_list_db->where = 'user_id = ' . $user_id . ' and manual_id = ' . $manual_id . ' and seller_id = ' . $seller_id;
        $manual_use_list = $manual_use_list_db->find();
        return $manual_use_list;
    }
    
    public function get_manual_use_list_by_dqk_id($user_id = 0, $manual_id = 0, $dqk_id = 0)
    {
        if ( !$user_id || !$manual_id || !$dqk_id )
        {
            return false;
        }
        
        $manual_use_list_db = new IQuery('manual_use_list');
        $manual_use_list_db->where = 'user_id = ' . $user_id . ' and manual_id = ' . $manual_id . ' and dqk_id = ' . $dqk_id;
        $manual_use_list_db->order = 'time desc';
        $manual_use_list = $manual_use_list_db->find();
        return $manual_use_list;
    }
    
}

?>