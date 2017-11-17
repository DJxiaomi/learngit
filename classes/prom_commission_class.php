<?php 

class prom_commission_class
{
    // 获取个人提成总额
    public static function get_user_commision_count($user_id = 0, $user_type = 1, $month = 0)
    {
        $prom_commission_db = new IQuery('prom_commission');
        $prom_commission_db->fields = 'commission';
        $where = 'type = 1 and level = 1';
        $where .= ( $user_type == 1 ) ? ' and user_id = ' . $user_id : ' and seller_id = ' . $user_id;
        if ( $month )
        {
            $time_limit = promote_class::get_month_limit($month);
            $start_time = strtotime($time_limit[0]);
            $end_time = strtotime($time_limit[1]);
            $where .= " and ( create_time >= $start_time and create_time < $end_time )";
        }
        $prom_commission_db->where = $where;
        $commission_list = $prom_commission_db->find();
        $commission_count = 0;
        if ( $commission_list )
        {
            foreach( $commission_list as $kk => $vv )
            {
                $commission_count += $vv['commission'];
            }
        }
        return $commission_count;
    }
    
    // 获取商户提成总额
    public static function get_seller_commision_count($user_id = 0, $user_type = 1, $month = 0)
    {
        $prom_commission_db = new IQuery('prom_commission');
        $prom_commission_db->fields = 'commission';
        $where = 'type = 2 and level = 1';
        $where .= ( $user_type == 1 ) ? ' and user_id = ' . $user_id : ' and seller_id = ' . $user_id;
        if ( $month )
        {
            $time_limit = promote_class::get_month_limit($month);
            $start_time = strtotime($time_limit[0]);
            $end_time = strtotime($time_limit[1]);
            $where .= " and ( create_time >= $start_time and create_time < $end_time )";
        }
        $prom_commission_db->where = $where;
        $commission_list = $prom_commission_db->find();
        $commission_count = 0;
        if ( $commission_list )
        {
            foreach( $commission_list as $kk => $vv )
            {
                $commission_count += $vv['commission'];
            }
        }
        return $commission_count;
    }
    
    // 获取下级提成
    public static function get_other_commision_count($user_id = 0, $user_type = 1, $month = 0)
    {
        $prom_commission_db = new IQuery('prom_commission');
        $prom_commission_db->fields = 'commission';
        $where = 'level != 1';
        $where .= ( $user_type == 1 ) ? ' and user_id = ' . $user_id : ' and seller_id = ' . $user_id;
        if ( $month )
        {
            $time_limit = promote_class::get_month_limit($month);
            $start_time = strtotime($time_limit[0]);
            $end_time = strtotime($time_limit[1]);
            $where .= " and ( create_time >= $start_time and create_time < $end_time )";
        }
        $prom_commission_db->where = $where;
        $commission_list = $prom_commission_db->find();
        $commission_count = 0;
        if ( $commission_list )
        {
            foreach( $commission_list as $kk => $vv )
            {
                $commission_count += $vv['commission'];
            }
        }
        return $commission_count;
    }
}

?>