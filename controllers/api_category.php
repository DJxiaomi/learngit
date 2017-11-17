<?php
/**
 * @copyright Copyright(c) 2017 hnlxsh
 * @file api_index.php
 * @brief 列表页接口调用
 * @author Lee
 * @date 2017-02-09
 * @version 1.0
 * @note
 */
/**
 * @brief api_category
 * @class api_category
 * @note
 */
header( "Access-Control-Allow-Origin:*" );
header( "Access-Control-Allow-Methods:POST,GET" );
header( "Access-Control-Allow-Headers:X-Requested-With" );
class api_category extends IController
{
	public function init()
	{
		//todo
	}

	//获取列表
	public function get_pro_list_ajax()
	{
		$id=intval(IReq::get('id'));
	    $keyword = IFilter::act(IReq::get('word'),'text');
	    $page = intval(IReq::get('page'));
	    $page = max( $page, 1 );
	    $perpage = 10;
	    $this->catId = IFilter::act(IReq::get('cat'),'int');//分类id
	    $this->catStr = '' . $this->catId;
	     
	    if ( $this->catId )
	    {
	        //查找分类信息
	        $catObj       = new IModel('category');
	        $this->cat_info = $catObj->getObj('id = '.$this->catId);
	    
	        if($this->cat_info == null)
	        {
	            IError::show(403,'此分类不存在');
	        }
	    
	        //获取子分类
	        $this->childId = goods_class::catChild($this->catId);
	        $cat_list = goods_class::catTree($this->catId);
	    }
	     
	    // 搜索关键词的处理 added by jack 20160617
	    if(preg_match("|^[\w\x7f\s*-\xff*]+$|",$keyword ))
	    {
	        //搜索关键字
	        $tb_sear     = new IModel('search');
	        $search_info = $tb_sear->getObj('keyword = "'.$keyword.'"','id');
	         
	        //如果是第一页，相应关键词的被搜索数量才加1
	        if($search_info && $page < 2 )
	        {
	            //禁止刷新+1
	            $allow_sep = "30";
	            $flag = false;
	            $time = ICookie::get('step');
	            if(isset($time))
	            {
	                if (time() - $time > $allow_sep)
	                {
	                    ICookie::set('step',time());
	                    $flag = true;
	                }
	            } else {
	                ICookie::set('step',time());
	                $flag = true;
	            }
	            if($flag)
	            {
	                $tb_sear->setData(array('num'=>'num + 1'));
	                $tb_sear->update('id='.$search_info['id'],'num');
	            }
	        }
	        elseif( !$search_info )
	        {
	            //如果数据库中没有这个词的信息，则新添
	            $tb_sear->setData(array('keyword'=>$keyword,'num'=>1));
	            $tb_sear->add();
	        }
	    }
	    
	    //区域
	    $area_id = IFilter::act(IReq::get('area'), 'int');
	    $seller_arr = array();
	    if ( $area_id )
	    {
	        $seller_db = new IQuery('seller');
	        $seller_db->where = 'area = ' . $area_id;
	        $seller_db->fields = 'id';
	        $seller_list = $seller_db->find();
	        if ( $seller_list )
	        {
	            foreach( $seller_list as $kk => $vv )
	            {
	                if ( !in_array( $vv['id'], $seller_arr ))
	                    $seller_arr[] = $vv['id'];
	            }
	        }
	    }
	    
	    //$where = db_create_in($this->seller_list, 'go.seller_id');
	    $where = "1=1";
	    
	    // 添加分类的条件
	    if ( $this->childId )
	        $where .= " and go.id in (select distinct goods_id from category_extend where category_id in (". $this->childId .") )";
	    
	    //添加区域的条件
	    if ( $seller_arr )
	        $where .= ' and ' .db_create_in( $seller_arr, 'go.seller_id');
	    
	    //添加关键词的条件
	    if ( $keyword )
	        $where .= " and go.search_words like '%$keyword%'";
	    
	    $goodsObj = search_goods::find( $where, $perpage );
	    $resultData = $goodsObj->find();
	    
	    if( $resultData )
	    {
	        foreach( $resultData as $kk => $vv )
	        {
	        	$price = goods_class::get_min_max_price_by_goods_id($vv['id']);
	        	$resultData[$kk]['thumb'] = IUrl::creatUrl('/pic/thumb/img/' . $vv['img'] . '/w/100/h/100');
	        	if($price['minprice'] != $price['maxprice'])
	        	{
	        		$resultData[$kk]['seller_price'] = '￥' . $price['minprice'] . ' - ￥' . $price['maxprice'];
	        	}
	        	else
	        	{
	        		$resultData[$kk]['seller_price'] = '￥' . $vv['market_price'];
	        	}
	        }
	        $resultData['num'] = count($resultData);
	    	$resultData['page'] = $page + 1;
	    }
	    else
	    {
	    	$resultData['num'] = 0;
	    	$resultData['page'] = 1;
	    }
	    
	    $this->json_result($resultData, 'ok');
	}
}
?>