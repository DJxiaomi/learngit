<?php 

class brand_chit_zuhe_use_list_class
{
    public static function get_brand_chit_zuhe_use_list_info($id = 0)
    {
        if ( !$id )
            return false;
        
        $brand_chit_zuhe_use_list_db = new IQuery('brand_chit_zuhe_use_list');
        $brand_chit_zuhe_use_list_db->where = 'id = ' . $id;
        $info = $brand_chit_zuhe_use_list_db->getOne();
        return $info;
    }
}

?>