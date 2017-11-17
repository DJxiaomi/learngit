<?php
/**
 * @copyright Copyright(c) 2017 hnlxsh
 * @file api_index.php
 * @brief 首页接口调用
 * @author Lee
 * @date 2017-02-08
 * @version 1.0
 * @note
 */
/**
 * @brief api_index
 * @class api_index
 * @note
 */
header( "Access-Control-Allow-Origin:*" );
header( "Access-Control-Allow-Methods:POST,GET" );
header( "Access-Control-Allow-Headers:X-Requested-With" );
class Api_index extends IController
{
	public function init()
	{
		//todo
	}

	//获取首页轮播图
	public function getslide()
	{
		$ad_slide_mobile_list = Ad::getAdList(26);

		$this->json_result($ad_slide_mobile_list, 'ok');
	}

	//获取首页广告图
	public function getmobilead()
	{
		$ad_mobile_list = Ad::getAdList(24);

		$this->json_result($ad_mobile_list, 'ok');
	}

	//获取首页产品
	public function getproduct()
	{
		$categories = Api::run('getCategoryListTop');
		foreach($categories AS $idx => $category)
		{
			$child = Api::run('getCategoryByParentid',array('#parent_id#',$category['id']));
			$products = Api::run('getCategoryExtendList',array('#categroy_id#',$category['id']),8);
			foreach($products AS $key => $product)
			{
				$products[$key]['name'] = mb_substr($product['name'], 0, 12,'utf-8');
				$products[$key]['content'] = mb_substr(strip_tags($product['content']), 0, 30, 'utf-8');
				$products[$key]['seller_name'] = mb_substr(Seller_class::get_seller_shortname($product['seller_id']), 0, 6);
			}
			$categories[$idx]['child'] = $child;
			$categories[$idx]['products'] = $products;
		}

		$this->json_result($categories, 'ok');
	}

	//获取首页商家
	public function getshoplist()
	{
		// 商家推荐
	    $shop_db = new IQuery('seller s');
	    $shop_db->join = " left join brand AS b on b.id = s.brand_id";
	    $shop_db->where = "s.is_del = 0 and s.is_lock = 0 and s.type = 1 and s.is_vip = 1 and s.logo != '' and b.description != '' and s.shortname != ''";
	    $shop_db->fields = 's.id, s.true_name, s.seller_name, s.address, s.area, s.logo, s.brand_id, s.shortname, b.description';
	    $shop_db->order = 's.id desc';
	    $shop_db->limit = 10;
	    
	    $shop_list = $shop_db->find();

	    foreach($shop_list AS $idx => $shop)
	    {
	    	$shop_list[$idx]['shortname'] = !empty($shop['shortname']) ? $shop['shortname'] : mb_substr($shop['true_name'], 0, 12,'utf-8');
	    	$shop_list[$idx]['description'] = mb_substr(strip_tags($shop['description']), 0, 30, 'utf-8');
	    	$shop_list[$idx]['address'] = mb_substr($item['address'], 0, 11,'utf-8');
	    }

	    $this->json_result($shop_list, 'ok');
	}
}
?>