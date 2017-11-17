<?php
/**
 * @file school.php
 * @brief 学校页面
 * @author Lee
 * @date 2016-10-27
 * @version 0.6
 * @note
 */
header( "Access-Control-Allow-Origin:*" );
header( "Access-Control-Allow-Methods:POST,GET" );
class School extends IController
{
    public $layout='school';
    public $seller;
    public $seller_id;
    public $site_config = null;

	function init()
	{
// 		$seller_id = IFilter::act(IReq::get('id'),'int');
// 		if ( !$seller_id )
// 	        IError::show(403, '参数不正确，操作失败');
// 	    $seller_info = Seller_class::get_seller_info( $seller_id );
// 	    if ( !$seller_info || $seller_info['is_del'] )
// 	        IError::show(403,'该商家可能个已被删除');
// 	    if ( $seller_info['brand_id'] > 0 )
//             $seller_info['brand_info'] = brand_class::get_brand_info( $seller_info['brand_id'] );
//         if ( $seller_info['coordinate'] )
//             $seller_info['coordinate_info'] = explode(',', $seller_info['coordinate'] );
//         if ( $seller_info['province'] > 0 )
// 	    {
// 	        $seller_info['province_info'] = area::get_area_info( $seller_info['province'] );
// 	    }
// 	    if ( $seller_info['city'] > 0 )
// 	    {
// 	        $seller_info['city_info'] = area::get_area_info( $seller_info['city'] );
// 	    }
// 	    if ( $seller_info['area'] > 0 )
// 	    {
// 	        $seller_info['area_info'] = area::get_area_info( $seller_info['area'] );
// 	    }
	    
// 	    $seller_info['category'] = Category_extend_class::get_category_name_by_store( $seller_id );

// 	    $this->seller = $seller_info;
// 	    $this->seller_id = $seller_id;
// 	    $this->title = $seller_info['true_name'];
	    
// 	    $this->site_config = new Config('site_config');

	   
		/*if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false && empty(ISafe::get('user_id'))) {
			$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
         	ISafe::set('jump_url',$url);
            die("<script>location.href = '/simple/login2';</script>");
        }*/
	}
	
	// 商家信息
	function show()
	{	    
	
	    // 获取课程列表
	    $goods_list = goods_class::get_goods_list_by_seller_id( $this->seller_id, 9 );
	    $goods_list = $this->_chunk_list( $goods_list );

	    foreach($goods_list AS $idx => $goods)
	    {
	    	foreach($goods AS $i => $good)
	    	{
		    	$specs = json_decode($good['spec_array'], true);
		    	if($specs)
		    	{
		    		foreach($specs AS $spec)
			    	{
			    		$val = explode(',', $spec['value']);
			    		$val = $val[0];
			    	}
		    	}
		    	else
		    	{
		    		$val = '';
		    	}
		    	
		    	$goods_list[$idx][$i]['ks'] = $val;
	    	}
	    }
   
	    // 获取教师列表
	    $teacher_list = Teacher_class::get_goods_list_by_seller_id($this->seller_id, 9);
	    $teacher_list = $this->_chunk_list( $teacher_list );
	    
	    // 获取轮播图
	    $banner_position_id = 23;
	    $ad_list = ad::getAdList( $banner_position_id, 0, $this->seller_id );
	    
	    $seller_info = Seller_class::get_seller_info($this->seller_id);
	    $brand_info = brand_class::get_brand_info( $seller_info['brand_id'] );
	    if(!empty($brand_info['img']))
	    {
	    	$brandimg = array(); //定义图片数组
	    	$imgarr = explode(',', $brand_info['img']); //获取图片列表
	    	$imgnum = count($imgarr); //计算图片数量
	    	$imgminus = $imgnum % 3;
	    	$imgplus = floor($imgnum / 3);

	    	//计算图片样式
	    	foreach($imgarr AS $idx => $v)
	    	{
	    		$img = array();
	    		$k = $idx + 1;
	    		$img['imgurl'] = $v;
	    		$class = '';
	    		if($imgminus == 0)
	    		{
	    			$img['class'] = 'col-xs-4';
	    		}
	    		else
	    		{
	    			if($imgnum < 3)
		    		{
		    			if($imgnum == 2)
		    			{
		    				$img['class'] = 'col-xs-6';
		    			}
		    			elseif($imgnum == 1)
		    			{
		    				$img['class'] = 'col-xs-12';
		    			}
		    		}
		    		else
		    		{
		    			if($imgminus == 1)
		    			{
		    				if($k > (3 * $imgplus) && $k % 3 <= 2)
		    				{
		    					$img['class'] = 'col-xs-12';
		    				}
		    				else
		    				{
		    					$img['class'] = 'col-xs-4';
		    				}
		    			}
		    			elseif($imgminus == 2)
		    			{
		    				if($k > (3 * $imgplus) && $k % 3 <= 2)
		    				{
		    					$img['class'] = 'col-xs-6';
		    				}
		    				else
		    				{
		    					$img['class'] = 'col-xs-4';
		    				}
		    			}
		    		}
	    		}
	    		array_push($brandimg, $img);
	    	}
	    	$seller_info['brandimg'] = $brandimg;
	    }
	    $seller_info['content'] = $brand_info['description'];
	    
	    // 自定义模块列表
	    $brand_attr_list = brand_attr_class::get_brand_attr_list( $seller_info['brand_id'] );
	    
	    // 为了便于展示，进行处理
	    if ( $brand_attr_list )
	    {
	        foreach( $brand_attr_list as $kk => $vv )
	        {
	            $brand_attr_list[$kk]['img'] = $this->_chunk_list( $vv['img'] );
	            $brand_attr_list[$kk]['imgtitle'] = $this->_chunk_list( $vv['imgtitle'] );
	            $brand_attr_list[$kk]['imgbrief'] = $this->_chunk_list( $vv['imgbrief'] );
	        }
	    }

	    $seller_chits = brand_chit_class::get_chit_list_by_seller_id($this->seller_id);
	    
	    //seo_data
	    $delimiter = '-';
        $goods_arr = array();
        $goods_str = '';
        if ( $goods_list )
        {
            foreach( $goods_list as $kk => $vv )
            {
                foreach( $vv as $k => $v )
                {
                    if( !in_array( $v['name'], $goods_arr ))
                        $goods_arr[] = $v['name'];
                }
            }
        }
        if ( $goods_arr )
        {
            $goods_str = implode( $delimiter, $goods_arr );
        }
        $content = strip_tags($seller_info['content']);
        $content = mb_substr( $content, 0, 50, 'utf-8');
        $shop_catname = '教育机构';
        $cate_list_info = $this->get_shop_cate_list($shop_catname);
        $cate_list_info = implode($delimiter, $cate_list_info);
	    
	    $this->setRenderData(array(
	        'goods_list'       =>  $goods_list,
	        'teacher_list'     =>  $teacher_list,
	        'ad_list'          =>  $ad_list,
	        'brand_attr_list'    =>  $brand_attr_list,
	        'seller_info'      =>  $seller_info,
	        'brand_info'      =>  $brand_info,
	        'seller_chits'      =>  $seller_chits,
	        'seo_data'     =>  array(
	            'title'    =>  $this->site_config->index_seo_title . $delimiter . $seller_info['shortname'],
	            'keywords' =>  $this->get_city() . '-' . $shop_catname . '(' . $cate_list_info . ')-' . $seller_info['true_name'],
	            'description'  =>  $seller_info['shortname'] . '是' . $this->get_city() . '专业教学机构，学校地址：' . $seller_info['address'] . '，' . $seller_info['shortname'] . '包含（' . $goods_str . '）等课程，' . $content,
	        ),
	    ));
	    
	    $this->redirect('show');
	}
	
	
	private function _chunk_list( $list = array() )
	{
	    if ( !is_array($list))
	        return false;
	    
	    $max_num = ( IClient::getDevice() == IClient::PC ) ? 3 : 2;
	    if ( sizeof( $list ) == 4 )
	        $max_num = 2;
	    
	    return array_chunk( $list, $max_num );
	}

	function product()
	{	
		$goods_id = IFilter::act(IReq::get('goods_id'),'int');
		$goods = goods_class::get_goods_info($goods_id);

		echo json_encode($goods);
	}

	function getproduct()
	{
		$goods_id = IFilter::act(IReq::get('goods_id'),'int');
		$productid = IFilter::act(IReq::get('productid'),'int');
		$productDB = new IModel('products');
		$price = $productDB->getObj("goods_id = '$goods_id' AND id = '$productid'", 'market_price');

		echo json_encode(array('market_price' => $price['market_price']));
	}
	
	function about()
	{
	    $this->redirect('about');
	}
	
	function teacher()
	{
	    $teacher_id = IFilter::act(IReq::get('id'),'int');
	    if ( !$teacher_id )
	        IError::show(403, '参数不正确，操作失败');
	    
	    $teacher_info = Teacher_class::get_teacher_info( $teacher_id );
	    if ( !$teacher_info )
	        IError::show(403, '该教师可能已被删除');
	    	    
	    $this->setRenderData(array(
	        'teacher_info'     =>  $teacher_info,
	    ));
	    
	    $this->redirect('teacher');
	}

	//[列表页]商品
	function pro_list()
	{
        $goods_list = goods_class::get_goods_list_by_seller_id( $this->seller_id, 20 );
        
        $this->setRenderData(array(
            'goods_list'   =>   $goods_list,
        ));
	    
	    $this->redirect('pro_list');
	}
	
	function teacher_list()
	{
		$teacher_list = Teacher_class::get_teacher_list('seller_id = ' . $this->seller_id, 0, 0);
		$this->setRenderData(array(
	        'teacher_list'       =>  $teacher_list
	    ));
		$this->redirect('teacher_list');
	}

	function contact()
	{
	    $this->redirect('contact');
	}
	
	
	//商家主页
	function home()
	{
	    $brand_id = IFilter::act(IReq::get('id'),'int');
	    if(!$brand_id)
	    {
	        IError::show(403,"传递的参数不正确");
	        exit;
	    }
	    
	    $brand_info = brand_class::get_brand_info($brand_id);
	    $user_id = $this->user['user_id'];
	    $seller_info = seller_class::get_seller_info_by_bid($brand_id);
	    $seller_id = $seller_info['id'];
	    $user_id = $this->user['user_id'];
	    $type = IFilter::act(IReq::get('type'),'int');
	    
	    $seller_info = seller_class::get_seller_info($seller_id);
	    if ( !$seller_info )
	    {
	        IError::show(403, '商户不存在');
	    }

	    $seller_info['brand_info'] = brand_class::get_brand_info($seller_info['brand_id']);
	    $seller_info['brand_info']['class_desc_img'] = ($seller_info['brand_info']['class_desc_img']) ? explode(',', $seller_info['brand_info']['class_desc_img']) : '';
	    $seller_info['brand_info']['shop_desc_img'] = ($seller_info['brand_info']['shop_desc_img']) ? explode(',', $seller_info['brand_info']['shop_desc_img']) : '';
	    $seller_info['teacher_list'] = teacher_class::get_goods_list_by_seller_id($seller_id, 10);
	    $seller_info['album'] = ($seller_info['brand_info']['img']) ? explode(',', $seller_info['brand_info']['img']) : '';
	
	    if ( $seller_info['teacher_list'] )
	    {
	        foreach( $seller_info['teacher_list'] as $kk => $vv )
	        {
	            $description = nl2br($vv['description']);
	            $seller_info['teacher_list'][$kk]['description'] = str_replace('<br><br>','<br>', $description );
	        }
	    }
	
	    // 获取课程列表
	    $goods_list = goods_class::get_goods_list_by_brand_id($brand_id);
	    $goods_list_mini = array();
	    $goods_price = array();
	    $photo = array();
	    if ( $goods_list )
	    {
	        foreach( $goods_list as $kk => $vv )
	        {
	            $goods_price[] = $vv['sell_price'];
	            $photo[] = $vv['img'];
	
	            $goods_list_mini[$vv['id']] = array(
	                'id'    =>  $vv['id'],
	                'name'  =>  $vv['name'],
	                'market_price'  =>  $vv['market_price'],
	                'img'   =>  $vv['img'],
	                'store_nums'    =>  $vv['store_nums'],
	                'goods_no'  =>  $vv['goods_no'],
	                'limit_num' =>  $vv['limit_num'],
	                'limit_start_time'  =>  $vv['limit_start_time'],
	                'limit_end_time'    =>  $vv['limit_end_time'],
	                'product_list'  =>  products_class::get_product_list($vv['id']),
	                'class_effect'  =>  $vv['class_effect'],
	                'class_target'  =>  $vv['class_target'],
	                'class_details' =>  ($vv['class_details']) ? unserialize($vv['class_details']) : array(),
	                'goods_brief'   =>  mb_substr($vv['goods_brief'], 0, 35, 'utf-8'),
	                'active'         =>  goods_class::get_goods_promotion($vv['id'], $user_id),
	                'content'   =>  $vv['content'],
	            );
	        }
	    }
	
	    if ( $goods_list_mini )
	    {
	        foreach($goods_list_mini as $kk => $vv )
	        {
	            if ( $vv['class_details'] )
	            {
	                foreach( $vv['class_details'] as $k => $v )
	                {
	                    $goods_list_mini[$kk]['class_details'][$k] = ($v) ? str_replace(array(',','，'), '<br />', $v) : '';
	                }
	            }
	        }
	    }
	
	    //attribute
	    $goods_db = new IQuery('goods as g');
	    $goods_db->join = ' left join goods_attribute as a on g.id = a.goods_id';
	    $goods_db->fields = 'a.attribute_value';
	    $goods_db->where = 'g.seller_id = ' . $seller_id . ' and a.attribute_id = 1';
	    $info = $goods_db->find();
	
	    $new_arr = '';
	    $attrStr = '';
	    if($info){
	        foreach($info as $k => $v){
	            if($k != 0){
	                $attrStr .= ',';
	            }
	            $attrStr .= $v['attribute_value'];
	        }
	    }
	
	    if($attrStr){
	        $attrArr = explode(',',$attrStr);
	    }
	
	    if ( $attrArr && is_array($attrArr))
	       $attrArr = array_unique($attrArr);
	
	    $word_arr = array('一','二','三','四','五','六','日');
	    if ( $attrArr) 
	    {
	        foreach($attrArr as $v){
	            $cut_str = mb_substr($v,-1,1,'utf-8');
	            $new_arr[] = $cut_str;
	        }
	    }
	    if ( $new_arr && is_array($new_arr))
	       $new_arr = array_unique($new_arr);
	    $attrArr = '';
	    if ( $new_arr )
	    {
	        foreach($new_arr as $val){
	            if ( $word_arr )
	            {
	                foreach($word_arr as $v){
	                    if($val == $v){
	                        $attrArr[] = $val;
	                        break;
	                    }
	                }
	            }
	        }
	    }
	
	    $min = ($goods_price) ? min($goods_price) : 0;
	    $ticket = order_class::get_new_order_max_cprice2($min, $seller_id);
	
	    //get next
	    $seller_db = new IModel('seller');
	    $nextid = $seller_db->query("id > '$seller_id' AND is_del=0 and is_authentication = 1 and is_system_seller = 0 ", 'id', 'id ASC', 1);
	    if(!$nextid[0]['id'])
	    {
	        $nextid = $seller_db->query("id < '$seller_id' AND is_del=0 and is_authentication = 1 and is_system_seller = 0", 'id', 'id ASC', 1);
	    }
	    $seller_info['nextid'] = $nextid[0]['id'];
	
	    // 赋值
	    $min = ($goods_price) ? min($goods_price) : 0;
	    $max = ($goods_price) ? max($goods_price) : 0;
	    $seller_info['goods_list'] = $goods_list_mini;
	    $seller_info['goods_list_json'] = json_encode($goods_list_mini);
	    $seller_info['price_level'] = ($min == $max ) ? $min : $min . '-' . $max;
	    $seller_info['photo'] = $photo;
	    $this->title = $seller_info['shortname'];
	    
	    // 商户代金券
	    $chit_list = brand_chit_class::get_chit_list_by_seller_id($seller_id);
	
	    $this->setRenderData(array(
	        'seller_info'   =>  $seller_info,
	        'attrArr'       =>  $attrArr,
	        'ticket'        => $ticket,
	        'chit_list'     => $chit_list,
	        'stk_list'     =>  $stk_list,    
	        'seller_stk_list'  =>  $seller_stk_list,
	    ));
	    $this->redirect('home');
	}

	function get_current_chit(){
		$price = intval(IReq::get('price'));
		$info = order_class::get_new_order_max_cprice($price);
		echo json_encode($info);
	}

	function get_chit_info()
	{
		$prop = intval(IReq::get('prop'));
		$barnd_chit_db = new IQuery('brand_chit');
		$barnd_chit_db->where = 'brand_id = 247 and max_order_chit = ' . $prop;
		$info = $barnd_chit_db->getOne();
		if($info){
			$info['limittime'] = date('Y-m-d',$info['limittime']);
		}
		echo json_encode($info);
	}
	
	public function get_special_seller_goods_list_ajax()
	{
        $seller_id = $this->seller_id;
        $page = IFilter::act(IReq::get('page'),'int');
        $page = max($page, 1);
        $keyword = IFilter::act(IReq::get('key'));
        $page_size = 10;
        $sellerRow = Api::run('getSellerInfo',$seller_id);
        $user_id = $this->user['user_id'];
        $member_info = array();
        $where = ($keyword) ? "name like '%$keyword%'" : '';
        $resultData = search_goods::get_special_seller_goods_list($seller_id, $page, $page_size, $where);
        $page_info = $resultData['page_info'];
        $page_count = $resultData['page_count'];
        $list = $resultData['list'];

        $result = '';
        if ( $list )
        {
            foreach($list as $kk => $vv )
            {
                $result .= '<li>';
                    $result .= '<div class="class_image">';
                        $result .= '<a href="' . IUrl::creatUrl('/site/products3/id/' . $vv['id']) . '"><img src="/' . $vv['img'] . '" /></a>';
                    $result .= '</div>';
                    $result .= '<div class="class_action">';
                        $result .= '<div class="t-left">姓名：' . $vv['name'] . '</div>';
                        $result .= '<div class="t-right">排名：' . discussion_class::get_vote_range($vv['id']) . '</div>';
                    $result .= '</div>';
                    $result .= '<div class="class_action">';
                        $result .= '<div class="t-left">编号：' . $vv['sort'] . '</div>';
                        $result .= '<div class="t-right">票数：' . discussion_class::get_vote_count($vv['id']) . '</div>';
                    $result .= '</div>';
                $result .= '</li>';
            }
        }
	    
        die($result);
	}
	
	public function search_mlmm()
	{
	    $this->redirect('search_mlmm');
	}
}
