<?php
/**
 * @file help.php
 * @brief 帮助管理
 * @author Lee
 * @date 2016-12-13
 * @version 0.6
 */

 /**
 * @class help
 * @brief 帮助管理模块
 */
class Help
{
	
	// 获取用户文章列表
	public static function get_help_cat_list()
	{
	    $cat_db = new IQuery('help_category');
	    $cat_db->where = 'position_foot = 1';
	    $cat_db->page = 1;
	    $cat_db->pagesize = 5;
	    $cat_db->order = 'id desc';
	    return $cat_db->find();
	}
}