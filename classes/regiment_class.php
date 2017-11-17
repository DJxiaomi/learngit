<?php 

class Regiment_class
{
    public static function get_regiment_info_by_goods_id( $goods_id )
    {
        $time = date('Y-m-d H:i:s');
        $regi_db = new IQuery('regiment');
        $regi_db->where = 'goods_id = ' . $goods_id . " and unix_timestamp( '$time' ) > unix_timestamp( `start_time` ) and unix_timestamp( '$time' ) < unix_timestamp( `end_time` )";
        return $regi_db->getOne();
    }

    public static function get_promotion_info_by_goods_id( $goods_id )
    {
        $time = date('Y-m-d H:i:s');
        $query = new IQuery('promotion');
        $query->where = '`condition` = ' . $goods_id . " and type = '1' and unix_timestamp( '$time' ) > unix_timestamp( `start_time` ) and unix_timestamp( '$time' ) < unix_timestamp( `end_time` )";
        return $query->getOne();
    }
}

?>