<?php 

class discussion_class
{
    // 获取票数
    public static function get_vote_count($goods_id = 0)
    {
        if ( !$goods_id)
            return false;
    
        $discussion_db = new IQuery('discussion');
        $discussion_db->where = 'goods_id = ' . $goods_id;
        $result = $discussion_db->find();
        return sizeof( $result );
    }
    
    // 获取排名
    public static function get_vote_range($goods_id = 0)
    {
        if ( !$goods_id )
            return false;
        
        $goods_info = goods_class::get_goods_info($goods_id);
        if ( !$goods_info )
            return false;
        
        $goods_list = goods_class::get_goods_list_by_seller_id($goods_info['seller_id'], 1000000);
        $goods_list2 = array();
        $vote_arr = array();
        if ( $goods_list )
        {
            foreach( $goods_list as $kk => $vv )
            {
                $vote_count = self::get_vote_count($vv['id']);
                $goods_list2[$kk]['id'] = $vv['id'];
                $goods_list2[$kk]['vote_count'] = $vote_count;
                $vote_arr[] = $vote_count;
            }
        }
    
        array_multisort($vote_arr, SORT_DESC, $goods_list2);
        foreach( $goods_list2 as $kk => $vv )
        {
            if ( $vv['id'] == $goods_id )
                return $kk + 1;
        }
        
        
    }
}

?>