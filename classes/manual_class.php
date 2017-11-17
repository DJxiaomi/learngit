<?php 

class manual_class
{
    // 获取手册列表
    public function get_manual_list($where,$page,$page_size)
    {
        if ( !$where )
            $where = '1=1';
        $manual_db = new IQuery('manual');
        $manual_db->where = $where;
        $manual_db->page = $page;
        $manual_db->pagesize = $page_size;
        $manual_list = $manual_db->find();
         
        if ( $manual_list )
        {
            foreach($manual_list as $kk => $vv )
            {
                if ( $vv['user_id'] > 0 )
                {
                    $user_info = user_class::get_user_info($vv['user_id']);
                    $manual_list[$kk]['username'] = $user_info['username'];
                }
            }
        }
        
        return array(
            'list'  =>  $manual_list,
            'page_info' =>  $manual_db->getPageBar(),
        );
    }
    
    // 检验手册是否可用
    public function is_avalible($code = '', $user_id = 0)
    {
        if ( !$code )
        {
            return -2;
        }
        
        $manual_db = new IQuery('manual');
        $manual_db->where = "activation_code = '$code'";
        $result = $manual_db->getOne();
        if ( !$result )
        {
            return -1;
        } else {
            if ( !$result['is_activation'] && (!$result['user_id'] || ($result['user_id'] == $user_id) ))
                return $result['id'];
            else
                return 0;
        }
    }
    
    // 根据用户ID获取信息
    public function get_manual_info_by_userid($user_id = 0)
    {
        if ( !$user_id )
            return false;
        
        $manual_db = new IQuery('manual');
        $manual_db->where = 'user_id = ' . $user_id;
        return $manual_db->getOne();
    }
    
    // 获取手册信息
    public function get_manual_info($manual_id = 0)
    {
        if ( !$manual_id )
            return false;
        
        $manual_db = new IQuery('manual');
        $manual_db->where = 'id = ' . $manual_id;
        return $manual_db->getOne();
    }
    
    public function get_manual_list_by_userid($user_id = 0)
    {
        if ( !$user_id )
            return false;
        
        $manual_db = new IQuery('manual');
        $manual_db->where = 'user_id = ' . $user_id;
        return $manual_db->find();
    }
    
    public function create_manual($user_id = 0)
    {
        $code = self::get_activation_code();
        $data = array(
            'user_id'   =>  $user_id,
            'activation_code'   =>  $code,
            'is_activation'     =>  0,
        );
        
        $manual_db = new IModel('manual');
        $manual_db->setData($data);
        $manual_db->add();
    }
    
    public static function get_activation_code()
    {
        $db = IDBFactory::getDB();
        $sql = "SELECT FLOOR( 10000000 + RAND() * (99999999 - 10000000)) as `activation_code` from `iwebshop_manual` where activation_code not in ( select activation_code from `iwebshop_manual` where activation_code > 0  ) limit 1";
        $verification_code = $db->query( $sql );
    
        if ( !$verification_code[0]['verification_code'] )
        {
            return mt_rand(10000000,99999999);
        } else {
            return $verification_code[0]['verification_code'];
        }
    }
    
    public static function check_manual($id = 0, $user_id = 0)
    {
        if ( !$id || !$user_id )
            return false;
        
        $manual_db = new IQuery('manual');
        $manual_db->where = 'id = ' . $id . ' and user_id = ' . $user_id;
        return $manual_db->getOne();
    }
    
    public static function check_manual_category($id = 0, $category = 0)
    {
        
    }
    
    
}

?>