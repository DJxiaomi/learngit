<?php 

class brand_chit_zuhe
{
    public static function get_brand_zuhe_list($zuhe_id = 0)
    {
        if ( !$zuhe_id)
        {
            return false;
        }
        
        $brand_chit_db = new Iquery('brand_chit as bc');
        $brand_chit_db->join = 'left join brand_chit_zuhe_detail as bczd on bc.id = bczd.brand_chit_id left join seller as s on bc.seller_id = s.id';
        $brand_chit_db->fields = 'bc.*,s.shortname';
        $brand_chit_db->where = 'bczd.zuhe_id = ' . $zuhe_id;
        return $brand_chit_db->find();
    }
}

?>