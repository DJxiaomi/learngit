<?php 

class article_reply_class
{
    // 获取文章的回复列表
    public static function get_article_reply_list( $article_id = 0, $page = 1, $page_size = 10 )
    {
        if ( !$article_id )
            return false;
        
        $page = max( $page, 1 );
        $article_reply_db = new IQuery('article_reply');
        $article_reply_db->where = 'article_id = ' . $article_id;
        $article_reply_db->page = $page;
        $article_reply_db->pagesize = $page_size;
        return $article_reply_db;
    }
    
    // 获取文章回复总数
    public static function get_article_reply_count( $article_id = 0 )
    {
        if ( !$article_id )
            return false;
        
        $article_reply_db = new IQuery('article_reply');
        $article_reply_db->where = 'article_id = ' . $article_id;
        $article_reply_db->fields = 'count(*) as c_count';
        $result = $article_reply_db->getOne();
        if ( $result )
        {
            return $result['c_count'];
        } else {
            return 0;
        }
    }
}

?>