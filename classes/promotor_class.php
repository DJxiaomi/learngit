<?php 

class promotor_class
{
    // 获取推广者信息
    public static function get_promotor_info($prom_code = '')
    {
        $user_ere = '/^[0-9]+$/';
        preg_match_all($user_ere, $prom_code, $result);
        if ( $result[0] )
        {
            $id = $result[0][0];
            $user_db = new IQuery('user as u');
            
            $user_db->join = 'left join member as m on u.id = m.user_id';
            
            $user_db->fields = 'u.*,m.true_name';
            $user_db->where = 'u.id = ' . $id;
            $user_info = $user_db->getOne();
            return ($user_info) ? $user_info : false;
        }
        $seller_ere = '/^[sS]([0-9]+)$/';
        preg_match_all($seller_ere, $prom_code, $result);
        if ( $result[1] )
        {
            $id = $result[1][0];
            $seller_db = new IQuery('seller');
            $seller_db->where = 'id = ' . $id;
            $seller_info = $seller_db->getOne();
            return ($seller_info) ? $seller_info : false;
        }
        return false;
    }
    
    public static function get_promotor_info2($prom_code = '')
    {
        $user_ere = '/^[0-9]+$/';
        preg_match_all($user_ere, $prom_code, $result);
        if ( $result[0] )
        {
            $id = $result[0][0];
            $user_db = new IQuery('user');
            $user_db->where = 'id = ' . $id;
            $user_info = $user_db->getOne();
            if ( $user_info )
            {
                return array(
                    'type'          =>   'user',
                    'user_id'       =>  $id,
                    'promo_code'    =>  $user_info['promo_code'],
                );
            }
        }
        $seller_ere = '/^[sS]([0-9]+)$/';
        preg_match_all($seller_ere, $prom_code, $result);
        if ( $result[1] )
        {
            $id = $result[1][0];
            $seller_db = new IQuery('seller');
            $seller_db->where = 'id = ' . $id;
            $seller_info = $seller_db->getOne();
            if ( $seller_info )
            {
                return array(
                    'type'          =>  'seller',
                    'user_id'       =>  $id,
                    'promo_code'    =>  $seller_info['promo_code'],
                );
            }
        }
        
        return array();
    }
    
    // 获取我名下所有推广人
    public static function get_my_promotor_list($prom_code = '', $filter = true)
    {
        $promotor_info = self::get_promotor_info($prom_code);
        if ( !$promotor_info )
            return array();
        
        $promotor_list = self::_get_my_promotor_list($prom_code);
        $promotor_list = explode(',', $promotor_list);
        unset($promotor_list[0]);
        
        if ( $filter )
        {
            $ere = '/^[0-9]+$/';
            $arr = array();
            foreach($promotor_list as $kk => $vv )
            {
                if ( preg_match($ere, $vv))
                {
                    $arr['users'][] = $vv;
                } else {
                    $arr['sellers'][] = $vv;
                }
            }
            
            return $arr;
        } else {
            return $promotor_list;
        }

    }
    
    // 递归获取
    public static function _get_my_promotor_list($prom_code = '')
    {
        $ids = $prom_code;
        $promotor_db = new IQuery('promotors');
        $promotor_db->fields = 'promo_code';
        $promotor_db->where = "parent_promo_code='$prom_code'";
        $promo_list = $promotor_db->find();
        if ( $promo_list )
        {
            foreach($promo_list as $kk => $vv )
            {
                $ids .= ',' . self::_get_my_promotor_list($vv['promo_code']);
            }
        }
        return $ids;
    }
    
    // 插入推广人
    public static function insert_promotor($promo_code, $parent_promo_code = '')
    {
        $promotor_db = new IQuery('promotors');
        $promotor_db->where = "promo_code = '$promo_code'";
        $promotor_info = $promotor_db->getOne();
        if ( $promotor_info )
            return true;
        
        $data = array(
            'promo_code'    =>  $promo_code,
            'create_time'   =>  time(),
        );
        if ( $parent_promo_code != '' && $parent_promo_code != $promo_code )
            $data['parent_promo_code'] = $parent_promo_code;
        
        $promotor_db = new IModel('promotors');
        $promotor_db->setData($data);
        $promotor_db->add($data);
    }

    public static function get_promotor_name_by_promotor_info($promotor_info = array())
    {
        if ( isset($promotor_info['username']) )
        {
            return ($promotor_info['true_name']) ? $promotor_info['true_name'] : $promotor_info['username'];
        } else {
            return $promotor_info['shortname'];
        }
    }
}

?>