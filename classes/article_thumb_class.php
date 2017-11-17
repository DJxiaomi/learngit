<?php 

class article_thumb_class
{
    // 验证是否可点赞
    public static function can_thumb($id = 0, $user_id = 0)
    {
        if ( !$id || !$user_id )
            return false;
        
        $article_reply_thumb_db = new IQuery('article_thumb');
        $article_reply_thumb_db->where = "article_id = $id and user_id = $user_id";
        $result = $article_reply_thumb_db->getOne();
        return (!$result) ? true : false;
    }
    
    // 点赞
    public static function add_thumb($id = 0, $user_id = 0)
    {
        if ( !$id || !$user_id )
            return false;
        
        $data = array(
            'article_id'  =>  $id,
            'user_id'   =>  $user_id,
            'add_time'  =>  time(),
        );
        $article_reply_thumb_db = new IModel('article_thumb');
        $article_reply_thumb_db->setData($data);
        if ( $article_reply_thumb_db->add() )
        {
            die('1');
        } else {
            die('0');
        }
    }
    
    // 获取点赞总数
    public static function get_article_thumb_count($id = 0)
    {
        if ( !$id )
            return 0;
        
        $article_reply_thumb_db = new IQuery('article_thumb');
        $article_reply_thumb_db->fields = 'count(*) as c_count';
        $article_reply_thumb_db->where = 'article_id = ' . $id;
        $list = $article_reply_thumb_db->getOne();
        return $list['c_count'];
    }
}

?>