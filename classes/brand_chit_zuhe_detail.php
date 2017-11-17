<?php 

class brand_chit_zuhe_detail
{
    public static function get_detail_list($zuhe_id = 0)
    {
        $zuhe_detail_db = new IQuery('brand_chit_zuhe_detail as bczd');
        $zuhe_detail_db->join = 'left join brand_chit as bc on bczd.brand_chit_id = bc.id';
        $zuhe_detail_db->fields = 'bc.*,bczd.zuhe_id';
        $zuhe_detail_db->where = 'bczd.zuhe_id = ' . $zuhe_id;
        return $zuhe_detail_db->find();
    }
}

?>