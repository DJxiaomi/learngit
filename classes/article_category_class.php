<?php 

class article_category_class
{
    public static function get_category_info( $cid = 0 )
    {
        if ( !$cid )
            return false;
        
        $article_category_db = new IQuery('article_category');
        $article_category_db->where = 'id = ' . $cid;
        return $article_category_db->getOne();
    }
    
    // 获取子分类带分类内容
    public static function get_child_category_list( $parent_id = 0 )
    {
        $categorys = array();
        $article_category_db = new IQuery('article_category');
        $article_category_db->where = 'parent_id = ' . $parent_id;
        $article_category_db->fields = 'id,name,parent_id';
        $categorys = $article_category_db->find();
        if ( $categorys )
        {
            foreach( $categorys as $kk => $vv )
            {
                $cates = self::get_child_category_list( $vv['id'] );
                if ( $cates )
                    $categorys[$kk]['child'] = $cates;
            }
        }
        return $categorys;
    }
    
    public static function get_parent_category_list( $cid = 0 )
    {
        if ( !$cid )
            return false;
        
        $category = array();
        $article_category_db = new IQuery('article_category');
        $article_category_db->where = 'id = ' . $cid;
        $category[] = $article_category_db->getOne();
        if ( $category['parent_id'] != 0 )
        {
            $category[] = self::get_parent_category_list( $category['parent_id'] );
        }
        return $category;
    }
}

?>