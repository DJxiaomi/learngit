<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP version 5                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2004 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 3.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.php.net/license/3_0.txt.                                  |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors: Original Author <author@example.com>                        |
// |          Your Name <you@example.com>                                 |
// +----------------------------------------------------------------------+
//
// $Id:$

class category_class {
    // 获取子分类
    public static function get_child_category($parent_id = 0) {
        $category_db = new IQuery('category');
        $category_db->where = 'parent_id = ' . $parent_id;
        $category_db->fields = 'id';
        $category_ids = $parent_id;
        $child_category = $category_db->find();
        if ($child_category) {
            foreach ($child_category as $kk => $vv) {
                $category_ids.= ',' . self::get_child_category($vv['id']);
            }
        }
        return $category_ids;
    }
    // 获取网站所有分类
    public static function get_site_category($parent_id = 0, $show_all = 1) {
        $categorys = array();
        $category_db = new IQuery('category');
        if ( $show_all )
            $category_db->where = 'parent_id = ' . $parent_id;
        else
            $category_db->where = 'parent_id = ' . $parent_id . ' and visibility = 1';
        $category_db->order = 'sort asc';
        $category_db->fields = 'id,name,parent_id';
        $categorys = $category_db->find();
        if ($categorys) {
            foreach ($categorys as $kk => $vv) {
                $cates = self::get_site_category($vv['id'], $show_all);
                if ($cates) $categorys[$kk]['child'] = $cates;
            }
        }
        return $categorys;
    }
    
    // 获取单个分类下的子分类
    public static function get_category_list_by_parent($parent_id = 0 )
    {
        $category_db = new IQuery('category');
        $category_db->where = 'parent_id = ' . $parent_id . ' and visibility = 1';
        $category_db->fields = 'id,name,parent_id';
        $list =  $category_db->find();
        
        $arr = array();
        if ( $list )
        {
            foreach($list as $kk => $vv )
            {
                $arr[$vv['id']] = $vv;
            }
        }
        
        return $arr;
    }
    
    public static function get_category_title($cat_id = 0 )
    {
        if ( !$cat_id )
            return false;
        
        $category_db = new IQuery('category');
        $category_db->where = 'id = ' . $cat_id;
        $cate_info = $category_db->getOne();
        return ($cate_info) ? $cate_info['name'] : '';
    }

    public static function category_handle($category){
        if ( !$category )
            return false;

        $category_db = new IQuery('category');

        foreach($category as $v){
            $category_db->where = " name like '%".$v."%' and visibility = 1 and seller_id = 0";
            $category_db->fields = 'id,name,parent_id';
            $cate_tmp = $category_db->find(); 
            if($cate_tmp){
                $catelist[] = $cate_tmp;
            }
                            
        }
        
        if( count($catelist) == count($category) && count($catelist) == 2){
            foreach($catelist[0] as $val){
                foreach($catelist[1] as $v){
                    if($val['id'] == $v['parent_id']){
                        $new_arr[] = $v;
                        break;
                    }
                }
            }

            $catelist = $new_arr;

            return $catelist;
        }

        
        return false;

    }
}
?>      
