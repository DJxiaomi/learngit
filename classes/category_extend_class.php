<?php 

class Category_extend_class
{
    public static function get_category_by_goods_id( $goods_id )
    {
        if ( !$goods_id )
            return false;
        
        $category_ex_db = new IQuery('category_extend ce');
        $category_ex_db->join = 'left join category as c on c.id = ce.category_id';
        $category_ex_db->where = 'ce.goods_id = ' . $goods_id;
        $category_list = $category_ex_db->find();
        
        $cate = '';
        if ( $category_list )
        {
            foreach( $category_list as $kk => $vv )
            {
                $cate .= ( !$cate ) ? $vv['name'] : ' ' . $vv['name'];
            }
        }
        return $cate;
    }
    
    public static function get_category_id_by_goods_id( $goods_id )
    {
        if ( !$goods_id )
            return false;
        
        $category_ex_db = new IQuery('category_extend ce');
        $category_ex_db->where = 'goods_id = ' . $goods_id;
        $category_ex_info = $category_ex_db->getOne();
        return ( $category_ex_info ) ? $category_ex_info['category_id'] : 0;
    }
    public static function get_category_by_goods_ids( $ids_arr )
    {
        if ( !$ids_arr )
            return false;
        
        $category_ex_db = new IQuery('category_extend ce');
        $category_ex_db->join = 'left join category as c on c.id = ce.category_id';
        $category_ex_db->where = db_create_in( $ids_arr, 'ce.goods_id');
        $category_list = $category_ex_db->find();
        
        $category_info = array();
        if ( $category_list )
        {
            foreach( $category_list as $kk => $vv )
            {
                $category_info[$vv['goods_id']] .= ( !$category_info[$vv['goods_id']] ) ? $vv['name'] : ' ' . $vv['name'];
            }
        }
        
        return $category_info;
    }
    
    
    public static function get_category_name_by_store( $store_id )
    {
        if ( !$store_id )
            return false;
        
        $goods_db = new IQuery('goods g');
        $goods_db->join = 'left join category_extend as ce on g.id = ce.goods_id left join category as c on c.id = ce.category_id';
        $goods_db->where = 'g.seller_id = ' . $store_id . ' and ce.category_id > 0 ';
        $goods_db->fields = 'c.id, c.name';
        $category_list = $goods_db->find();
        
        if ( $category_list )
        {
            $category_arr = array();
            foreach( $category_list as $kk => $vv )
            {
                $category_arr[$vv['name']]++;
            }
            arsort( $category_arr );
            $category_arr = array_keys( $category_arr );
            $category_arr = array_chunk( $category_arr, 3 );
            return implode(' ', $category_arr[0] );
        }
         return '';
    }
    
    public static function get_rand_seller( $cate_arr )
    {
        if ( !$cate_arr )
            return false;
        
        $goods_db = new IQuery('goods as g');
        $goods_db->join = 'left join category_extend as ce on g.id = ce.goods_id left join seller as s on g.seller_id = s.id';
        $goods_db->fields = 'g.id,g.seller_id,s.logo';
        $goods_db->where = db_create_in($cate_arr, 'ce.category_id') . " and s.logo != ''";
        $goods_list = $goods_db->find();
        
        $rand = array_rand( $goods_list, 1 );
        return $goods_list[$rand];
    }
}

?>