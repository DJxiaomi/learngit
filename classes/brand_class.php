<?php 

/**
 * @copyright (c) 2016 lelele999.com
 * @file brand_class.php
 * @brief 品牌管理库
 * @author jack
 * @date 2016/7/27
 * @version 1.0
 */
 
class brand_class
{
    public static function get_brand_info( $brand_id = 0 ) 
    {
        if ( !$brand_id )
            return false;
        
        $brand_db = new IQuery('brand');
        $brand_db->where = 'id = ' . $brand_id;
        return $brand_db->getOne();
    }
    
    public static function get_brand_info_by_id_arr( $id_arr )
    {
        if ( !is_array( $id_arr ) || !$id_arr )
        {
            return false;
        }
        
        $brand_db = new IQuery('brand');
        $brand_db->where = db_create_in( $id_arr, 'id');
        return $brand_db->find();
    }
    
    public static function get_brand_list()
    {
        $brand_db = new IQuery('brand');
        $brand_db->where = '1 = 1';
        return $brand_db->find();
    }
    
    public static function get_brand_list_by_cat($catid = 0, $limit = 0)
    {
        $brand_db = new IQuery('brand as b');
        $where = (!$catid ) ? '1=1 and s.is_authentication = 1' : "b.category_ids = '$catid' and s.is_authentication = 1";
        $limit = (!$limit) ? 200 : 10;
        $brand_db->where = $where;
        $brand_db->fields = 'b.*';
        $brand_db->join = 'left join seller as s on s.brand_id = s.id';
        $brand_db->limit = $limit;
        return $brand_db->find();
    }

    public static function get_brand_category_list()
    {
        $brandcat_db = new IQuery('brand_category');
        $brandcat_db->where = '1 = 1';
        return $brandcat_db->find();
    }
    
    public static function get_brand_info_by_url( $host_name = '' )
    {
        if ( !$host_name )
            return false;
        
        $brand_db = new IQuery('brand');
        $brand_db->where = "url = '$host_name'";
        return $brand_db->getOne();
    }
    
    public static function get_rand_host()
    {
        $brand_db = new IQuery('brand');
        $brand_db->fields = 'url';
        $brand_db->where = "url != ''";
        $url_list = $brand_db->find();
        
        $url_arr = array();
        if ( $url_list )
        {
            foreach( $url_list as $kk => $vv )
            {
                $url_arr[] = $vv['url'];
            }
        }
        
        $str_arr = array( 0 => 'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
        $rand_str = array_rand($str_arr, 4);
        $str = '';
        if ( $rand_str )
        {
            foreach( $rand_str as $kk => $vv )
            {
                $str .= $str_arr[$vv];
            }
        }
        if ( !in_array( $str, $url_arr ))
            return $str;
        else
           return self::get_rand_host();
    }

    public static function get_brand_category_by_ids($arr){
        if(!$arr){
            return false;
        }

        $categroy_db = new IModel('brand_category');

        $arr_ids = explode(',',$arr);
        foreach($arr_ids as $v){            
            $cate_tmp = $categroy_db->getObj('id = ' . $v,'name');
            $categroy[] = $cate_tmp['name'];
        }

        return $categroy;
    }
}

?>