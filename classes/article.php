<?php
/**
 * @copyright (c) 2011 aircheng.com
 * @file article.php
 * @brief 关于文章管理
 * @author chendeshan
 * @date 2011-02-14
 * @version 0.6
 */

 /**
 * @class article
 * @brief 文章管理模块
 */
class Article
{
	//显示标题
	public static function showTitle($title,$color=null,$fontStyle=null)
	{
		$str='<span style="';
		if($color!=null) $str.='color:'.$color.';';
		if($fontStyle!=null)
		{
			switch($fontStyle)
			{
				case "1":
				$str.='font-weight:bold;';
				break;

				case "2":
				$str.='font-style:oblique;';
				break;
			}
		}
		$str.='">'.$title.'</span>';
		return $str;
	}

	// 获取用户文章列表

	public static function get_article_list( $user_id, $page, $page_size )

	{

	    $page = max( $page, 1 );

	    $article_db = new IQuery('article');

	    $article_db->where = 'user_id = ' . $user_id;

	    $article_db->page = $page;

	    $article_db->pagesize = $page_size;

	    $article_db->order = 'id desc';

	    return $article_db;

	}

	

	// 获取文章列表

	public static function get_article_list_by_cid( $cid, $page, $page_size )

	{

	    $cid = explode(',', $cid );

	    $page = max( $page, 1 );

	    $article_db = new IQuery('article');

	    $article_db->where = db_create_in($cid, 'category_id');

	    $article_db->page = $page;

	    $article_db->pagesize = $page_size;

	    $article_db->order = 'top desc, id desc';

	    return $article_db;

	}

	

	// 获取文章内容

	public static function get_info( $id )

	{

	    if ( !$id )

	        return false;

	    

	    $article_db = new IQuery('article');

	    $article_db->where = 'id = ' . $id;

	    return $article_db->getOne();

	}

	

	// 获取热门文章

	public static function get_hotest_list( $limit = 10, $fields = 'id, title, views' )

	{

	    $child_category_ids = self::get_child_category(2);

	    $child_category_arr = explode(',', $child_category_ids );

	    $article_db = new IQuery('article');

	    $article_db->where = db_create_in( $child_category_arr, 'category_id');

	    $article_db->order = 'views desc, id desc';

	    $article_db->limit = $limit;

	    $article_db->fields = $fields;

	    return $article_db->find();

	}

	

	// 获取子分类

	public static function get_child_category( $parent_id = 0 )

	{

	    $article_category_db = new IQuery('article_category');

	    $article_category_db->where = 'parent_id = ' . $parent_id;

	    $article_category_db->fields = 'id';

	    $category_ids = $parent_id;

	    $child_category = $article_category_db->find();

	    if ( $child_category )

	    {

	        foreach( $child_category as $kk => $vv )

	        {

	            $category_ids .= ',' . self::get_child_category( $vv['id'] );

	        }

	    }

	    

	    return $category_ids;

	}

	

	// 获取推荐文章

	public static function get_commend_list( $commend_id, $limit = 6 )

	{

	    if ( !$commend_id )

	        return false;

	    

	    $article_db = new IQuery('article');

	    $article_db->where = "FIND_IN_SET($commend_id, intro_id)";

	    $article_db->fields = 'id,title,views,intro_id';

	    $article_db->limit = $limit;

	    $article_db->order = 'id desc';

	    return $article_db->find();

	}

	

	// 更新文章浏览量

	public static function update_article_views( $article_id = 0 )

	{

	    if ( !$article_id )

	        return false;

	    

	    $article_info = self::get_info( $article_id );

	    if ( !$article_info )

	        return false;

	    

	    $article_db = new IModel('article');

	    $article_db->setData(array(

	        'views' => $article_info['views'] + 1,

	    ));

	    return $article_db->update('id = ' . $article_id );

	}

	

	// 获取文章的摘要

	public static function get_article_summary($content = '', $length = 100 )

	{

	    $content = strip_tags( $content );

	    if ( $content )

	    {

	        //$content = str_cut( $content, $length, '');

	        $content = mb_substr($content, 0, $length, 'utf-8');

	    }

	    return $content;

	}
}