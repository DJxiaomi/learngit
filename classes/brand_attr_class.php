<?php 

class brand_attr_class
{
    public static function get_brand_attr_list( $brand_id = 0 )
    {
        if ( !$brand_id )
            return false;
        
        $brand_attr_db = new IQuery('brand_attr');
        $brand_attr_db->where = 'brand_id = ' . $brand_id;
        $brand_attr_db->order = 'id desc';
        $brand_attr_list =  $brand_attr_db->find();
        
        if ( $brand_attr_list )
        {
            $delim_1 = '|';
            foreach( $brand_attr_list as $kk => $vv )
            {
                $brand_attr_list[$kk]['img'] = explode($delim_1, $vv['img'] );
                $brand_attr_list[$kk]['imgtitle'] = explode($delim_1, $vv['imgtitle'] );
                $brand_attr_list[$kk]['imgbrief'] = explode($delim_1, $vv['imgbrief'] );
            }
        }
        
        return $brand_attr_list;
    }
}

?>