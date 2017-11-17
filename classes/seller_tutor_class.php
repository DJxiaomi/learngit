<?php

class seller_tutor_class 
{
    public static function get_seller_tutor_list_db($seller_id = 0, $page = 1, $page_size = 12)
    {
        if ( !$seller_id )
            return false;
        
        $seller_tutor_db = new IQuery('seller_tutor');
        $seller_tutor_db->where = 'seller_id = ' . $seller_id;
        $seller_tutor_db->page = $page;
        $seller_tutor_db->pagesize = $page_size;
        return $seller_tutor_db;
    }
    
    public static function get_seller_tutor_info($id = 0)
    {
        if ( !$id )
            return false;
        
        $seller_tutor_db = new IQuery('seller_tutor');
        $seller_tutor_db->where = 'id = ' . $id;
        return $seller_tutor_db->getOne();
    }
    
    // 获取家教的价格
    public static function get_tutor_dprice($id = 0)
    {
        $seller_tutor_info = self::get_seller_tutor_info($id);
        if ( !$seller_tutor_info )
            return false;

        return $seller_tutor_info['price'];
//         if ($seller_tutor_info['price'] >= 200)
//         {
//             return $seller_tutor_info['price'];
//         }
        
//         return ($seller_tutor_info['price'] >= 200) ? $seller_tutor_info['price'] : 200;
    }
    
    // 获取家教手续费
    public static function get_tutor_counter_fee()
    {
        $site_config=new Config('site_config');
        $tucommission = $site_config->tucommission;
        return ($tucommission) ? $tucommission / 100 : 0;
    }
    
    // 获取家教价格区间
    public static function get_seller_tutor_price($tutor_list = array())
    {
        $min = 0;
        $max = 0;
        if ($tutor_list)
        {
            foreach($tutor_list as $kk => $vv)
            {
                if ( $vv['price'] )
                {
                    if ( !$min )
                        $min = $vv['price'];
                    if ( !$max )
                        $max = $vv['price'];;
                    if ( $vv['price'] < $min )
                        $min = $vv['price'];
                    if ( $vv['price'] > $max )
                        $max = $vv['price'];
                }
            }
        }
        
        return ( $min == $max ) ? ( $min + 0 ): ($min + 0 ) .'-' . ($max + 0);
    }
    
    public static function get_seller_tutor_list_by_cat($cat = 0)
    {
        if ( !$cat)
        {
            return 0;
        }
        
        $seller_tutor_db = new IQuery('seller_tutor');
        $seller_tutor_db->where = 'grade_level = ' . $cat . '  or grade = ' . $cat . ' or category_id = ' . $cat . ' or category_id2 = ' . $cat;
        return $seller_tutor_db->find();
    }
    
    public static function get_seller_experience_arr()
    {
        return array(
            1 => array('min' => 1, 'max' => 3),
            array('min' => 3, 'max' => 6),
            array('min' => 6, 'max' => 8),
            array('min' => 8, 'max' => 10),
            array('min' => 10, 'max' => 30),
            array('min' => 30)
        );
    }
    
    public static function get_tutor_seller_list()
    {
        $seller_tutor_db = new IQuery('seller_tutor as st');
        $seller_tutor_db->join = 'left join seller as s on s.id = st.seller_id left join brand as b on s.brand_id = b.id';
        $seller_tutor_db->fields = 'distinct(st.seller_id) as seller_id';
        //$seller_tutor_db->where = 'st.is_publish = 1 and s.is_authentication = 1';
        $seller_tutor_db->where = 's.is_authentication = 1 and b.category_ids = 16';
        $list = $seller_tutor_db->find();
        $arr = array();
        
        if ( $list )
        {
            foreach( $list as $kk => $vv )
            {
                if ( !in_array($vv['seller_id'], $arr ))
                    $arr[] = $vv['seller_id'];
            }
        }
        
        return $arr;
    }
}

?>