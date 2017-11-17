<?php
/**
 * @copyright Copyright(c) 2011 aircheng.com
 * @file site.php
 * @brief
 * @author webning
 * @date 2011-03-22
 * @version 0.6
 * @note
 */

class Site extends IController
{
    public $layout='site';
    public $hide_price = '88888';
    public $hide_price_str = '报名该课程请与学校直接联系';
    public $seller_receipt_id = 1989;
    public $signPackage = '';
    public $promote = '';

	function init()
	{
	    if(IClient::isWechat())
	    {
	        $this->iswechat = 1;
	        $signPackage = jssdk::GetSignPackage();
	        $this->signPackage = $signPackage;
	    }
	    
	    $userid = ISafe::get('user_id');
	    
	    // 获取推广人信息
	    $promote = IFilter::act(IReq::get('promote'));
	    if ( $promote )
	    {
	        $promotor_info = promotor_class::get_promotor_info($promote);
	        if ($promotor_info )
	        {
	            ICookie::set('promote',$promote,365);
	            $this->promote = $promote;
	        }
	    }
        

	    if ( IClient::isWechat() && empty($userid) )
	    {
	        $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	        ISafe::set('jump_url',$url);
	        $redirect = '/simple/login2';
	        if ($this->promote)
	           $redirect .= '/promote/' . $this->promote;
	        die("<script>location.href = '$redirect';</script>");
	    }
	    
	}
	
	function activity_discount()
	{
		$this->redirect('activity_discount');
	}
	
	function activity_zhuanti()
	{
		 $this->redirect('activity_zhuanti');
	}

	
	function index()
	{
	    $user_id = $this->user['user_id'];
	    $my_city_code = city::get_my_city_code();
	    $area_arr = city::get_city_arr();
	    $area_list = area::get_child_area_list($my_city_code);
	    $arr = array('area_id'  =>  0, 'area_name'    => '全部',);
	    array_unshift($area_list, $arr);
	    $shop_list = array();
	    if ( $area_list )
	    {
	        foreach( $area_list as $kk => $vv )
	        {
	            if ( !$vv['area_id'])
	            {
                    $shop_list[$vv['area_id']] = seller_class::get_intro_shop_list_by_area_id($my_city_code,$vv['area_id'], 200);
	            }
	            else
	            {
	                $shop_list[$vv['area_id']] = seller_class::get_intro_shop_list_by_area_id($my_city_code,$vv['area_id']);
	            }
	        }
	    }
	    if ( $shop_list )
	    {
	        foreach($shop_list as $kk => $vv )
	        {
	            foreach( $vv as $k => $v )
	            {
	                $length = 35;
	                $description = $v['description'];
	                $description = str_replace(array('&lt;','&gt;'),array('<','>'),$description);
	                $description = nl2br($description);
	                $description = strip_tags($description);
	                $description = str_replace('\n','', $description);
	                if ( strlen($description) > $length )
	                    $shop_list[$kk][$k]['description'] = mb_substr($description, 0, 35, 'utf-8') . '...';
	                else
	                    $shop_list[$kk][$k]['description'] = mb_substr($description, 0, 35, 'utf-8');
	                
	                $brief = $v['brief'];
	                if ( strlen($brief) > $length )
	                    $shop_list[$kk][$k]['brief'] = mb_substr($brief, 0, 35, 'utf-8') . '...';
	                else
	                    $shop_list[$kk][$k]['brief'] = mb_substr($brief, 0, 35, 'utf-8');
	            }
	        }
	    }
		//获取分类标题图片
		$shop_intro_db=new IQuery('ad_manage');
        $shop_intro_db->fields='content';
	    $shop_intro_db->where='position_id in(17,18,19,20,27)';
		
		$shop_intro=$shop_intro_list=$shop_intro_db->find();

		foreach($shop_intro as $kkk=>$vvv)
		{
			 $contents[]=$vvv['content'];
		}
		$this->contents=$contents;




		//获取短期课列表 10课
    	$dqk_list[] = array('name' => '全部','id' => 0,'list' => brand_chit_class::get_intro_dqk_list_by_category_id($my_city_code,0,10));
    	
    	//获取短期课分类
    	$dqk_category_list = manual_category_class::get_category_list();
    	if ( $dqk_category_list )
    	{
    	    foreach($dqk_category_list as $kk => $vv )
    	    {
    	        $dqk_list[] = array('name' => $vv['name'],'id' => $vv['id'],'list' => brand_chit_class::get_intro_dqk_list_by_category_id($my_city_code,$vv['id']));
    	    }
    	}
    	
    	// 设定微信分享的信息
    	if ( IClient::isWechat() )
    	{
    	    $siteConfig = new Config("site_config");
    	    $share_link = 'http://www.dsanke.com/site/index';
    	    if ( $user_id )
    	        $share_link .= '/promote/' . $user_id;
    	    $this->sharedata = json_encode(array(
    	        'imgUrl'    =>  'http://www.dsanke.com/views/mobile/skin/blue/images/wechat_share_logo.jpg',
    	        'desc'      =>  $siteConfig->index_seo_description,
    	        'title'     =>  $siteConfig->index_seo_title,
    	        'link'      =>  $share_link,
    	    ));
    	}
    	
	    $this->setRenderData(array(
	        'city'        =>  str_replace("市","",area::getName($my_city_code)),
	        'city_arr'    =>  city::get_city_arr(),
	        'page'        =>  1,
	        'page_count'  =>  $paging->totalpage,
	        'shop_list'   =>  $shop_list,
	        'area_list'   =>  $area_list,
	        'dqk_list'    =>  $dqk_list,
	    ));
		$this->index_slide = Api::run('getBannerList');
		$this->index_slide_mobile = Api::run('getBannerMobileList');
		$this->redirect('index');
	}

	//[首页]商品搜索
	function search_list()
	{
		$this->word = IFilter::act(IReq::get('word'),'text');
		$cat_id     = IFilter::act(IReq::get('cat'),'int');

		if(preg_match("|^[\w\x7f\s*-\xff*]+$|",$this->word))
		{
			//搜索关键字
			$tb_sear     = new IModel('search');
			$search_info = $tb_sear->getObj('keyword = "'.$this->word.'"','id');

			//如果是第一页，相应关键词的被搜索数量才加1
			if($search_info && intval(IReq::get('page')) < 2 )
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
				}
				else
				{
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
				$tb_sear->setData(array('keyword'=>$this->word,'num'=>1));
				$tb_sear->add();
			}
			
			$this->title = $this->word;
		}
		else
		{
			IError::show(403,'请输入正确的查询关键词');
		}
		$this->cat_id = $cat_id;
		$this->redirect('search_list');
	}

	//[site,ucenter头部分]自动完成
	function autoComplete()
	{
		$word = IFilter::act(IReq::get('word'));
		$isError = true;
		$data    = array();

		if($word != '' && $word != '%' && $word != '_')
		{
			$wordObj  = new IModel('keyword');
			$wordList = $wordObj->query('word like "'.$word.'%" and word != "'.$word.'"','word, goods_nums','',10);

			if(!empty($wordList))
			{
				$isError = false;
				$data = $wordList;
			}
		}

		//json数据
		$result = array(
			'isError' => $isError,
			'data'    => $data,
		);

		echo JSON::encode($result);
	}

	//[首页]邮箱订阅
	function email_registry()
	{
		$email  = IReq::get('email');
		$result = array('isError' => true);

		if(!IValidate::email($email))
		{
			$result['message'] = '请填写正确的email地址';
		}
		else
		{
			$emailRegObj = new IModel('email_registry');
			$emailRow    = $emailRegObj->getObj('email = "'.$email.'"');

			if(!empty($emailRow))
			{
				$result['message'] = '此email已经订阅过了';
			}
			else
			{
				$dataArray = array(
					'email' => $email,
				);
				$emailRegObj->setData($dataArray);
				$status = $emailRegObj->add();
				if($status == true)
				{
					$result = array(
						'isError' => false,
						'message' => '订阅成功',
					);
				}
				else
				{
					$result['message'] = '订阅失败';
				}
			}
		}
		echo JSON::encode($result);
	}

	//[列表页]商品
	function pro_list()
	{
		$this->catId = IFilter::act(IReq::get('cat'),'int');//分类id
		$keywords = IFilter::act(IReq::get('keywords'));
		$area_id = city::get_my_city_code();

		if($this->catId == 0)
		{
			$this->catarray=array(1,2,4,5,196);
		}

		//查找分类信息
		$catObj       = new IModel('category');
		$this->catRow = $catObj->getObj('id = '.$this->catId);

		if ( !$this->catId )
		{
		    $this->catRow = array(
		        'id' => 0,
		        'name' => '全部分类',
		    );
		}
		
		if ( IClient::getDevice() != IClient::PC )
		{
		    // 获取所有可选分类
		    $jsoncat = array();
		    $cat_list = Api::run('getCategoryListTop');
		    if ( $cat_list )
		    {
		        foreach( $cat_list AS $idx => $cat)
		        {
		            $jsoncat[$idx]['value'] = $cat['id'];
		            $jsoncat[$idx]['text'] = $cat['name'];
		            $son_cat_db = new IQuery('category');
		            $son_cat_db->where = "parent_id = '$cat[id]'";
		            $sons = $son_cat_db->find();
		            foreach($sons AS $k => $son)
		            {
		                $jsoncat[$idx]['children'][$k]['value'] = $son['id'];
		                $jsoncat[$idx]['children'][$k]['text'] = $son['name'];
		            }
		        }
		    }
		    
		    // 获取所有可选区域
		    $area_arr = array(array(
		                'value'   =>  $area_id,
		                'text'    =>  area::getName($area_id),
		    ));
		    $area_list = area::get_child_area_list($area_id);
		    if ( $area_list )
		    {
		        foreach($area_list as $kk => $vv )
		        {
		            $area_arr[] = array(
		                'value'   =>  $vv['area_id'],
		                'text'    =>  $vv['area_name'],
		            );
		        }
		    }

		    $this->setRenderData(array(
		        'jsoncats'   => json_encode($jsoncat),
		        'area_arr'   => json_encode($area_arr),
		        'area_id'    => $area_id,
		        'keywords'   => $keywords,
		    ));
		}

		//获取子分类
		$this->childId = goods_class::catChild($this->catId);
		
		$this->title = $this->catRow['name'];
		$this->redirect('pro_list');
	}
	//咨询
	function consult()
	{
		$this->goods_id = IFilter::act(IReq::get('id'),'int');
		if($this->goods_id == 0)
		{
			IError::show(403,'缺少商品ID参数');
		}

		$goodsObj   = new IModel('goods');
		$goodsRow   = $goodsObj->getObj('id = '.$this->goods_id);
		if(!$goodsRow)
		{
			IError::show(403,'商品数据不存在');
		}

		//获取次商品的评论数和平均分
		$goodsRow['apoint'] = $goodsRow['comments'] ? round($goodsRow['grade']/$goodsRow['comments']) : 0;

		$this->goodsRow = $goodsRow;
		$this->redirect('consult');
	}

	//咨询动作
	function consult_act()
	{
		$goods_id   = IFilter::act(IReq::get('goods_id','post'),'int');
		$captcha    = IFilter::act(IReq::get('captcha','post'));
		$question   = IFilter::act(IReq::get('question','post'));
		$_captcha   = ISafe::get('captcha');
		$message    = '';

    	if(!$captcha || !$_captcha || $captcha != $_captcha)
    	{
    		$message = '验证码输入不正确';
    	}
    	else if(!$question)
    	{
    		$message = '咨询内容不能为空';
    	}
    	else if(!$goods_id)
    	{
    		$message = '商品ID不能为空';
    	}
    	else
    	{
    		$goodsObj = new IModel('goods');
    		$goodsRow = $goodsObj->getObj('id = '.$goods_id);
    		if(!$goodsRow)
    		{
    			$message = '不存在此商品';
    		}
    	}

		//有错误情况
    	if($message)
    	{
    		IError::show(403,$message);
    	}
    	else
    	{
			$dataArray = array(
				'question' => $question,
				'goods_id' => $goods_id,
				'user_id'  => isset($this->user['user_id']) ? $this->user['user_id'] : 0,
				'time'     => ITime::getDateTime(),
			);
			$referObj = new IModel('refer');
			$referObj->setData($dataArray);
			$referObj->add();
			plugin::trigger('setCallback','/site/products/id/'.$goods_id);
			$this->redirect('/site/success');
    	}
	}

	//公告详情页面
	function notice_detail()
	{
		$this->notice_id = IFilter::act(IReq::get('id'),'int');
		if($this->notice_id == '')
		{
			IError::show(403,'缺少公告ID参数');
		}
		else
		{
			$noObj           = new IModel('announcement');
			$this->noticeRow = $noObj->getObj('id = '.$this->notice_id);
			if(empty($this->noticeRow))
			{
				IError::show(403,'公告信息不存在');
			}
			$this->redirect('notice_detail');
		}
	}

	//文章列表页面
	function article()
	{
		/*$catId  = IFilter::act(IReq::get('id'),'int');
		$catRow = Api::run('getArticleCategoryInfo',$catId);
		$queryArticle = $catRow ? Api::run('getArticleListByCatid',$catRow['id']) : Api::run('getArticleList');
		$this->setRenderData(array("catRow" => $catRow,'queryArticle' => $queryArticle));
		$this->redirect('article');*/
		$page = IFilter::act(IReq::get('page'),'int');
	    $page = max( $page, 1 );
	    $page_size = 12;
	    $cid = IFilter::act(IReq::get('cid'),'int');
	    if ( !$cid )
	    {
	        //$this->show_warning('参数不正确');
	        IError::show(403,'参数不正确');
	        exit();
	    }
	    if ( $cid == 7) 
	    {
	        header("location:" . IUrl::creatUrl('/site/article2'));
	        exit();
	    }
	    
	    $category_info = article_category_class::get_category_info( $cid );
	    if ( !$category_info )
	    {
	        //$this->show_warning('该类目可能已被删除');
	        IError::show(403,'该类目可能已被删除');
	        exit();
	    }
	    
	    // 获取文章列表和回复总数
	    $category_child_ids = article::get_child_category( $cid );
	    $article_db = article::get_article_list_by_cid($category_child_ids, $page, $page_size);
	    $article_list = $article_db->find();
	    $paging = $article_db->paging;	    
	    if ( $article_list )
	    {
	        foreach( $article_list as $kk => $vv )
	        {
	            $article_list[$kk]['reply_count'] = article_reply_class::get_article_reply_count( $vv['id'] );
	            $article_list[$kk]['summary'] = article::get_article_summary($vv['content'], 160 );
	            if ( !$vv['thumb'])
	            {
	                preg_match_all("/\<img.*?src\=\"(.*?)\"[^>]*>/i", $vv['content'], $match);
	                if ( $match[1] )
	                {
	                    $article_list[$kk]['thumb'] = trim($match[1][0],'/');
	                }
	            }
	        }
	    }
	    
	    // 获取列表页广告图
	    $ad_list = Ad::getAdList(22);
	    
	    // 获取侧边栏分类
	    $category_list = article_category_class::get_child_category_list(2);
	    
	    // 获取热门文章
	    $hot_article_list = article::get_hotest_list(6);
	    $this->title = '教育资讯';
	    $this->setRenderData(array(
	        'article_list' =>  $article_list,
	        'page_info'    =>  $article_db->getPageBar(),
	        'ad_list'      =>  $ad_list,
	        'category_list'    =>  $category_list,
	        'cid'          =>  $cid,
	        'hot_article_list' =>  $hot_article_list,
	        'category_info'    =>  $category_info,
            'paging'           =>$paging,
	        'cid'              =>  $cid,
	        'seo_data'     =>  array(
	            'title'    =>  $this->site_config->index_seo_title,
	            'keywords' =>  $this->get_city() . '-' . $this->title,
	            'description'  =>  '',
	        ),
	    ));
	    
	    $this->redirect('article');
	}
	
	
	//试听列表
	function article2()
	{
	    $page = IFilter::act(IReq::get('page'),'int');
	    $page = max( $page, 1 );
	    $page_size = 12;
	    $cid = 7;
	    if ( !$cid )
	    {
	        IError::show(403,'参数不正确');
	        exit();
	    }
	     
	    $category_info = article_category_class::get_category_info( $cid );
	    if ( !$category_info )
	    {
	        IError::show(403,'该类目可能已被删除');
	        exit();
	    }
	    
	    // 获取列表页广告图
	    $ad_list = Ad::getAdList(22);
	     
	    // 获取侧边栏分类
	    $category_list = article_category_class::get_child_category_list(2);
	     
	    // 获取热门文章
	    $hot_article_list = article::get_hotest_list(6);
	     
	    // 获取文章列表和回复总数
	    $category_child_ids = article::get_child_category( $cid );
	    $article_db = article::get_article_list_by_cid($category_child_ids, $page, $page_size);
	    $article_list = $article_db->find();
	    $paging = $article_db->paging;
	    if ( $article_list )
	    {
	        foreach( $article_list as $kk => $vv )
	        {
	            $article_list[$kk]['reply_count'] = article_reply_class::get_article_reply_count( $vv['id'] );
	            $article_list[$kk]['summary'] = article::get_article_summary($vv['content'], 160 );
	            $article_list[$kk]['thumb_count'] = article_thumb_class::get_article_thumb_count($vv['id']);
	            if ( !$vv['thumb'])
	            {
	                preg_match_all("/\<img.*?src\=\"(.*?)\"[^>]*>/i", $vv['content'], $match);
                    if ( $match[1] )
                    {
                        $article_list[$kk]['thumb'] = trim($match[1][0],'/');
                    }
	            }
	        }
	    }
	     
	    // 获取热门文章
	    $this->title = '试听体验';
	    $this->setRenderData(array(
	        'article_list' =>  $article_list,
	        'page_info'    =>  $article_db->getPageBar(),
	        'ad_list'      =>  $ad_list,
	        'category_list'    =>  $category_list,
	        'cid'          =>  $cid,
	        'hot_article_list' =>  $hot_article_list,
	        'category_info'    =>  $category_info,
            'paging'           =>$paging,
	        'cid'              =>  $cid,
	        'seo_data'     =>  array(
	            'title'    =>  $this->site_config->index_seo_title,
	            'keywords' =>  $this->get_city() . '-' . $this->title,
	            'description'  =>  '',
	        ),
	    ));
	     
	    $this->redirect('article2');
	}

	//文章详情页面
// 	function article_detail()
// 	{
// 		$this->article_id = IFilter::act(IReq::get('id'),'int');
// 		if($this->article_id == '')
// 		{
// 			IError::show(403,'缺少咨询ID参数');
// 		}
// 		else
// 		{
// 			$articleObj       = new IModel('article');
// 			$this->articleRow = $articleObj->getObj('id = '.$this->article_id);
// 			if(empty($this->articleRow))
// 			{
// 				IError::show(403,'资讯文章不存在');
// 				exit;
// 			}

// 			//关联商品
// 			$this->relationList = Api::run('getArticleGoods',array("#article_id#",$this->article_id));
// 			$this->redirect('article_detail');
// 		}
// 	}
//文章详情页面
function article_detail()
{
    $this->article_id = IFilter::act(IReq::get('id'),'int');

    if($this->article_id == '')
    {
        //$this->show_warning('参数不正确');
        IError::show(403,'参数不正确');
        exit();
    }
    else
    {
        $page = IFilter::act(IReq::get('page'),'int');
        $page = max( $page, 1 );
        $page_size = 100;

        $articleObj       = new IModel('article');
        $article_info = $articleObj->getObj('id = '.$this->article_id);
        if ( $article_info['category_id'] == 17)
        {
            header("location:" . IUrl::creatUrl('/site/article_detail3/id/' . $this->article_id));
        }
        if(empty($article_info))
        {
            //$this->show_warning('资讯文章不存在');
            IError::show(403,'文章不存在');
            exit();
        }
        if ( $article_info['user_id'] )
        {
            $user_db = new IQuery('user');
            $user_db->where = 'id = ' . $article_info['user_id'];
            $user_info = $user_db->getOne();
            if ( $user_info )
                $article_info['user_name'] = $user_info['username'];
        }
        	
        //关联商品
        //$this->relationList = Api::run('getArticleGoods',array("#article_id#",$this->article_id));
        	
        // 获取文档分类路径
        $article_info['path'] = article_category_class::get_parent_category_list( $article_info['category_id'] );
        //dump( $article_info );
        	
        // 获取列表页广告图
        $ad_list = Ad::getAdList(22);
        	
        // 获取侧边栏分类
        $category_list = article_category_class::get_child_category_list(2);
        	
        // 获取热门文章
        $hot_article_list = article::get_hotest_list(6);
        	
        // 获取评论
        $reply_db = article_reply_class::get_article_reply_list( $this->article_id, $page, $page_size );
        $reply_list = $reply_db->find();
        $paging = $reply_db->paging;
        if ( $reply_list )
        {
            $user_id_arr = array();
            foreach( $reply_list as $kk => $vv )
            {
                if ( !in_array( $vv['user_id'], $user_id_arr ))
                    $user_id_arr[] = $vv['user_id'];
                 
                $reply_list[$kk]['thumb_count'] = article_reply_thumb_class::get_reply_thumb_count($vv['id']);
            }
             
            $user_db = new IQuery('user as u ');
            $user_db->join = 'left join member as m on u.id = m.user_id';
            $user_db->where = db_create_in( $user_id_arr, 'u.id');
            $user_db->fields = 'u.id, u.username, u.head_ico,m.sex';
            $user_list = $user_db->find();
             
            $user_temp = array();
            if ( $user_list )
            {
                foreach( $user_list as $kk => $vv )
                {
                    $user_temp[$vv['id']] = $vv;
                }
            }
            $user_list = $user_temp;
             
            foreach( $reply_list as $kk => $vv )
            {
                if (isset($user_list[$vv['user_id']]))
                {
                    $reply_list[$kk]['head_ico'] = $user_list[$vv['user_id']]['head_ico'];
                }
            }
        }
        $page_info = $reply_db->getPageBar();
        	
        $article_info['reply_count'] = article_reply_class::get_article_reply_count($this->article_id );
        	
        // 更新浏览量, 设置cookie过期时间为24小时
        if ( !isset( $_COOKIE['article_' . $this->article_id] ) || $_COOKIE['article_' . $this->article_id] != '1' )
        {
            article::update_article_views( $this->article_id );
            setcookie( 'article_' . $this->article_id, '1', time() + 3600 * 24 );
        }
        $callback = $_SERVER['PHP_SELF'];
        $this->title = '资讯详情';

        //seo_data
        if ( $article_info['user_id'] )
        {
            $user_db = new IQuery('user');
            $user_db->where = 'id = ' . $article_info['user_id'];
            $user_info = $user_db->getOne();
            $user_name = $user_info['username'];
        } else {
            $user_name = '第三课';
        }
        $content = strip_tags($article_info['content']);
        $content = mb_substr( $content, 0, 50, 'utf-8');
        	
        // 微信分享
        $wechat = new wechat_class();
        $wechat->token = 'y53na1qnxJ6o1qj1';
        $wechat->appid = 'wx72fc7befef40f55a';
        $wechat->appSecret = '8446dfd26a915aa506567d436ac9db52';
        $urls = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $sign_package_info = $wechat->shareMsg($urls);
        	
        $this->setRenderData(array(
            'ad_list'    =>  $ad_list,
            'category_list'  =>  $category_list,
            'hot_article_list'   =>  $hot_article_list,
            'article_info'   =>  $article_info,
            'reply_list'     =>  $reply_list,
            'page_info'      =>  $page_info,
            'user_list'      =>  $user_list,
            'page'           =>  $page,
            'page_size'      =>  $page_size,
            'paging'         =>  $paging,
            'id'             =>  $this->article_id,
            'callback'       =>  $callback,
            'sign_package_info'  =>  $sign_package_info,
            'share_url'      =>  $urls
        ));
        	

        $this->redirect('article_detail');

    }
}

//文章详情页面
function article_detail2()
{
    $this->article_id = IFilter::act(IReq::get('id'),'int');
    $userid = $this->user['user_id'];
    if ( !$userid && IClient::isWechat())
    {
        $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        ISafe::set('jump_url',$url);
        die("<script>location.href = '/simple/login3';</script>");
    }

    if($this->article_id == '')
    {
        //$this->show_warning('参数不正确');
        IError::show(403,'参数不正确');
        exit();
    }
    else
    {
        $page = IFilter::act(IReq::get('page'),'int');
        $page = max( $page, 1 );
        $page_size = 100;

        $articleObj       = new IModel('article');
        $article_info = $articleObj->getObj('id = '.$this->article_id);
        if(empty($article_info))
        {
            //$this->show_warning('资讯文章不存在');
            IError::show(403,'文章不存在');
            exit();
        }
        if ( $article_info['user_id'] )
        {
            $user_db = new IQuery('user');
            $user_db->where = 'id = ' . $article_info['user_id'];
            $user_info = $user_db->getOne();
            if ( $user_info )
                $article_info['user_name'] = $user_info['username'];
        }
        	
        //关联商品
        //$this->relationList = Api::run('getArticleGoods',array("#article_id#",$this->article_id));
        	
        // 获取文档分类路径
        $article_info['path'] = article_category_class::get_parent_category_list( $article_info['category_id'] );
        $article_info['content'] = nl2br($article_info['content']);
        $article_info['content'] = str_replace('\n','<br />',$article_info['content']);
        //dump( $article_info );
        	
        // 获取列表页广告图
        $ad_list = Ad::getAdList(22);
        	
        // 获取侧边栏分类
        $category_list = article_category_class::get_child_category_list(2);
        	
        // 获取热门文章
        $hot_article_list = article::get_hotest_list(6);
        	
        // 获取评论
        $reply_db = article_reply_class::get_article_reply_list( $this->article_id, $page, $page_size );
        $reply_list = $reply_db->find();
        $paging = $reply_db->paging;
        if ( $reply_list )
        {
            $user_id_arr = array();
            foreach( $reply_list as $kk => $vv )
            {
                if ( !in_array( $vv['user_id'], $user_id_arr ))
                    $user_id_arr[] = $vv['user_id'];
                 
                $reply_list[$kk]['thumb_count'] = article_reply_thumb_class::get_reply_thumb_count($vv['id']);
            }
             
            $user_db = new IQuery('user as u ');
            $user_db->join = 'left join member as m on u.id = m.user_id';
            $user_db->where = db_create_in( $user_id_arr, 'u.id');
            $user_db->fields = 'u.id, u.username, u.head_ico,m.sex';
            $user_list = $user_db->find();
             
            $user_temp = array();
            if ( $user_list )
            {
                foreach( $user_list as $kk => $vv )
                {
                    $user_temp[$vv['id']] = $vv;
                }
            }
            $user_list = $user_temp;
             
            foreach( $reply_list as $kk => $vv )
            {
                if (isset($user_list[$vv['user_id']]))
                {
                    $reply_list[$kk]['head_ico'] = $user_list[$vv['user_id']]['head_ico'];
                }
            }
        }
        $page_info = $reply_db->getPageBar();
        	
        $article_info['reply_count'] = article_reply_class::get_article_reply_count($this->article_id );
        	
        // 更新浏览量, 设置cookie过期时间为24小时
        if ( !isset( $_COOKIE['article_' . $this->article_id] ) || $_COOKIE['article_' . $this->article_id] != '1' )
        {
            article::update_article_views( $this->article_id );
            setcookie( 'article_' . $this->article_id, '1', time() + 3600 * 24 );
        }
        $callback = $_SERVER['PHP_SELF'];
        $this->title = '试听报告详情';

        //seo_data
        if ( $article_info['user_id'] )
        {
            $user_db = new IQuery('user');
            $user_db->where = 'id = ' . $article_info['user_id'];
            $user_info = $user_db->getOne();
            $user_name = $user_info['username'];
        } else {
            $user_name = '第三课';
        }
        $content = strip_tags($article_info['content']);
        $content = mb_substr( $content, 0, 50, 'utf-8');
        	
        // 微信分享
        $wechat = new wechat_class();
        $wechat->token = 'y53na1qnxJ6o1qj1';
        $wechat->appid = 'wx72fc7befef40f55a';
        $wechat->appSecret = '8446dfd26a915aa506567d436ac9db52';
        $urls = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $sign_package_info = $wechat->shareMsg($urls);
        
        $article_info['thumb_count'] = article_thumb_class::get_article_thumb_count($this->article_id);
        	
        $this->setRenderData(array(
            'ad_list'    =>  $ad_list,
            'category_list'  =>  $category_list,
            'hot_article_list'   =>  $hot_article_list,
            'article_info'   =>  $article_info,
            'reply_list'     =>  $reply_list,
            'page_info'      =>  $page_info,
            'user_list'      =>  $user_list,
            'page'           =>  $page,
            'page_size'      =>  $page_size,
            'paging'         =>  $paging,
            'id'             =>  $this->article_id,
            'callback'       =>  $callback,
            'seo_data'     =>  array(
                'title'    =>  $this->site_config->index_seo_title . '-' . $article_info['path'][0]['name'] . '-' . $article_info['title'],
                'keywords' =>  $this->get_city() . '-教育资讯-' . $article_info['path'][0]['name'] . '-' . $user_name,
                'description'  =>  $article_info['title'] . '，' . $article_info['create_time'] . '，' . $user_name . $content,
            ),
             
            'sign_package_info'  =>  $sign_package_info,
            'share_url'      =>  $urls
        ));
        	

        $this->redirect('article_detail2');

    }
}

    // 文章评论
    function article_reply()
    {
        $user = $this->user;
        $article_id = IFilter::act(IReq::get('article_id'),'int');
        $content = IFilter::act(IReq::get('reply_content'),'text');
        $captcha = strtolower( IFilter::act(IReq::get('captcha','post')) );
        $_captcha   = strtolower( ISafe::get('captcha') );
        $type = IFilter::act(IReq::get('type'));
         
        $bad_file = IWEB_ROOT . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'bad_words.php';
        if ( file_exists($bad_file))
        {
            $bad_words = include_once($bad_file);
            $content_bad_words = check_bad_words($content, $bad_words );
            $content = ( $content_bad_words ) ? str_replace($content_bad_words, '', $content ) : $content;
            unset( $bad_words );
        }
    
        $article_info = article::get_info($article_id);
        if ( !$article_info )
        {
            //$this->show_warning('文章可能已被删除，无法回复!');
            IError::show(403,'文章可能已被删除，无法回复!');
            exit();
        }
         
        if ( !$content )
        {
            //$this->show_warning('内容不能为空!');
            IError::show(403,'内容不能为空!');
            exit();
        }
         
        /*if ( $captcha && $captcha != $_captcha && $type != 'mobile')
         {
         $this->show_warning('验证码不正确!');
         exit();
         }*/
         
        $data = array(
            'article_id'   =>  $article_id,
            'content'      =>  $content,
            'user_id'      =>  $user['user_id'],
            'add_time'     =>  time(),
        );
         
        $article_reply_db = new IModel('article_reply');
        $article_reply_db->setData($data);
        if ( $article_reply_db->add() )
        {
            /*if($article_info['goods_id'])
             {
             $this->show_message('回复成功', '返回课程', IUrl::creatUrl('/site/products/id/' . $article_info['goods_id']));
             }
             else
             {*/
            //$this->show_message('回复成功', '返回文章', IUrl::creatUrl('/site/article_detail/id/' . $article_id));
            //}
            header("location:" . IUrl::creatUrl('/site/article_detail/id/' . $article_id));
            exit();
        } else {
            //$this->show_warning('回复失败!');
            IError::show(403,'回复失败!');
            exit();
        }
    }

    // 评论点赞
    function article_reply_thumb_ajax()
    {
        $user = $this->user;
        $id = IFilter::act(IReq::get('id'),'int');
    
        if ( !$user['user_id'] || !$id )
        {
            // 参数不正确
            die('-1');
        }
        $result = article_reply_thumb_class::can_thumb($id, $user['user_id']);
        if ( !$result )
        {
            // 已经点过赞了
            die('0');
        }
         
        if ( article_reply_thumb_class::add_thumb($id, $user['user_id']))
        {
            // 点赞成功
            die('1');
        } else {
            // 点赞失败
            die('-2');
        }
    }

    // 文章点赞功能
    function article_thumb_ajax()
    {
        $user = $this->user;
        $id = IFilter::act(IReq::get('id'),'int');
        
        if ( !$user['user_id'] || !$id )
        {
            // 参数不正确
            die('-1');
        }
        $result = article_thumb_class::can_thumb($id, $user['user_id']);
        if ( !$result )
        {
            // 已经点过赞了
            die('0');
        }
         
        if ( article_thumb_class::add_thumb($id, $user['user_id']))
        {
            // 点赞成功
            die('1');
        } else {
            // 点赞失败
            die('-2');
        }
    }

	//商品展示
	function products()
	{
		$goods_id = IFilter::act(IReq::get('id'),'int');
		$user_id = $this->user['user_id'];

		if(!$goods_id)
		{
			IError::show(403,"传递的参数不正确");
			exit;
		}

		//使用商品id获得商品信息
		$tb_goods = new IModel('goods');
		$goods_info = $tb_goods->getObj('id='.$goods_id." AND is_del=0");
		if(!$goods_info)
		{
		    $goods_info = $tb_goods->getObj('id='.$goods_id);
		    if ( $goods_info && $goods_info['seller_id'] == 404 )
		    {
		        $seller_info = seller_class::get_seller_info($goods_info['seller_id']);
		        $brand_id = $seller_info['brand_id'];
		        header("location: " . IUrl::creatUrl('/site/brand_zone/id/' . $brand_id));
		        exit();
		    }
			IError::show(403,"这件商品不存在");
			exit;
		}

		//品牌名称
		if($goods_info['brand_id'])
		{
			$tb_brand = new IModel('brand');
			$brand_info = $tb_brand->getObj('id='.$goods_info['brand_id']);
			if($brand_info)
			{
				$goods_info['brand'] = $brand_info['name'];
			}
		}
		
		//计算提成
		$goods_info['goods_promotion_commission'] = order_class::get_goods_promote($goods_id);

		//获取商品分类
		$categoryObj = new IModel('category_extend as ca,category as c');
		$categoryList= $categoryObj->query('ca.goods_id = '.$goods_id.' and ca.category_id = c.id','c.id,c.name','ca.id desc',1);
		$categoryRow = null;
		if($categoryList)
		{
			$categoryRow = current($categoryList);
		}
		$goods_info['category'] = $categoryRow ? $categoryRow['id'] : 0;

		//商品图片
		$tb_goods_photo = new IQuery('goods_photo_relation as g');
		$tb_goods_photo->fields = 'p.id AS photo_id,p.img ';
		$tb_goods_photo->join = 'left join goods_photo as p on p.id=g.photo_id ';
		$tb_goods_photo->where =' g.goods_id='.$goods_id;
		$tb_goods_photo->order =' g.id asc';
		$goods_info['photo'] = $tb_goods_photo->find();

		//商品是否参加促销活动(团购，抢购)
		$goods_info['promo']     = IReq::get('promo')     ? IReq::get('promo') : '';
		$goods_info['active_id'] = IReq::get('active_id') ? IFilter::act(IReq::get('active_id'),'int') : 0;
		if($goods_info['promo'])
		{
			$activeObj    = new Active($goods_info['promo'],$goods_info['active_id'],$this->user['user_id'],$goods_id);
			$activeResult = $activeObj->data();
			if(is_string($activeResult))
			{
				IError::show(403,$activeResult);
			}
			else
			{
				$goods_info[$goods_info['promo']] = $activeResult;
			}
		}

		//获得扩展属性
		$tb_attribute_goods = new IQuery('goods_attribute as g');
		$tb_attribute_goods->join  = 'left join attribute as a on a.id=g.attribute_id ';
		$tb_attribute_goods->fields=' a.name,g.attribute_value ';
		$tb_attribute_goods->where = "goods_id='".$goods_id."' and attribute_id!=''";
		$goods_info['attribute'] = $tb_attribute_goods->find();

		//购买记录
		$tb_shop = new IQuery('order_goods as og');
		$tb_shop->join = 'left join order as o on o.id=og.order_id';
		$tb_shop->fields = 'count(*) as totalNum';
		$tb_shop->where = 'og.goods_id='.$goods_id.' and o.status = 5';
		$shop_info = $tb_shop->find();
		$goods_info['buy_num'] = 0;
		if($shop_info)
		{
			$goods_info['buy_num'] = $shop_info[0]['totalNum'];
		}

		//购买前咨询
		$tb_refer    = new IModel('refer');
		$refeer_info = $tb_refer->getObj('goods_id='.$goods_id,'count(*) as totalNum');
		$goods_info['refer'] = 0;
		if($refeer_info)
		{
			$goods_info['refer'] = $refeer_info['totalNum'];
		}

		//网友讨论
		$tb_discussion = new IModel('discussion');
		$discussion_info = $tb_discussion->getObj('goods_id='.$goods_id,'count(*) as totalNum');
		$goods_info['discussion'] = 0;
		if($discussion_info)
		{
			$goods_info['discussion'] = $discussion_info['totalNum'];
		}

		//获得商品的价格区间
		$tb_product = new IModel('products');
		$product_info = $tb_product->getObj('goods_id='.$goods_id,'max(sell_price) as maxSellPrice ,max(market_price) as maxMarketPrice');
		if(isset($product_info['maxSellPrice']) && $goods_info['sell_price'] != $product_info['maxSellPrice'])
		{
			$goods_info['sell_price']   .= "-".$product_info['maxSellPrice'];
		}

		if(isset($product_info['maxMarketPrice']) && $goods_info['market_price'] != $product_info['maxMarketPrice'])
		{
			$goods_info['market_price'] .= "-".$product_info['maxMarketPrice'];
		}

		//获得会员价
		$countsumInstance = new countsum();
		//$goods_info['group_price'] = $countsumInstance->groupPriceRange($goods_id);

		//获取商家信息
		if($goods_info['seller_id'])
		{
			$sellerDB = new IModel('seller');
			$goods_info['seller'] = $sellerDB->getObj('id = '.$goods_info['seller_id']);
			
			$brand_db = new IQuery('brand');
			$brand_db->where = 'id = ' . $goods_info['seller']['brand_id'];
			$goods_info['brand'] = $brand_db->getOne();
		}
        
		//增加浏览次数
		$visit    = ISafe::get('visit');
		$checkStr = "#".$goods_id."#";
		if($visit && strpos($visit,$checkStr) !== false)
		{
		}
		else
		{
			$tb_goods->setData(array('visit' => 'visit + 1'));
			$tb_goods->update('id = '.$goods_id,'visit');
			$visit = $visit === null ? $checkStr : $visit.$checkStr;
			ISafe::set('visit',$visit);
		}
		
        $brand_id=$goods_info['brand_id'];
        $goods_list = goods_class::get_goods_list_by_brand_id($brand_id,50);
        $goods_list_mini = array();
        $goods_price = array();
        $photo = ( $brand_info['img'] ) ? explode(',', $brand_info['img']) : array();
        if ( $goods_list )
        {
            foreach( $goods_list as $kk => $vv )
            {
                $goods_price[] = $vv['sell_price'];
                //$photo[] = $vv['img'];
        
                $goods_list_mini[$vv['id']] = array(
                    'id'    =>  $vv['id'],
                    'name'  =>  $vv['name'],
                    'seller_id' =>  $vv['seller_id'],
                    'market_price'  =>  $vv['market_price'],
                    'sell_price'   =>  $vv['sell_price'],
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
                    'keywords'   =>  mb_substr($vv['keywords'], 0, 35, 'utf-8'),
                    'content'   =>  $vv['content'],
                    'chit'     =>  $vv['chit'],
                    'max_price'    =>  $vv['max_price'],
                );
                 
                $product_list = products_class::get_product_list($vv['id']);
				
                if ( $product_list )
                {
                    foreach( $product_list as $kk => $vv )
                    {
                        $goods_price[] = $vv['sell_price'];
                    }
					
                }
            }
        }
		    
			  $this->brandname=$brand_info['name'];
		    $this->setRenderData(array(
			  'goods_list'=>$goods_list,'brand_id'=>$brand_id));
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
		   
		  $goods_list_json = json_encode($goods_list_mini);
	
	
           $this->setRenderData(array(
			  'goods_list_json'=>$goods_list_json,'goods_list_mini'=>$goods_list_mini));		  
		
		
		
	
	  
	
	
	
	
	
	
		
		// 获取商品规格
		$productDB = new IModel('products');
		$products = $productDB->query("goods_id = '$goods_id'", '*', 'market_price ASC');
		$spec_array = array();
		$val_array = array();
		$spec_array['name'] = $products[0]['cusname'];
		foreach($products AS $product)
		{
		    $spec_array['value'][] = array(
		        'id' => $product['id'],
		        'cusval' => $product['cusval'],
		        'classnum' => $product['classnum'],
		        'month' => $product['month'],
		    );
		}
		$this->setRenderData(array('goods_spec_array' => $spec_array));
		
		if( $goods_info['brand']['certificate_of_authorization'] )
		{
		    $goods_info['brand']['certificate_of_authorization'] = explode(',', $goods_info['brand']['certificate_of_authorization'] );
		}
		
		// 获取该课程的短期课
		$dqk_list = brand_chit_class::get_dqk_info_by_goods_id($goods_id);
		$goods_info['dqk_list'] = $dqk_list;
		
		
		// 设定微信分享的信息
		if ( IClient::isWechat() )
		{
		    $siteConfig = new Config("site_config");
		    $share_link = 'http://www.dsanke.com/site/products/id/' . $goods_id;
		    if ( $user_id )
		        $share_link .= '/promote/' . $user_id;
		    $this->sharedata = json_encode(array(
		        'imgUrl'    =>  'http://www.dsanke.com/views/mobile/skin/blue/images/wechat_share_logo.jpg',
		        'desc'      =>  $goods_info['keywords'],
		        'title'     =>  $goods_info['name'],
		        'link'      =>  $share_link,
		    ));
		}

		$this->title = $goods_info['name'];
		$this->setRenderData($goods_info);
		$this->redirect('products');
	}
	//商品讨论更新
	function discussUpdate()
	{
		$goods_id = IFilter::act(IReq::get('id'),'int');
		$content  = IFilter::act(IReq::get('content'),'text');
		$captcha  = IReq::get('captcha');
		$_captcha = ISafe::get('captcha');
		$return   = array('isError' => true , 'message' => '');

		if(!$this->user['user_id'])
		{
			$return['message'] = '请先登录系统';
		}
    	else if(!$captcha || !$_captcha || $captcha != $_captcha)
    	{
    		$return['message'] = '验证码输入不正确';
    	}
    	else if(trim($content) == '')
    	{
    		$return['message'] = '内容不能为空';
    	}
    	else
    	{
    		$return['isError'] = false;

			//插入讨论表
			$tb_discussion = new IModel('discussion');
			$dataArray     = array(
				'goods_id' => $goods_id,
				'user_id'  => $this->user['user_id'],
				'time'     => ITime::getDateTime(),
				'contents' => $content,
			);
			$tb_discussion->setData($dataArray);
			$tb_discussion->add();

			$return['time']     = $dataArray['time'];
			$return['contents'] = $content;
			$return['username'] = $this->user['username'];
    	}
    	echo JSON::encode($return);
	}

	//获取货品数据
	function getProduct()
	{
		$goods_id = IFilter::act(IReq::get('goods_id'),'int');
		$product_id = IFilter::act(IReq::get('product_id'),'int');
		$specJSON = IReq::get('specJSON');
// 		if(!$specJSON || !is_array($specJSON))
// 		{
// 			echo JSON::encode(array('flag' => 'fail','message' => '规格值不符合标准'));
// 			exit;
// 		}

		//获取货品数据
		$tb_products = new IModel('products');
		$procducts_info = $tb_products->getObj("goods_id = ".$goods_id." and spec_array = '".IFilter::act(JSON::encode($specJSON))."'");
		
		if ( !$procducts_info )
		{
		    $tb_products = new IModel('products');
		    $procducts_info = $tb_products->getObj("goods_id = ".$goods_id." and id = '$product_id'");
		}

		//匹配到货品数据
		if(!$procducts_info)
		{
			echo JSON::encode(array('flag' => 'fail','message' => '没有找到相关货品'));
			exit;
		}

		//获得会员价
		$countsumInstance = new countsum();
		$group_price = $countsumInstance->getGroupPrice($procducts_info['id'],'product');

		//会员价格
		if($group_price !== null)
		{
			$procducts_info['group_price'] = $group_price;
		}

		echo JSON::encode(array('flag' => 'success','data' => $procducts_info));
	}

	//顾客评论ajax获取
	function comment_ajax()
	{
		$goods_id = IFilter::act(IReq::get('goods_id'),'int');
		$page     = IFilter::act(IReq::get('page'),'int') ? IReq::get('page') : 1;

		$commentDB = new IQuery('comment as c');
		$commentDB->join   = 'left join goods as go on c.goods_id = go.id AND go.is_del = 0 left join user as u on u.id = c.user_id';
		$commentDB->fields = 'u.head_ico,u.username,c.*';
		$commentDB->where  = 'c.goods_id = '.$goods_id.' and c.status = 1';
		$commentDB->order  = 'c.id desc';
		$commentDB->page   = $page;
		$data     = $commentDB->find();
		$pageHtml = $commentDB->getPageBar("javascript:void(0);",'onclick="comment_ajax([page])"');

		echo JSON::encode(array('data' => $data,'pageHtml' => $pageHtml));
	}

	//购买记录ajax获取
	function history_ajax()
	{
		$goods_id = IFilter::act(IReq::get('goods_id'),'int');
		$page     = IFilter::act(IReq::get('page'),'int') ? IReq::get('page') : 1;

		$orderGoodsDB = new IQuery('order_goods as og');
		$orderGoodsDB->join   = 'left join order as o on og.order_id = o.id left join user as u on o.user_id = u.id';
		$orderGoodsDB->fields = 'o.user_id,og.goods_price,og.goods_nums,o.create_time as completion_time,u.username';
		$orderGoodsDB->where  = 'og.goods_id = '.$goods_id.' and o.status = 5';
		$orderGoodsDB->order  = 'o.create_time desc';
		$orderGoodsDB->page   = $page;

		$data = $orderGoodsDB->find();
		$pageHtml = $orderGoodsDB->getPageBar("javascript:void(0);",'onclick="history_ajax([page])"');

		echo JSON::encode(array('data' => $data,'pageHtml' => $pageHtml));
	}

	//讨论数据ajax获取
	function discuss_ajax()
	{
		$goods_id = IFilter::act(IReq::get('goods_id'),'int');
		$page     = IFilter::act(IReq::get('page'),'int') ? IReq::get('page') : 1;

		$discussDB = new IQuery('discussion as d');
		$discussDB->join = 'left join user as u on d.user_id = u.id';
		$discussDB->where = 'd.goods_id = '.$goods_id;
		$discussDB->order = 'd.id desc';
		$discussDB->fields = 'u.username,d.time,d.contents';
		$discussDB->page = $page;

		$data = $discussDB->find();
		$pageHtml = $discussDB->getPageBar("javascript:void(0);",'onclick="discuss_ajax([page])"');

		echo JSON::encode(array('data' => $data,'pageHtml' => $pageHtml));
	}

	//买前咨询数据ajax获取
	function refer_ajax()
	{
		$goods_id = IFilter::act(IReq::get('goods_id'),'int');
		$page     = IFilter::act(IReq::get('page'),'int') ? IReq::get('page') : 1;

		$referDB = new IQuery('refer as r');
		$referDB->join = 'left join user as u on r.user_id = u.id';
		$referDB->where = 'r.goods_id = '.$goods_id;
		$referDB->order = 'r.id desc';
		$referDB->fields = 'u.username,u.head_ico,r.time,r.question,r.reply_time,r.answer';
		$referDB->page = $page;

		$data = $referDB->find();
		$pageHtml = $referDB->getPageBar("javascript:void(0);",'onclick="refer_ajax([page])"');

		echo JSON::encode(array('data' => $data,'pageHtml' => $pageHtml));
	}

	//评论列表页
	function comments_list()
	{
		$id   = IFilter::act(IReq::get("id"),'int');
		$type = IFilter::act(IReq::get("type"));
		$data = array();

		//评分级别
		$type_config = array('bad'=>'1','middle'=>'2,3,4','good'=>'5');
		$point       = isset($type_config[$type]) ? $type_config[$type] : "";

		//查询评价数据
		$this->commentQuery = Api::run('getListByGoods',$id,$point);
		$this->commentCount = Comment_Class::get_comment_info($id);
		$this->goods        = Api::run('getGoodsInfo',array("#id#",$id));
		if(!$this->goods)
		{
			IError::show("商品信息不存在");
		}
		$this->redirect('comments_list');
	}

	//提交评论页
	function comments()
	{
		$id = IFilter::act(IReq::get('id'),'int');

		if(!$id)
		{
			IError::show(403,"传递的参数不完整");
		}

		if(!isset($this->user['user_id']) || $this->user['user_id']==null )
		{
			IError::show(403,"登录后才允许评论");
		}

		$result = Comment_Class::can_comment($id,$this->user['user_id']);
		if(is_string($result))
		{
			IError::show(403,$result);
		}

		$this->comment      = $result;
		$this->commentCount = Comment_Class::get_comment_info($result['goods_id']);
		$this->goods        = Api::run('getGoodsInfo',array("#id#",$result['goods_id']));
		$this->redirect("comments");
	}

	/**
	 * @brief 进行商品评论 ajax操作
	 */
	public function comment_add()
	{
		$id      = IFilter::act(IReq::get('id'),'int');
		$content = IFilter::act(IReq::get("contents"));
		if(!$id || !$content)
		{
			IError::show(403,"填写完整的评论内容");
		}

		if(!isset($this->user['user_id']) || !$this->user['user_id'])
		{
			IError::show(403,"未登录用户不能评论");
		}

		$data = array(
			'point'        => IFilter::act(IReq::get('point'),'float'),
			'contents'     => $content,
			'status'       => 1,
			'comment_time' => ITime::getNow("Y-m-d"),
		);

		if($data['point']==0)
		{
			IError::show(403,"请选择分数");
		}

		$result = Comment_Class::can_comment($id,$this->user['user_id']);
		if(is_string($result))
		{
			IError::show(403,$result);
		}

		$tb_comment = new IModel("comment");
		$tb_comment->setData($data);
		$re         = $tb_comment->update("id={$id}");

		if($re)
		{
			$commentRow = $tb_comment->getObj('id = '.$id);

			//同步更新goods表,comments,grade
			$goodsDB = new IModel('goods');
			$goodsDB->setData(array(
				'comments' => 'comments + 1',
				'grade'    => 'grade + '.$commentRow['point'],
			));
			$goodsDB->update('id = '.$commentRow['goods_id'],array('grade','comments'));

			//同步更新seller表,comments,grade
			$sellerDB = new IModel('seller');
			$sellerDB->setData(array(
				'comments' => 'comments + 1',
				'grade'    => 'grade + '.$commentRow['point'],
			));
			$sellerDB->update('id = '.$commentRow['seller_id'],array('grade','comments'));
			$this->redirect("/site/comments_list/id/".$commentRow['goods_id']);
		}
		else
		{
			IError::show(403,"评论失败");
		}
	}

	function pic_show()
	{
		$this->layout="";

		$id   = IFilter::act(IReq::get('id'),'int');
		$item = Api::run('getGoodsInfo',array('#id#',$id));
		if(!$item)
		{
			IError::show(403,'商品信息不存在');
		}
		$photo = Api::run('getGoodsPhotoRelationList',array('#id#',$id));
		$this->setRenderData(array("id" => $id,"item" => $item,"photo" => $photo));
		$this->redirect("pic_show");
	}

	function help()
	{
		$id       = IFilter::act(IReq::get("id"),'int');
		$tb_help  = new IModel("help");
		$help_row = $tb_help->getObj("id={$id}");
		if(!$help_row)
		{
			IError::show(404,"您查找的页面已经不存在了");
		}
		$help_row['content'] = str_replace('\n', '', $help_row['content']);
		$tb_help_cat    = new IModel("help_category");
		$this->cat_row  = $tb_help_cat->getObj("id={$help_row['cat_id']}");
		$this->help_row = $help_row;
		$this->title = $this->help_row['name'];
		$this->redirect("help");
	}

	function help_list()
	{
        $key = IFilter::act(IReq::get("key"));
		
        $page = 1;
        if ( $key )
        {
            $help_db = new IQuery('help');
            $help_db->where = "name like '%$key%'";
            $help_db->page = $page;
            $help_db->pagesize = 12;
            $help_list = $help_db->find();
            
            $category_list = Api::run('getHelpCategoryLeft',10);
            if ( $category_list )
            {
                foreach($category_list as $kk => $vv )
                {
                    $category_list[$kk]['help_list'] = Api::run('getHelpListByCatidAll',array('#cat_id#',$vv['id']));
                    if ($vv['id'] == $this->cat_row['id'])
                        $category_list[$kk]['show'] = 1;
                }
            }
            
            $this->setRenderData(array(
                'help_list' =>  $help_list,
                'page_info' =>  $help_db->getPageBar(),
                'category_list'   =>  $category_list,
                'keyword'   =>  $key,
            ));
        } else {
            $category_list = Api::run('getHelpCategoryLeft',10);
            if ( $category_list )
            {
                foreach($category_list as $kk => $vv )
                {
                    $category_list[$kk]['help_list'] = Api::run('getHelpListByCatidAll',array('#cat_id#',$vv['id']));
                    if ( !$kk )
                    {
                        $this->redirect('/site/help/id/' . $category_list[$kk]['help_list'][0]['id']);
                        exit();
                    }
                }
            }
        }
		$this->redirect("help_list");
	}

	//团购页面
	function groupon()
	{
		$id = IFilter::act(IReq::get("id"),'int');

		//指定某个团购
		if($id)
		{
			$this->regiment_list = Api::run('getRegimentRowById',array('#id#',$id));
			$this->regiment_list = $this->regiment_list ? array($this->regiment_list) : array();
		}
		else
		{
			$this->regiment_list = Api::run('getRegimentList');
		}

		if(!$this->regiment_list)
		{
			IError::show('当前没有可以参加的团购活动');
		}

		//往期团购
		$this->ever_list = Api::run('getEverRegimentList');
		$this->redirect("groupon");
	}

	//品牌列表页面
	function brand()
	{
		$category_id   = IFilter::act(IReq::get('id'),'int');
		$cat_id   = IFilter::act(IReq::get('cat_id'),'int');
		$category_list = brand_class::get_brand_category_list();
		$city_id = city::get_my_city_code();
		$area_list = area::get_child_area_list($city_id);
		$page = IFilter::act(IReq::get('page'),'int');
		$page = max( $page, 1 );
		$where = '';
		$catname = '';
		$area_id = $city_id;
		$area_id = IFilter::act(IReq::get('area_id'),'int');
		$page_size = ( IClient::getDevice() == IClient::PC ) ? 12 : 100;
		$keywords = IFilter::act(IReq::get('keywords'));

		if($category_id)
		{
		    $categoryModel = new IModel('brand_category');
		    $cat = $categoryModel->getObj("id = '$category_id'", 'name');
		    $catname = $cat['name'];
		    $where .= " and find_in_set('$category_id', b.category_ids)";
		}
		if($area_id)
		{
		    $where .= " and b.discrict = '$area_id'";
		}
		
		if ( IClient::getDevice() == IClient::PC )
		{
		    $brand_db = new IQuery('brand AS b');
		    $brand_db->join = "left join seller AS s ON b.id = s.brand_id";
		    $brand_db->where = "s.is_authentication = 1 and b.logo != '' AND s.is_vip = '1'AND b.description != '' AND b.shortname != '' $where";
		    //$brand_db->order = 'b.id desc';
		    $brand_db->order = 'b.sort desc, id desc';
		    $brand_db->fields = 'b.*,s.is_support_props';
		    $brand_db->page = $page;
		    $brand_db->pagesize = $page_size;
		    $brand_list = $brand_db->find();
		    $page_info = $brand_db->getPageBar();
		    foreach($brand_list AS $idx => $brand)
		    {
		        $seller_db = new IModel('seller');
		        $seller = $seller_db->getObj("brand_id = '$brand[id]'", 'is_lock,id');
		        $brand_list[$idx]['is_lock'] = $seller['is_lock'];
		        $brand_list[$idx]['seller_id'] = $seller['id'];
		        $brand_list[$idx]['category'] = Category_extend_class::get_category_name_by_store( $seller['id'] );
		    
		        $goods_db2 = new IQuery('goods');
		        $goods_db2->where = "seller_id = '$seller[id]' and is_del = 0";
		        $goods_db2->fields = 'id, seller_id,visit,sale';
		        $goods_list = $goods_db2->find();
		        $brand_list[$idx]['visit'] = 0;
		        $brand_list[$idx]['sale'] = 0;
		        if ( $goods_list)
		        {
		            foreach( $goods_list as $k => $v )
		            {
		                if ( $v['seller_id'] == $seller['id'] )
		                {
		                    $brand_list[$idx]['visit']+= $v['visit'];
		                    $brand_list[$idx]['sale']+= $v['sale'];
		                }
		            }
		        }

		        $length = 35;
		        $description = $brand['description'];
		        $description = str_replace(array('&lt;','&gt;'),array('<','>'),$description);
		        $description = nl2br($description);
		        $description = strip_tags($description);
		        $description = str_replace('\n','', $description);
		        if ( strlen($description) > $length )
		            $description = mb_substr($description, 0, 35, 'utf-8') . '...';
		        else
		            $description = mb_substr($description, 0, 35, 'utf-8');
		         
		        $brand_list[$idx]['description'] = $description;
		    }
		    
		    //seo_data
		    $delimiter = '-';
		    $catname_info = ( !$category_id ) ? '教育机构' : $catname;
		    $cate_list_info = $this->get_shop_cate_list($catname_info);
		    $cate_list_info = implode($delimiter, $cate_list_info);
		    
		    $shop_arr = array();
		    if ( $brand_list )
		    {
		        foreach( $brand_list as $kk => $vv )
		        {
		            if ( !in_array( $vv['shortname'], $shop_arr ))
		                $shop_arr[] = $vv['shortname'];
		        }
		    }
		    if ( $shop_arr )
		    {
		        $shop_str = implode($delimiter, $shop_arr);
		    }
		    
		    //查找分类信息
		    $catObj       = new IModel('category');
		    
		    //获取子分类
		    $cat_list = category_class::get_site_category(0);
		    
		    $this->setRenderData(array(
		        'brand_list'   =>  $brand_list,
		        'category_list' => $category_list,
		        'area_list' => $area_list,
		        'category_id' => $category_id,
		        'cat_list'  =>  $cat_list,
		        'area_id' => $area_id,
		        'page_info'     =>  $page_info,
		        'seo_data'     =>  array(
		            'title'    =>  $this->site_config->index_seo_title . '-' . $catname_info . '(' . $cate_list_info . ')',
		            'keywords' =>  $this->get_city() . '-' . $catname_info . '(' . $cate_list_info . ')',
		            'description'  =>  '乐享生活' . $this->get_city() . '的' . $this->title . '包含各类教育培训机构。您可以搜索（' . $shop_str . '）等，对它们进行了解。',
		        ),
		    ));
		} else {
		    $area_id = $city_id;
		    if ($cat_id)
		    {
		        //查找分类信息
		        $catObj       = new IModel('category');
		        $cat_info = $catObj->getObj('id = '.$cat_id);
		    } else {
		        $cat_info['id'] = 0;
		        $cat_info['name'] = '全部分类';
		    }
		    
		    // 获取所有可选分类
		    $jsoncat = array();
		    $cat_list = Api::run('getCategoryListTop');
		    if ( $cat_list )
		    {
		        foreach( $cat_list AS $idx => $cat)
		        {
		            $jsoncat[$idx]['value'] = $cat['id'];
		            $jsoncat[$idx]['text'] = $cat['name'];
		            $son_cat_db = new IQuery('category');
		            $son_cat_db->where = "parent_id = '$cat[id]'";
		            $sons = $son_cat_db->find();
		            foreach($sons AS $k => $son)
		            {
		                $jsoncat[$idx]['children'][$k]['value'] = $son['id'];
		                $jsoncat[$idx]['children'][$k]['text'] = $son['name'];
		            }
		        }
		    }
		    
		    // 获取所有可选区域
		    $area_arr = array(array(
		        'value'   =>  $area_id,
		        'text'    => area::getName($area_id),
		    ));
		    $area_list = area::get_child_area_list($area_id);
		    if ( $area_list )
		    {
		        foreach($area_list as $kk => $vv )
		        {
		            $area_arr[] = array(
		                'value'   =>  $vv['area_id'],
		                'text'    =>  $vv['area_name'],
		            );
		        }
		    }
		    
		    $this->setRenderData(array(
		        'jsoncats'   => json_encode($jsoncat),
		        'area_arr'   => json_encode($area_arr),
		        'area_id'    => $area_id,
		        'cat_info'   => $cat_info,
		        'keywords'   => $keywords,
		    ));
		    
		    $this->title = $catname ? $catname : '学校列表';
		}
		$this->redirect('brand');
	}

	//品牌专区页面
	function brand_zone()
	{
        $brand_id = IFilter::act(IReq::get('id'),'int');
        if(!$brand_id)
        {
            IError::show(403,"传递的参数不正确");
            exit;
        }
        
        $user_id = $this->user['user_id'];
        $type = IFilter::act(IReq::get('type'),'int');
         
        $brand_info = brand_class::get_brand_info($brand_id);
        if ( !$brand_info )
        {
            IError::show(403, '品牌不存在');
        }
        
        $seller_info = array();
        $seller_info = seller_class::get_seller_info_by_bid($brand_id);
        $seller_id = $seller_info['id'];
        $seller_info['brand_info'] = $brand_info;
        $seller_info['brand_info']['class_desc_img'] = ($seller_info['brand_info']['class_desc_img']) ? explode(',', $seller_info['brand_info']['class_desc_img']) : '';
        $seller_info['brand_info']['shop_desc_img'] = ($seller_info['brand_info']['shop_desc_img']) ? explode(',', $seller_info['brand_info']['shop_desc_img']) : '';
        $seller_info['brand_info']['certificate_of_authorization'] = ($seller_info['brand_info']['certificate_of_authorization']) ? explode(',', $seller_info['brand_info']['certificate_of_authorization']) : '';
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
        $goods_list = goods_class::get_goods_list_by_brand_id($brand_id,50);
        $goods_list_mini = array();
        $goods_price = array();
        $goods_promotion_commission = array();
        $photo = ( $brand_info['img'] ) ? explode(',', $brand_info['img']) : array();
        if ( $goods_list )
        {
            foreach( $goods_list as $kk => $vv )
            {
                $goods_price[] = $vv['sell_price'];        
                $goods_list_mini[$vv['id']] = array(
                    'id'    =>  $vv['id'],
                    'name'  =>  $vv['name'],
                    'seller_id' =>  $vv['seller_id'],
                    'market_price'  =>  $vv['market_price'],
                    'sell_price'   =>  $vv['sell_price'],
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
                    'keywords'   =>  mb_substr($vv['keywords'], 0, 35, 'utf-8'),
                    'content'   =>  $vv['content'],
                    'chit'     =>  $vv['chit'],
                    'max_price'    =>  $vv['max_price'],
                );
                 
                $product_list = products_class::get_product_list($vv['id']);
                if ( $product_list )
                {
                    foreach( $product_list as $kk => $vv )
                    {
                        $goods_price[] = $vv['sell_price'];
                    }
                }
                
                // 计算订单的提成
                $goods_promotion_commission[] = order_class::get_goods_promote($vv['id']);
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
        $goods_db->where = 'g.brand_id = ' . $brand_id . ' and a.attribute_id = 1';
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
        
        //get next
        $seller_db = new IModel('brand');
        $nextid = $seller_db->query("id > '$brand_id'", 'id', 'id ASC', 1);
        if(!$nextid[0]['id'])
        {
            $nextid = $seller_db->query("id < '$brand_id'", 'id', 'id ASC', 1);
        }
        $seller_info['nextid'] = $nextid[0]['id'];
        
        // 赋值
        $min = ($goods_price) ? min($goods_price) : 0;
        $max = ($goods_price) ? max($goods_price) : 0;
        $seller_info['goods_list'] = $goods_list_mini;
        $seller_info['goods_list_json'] = json_encode($goods_list_mini);
        $seller_info['price_level'] = ($min == $max ) ? $min : $min . '-' . $max;
        $seller_info['photo'] = $photo;
        $this->title = $seller_info['brand_info']['shortname'];
         
        // 商户代金券
        $chit_list = brand_chit_class::get_chit_list_by_brand_id($brand_id);
         
        // 获取短期课列表
        $dqk_list = brand_chit_class::get_dqk_list_by_brand_id($brand_id);
        $dqk_list = array_chunk($dqk_list,2);
        $dqk_list = current($dqk_list);
        
        // 设定微信分享的信息
        if ( IClient::isWechat() )
        {
            $siteConfig = new Config("site_config");
            $share_link = 'http://www.dsanke.com/site/brand_zone/id/' . $brand_id;
            if ( $user_id )
                $share_link .= '/promote/' . $user_id;
            $this->sharedata = json_encode(array(
                'imgUrl'    =>  'http://www.dsanke.com/views/mobile/skin/blue/images/wechat_share_logo.jpg',
                'desc'      =>  $brand_info['brief'],
                'title'     =>  $brand_info['shortname'],
                'link'      =>  $share_link,
            ));
        }
        
        $this->setRenderData(array(
            'brand_info'   =>  $brand_info,
            'seller_info'   =>  $seller_info,
            'attrArr'       =>  $attrArr,
            'chit_list'     => $chit_list,
            'dqk_list'     =>  $dqk_list,
            'djq_list'     =>  $djq_list,
            'max_promotion_commission'  =>  max($goods_promotion_commission),
        ));
        $this->redirect('brand_zone');
	}

	//商家主页1
	function home1()
	{
		$seller_id = IFilter::act(IReq::get('id'),'int');
		$sellerRow = Api::run('getSellerInfo',$seller_id);
		if(!$sellerRow)
		{
			IError::show(403,'商户信息不存在');
		}
		$this->setRenderData(array('sellerRow' => $sellerRow,'seller_id' => $seller_id));
		$this->redirect('home1');
	}
	
	//商家主页
	function home()
	{
	    $seller_id = IFilter::act(IReq::get('id'),'int');
	    if(!$seller_id)
	    {
	        IError::show(403,"传递的参数不正确");
	        exit;
	    }
	   
	    $user_id = $this->user['user_id'];
	    $user_id = $this->user['user_id'];
	    $type = IFilter::act(IReq::get('type'),'int');
	    
	    $seller_info = seller_class::get_seller_info($seller_id);
	    if ( !$seller_info )
	    {
	        IError::show(403, '商户不存在');
	    }
	    
	    header("location: " . IUrl::creatUrl('/site/brand_zone/id/' . $seller_info['brand_id']));
	    exit();

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
	    $goods_list = goods_class::get_goods_list_by_seller_id($seller_id, 50);
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
	                'sell_price'   =>  $vv['sell_price'],
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
	                'content'   =>  $vv['content'],
	                'chit'     =>  $vv['chit'],
	                'max_price'    =>  $vv['max_price'],
	            );
	            
	            $product_list = products_class::get_product_list($vv['id']);
	            if ( $product_list )
	            {
	                foreach( $product_list as $kk => $vv )
	                {
	                    $goods_price[] = $vv['sell_price'];
	                }
	            }
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
	    
	    // 获取短期课列表
	    $dqk_list = brand_chit_class::get_dqk_list_by_seller_id($seller_id);
	    $dqk_list = array_chunk($dqk_list,2);
	    $dqk_list = current($dqk_list);
	    
	    // 获取代金券列表
	    $djq_list = brand_chit_class::get_chit_list2_by_seller_id($seller_id);
	    $djq_list = array_chunk($djq_list,2);
	
	    $this->setRenderData(array(
	        'seller_info'   =>  $seller_info,
	        'attrArr'       =>  $attrArr,
	        'ticket'        => $ticket,
	        'chit_list'     => $chit_list,
	        'stk_list'     =>  $stk_list,
	        'seller_stk_list'  =>  $seller_stk_list,
	        'dqk_list'     =>  $dqk_list,
	        'djq_list'     =>  $djq_list,
	    ));
	    $this->redirect('home');
	}
	
		// 获取代金券信息
	function get_chit_info()
	{	    
	    $seller_id = IFilter::act(IReq::get('seller_id'),'int');
	    $goods_id = IFilter::act(IReq::get('goods_id'),'int');
	    $spec_id = IFilter::act(IReq::get('spec_id'),'int');
	
	    $barnd_chit_db = new IQuery('brand_chit');
	    $barnd_chit_db->where = 'goods_id = ' . $goods_id . '  and product_id = ' . $spec_id . ' and category = 1';
	    $info = $barnd_chit_db->getOne();
	    if($info){
	        $info['limittime'] = date('Y-m-d',$info['limittime']);
	    }
	    echo json_encode($info);
	}
	
	// 优惠购课
	function buy_chit()
	{
	    $type = IFilter::act(IReq::get('type'));
	    $id = IFilter::act(IReq::get('id'),'int');
	    
	    if ( !$id || !in_array($type, array('goods','product')))
	    {
	        IError::show(403, '参数不正确');
	        exit();
	    }
	    
	    if ( $type == 'goods')
	    {
	        $goods_info = goods_class::get_goods_info($id);
	        $max_price = $goods_info['max_price'];
	        $max_order_chit = $goods_info['chit'];
	    } else {
	        $product_info = products_class::get_product_info($id);
	        $goods_info = goods_class::get_goods_info($product_info['goods_id']);
	        $max_price = $product_info['max_price'];
	        $max_order_chit = $product_info['chit'];
	    }
	    
	    if ( !$goods_info || $goods_info['is_del'] == 1)
	    {
	        IError::show(403, '该课程可能已被删除');
	        exit();
	    }

	    // 读取代金券信息
	    if ( !$max_price || !$max_order_chit )
	    {
	        IError::show(403, '该课程无可用代金券');
	        exit();
	    }
	    
	    $info = array(
	        'max_price'    =>  $max_price,
	        'max_order_chit'   =>  $max_order_chit,
	        'rate'         =>  number_format($max_order_chit / $goods_info['sell_price'], 4, '.', '')
	    );
	    
	    $this->title = '优惠购课';
	    $this->setRenderData(array(
	        'goods_info'   =>  $goods_info,
	        'brand_chit_info'  =>  $info,
	        'type'         =>  $type,
	        'id'           =>  $id,
	    ));
	    $this->redirect('buy_chit');
	}
	
	function chit()
	{
	    $this->title = '代金券列表';
	    $this->redirect('chit');
	}
	
	// 短期课列表
	function chit1()
	{
	    $keywords = IFilter::act(IReq::get('keywords'));
	    if(IClient::getDevice() == 'pc')
	    {
	        $page = IFilter::act(IReq::get('page'),'int');
	        $page = max($page,1);
	        $page_size = 10;
	        
	    	$brand_chit_db = new IQuery('brand_chit as bc');
    	    $brand_chit_db->where = 'g.is_del = 0 and bc.category = 2 and bc.is_del = 0';
    	    $brand_chit_db->order = 'bc.id desc';
    	    $brand_chit_db->join = 'left join goods as g on bc.goods_id = g.id left join seller as s on bc.seller_id = s.id';
    	    $brand_chit_db->fields = 'distinct(bc.seller_id) as seller_id,bc.*,s.shortname as seller_name';
    	    $brand_chit_db->group = 'bc.seller_id';
    	    $chits = $brand_chit_db->find();
    	
    	    $list_count = sizeof($chits);
    	    $chits = array_chunk($chits,$page_size);
    	    $chits = $chits[$page - 1];
    	    
    	    if ( $chits )
    	    {
    	        $max_goods_name = 2;
    	        foreach( $chits as $kk => $vv )
    	        {
    	            $list = array();
    	            $price_list = array();
    	            $dqk_list = brand_chit_class::get_dqk_list_by_seller_id($vv['seller_id']);
    	            $dqk_list = array_chunk($dqk_list,$max_goods_name);
    	            $dqk_list = current($dqk_list);
                    if ( $dqk_list )
                    {
                        foreach( $dqk_list as $k => $v )
                        {
                            $list[] = $v['name'];
                            $price_list[] = $v['max_price'];
                        }
                        $chits[$kk]['goods_names'] = implode('<br /><span class="goods_name"></span>', $list);
                        $chits[$kk]['min_price'] = min($price_list);
                    }
    	        }
    	    }
    	    
    	    $paging = new IPaging();
    	    $paging->getPageInfo($list_count, $page_size, $page);
    	    
            $this->setRenderData(array(
                'list'  =>  $chits,
                'page_info' =>  $paging->getPageBar(),
            ));
	    } else {
	        // 手机端
	        // 获取所有分类
	    	$category_list = manual_category_class::get_category_list();
            $cate_arr = array();
            $cate_arr[] = array(
                'value'    =>   0,
                'text'      =>  '所有分类',
            );
            if ( $category_list )
            {
                foreach( $category_list as $kk => $vv )
                {
                    $cate_arr[] = array(
                        'value' =>  $vv['id'],
                        'text'  =>  $vv['name'],
                    );
                }
            }
	        
	        $this->setRenderData(array(
	            'jsoncats'   => json_encode($cate_arr),
	            'isctrl' => array('url' => '/simple/dqk_cart', 'text' => "<img src='/views/mobile/skin/blue/images/shopping cart_icon.png' class='dqk_cart' width='32' height='32' />"),
	            'keywords' =>  $keywords,
	        ));
	    }
	    $this->title = '短期课列表';
	    $this->redirect('chit1');
	}
	
	// 短期可详情
	function chit1_detail()
	{
	    $seller_id = IFilter::act(IReq::get('id'),'int');
	    $type = IFilter::act(IReq::get('type'),'int');
	    if ( !$seller_id )
	    {
	        IError::show('参数不正确');
	        return false;
	    }
	    $seller_info = seller_class::get_seller_info($seller_id);
	    if ( !$seller_info )
	    {
	        IError::show('商户不存在');
	        return false;
	    }
	    $type = ( !$type ) ? 1 : $type;
	    $brand_info = brand_class::get_brand_info($seller_info['brand_id']);
	    if( $brand_info['shop_desc_img'] )
	    {
	        $brand_info['shop_desc_img'] = explode(',', $brand_info['shop_desc_img']);
	    }
	    if( $brand_info['class_desc_img'] )
	    {
	        $brand_info['class_desc_img'] = explode(',', $brand_info['class_desc_img']);
	    }
	    if( $brand_info['certificate_of_authorization'] )
	    {
	        $brand_info['certificate_of_authorization'] = explode(',', $brand_info['certificate_of_authorization']);
	    }

	    $dqk_list = brand_chit_class::get_dqk_list_by_seller_id($seller_id);
	    if ( !$dqk_list )
	    {
	        IError::show('该学校暂时没有短期课');
	        exit();
	    }
		$price_arr = array();
		$goods_promotion_commission = array();
		$pay_dqk = array();
	    foreach($dqk_list as $kk => $vv )
	    {
	        $price_arr[] = $vv['max_price'];
	        
	        // 获取课程的相关信息
	        $goods_info = goods_class::get_goods_info($vv['goods_id']);
            if ( $vv['product_id'] )
            {
                $product_info = products_class::get_product_info($vv['product_id']);
            }
            $market_price = $vv['max_order_chit'];
            $age_grade = ($vv['product_id']) ? $product_info['Age_grade'] : $goods_info['Age_grade'];
            $age_grade = (!$age_grade) ? '' : $age_grade;
            $content = ($vv['content']) ? $vv['content'] : $goods_info['content'];
            $content = str_replace('\r\n', '<br />', $content);
            $content = strip_tags($content,'<p><br/><br><table><tr><td><img>');
            $dqk_list[$kk]['market_price'] = floor($market_price);
            $dqk_list[$kk]['limittime'] = ($vv['limittime']) ? date('Y.m.d', $vv['limittime']) : '';
            $dqk_list[$kk]['age_grade'] = $age_grade;
            $dqk_list[$kk]['goods_info'] = $goods_info;
            $dqk_list[$kk]['content'] = $content;
            $dqk_list[$kk]['limitinfo'] = strip_tags($vv['limitinfo']);
            
            //计算提成
            if ( $type != 2 )
                $goods_promotion_commission[] = order_class::get_goods_promote($vv['id'],2);
            
            if ( $type == 2 && $vv['commission'] > 0 )
            {
                //$pay_dqk[] = $vv;
                $dqk_list[$kk]['other_pay'] = number_format($vv['commission'] / ($vv['use_times'] / $vv['each_times']), 0);
            } else {
                $dqk_list[$kk]['other_pay'] = '';
            }
	    }

	    if ( sizeof($price_arr) > 1 )
	    {
	        $max = max($price_arr);
	        $min = min($price_arr);
	        if ($max == $min )
	           $price_level = $max;
	        else 
	           $price_level = $min . '-' . $max;
	    } else {
	        $price_level = $price_arr[0];
	    }
	    
	    $user_id = $this->user['user_id'];
	    
	    // 获取优惠列表
	    $dqk_list2 = brand_chit_class::get_manual_discount_list_by_seller_id($seller_id);
	    
	    // 读取教师信息
	    $teacher_list = teacher_class::get_goods_list_by_seller_id($seller_id, 10);
	    if ( $teacher_list )
	    {
	        foreach( $teacher_list as $kk => $vv )
	        {
	            $description = nl2br($vv['description']);
	            $teacher_list[$kk]['description'] = str_replace('\n','<br>', $description );
	        }
	    }
	    
	    // 获取用户的手册信息
	    if ( $user_id )
	    {
	        $manual_list = manual_class::get_manual_list("user_id = $user_id and is_activation = 1",1,10);
	    } else {
	        $manual_list = array();
	    }
	    
	    $manual_info = ($manual_list['list']) ? $manual_list['list'][0] : array();
	    
	    $this->setRenderData(array(
	        'dqk_list' =>  $dqk_list,
	        'dqk_list2' => $dqk_list2,
	        'seller_info'  =>  $seller_info,
	        'brand_info'   =>  $brand_info,
	        'dqk_list_json'    =>  json_encode($dqk_list),
	        'price_level'  =>  $price_level,
	        'isctrl' => array('url' => '/simple/dqk_cart', 'text' => "<img src='/views/mobile/skin/blue/images/shopping cart_icon.png' class='dqk_cart' width='32' height='32' />"),
	        'user_id'      =>  $user_id,
	        'max_promotion_commission' =>  ($goods_promotion_commission) ? max($goods_promotion_commission) : 0,
	        'type'         =>  $type,
	        'teacher_list' => $teacher_list,
	        'manual_info'  => $manual_info
	    ));
	    
	    // 设定微信分享的信息
	    if ( IClient::isWechat() )
	    {
	        $siteConfig = new Config("site_config");
	        $share_link = 'http://www.dsanke.com/site/chit1_detail/id/' . $seller_id;
	        if ( $user_id )
	            $share_link .= '/promote/' . $user_id;
	        $this->sharedata = json_encode(array(
	            'imgUrl'    =>  'http://www.dsanke.com/views/mobile/skin/blue/images/wechat_share_logo.jpg',
	            'desc'      =>  $brand_info['brief'],
	            'title'     =>  $brand_info['shortname'],
	            'link'      =>  $share_link,
	        ));
	    }
	    
	    $this->title = '短期课详情';
	    $this->back_url = ($type != 2) ? IUrl::creatUrl('site/chit1') : IUrl::creatUrl('site/manual');
	    $this->redirect('chit1_detail');
	}
	
	// 短期课加入购物车
	function join_dqk_ajax()
	{
	    $id = IFilter::act(IReq::get('id'),'int');
	    if ( !$id )
	    {
	        //$this->json_error('参数不正确');
	        die('参数不正确');
	        exit();
	    }
	    $user_id = $this->user['user_id'];
	    if ( !$user_id )
	    {
	        //$this->json_error('请先登录');
	        die('请先登录');
	        exit();
	    }
	    
	    $dqk_info = brand_chit_class::get_dqk_info($id);
	    if ( !$dqk_info )
	    {
	        //$this->json_error('该短期课可能已被下架');
	        die('该短期课可能已被下架');
	        exit();
	    }
	    
	    $result = brand_chit_class::join_dqk($id, $user_id);
	    if ( !$result )
	    {
	        die('您已经加入购物车，请勿重复操作');
	        exit();
	    }
	    
	    //$this->json_result();
	    die('1');
	}
	
	function chit2()
	{
	    $this->title = '短期课组合列表';
	    $this->redirect('chit2');
	}
	
	// 获取代金券列表
	function get_chit_list_ajax()
	{
	    $page = intval(IReq::get('page'));
	    $page = max( $page, 1 );
	    $page_size = 10;
	    $brand_chit_db = new IQuery('brand_chit');
	    $brand_chit_db->where = 'category = 1 and seller_id > 0 and goods_id > 0 ';
	    $brand_chit_db->page = $page;
	    $brand_chit_db->pagesize = $page_size;
	    $brand_chit_db->order = 'id desc';
	    $chits = $brand_chit_db->find();
	    if ( $chits )
	    {
	        foreach( $chits as $kk => $vv )
	        {
	            if ( $vv['seller_id'] > 0 )
	            {
	                $seller_info = seller_class::get_seller_info($vv['seller_id']);
	                $chits[$kk]['seller_name'] = $seller_info['shortname'];
	            }
	            if ( $vv['goods_id'] > 0 )
	            {
	                $goods_info = goods_class::get_goods_info($vv['goods_id']);
	                $chits[$kk]['goods_name'] = $goods_info['name'];
	                $chits[$kk]['goods_brief'] = $goods_info['goods_brief'];
	            }
	        }
	    }
	    
	    $chits['num'] = sizeof( $chits );
	    $chits['page'] = $page + 1;
	    echo json_encode($chits);
	}
	
	//手机端获取短期课列表
	function get_chit_list_ajax1()
	{
	    $page = intval(IReq::get('page'));
	    $page = max( $page, 1 );
	    $page_size = 10;
	    $cat_id = IFilter::act(IReq::get('cat_id'),'int');
	    $keyword = IFilter::act(IReq::get('keyword'));
	    $my_city_code = city::get_my_city_code();
	    $where = ' and s.city = '.$my_city_code;
	    
	    if ( $cat_id )
	    {
            $seller_db = new IQuery('seller');
            $seller_db->where = 'manual_category_id = ' . $cat_id;
            $seller_db->fields = 'id';
            $seller_list = $seller_db->find();
            $seller_arr = array();
            if ($seller_list)
            {
                foreach($seller_list as $kk => $vv )
                {
                    $seller_arr[] = $vv['id'];
                }
            }
	        $where .= ' and ' . db_create_in($seller_arr, 'bc.seller_id');
	    }
	    
	    if ( $keyword )
	    {
	        $goods_ids = array();
	        $goods_db = new IQuery('goods');
	        $goods_db->where = "search_words like '%$keyword%' or name like '%$keyword%'";
	        $goods_db->fields = 'id';
	        $goods_list = $goods_db->find();
	        if ( $goods_list )
	        {
	            foreach($goods_list as $kk => $vv )
	            {
	                $goods_ids[] = $vv['id'];
	            }
	            $where .= ' and ' . db_create_in($goods_ids, 'bc.goods_id');
	        }
	    }
	    $brand_chit_db = new IQuery('brand_chit as bc');
	    $brand_chit_db->where = 'g.is_del = 0 and bc.is_del = 0 and bc.category = 2' . $where;
	    $brand_chit_db->order = 'bc.is_top desc,bc.sale desc';
	    $brand_chit_db->join = 'left join goods as g on bc.goods_id = g.id left join seller as s on bc.seller_id = s.id left join brand as b on s.brand_id = b.id';
	    $brand_chit_db->fields = 'distinct(bc.seller_id) as seller_id,sum(bc.sale) as c_sale,bc.*,s.area,s.shortname as seller_name,g.market_price,b.brief,b.logo as b_logo,s.address';
	    $brand_chit_db->group = 'bc.seller_id';
	    $chits = $brand_chit_db->find();
	    if ($chits)
	    {
	        foreach($chits as $kk => $vv )
	        {
	            $chits[$kk]['brief'] = ($vv['brief']) ? $vv['brief'] : '';
	            $chits[$kk]['address'] = ($vv['area']) ? area::getName($vv['area']) . $vv['address'] : $vv['address'];
	        }
	    }
	
	    $chits = array_chunk($chits,$page_size);
	    $chits = $chits[$page - 1];
	    
	    if ( $chits )
	    {
	        $chits['num'] = sizeof( $chits );
	        $chits['page'] = $page + 1;
	    } else {
	        $chits['num'] = 0;
	        $chits['page'] = 1;
	    }

	    echo json_encode($chits);
	}
	
	//手机端获取学习通优惠
	function get_manual_discount_list_ajax()
	{
	    $page = intval(IReq::get('page'));
	    $page = max( $page, 1 );
	    $page_size = 10;
	    $cat_id = IFilter::act(IReq::get('cat_id'),'int');
	    $keyword = IFilter::act(IReq::get('keyword'));
	    $where = '';
	     
	    if ( $cat_id )
	    {
	        $seller_db = new IQuery('seller');
	        $seller_db->where = 'manual_category_id = ' . $cat_id;
	        $seller_db->fields = 'id';
	        $seller_list = $seller_db->find();
	        $seller_arr = array();
	        if ($seller_list)
	        {
	            foreach($seller_list as $kk => $vv )
	            {
	                $seller_arr[] = $vv['id'];
	            }
	        }
	        $where .= ' and ' . db_create_in($seller_arr, 'bc.seller_id');
	    }
	     
	    if ( $keyword )
	    {
	        $goods_ids = array();
	        $goods_db = new IQuery('goods');
	        $goods_db->where = "search_words like '%$keyword%' or name like '%$keyword%'";
	        $goods_db->fields = 'id';
	        $goods_list = $goods_db->find();
	        if ( $goods_list )
	        {
	            foreach($goods_list as $kk => $vv )
	            {
	                $goods_ids[] = $vv['id'];
	            }
	            $where .= ' and ' . db_create_in($goods_ids, 'bc.goods_id');
	        }
	    }
	
	    $brand_chit_db = new IQuery('brand_chit as bc');
	    $brand_chit_db->where = 'bc.is_del = 0 and bc.category = 3' . $where;
	    $brand_chit_db->order = 'bc.is_top desc,bc.sale desc,bc.id desc';
	    $brand_chit_db->join = 'left join seller as s on bc.seller_id = s.id left join brand as b on s.brand_id = b.id';
	    $brand_chit_db->fields = 'distinct(bc.seller_id) as seller_id,sum(bc.sale) as c_sale,bc.*,s.area,s.shortname as seller_name,b.brief,b.logo as b_logo,s.address';
	    $brand_chit_db->group = 'bc.seller_id';
	    $chits = $brand_chit_db->find();
	    if ($chits)
	    {
	        foreach($chits as $kk => $vv )
	        {
	            $chits[$kk]['brief'] = ($vv['brief']) ? $vv['brief'] : '';
	            if ( !$vv['b_logo'])
	            {
	                $chits[$kk]['b_logo'] = $vv['logo'];
	            }
	            $chits[$kk]['address'] = ($vv['area']) ? area::getName($vv['area']) . $vv['address'] : $vv['address'];
	        }
	    }
	
	    $chits = array_chunk($chits,$page_size);
	    $chits = $chits[$page - 1];
	     
	    if ( $chits )
	    {
	        $chits['num'] = sizeof( $chits );
	        $chits['page'] = $page + 1;
	    } else {
	        $chits['num'] = 0;
	        $chits['page'] = 1;
	    }
	
	    echo json_encode($chits);
	}
	
	function create_brand_chit_zuhe()
	{
	    $prop_id = IFilter::act(IReq::get('ids'));
	    if ( !$prop_id )
	    {
	        IError::show(403,'请选择短期课');
	        exit();
	    }
	    $prop_id = explode(',', $prop_id);
	    
	    $brand_chit_db = new IQuery('brand_chit');
	    $brand_chit_db->where = db_create_in($prop_id,'id') . ' and category = 2';
	    $brand_chit_db->fields = 'name';
	    $chit_list = $brand_chit_db->find();
	    if ( $chit_list )
	    {
	        foreach( $chit_list as $kk => $vv )
	        {
	            $name_arr[] = $vv['name'];
	        }
	    }
	    $name = ($name_arr) ? implode('+', $name_arr) . '短期课组合' : '用户自选短期课组合';
	    
	    $start_time = time();
	    $end_time = strtotime("+1 years", $start_time);
	    
	    // 获取短期课折扣比例
	    $siteObj = new Config('site_config');
	    $this->commission = $siteObj->commission;
	    
	    $brand_chit_db = new IQuery('brand_chit');
	    $brand_chit_db->where = db_create_in($prop_id,'id') . ' and category = 2';
	    if ( sizeof($prop_id) > 1 )
	    {
	        $brand_chit_db->fields = 'sum(tc_price) as c_count';
	    } else {
	        $brand_chit_db->fields = 'sum(max_price) as c_count';
	    }
	    
	    $brand_chit_zuhe_info = $brand_chit_db->getOne();
	    $price = ($brand_chit_zuhe_info) ? $brand_chit_zuhe_info['c_count'] : 0;

	    
	    // 添加短期课组合信息
	    $chit_zuhe_db = new IModel('brand_chit_zuhe');
	    $data = array(
	        'name' => $name,
	        'price' => $price,
	        'start_time' => $start_time,
	        'end_time' => $end_time,
	        'content' => $name,
	        'is_system'  =>  0,
	    );
	    $chit_zuhe_db->setData($data);
	    $zuhe_id = $chit_zuhe_db->add();
	    
		if ( !$zuhe_id )
	    {
	        IError::show(403,'生成短期课组合失败');
	        exit();
	    }
	    
	    // 添加短期课组合清单
	    $brand_chit_zuhe_detail_db = new IModel('brand_chit_zuhe_detail');
	    foreach( $prop_id as $kk => $vv )
	    {
	        $zuhe_detail_db = new IQuery('brand_chit_zuhe_detail');
	        $zuhe_detail_db->where = 'zuhe_id = ' . $zuhe_id . ' and brand_chit_id = ' . $vv;
	        $zuhe_detail_info = $zuhe_detail_db->getOne();
	    
	        if ( !$zuhe_detail_info )
	        {
	            $arr = array(
	                'zuhe_id' => $zuhe_id,
	                'brand_chit_id' => $vv,
	            );
	            $brand_chit_zuhe_detail_db->setData($arr);
	            $brand_chit_zuhe_detail_db->add();
	        }
	    }
	    
	    header("location: " . IUrl::creatUrl('simple/cart21/id/5280/num/1/type/product/statement/2/stime/1/ischit/1/zuhe_id/' . $zuhe_id));
	}
	
	// 手机端获取数据
	function get_pro_list_ajax()
	{
	    $this->catId = IFilter::act(IReq::get('cat'),'int');//分类id
	    $keywords = IFilter::act(IReq::get('keywords'),'text');
	    $area_id = IFilter::act(IReq::get('area_id'),'int');
	    $page = intval(IReq::get('page'));
	    $page = max( $page, 1 );
	    $perpage = 10;
	    $condition = array();
	    
	    // 按区域查找
	    if ( $area_id )
	    {
	        $area_ids = area::get_child_area_id_list($area_id);
	        $area_ids[] = $area_id;
	        if ( $area_ids )
	        {
	            $area_ids = implode(',', $area_ids);
	        }
	        $condition['area_extend'] = $area_ids;
	    }
	    
	    // 按分类查找
	    if ( $this->catId )
	    {
	        $catObj       = new IModel('category');
	        $this->catRow = $catObj->getObj('id = '.$this->catId);
	    }

	    //获取子分类
	    $this->childId = $category_ids = category_class::get_child_category($this->catId);
        $condition['category_extend'] = $this->childId;
        
        // 按关键词查找
        if ( $keywords )
        {
            $condition['search'] = $keywords;
        }
	    
	    $breadGuide = goods_class::catRecursion($this->catId);
	    $goodsObj = search_goods::find2($condition,21);
	    $resultData = $goodsObj->find();
	    $paging = $goodsObj->paging;
	    $length = 18;
	    
	    if ( $resultData )
	    {
	        foreach($resultData as $kk => $vv )
	        {
	            $seller_info = seller_class::get_seller_info($vv['seller_id']);
	            $resultData[$kk]['seller_info'] = $seller_info;
	            $resultData[$kk]['seller_info']['address'] = ($seller_info['area']) ? area::getName($seller_info['area']) . $seller_info['address'] : $seller_info['address'];
	            if ( strlen($vv['keywords']) > $length * 2)
	               $resultData[$kk]['keywords'] = mb_substr($vv['keywords'], 0, $length, 'utf-8') . '...';
	        }
	    } else {
	        $resultData['num'] = 0;
	        $resultData['page'] = 1;
	    }
	    
	    if ( $page > $paging->totalpage )
	    {
	        $resultData = array();
	        $resultData['num'] = 0;
	        $resultData['page'] = 1;
	    }

	    $resultData['num'] = sizeof($resultData);
	    $resultData['page'] = $page + 1;

	    echo json_encode($resultData);
	}
	
	// 手机端短期课套餐列表
	function get_chit_list_ajax2()
	{
	    $chitDB = new IQuery('brand_chit');
	    $brandDB = new IModel('brand');
	    $nowtime = time();
	    $page = intval(IReq::get('page'));
	    $seller_id = IFilter::act(IReq::get('seller_id'),'int');
	    $page = max( $page, 1 );
	    $perpage = 10;
	
	    // 代金券组合
	    $zuhe_db = new IQuery('brand_chit_zuhe');
	    $zuhe_db->where = 'status = 1 and is_system = 1';
	    $zuhe_list = $zuhe_db->find();
	    if ( $zuhe_list )
	    {
	        foreach($zuhe_list as $kk => $vv )
	        {
	            $zuhe_list[$kk]['is_zuhe'] = 1;
	        }
	    }
	
	    $chits = $zuhe_list;
	    $chits = array_chunk( $chits, $perpage );
	    $chits = $chits[$page - 1];
	
	    foreach($chits AS $idx => $chit)
	    {
	        $chits[$idx]['shortname'] = $chit['name'];
	        if ( is_array( $chit ))
	        {
	            $chits[$idx]['limittime'] = date('Y-m-d', $chit['limittime']);
	            $chits[$idx]['limitinfo'] = empty($chit['limitinfo']) ? '' : $chit['limitinfo'];
	            preg_match('/\d+/',$chits[$idx]['limitinfo'],$arr);
	            $chits[$idx]['max_price'] = $chit['price'];
	            $chits[$idx]['max_order_chit'] = $chit['price'];
	        }
	    }
	
	    $chits['num'] = sizeof( $chits );
	    $chits['page'] = $page + 1;
	
	    echo json_encode($chits);
	}
	
	function get_current_chit(){
	    $seller_id = intval(IReq::get('seller_id'));
	    $goods_id = intval(IReq::get('goods_id'));
	    $product_id = intval(IReq::get('spec_id'));
	    
	    $brand_chit_db = new IQuery('brand_chit');
	    $brand_chit_db->where = 'goods_id = ' . $goods_id . ' and product_id = ' . $product_id . '  and category = 1';
	    $info = $brand_chit_db->getOne();
	    echo json_encode($info);
	}
	
	function all()
	{
	    $this->title = '所有应用';
	    $this->redirect('all');
	}
	
	
	public function tutor()
	{
	    $cat = IFilter::act(IReq::get('cat'),'int');
	    $this->catId = $cat;
	    $sex = IFilter::act(IReq::get('sex'),'int');
	    $region = IFilter::act(IReq::get('region'),'int');
	    $teaching_time = IFilter::act(IReq::get('teaching_time'),'int');
	    $teaching_type = IFilter::act(IReq::get('teaching_type'),'int');
	    $order = IFilter::act(IReq::get('order'));
	    $experience = IFilter::act(IReq::get('experience'),'int');
	    $search = array();
	    $seller_experience_arr = seller_tutor_class::get_seller_experience_arr();
	    $tutor_seller_list = seller_tutor_class::get_tutor_seller_list();
	    $where = 'b.category_ids = 16 and s.is_authentication = 1 and ' . db_create_in($tutor_seller_list, 's.id');
	    
	    $area_list = area::get_child_area_list('430200');
	    
	    //区域
	    $area_id = IFilter::act(IReq::get('area'), 'int');
	    $seller_arr = array();
	    if ( $area_id )
	    {
	        $seller_db = new IQuery('seller');
	        $seller_db->where = 'area = ' . $area_id;
	        $seller_db->fields = 'id,type';
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
	    //添加区域的条件
	    if ( $seller_arr )
	        $where .= ' and ' .db_create_in( $seller_arr, 's.id');
	    
	    // 处理分类
	    if ( $cat )
	    {
	        $seller_arr = array();
	        $seller_tutor_list = seller_tutor_class::get_seller_tutor_list_by_cat($cat);
	        if ( $seller_tutor_list )
	        {
	            foreach( $seller_tutor_list as $kk => $vv)
	            {
	                if(!in_array($vv['seller_id'], $seller_arr))
	                    $seller_arr[] = $vv['seller_id'];
	            }
	        }
	        
	        $where .= ' and ' . db_create_in($seller_arr, 's.id');
	        $search['cat'] = $cat;
	    }
	    if ( $this->catId )
	    {
	        //查找分类信息
	        $catObj       = new IModel('category');
	        $this->cat_info = $catObj->getObj('id = '.$this->catId);
	    
	        if($this->cat_info == null)
	        {
	            IError::show(403,'此分类不存在');
	        }
	        
	        if ( $this->cat_info['parent_id'] > 0 )
	        {
	            $this->parent_cat_name = category_class::get_category_title($this->cat_info['parent_id']);
	        }
	           
	    
	        //获取子分类
	        $this->childId = goods_class::catChild($this->catId);
	        $cat_list = goods_class::catTree($this->catId);
	    }
	    
	    // 处理性别
	    if ( $sex )
	    {
	        $seller_arr = array();
	        $teacher_db = new IQuery('teacher as t');
	        $teacher_db->join = 'left join seller as s on t.seller_id = s.id';
	        $teacher_db->where = 's.is_authentication = 1 and t.sex = ' . $sex;
	        $teacher_db->fields = 's.id';
	        $teacher_list = $teacher_db->find();
	        if ( $teacher_list )
	        {
	            foreach( $teacher_list as $kk => $vv)
	            {
	                if (!in_array($vv['id'], $seller_arr))
	                    $seller_arr[] = $vv['id'];
	            }
	        }
	        
	        $where .= ' and ' . db_create_in($seller_arr, 's.id');
	        $search['sex'] = $sex;
	    }
	    
	    // 处理区域
	    if ( $region )
	    {
	        $where .= ' and area = ' . $region;
	        $search['region'] = $region;
	    }
	    
	    // 上课时间
	    if ( $teaching_time )
	    {
	        $where .= " and find_in_set('$teaching_time',s.teaching_time)";
	        $search['teaching_time'] = $teaching_time;
	    }
	    
// 	    // 教学方式
// 	    if ( $teaching_type )
// 	    {
// 	        $where .= " and find_in_set('$teaching_type',s.teaching_type)";
// 	        $search['teaching_type'] = $teaching_type;
// 	    }
	    
	    // 教龄
	    if ( $experience )
	    {
	        if ( isset($seller_experience_arr[$experience]))
	        {
	            if ( $seller_experience_arr[$experience]['min'] && $seller_experience_arr[$experience]['max'])
	               $where .= ' and (experience >= ' . $seller_experience_arr[$experience]['min'] . ' and experience < ' . $seller_experience_arr[$experience]['max'] . ')';
	            else
	                $where .= ' and experience >= ' . $seller_experience_arr[$experience]['min'];
	            $search['experience'] = $experience;
	        }
	    }
	    	    
	    $page = intval(IReq::get('page'));
	    $page = max( $page, 1 );
	    $seller_list = seller_class::get_seller_list2($where, 's.*', $page, 12, $order);
	    
	    // 获取家教分类
	    $tutor_cate_list = category_class::get_category_list_by_parent(0);
	    $cates_arr = array();
	    $cates_arr_json = array();
	    if($tutor_cate_list)
	    {
	        foreach($tutor_cate_list as $kk => $vv)
	        {
	            $cates_arr[$vv['id']] = $vv['name'];
	            $cates_arr_json[] = array(
	                'text' => $vv['name'],
	                'value' => $vv['id'],
	            );
	        }
	    }
	    
	    if ( $seller_list['seller_list'] )
	    {
	        foreach( $seller_list['seller_list'] as $kk => $vv)
	        {
	            $seller_list['seller_list'][$kk]['price'] = seller_tutor_class::get_seller_tutor_price($vv['seller_tutor_list']);
	            $teaching_info = Teacher_class::get_teacher_info_by_seller2($vv['id']);
	            if ( $teaching_info )
	                $seller_list['seller_list'][$kk]['sex'] = $teaching_info['sex'];
	        }
	    }
	    
	    // 获取区域
	    $region_list = area::get_child_area_list(430200);
	    
	    // HOT老师排行榜
	    $hotest_tutor_seller_list = Seller_class::get_hotest_tutor_seller_list(5);
	    
	    
	    // 最新入驻老师
	    $latest_tutor_seller_list = Seller_class::get_latest_tutor_seller_list(5);

	    $this->setRenderData(array(
	        'seller_list'  =>  $seller_list['seller_list'],
	        'page_info'    =>  $seller_list['page_info'],
	        'cates_arr'    =>  $cates_arr,
	        'region_list'  =>  $region_list,
	        'teaching_type_arr'    =>  tutor_class::teaching_type_arr(),
	        'teaching_time'    =>  tutor_class::get_teaching_time2(),
	        'seller_experience_arr'    =>  $seller_experience_arr,
	        'search'       =>  $search,
	        'hotest_tutor_seller_list' => $hotest_tutor_seller_list['seller_list'],
	        'latest_tutor_seller_list' =>  $latest_tutor_seller_list['seller_list'],
	        'area_list'    =>  $area_list,
	        'cat_list'   => $cat_list,
	    ));
	    
	    $this->title = '家教列表';
	    
	    $this->redirect('tutor');
	}
	
	function tutor_info()
	{
	    $id = IFilter::act(IReq::get('id'),'int');
	    $type = IFilter::act(IReq::get('type'),'int');
	    $page = IFilter::act(IReq::get('page'),'int');
	    $page = max($page,1);
	    $page_size = 5;
	    if ( !$id )
	    {
	        IError::show(403,'参数不正确');
	    }
	     
	    $seller_info = seller_class::get_seller_info($id);
	    $brand_info = brand_class::get_brand_info($seller_info['brand_id']);
	    if ( !$seller_info || $brand_info['category_ids'] != 16)
	    {
	        IError::show(403, '家教教师信息不存在');
	    }
	     
	    $seller_info['teaching_time'] = ($seller_info['teaching_time']) ? unserialize($seller_info['teaching_time']) : array();
	    $seller_info['teaching_type'] = ($seller_info['teaching_type']) ? explode(',', $seller_info['teaching_type']) : array();
	     
	    // 增加浏览次数
	    seller_class::update_seller_views($id);
	     
	    // 获取评论次数和具体信息
	    $seller_comment_info = comment_class::get_tutor_comment_list($id);
	    $seller_info['comment_info'] = $seller_comment_info;
	     
	    // 获取家教列表
	    $seller_tutor_db = seller_tutor_class::get_seller_tutor_list_db($id, 1, 50);
	    $seller_info['seller_tutor_list'] = $seller_tutor_db->find();
	     
	    $grade_levels = array();
	    if ( $seller_info['seller_tutor_list'] )
	    {
	        foreach( $seller_info['seller_tutor_list'] as $kk => $vv )
	        {
	            if ( !in_array($vv['grade_level'], $grade_levels))
	                $grade_levels[] = $vv['grade_level'];
	        }
	    }
	    $seller_info['grade_level'] = $grade_levels;
	     
	    $teacher_info = Teacher_class::get_teacher_info_by_seller2($id);
	    $seller_info['teacher_info'] = $teacher_info;
	     
	    // 获取价格区间
	    $seller_info['price'] = seller_tutor_class::get_seller_tutor_price($seller_info['seller_tutor_list']);
	     
	    // 获取家教分类
	    $tutor_cate_list = category_class::get_category_list_by_parent(2);
	    $cates_arr = array();
	    if($tutor_cate_list)
	    {
	        foreach($tutor_cate_list as $kk => $vv)
	        {
	            $cates_arr[$vv['id']] = $vv['name'];
	        }
	    }
	     
	    // 手动分页
	    switch($type)
	    {
	        case 0:
	            $comment_list = $seller_info['comment_info']['comment_list'];
	            break;
	        case 1:
	            $comment_list = $seller_info['comment_info']['perfect_list'];
	            break;
	        case 2:
	            $comment_list = $seller_info['comment_info']['good_list'];
	            break;
	        case 3:
	            $comment_list = $seller_info['comment_info']['bad_list'];
	            break;
	    }
	    if( $comment_list )
	    {
	        $comment_list = array_chunk($comment_list, $page_size);
	        $page_count = sizeof($comment_list);
	        $comment_list = $comment_list[$page - 1];
	        if ( $comment_list )
	        {
	            foreach($comment_list as $kk => $vv)
	            {
	                $comment_list[$kk]['user_info'] = user_class::get_user_info($vv['user_id']);
	                $order_info = order_class::get_order_info($vv['order_no'], 2);
	                if ( $order_info['statement'] == 4 && $order_info['seller_tutor_id'] )
	                    $comment_list[$kk]['tutor_info'] = seller_tutor_class::get_seller_tutor_info($order_info['seller_tutor_id']);
	            }
	        }
	    } else {
	        $page_count = 0;
	    }
	     
	    // 手机端操作
	    if ( IClient::getDevice() == IClient::MOBILE )
	    {
	        // 全部评论
	        if ( $seller_info['comment_info']['comment_list'] )
	        {
	            foreach($seller_info['comment_info']['comment_list'] as $kk => $vv )
	            {
	                $seller_info['comment_info']['comment_list'][$kk]['user_info'] = user_class::get_user_info($vv['user_id']);
	                $order_info = order_class::get_order_info($vv['order_no'], 2);
	                if ( $order_info['statement'] == 4 && $order_info['seller_tutor_id'] )
	                    $seller_info['comment_info']['comment_list'][$kk]['tutor_info'] = seller_tutor_class::get_seller_tutor_info($order_info['seller_tutor_id']);
	            }
	        }
	         
	        // 好评
	        if ( $seller_info['comment_info']['perfect_list'] )
	        {
	            foreach($seller_info['comment_info']['perfect_list'] as $kk => $vv )
	            {
	                $seller_info['comment_info']['perfect_list'][$kk]['user_info'] = user_class::get_user_info($vv['user_id']);
	                $order_info = order_class::get_order_info($vv['order_no'], 2);
	                if ( $order_info['statement'] == 4 && $order_info['seller_tutor_id'] )
	                    $seller_info['comment_info']['perfect_list'][$kk]['tutor_info'] = seller_tutor_class::get_seller_tutor_info($order_info['seller_tutor_id']);
	            }
	        }
	         
	        // 中评
	        if ( $seller_info['comment_info']['good_list'] )
	        {
	            foreach($seller_info['comment_info']['good_list'] as $kk => $vv )
	            {
	                $seller_info['comment_info']['good_list'][$kk]['user_info'] = user_class::get_user_info($vv['user_id']);
	                $order_info = order_class::get_order_info($vv['order_no'], 2);
	                if ( $order_info['statement'] == 4 && $order_info['seller_tutor_id'] )
	                    $seller_info['comment_info']['good_list'][$kk]['tutor_info'] = seller_tutor_class::get_seller_tutor_info($order_info['seller_tutor_id']);
	            }
	        }
	         
	        // 差评
	        if ( $seller_info['comment_info']['bad_list'] )
	        {
	            foreach($seller_info['comment_info']['bad_list'] as $kk => $vv )
	            {
	                $seller_info['comment_info']['bad_list'][$kk]['user_info'] = user_class::get_user_info($vv['user_id']);
	                $order_info = order_class::get_order_info($vv['order_no'], 2);
	                if ( $order_info['statement'] == 4 && $order_info['seller_tutor_id'] )
	                    $seller_info['comment_info']['bad_list'][$kk]['tutor_info'] = seller_tutor_class::get_seller_tutor_info($order_info['seller_tutor_id']);
	            }
	        }
	    }
	     
	    // 推荐教师列表
	    $intro_tutor_seller_list = seller_class::get_intro_tutor_seller_list();
	     
	    // 检查教师是否接受预定
	    $is_receive_booking = seller_class::is_tutor_seller_receive_booking($seller_info['id']);
	     
	    $seller_info['point'] = comment_class::get_tutor_seller_point($id);
	    $this->setRenderData(array(
	        'seller_info'  =>  $seller_info,
	        'cates_arr'    =>  $cates_arr,
	        'teaching_time_arr'    =>  tutor_class::get_teaching_time2(),
	        'teaching_type_arr'    =>  tutor_class::teaching_type_arr(),
	        'grade_level_arr'      =>  tutor_class::get_grade_level_arr(),
	        'type'         =>  $type,
	        'page_count'   =>  $page_count,
	        'comment_list' =>  $comment_list,
	        'next_page' =>  ($page < $page_count) ? $page + 1 : 0,
	        'intro_tutor_seller_list'  =>  $intro_tutor_seller_list['seller_list'],
	        'is_rehired' => seller_class::check_seller_hired($seller_info['id'], $this->user['user_id']),
	        'is_receive_booking'   =>  $is_receive_booking,
	    ));
	     
	    $this->title = $seller_info['true_name'];
	     
	    $this->redirect('tutor_info');
	}
	
	function user_tutor_info()
	{
	    $id = IFilter::act(IReq::get('id'),'int');
	    if ( !$id )
	    {
	        IError::show(403,'参数不正确');
	    }
	     
	    $tutor_info = tutor_class::get_tutor_info($id);
	    $member_info = member_class::get_member_info($tutor_info['user_id']);
	    $user_info = user_class::get_user_info($tutor_info['user_id']);
	    $tutor_info['true_name'] = $member_info['true_name'];
	    $tutor_info['head_icon'] = ( $user_info['head_ico'] ) ? $user_info['head_ico'] : 'views/mobile/skin/blue/images/front/user_ico.gif';
	    $tutor_info['test_reward'] = ($tutor_info['test_reward']) ? unserialize($tutor_info['test_reward']) : array();
	    $tutor_info['teaching_time'] = ($tutor_info['teaching_time']) ? unserialize($tutor_info['teaching_time']) : array();
	     
	    // 推荐教师列表
	    $intro_tutor_seller_list = seller_class::get_intro_tutor_seller_list();
	     
	    $this->setRenderData(array(
	        'tutor_info'   =>  $tutor_info,
	        'intro_tutor_seller_list'  =>  $intro_tutor_seller_list['seller_list'],
	        'id'   =>  $id,
	        'teaching_time_arr'    =>  tutor_class::get_teaching_time2(),
	    ));
	    $this->redirect('user_tutor_info');
	}
	function user_tutor_list()
	{
	    $page = IFilter::act(IReq::get('page'),'int');
	    $page = max($page, 1);
	    $page_size = 10;
	    $cat = IFilter::act(IReq::get('cat'),'int');
	    $sex = IFilter::act(IReq::get('sex'),'int');
	
	    $region = IFilter::act(IReq::get('region'),'int');
	
	    $order = IFilter::act(IReq::get('order'));
	      
	    $where = '1 = 1';
	    
	    // 处理搜索条件
	    // 处理分类
	    if ( $cat )
	    {
	        $cat_name = category_class::get_category_title($cat);
	        if ( $cat_name )
	        {
	            $grade_arr = array();
	            $cate_db = new IQuery('category');
	            $cate_db->where = "name = '$cat_name'";
	            $cate_list = $cate_db->find();
	            if ( $cate_list )
	            {
	                foreach( $cate_list as $kk => $vv )
	                {
	                    $grade_arr[] = $vv['id'];
	                }
	            }
	            
	           $where .= ' and ' . db_create_in($grade_arr, 'grade');
	           $search['cat'] = $cat;
	        }
	    }
	     
	    // 处理性别
	    if ( $sex )
	    {	         
	        $where .= ' and gender = ' . $sex;
	        $search['sex'] = $sex;
	    }
	     
	    // 处理区域
	    if ( $region )
	    {
	        $where .= ' and region_id = ' . $region;
	        $search['region'] = $region;
	    }
	    
	    // 排序
	    if ($order)
	    {
	        if ( in_array($order, array('tutor_price')))
	        {
	            $search['order'] = $order;
	            $order = 'lowest_reward desc';
	        }
	    }
	    
	    $where .= ' and m.is_auth = 1';
	    $totur_db = tutor_class::get_tutor_list_db(0, 1, $page, $page_size);
	    $totur_db->join = 'left join member as m on m.user_id = iwebshop_tutor.user_id';
	    $totur_db->where = $where;
	    if ( $order )
	        $totur_db->order = $order;

	    $tutor_list = $totur_db->find();

	    if ( $tutor_list )
	    {
	        foreach($tutor_list as $kk => $vv)
	        {
	            $member_info = member_class::get_member_info($vv['user_id']);
	            $user_info = user_class::get_user_info($vv['user_id']);
	            if ( $member_info['is_auth'] )
	            {
	                $tutor_list[$kk]['true_name'] = $member_info['true_name'];
	                $tutor_list[$kk]['price'] = $vv['lowest_reward'];
	                $tutor_list[$kk]['price'] .= ($vv['highest_reward'] > 0 ) ? '-' . $vv['highest_reward'] : '';
	                $tutor_list[$kk]['head_ico'] = ( $user_info['head_ico'] ) ? $user_info['head_ico'] : 'views/mobile/skin/blue/images/front/user_ico.gif';
	            }
	        }
	    }
	    
	    // 获取家教分类
	    $tutor_cate_list = category_class::get_category_list_by_parent(2);
	    $cates_arr = array();
	    $cates_arr_json = array();
	    if($tutor_cate_list)
	    {
	        foreach($tutor_cate_list as $kk => $vv)
	        {
	            $cates_arr[$vv['id']] = $vv['name'];
	            $cates_arr_json[] = array(
	                'text' => $vv['name'],
	                'value' => $vv['id'],
	            );
	        }
	    }
	    
	    // 获取区域
	    $region_list = area::get_child_area_list(430200);
	    
	    // HOT老师排行榜
	    $hotest_tutor_seller_list = Seller_class::get_hotest_tutor_seller_list(5);

	    // 最新入驻老师
	    $latest_tutor_seller_list = Seller_class::get_latest_tutor_seller_list(5);
	    $this->setRenderData(array(
	        'tutor_list'   =>  $tutor_list,
	        'cates_arr'    =>  $cates_arr,
	        'region_list'  =>  $region_list,
	        // 'page_info'    =>  $totur_db->getPageBar(),
	        'hotest_tutor_seller_list' => $hotest_tutor_seller_list['seller_list'],
	        'latest_tutor_seller_list' =>  $latest_tutor_seller_list['seller_list'],
	        'search'       =>  $search,
	    ));
	    
	    $this->redirect('user_tutor_list');
	}
	
	function get_user_tutor_list_ajax()
	{
	    $page = IFilter::act(IReq::get('page'),'int');
	    $page = max($page, 1);
	    $page_size = 10;
	    $cat = IFilter::act(IReq::get('cat'),'int');
	    $sex = IFilter::act(IReq::get('sex'),'int');
	    $region = IFilter::act(IReq::get('region'),'int');
	    $order = IFilter::act(IReq::get('order'));
	    $where = '1 = 1';
	
	    // 处理搜索条件
	    // 处理分类
	    if ( $cat )
	    {
	        $cat_name = category_class::get_category_title($cat);
	        if ( $cat_name )
	        {
	            $grade_arr = array();
	            $cate_db = new IQuery('category');
	            $cate_db->where = "name = '$cat_name'";
	            $cate_list = $cate_db->find();
	            if ( $cate_list )
	            {
	                foreach( $cate_list as $kk => $vv )
	                {
	                    $grade_arr[] = $vv['id'];
	                }
	            }
	
	            $where .= ' and ' . db_create_in($grade_arr, 'grade');
	            $search['cat'] = $cat;
	        }
	    }
	     
	    // 处理性别
	    if ( $sex )
	    {
	        $where .= ' and gender = ' . $sex;
	        $search['sex'] = $sex;
	    }
	     
	    // 处理区域
	    if ( $region )
	    {
	        $where .= ' and region_id = ' . $region;
	        $search['region'] = $region;
	    }
	
	    // 排序
	    if ($order)
	    {
	        if ( in_array($order, array('tutor_price')))
	        {
	            $search['order'] = $order;
	            $order = 'lowest_reward desc';
	        }
	    }
	
	    //$where .= ' and m.is_auth = 1';
	    $totur_db = tutor_class::get_tutor_list_db(0, 1, $page, $page_size);
	    $totur_db->where = $where;
	    if ( $order )
	        $totur_db->order = $order;
	     
	    $tutor_list = $totur_db->find();
	    $arr = array();
	    if ( $tutor_list )
	    {
	        foreach($tutor_list as $kk => $vv)
	        {
	            $member_info = member_class::get_member_info($vv['user_id']);
	            $user_info = user_class::get_user_info($vv['user_id']);
	            if ( $member_info['is_auth'] )
	            {
	                $tutor_list[$kk]['true_name'] = $member_info['true_name'];
	                $tutor_list[$kk]['price'] = $vv['lowest_reward'];
	                $tutor_list[$kk]['price'] .= ($vv['highest_reward'] > 0 ) ? '-' . $vv['highest_reward'] : '';
	                $tutor_list[$kk]['head_ico'] = ( $user_info['head_ico'] ) ? $user_info['head_ico'] : 'views/mobile/skin/blue/images/front/user_ico.gif';
	                 
	                $price = $vv['lowest_reward'];
	                $price .= ($vv['highest_reward'] > 0 ) ? '-' . $vv['highest_reward'] : '';
	                $arr[] = array(
	                    'true_name'    =>  $member_info['true_name'],
	                    'head_ico'     =>  ( $user_info['head_ico'] ) ? $user_info['head_ico'] : 'views/mobile/skin/blue/images/front/user_ico.gif',
	                    'price'        =>  $price,
	                    'grade'        =>  category_class::get_category_title($vv['grade_level']) . '/' . category_class::get_category_title($vv['grade']),
	                    'link'         =>  IUrl::creatUrl('/site/user_tutor_info/id/' . $vv['id']),
	                );
	            }
	        }
	    }
	
	    // 获取家教分类
	    $tutor_cate_list = category_class::get_category_list_by_parent(2);
	    $cates_arr = array();
	    $cates_arr_json = array();
	    if($tutor_cate_list)
	    {
	        foreach($tutor_cate_list as $kk => $vv)
	        {
	            $cates_arr[$vv['id']] = $vv['name'];
	            $cates_arr_json[] = array(
	                'text' => $vv['name'],
	                'value' => $vv['id'],
	            );
	        }
	    }
	     
	    $resultData = $arr;
	    if ( $resultData)
	    {
	        $resultData['num'] = sizeof($arr);
	        $resultData['page'] = $page + 1;
	    } else {
	        $resultData['num'] = 0;
	        $resultData['page'] = 1;
	    }
	
	    echo json_encode($resultData);
	}
	
	function get_tutor_list_ajax()
	{
	    $cat = IFilter::act(IReq::get('cat'),'int');
	    $sex = IFilter::act(IReq::get('sex'),'int');
	    $region = IFilter::act(IReq::get('region'),'int');
	    $teaching_time = IFilter::act(IReq::get('teaching_time'),'int');
	    $teaching_type = IFilter::act(IReq::get('teaching_type'),'int');
	    $order = IFilter::act(IReq::get('order'));
	    $experience = IFilter::act(IReq::get('experience'),'int');
	    $search = array();
	    $seller_experience_arr = seller_tutor_class::get_seller_experience_arr();
	    $tutor_seller_list = seller_tutor_class::get_tutor_seller_list();
	    $where = ($tutor_seller_list) ? 's.is_authentication = 1 and ' . db_create_in($tutor_seller_list, 's.id') : 's.is_authentication = 1';
	
	    // 处理搜索条件
	    // 处理分类
	    if ( $cat )
	    {
	        $seller_arr = array();
	        $seller_tutor_list = seller_tutor_class::get_seller_tutor_list_by_cat($cat);
	        if ( $seller_tutor_list )
	        {
	            foreach( $seller_tutor_list as $kk => $vv)
	            {
	                if(!in_array($vv['seller_id'], $seller_arr))
	                    $seller_arr[] = $vv['seller_id'];
	            }
	        }
	         
	        $where .= ' and ' . db_create_in($seller_arr, 's.id');
	        $search['cat'] = $cat;
	    }
	    if ( $this->catId )
	    {
	        //查找分类信息
	        $catObj       = new IModel('category');
	        $this->cat_info = $catObj->getObj('id = '.$this->catId);
	         
	        if($this->cat_info == null)
	        {
	            IError::show(403,'此分类不存在');
	        }
	         
	        if ( $this->cat_info['parent_id'] > 0 )
	        {
	            $this->parent_cat_name = category_class::get_category_title($this->cat_info['parent_id']);
	        }
	
	         
	        //获取子分类
	        $this->childId = goods_class::catChild($this->catId);
	        $cat_list = goods_class::catTree($this->catId);
	    }
	
	    // 处理性别
	    if ( $sex )
	    {
	        $seller_arr = array();
	        $teacher_db = new IQuery('teacher as t');
	        $teacher_db->join = 'left join seller as s on t.seller_id = s.id';
	        $teacher_db->where = 's.is_authentication = 1 and t.sex = ' . $sex;
	        $teacher_db->fields = 's.id';
	        $teacher_list = $teacher_db->find();
	        if ( $teacher_list )
	        {
	            foreach( $teacher_list as $kk => $vv)
	            {
	                if (!in_array($vv['id'], $seller_arr))
	                    $seller_arr[] = $vv['id'];
	            }
	        }
	
	        $where .= ' and ' . db_create_in($seller_arr, 's.id');
	        $search['sex'] = $sex;
	    }
	
	    // 处理区域
	    if ( $region )
	    {
	        $where .= ' and area = ' . $region;
	        $search['region'] = $region;
	    }
	
	    // 上课时间
	    if ( $teaching_time )
	    {
	        $where .= " and find_in_set('teaching_time', $teaching_time)";
	        $search['teaching_time'] = $teaching_time;
	    }
	
	    // 教学方式
	    if ( $teaching_type )
	    {
	        $where .= " and find_in_set('teaching_type', $teaching_type)";
	        $search['teaching_type'] = $teaching_type;
	    }
	
	    // 教龄
	    if ( $experience )
	    {
	        if ( isset($seller_experience_arr[$experience]))
	        {
	            if ( $seller_experience_arr[$experience]['min'] && $seller_experience_arr[$experience]['max'])
	                $where .= ' and (experience >= ' . $seller_experience_arr[$experience]['min'] . ' and experience < ' . $seller_experience_arr[$experience]['max'] . ')';
	            else
	                $where .= ' and experience >= ' . $seller_experience_arr[$experience]['min'];
	            $search['experience'] = $experience;
	        }
	    }
	
	    // 排序
	    if ($order)
	    {
	        if ( in_array($order, array('tutor_price')))
	        {
	            $search['order'] = $order;
	            $order = $order . ' desc';
	        }
	    }
	
	    $page = intval(IReq::get('page'));
	    $page = max( $page, 1 );
	    $seller_list = seller_class::get_seller_list2($where, 's.*', $page, 12, $order);
	
	    if ( $seller_list['seller_list'] )
	    {
	        foreach( $seller_list['seller_list'] as $kk => $vv)
	        {
	            $seller_list['seller_list'][$kk]['price'] = seller_tutor_class::get_seller_tutor_price($vv['seller_tutor_list']);
	            $seller_list['seller_list'][$kk]['link'] = IUrl::creatUrl('/site/tutor_info/id/'.$vv['id']);
	            $str = '';
	            if( $vv['seller_tutor_list'] )
	            {
	                foreach($vv['seller_tutor_list'] as $k => $v)
	                {
	                    if (!$str)
	                        $str = tutor_class::get_tutor_category_title($v);
	                    else
	                        $str .= ' ' . tutor_class::get_tutor_category_title($v);
	                }
	            }
	            $seller_list['seller_list'][$kk]['str'] = $str;
	            $seller_list['seller_list'][$kk]['logo'] = ($seller_list['seller_list'][$kk]['logo']) ? $seller_list['seller_list'][$kk]['logo'] : get_default_icon($vv['sex']);
	        }
	    }
	     
	    $resultData = $seller_list['seller_list'];
	    if ( $resultData)
	    {
	        $resultData['num'] = $seller_list['result_count'];
	        $resultData['page'] = $page + 1;
	    } else {
	        $resultData['num'] = 0;
	        $resultData['page'] = 1;
	    }
	     
	    echo json_encode($resultData);
	}
	
	function goods_new()
	{
	    $this->title = '选课程';
	    $jsoncat = array();
	    $cat_list = Api::run('getCategoryListTop');
	    if ( $cat_list )
	    {
	        foreach( $cat_list AS $idx => $cat)
	        {
	            $jsoncat[$idx]['value'] = $cat['id'];
	            $jsoncat[$idx]['text'] = $cat['name'];
	            $son_cat_db = new IQuery('category');
	            $son_cat_db->where = "parent_id = '$cat[id]'";
	            $sons = $son_cat_db->find();
	            foreach($sons AS $k => $son)
	            {
	                $jsoncat[$idx]['children'][$k]['value'] = $son['id'];
	                $jsoncat[$idx]['children'][$k]['text'] = $son['name'];
	            }
	        }
	    }
	    
	    $this->setRenderData(array(
	        'jsoncats'   => json_encode($jsoncat),
	    ));
	    $this->redirect('goods_new');
	}
	
	function test()
	{
	    $user_id = ISafe::get('user_id');
	    if ( IClient::isWechat() && empty($use_id) )
	    {
	        $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	        ISafe::set('jump_url',$url);
	        die("<script>location.href = '/simple/login2';</script>");
	    }
	    echo 'cc';
	}
	
	// 皮纹检测报名
	function to_vote_test()
	{
	    $userid = ISafe::get('user_id');
	    if ( IClient::isWechat() && empty($userid) )
	    {
	        $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	        ISafe::set('jump_url',$url);
	        die("<script>location.href = '/simple/login2';</script>");
	    }
	    
	    header("location: " . IUrl::creatUrl('/ucenter/article_add3'));
	    exit();
	}
	
	// 皮纹检测手机报名入口
	function to_vote_mobile_test()
	{
	    $user_id = $this->user['user_id'];
	    if ( !$user_id )
	    {
	        header("location: http://www.dsanke.com/simple/reg?callback=/ucenter/article_add3");
	    } else {
	        $this->redirect('/ucenter/article_add3');
	    }
	}
	
	// 发布试听报告入口
	function to_release_report()
	{
	    $redirect_url = '/site/article2';
	    $userid = $this->user['user_id'];
	    if ( $userid )
	    {
	        $this->redirect($redirect_url);
	        exit();
	    } else {
	        if ( IClient::isWechat() )
	        {
	            $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	            ISafe::set('jump_url',$url);
	            die("<script>location.href = '/simple/login3';</script>");
	        } else {
	            header("location: http://www.dsanke.com/simple/reg?callback=$redirect_url");
	        }
	    }
	}
	
	function manual()
	{
	    $this->title = '学习通会员专享';
	    
	    // 获取所有短期课商户列表
	    $my_city_code = city::get_my_city_code();
	    $brand_chit_db = new IQuery('brand_chit as bc');
	    $brand_chit_db->where = 'g.is_del = 0 and bc.is_del = 0 and bc.category = 2 and s.city = '.$my_city_code;
	    $brand_chit_db->order = 'c_sale desc';
	    $brand_chit_db->join = 'left join goods as g on bc.goods_id = g.id left join seller as s on bc.seller_id = s.id left join brand as b on s.brand_id = b.id';
	    $brand_chit_db->fields = 'distinct(bc.seller_id) as seller_id,sum(bc.sale) as c_sale,bc.*,s.area,s.shortname as seller_name,g.market_price,b.brief,b.logo as b_logo,s.address';
	    $brand_chit_db->group = 'bc.seller_id';
	    $brand_chit_db->order = 'bc.is_top desc,bc.sale desc';
	    $chits = $brand_chit_db->find();
	    if ($chits)
	    {
	        foreach($chits as $kk => $vv )
	        {
	            $chits[$kk]['brief'] = ($vv['brief']) ? $vv['brief'] : '';
	            $chits[$kk]['address'] = ($vv['area']) ? area::getName($vv['area']) . $vv['address'] : $vv['address'];
	        }
	    }
	    
	    $category_list = manual_category_class::get_category_list();
        $cate_arr = array();
        $cate_arr[] = array(
            'value'    =>   0,
            'text'      =>  '所有分类',
        );
        if ( $category_list )
        {
            foreach( $category_list as $kk => $vv )
            {
                $cate_arr[] = array(
                    'value' =>  $vv['id'],
                    'text'  =>  $vv['name'],
                );
            }
        }
	    
	    $this->setRenderData(array(
	        'chits'            =>  $chits,
	        'category_list'    =>  json_encode($cate_arr),
	    ));
	    $this->redirect('manual');
	}
	
	function manual_info()
	{
	    $this->title = '学习通简介';
	    $this->redirect('manual_info');
	}
	
	function manual_discount()
	{
	    $this->title = '学习通优惠';
	    $this->redirect('manual_discount');
	}
	
	// 短期可详情
	function manual_discount_detail()
	{
	    $seller_id = IFilter::act(IReq::get('id'),'int');
	    $type = IFilter::act(IReq::get('type'),'int');
	    if ( !$seller_id )
	    {
	        IError::show('参数不正确');
	        return false;
	    }
	    $seller_info = seller_class::get_seller_info($seller_id);
	    if ( !$seller_info )
	    {
	        IError::show('商户不存在');
	        return false;
	    }
	    $type = ( !$type ) ? 1 : $type;
	    $brand_info = brand_class::get_brand_info($seller_info['brand_id']);
	    if( $brand_info['shop_desc_img'] )
	    {
	        $brand_info['shop_desc_img'] = explode(',', $brand_info['shop_desc_img']);
	    }
	    if( $brand_info['class_desc_img'] )
	    {
	        $brand_info['class_desc_img'] = explode(',', $brand_info['class_desc_img']);
	    }
	    if( $brand_info['certificate_of_authorization'] )
	    {
	        $brand_info['certificate_of_authorization'] = explode(',', $brand_info['certificate_of_authorization']);
	    }
	
	    $dqk_list = brand_chit_class::get_manual_discount_list_by_seller_id($seller_id);
	    if ( !$dqk_list )
	    {
	        IError::show('该学校暂时没有学习通优惠');
	        exit();
	    }
	    $price_arr = array();
	    $goods_promotion_commission = array();
	    foreach($dqk_list as $kk => $vv )
	    {
	        $price_arr[] = $vv['max_price'];
	         
	        // 获取课程的相关信息
	        $goods_info = goods_class::get_goods_info($vv['goods_id']);
	        if ( $vv['product_id'] )
	        {
	            $product_info = products_class::get_product_info($vv['product_id']);
	        }
	        $market_price = $vv['max_order_chit'];
	        $age_grade = ($vv['product_id']) ? $product_info['Age_grade'] : $goods_info['Age_grade'];
	        $age_grade = (!$age_grade) ? '' : $age_grade;
	        $content = ($vv['content']) ? $vv['content'] : $goods_info['content'];
	        $content = str_replace('\r\n', '<br />', $content);
	        $content = strip_tags($content,'<p><br/><br><table><tr><td><img>');
	        $dqk_list[$kk]['market_price'] = floor($market_price);
	        $dqk_list[$kk]['limittime'] = ($vv['limittime']) ? date('Y.m.d', $vv['limittime']) : '';
	        $dqk_list[$kk]['age_grade'] = $age_grade;
	        $dqk_list[$kk]['goods_info'] = $goods_info;
	        $dqk_list[$kk]['content'] = $content;
	        $dqk_list[$kk]['limitinfo'] = strip_tags($vv['limitinfo']);
	
	        //计算提成
	        $goods_promotion_commission[] = order_class::get_goods_promote($vv['id'],2);
	    }
	
	    if ( sizeof($price_arr) > 1 )
	    {
	        $max = max($price_arr);
	        $min = min($price_arr);
	        if ($max == $min )
	            $price_level = $max;
	        else
	            $price_level = $min . '-' . $max;
	    } else {
	        $price_level = $price_arr[0];
	    }
	     
	    $user_id = $this->user['user_id'];
	    
	    // 读取教师信息
	    $teacher_list = teacher_class::get_goods_list_by_seller_id($seller_id, 10);
	    if ( $teacher_list )
	    {
	        foreach( $teacher_list as $kk => $vv )
	        {
	            $description = nl2br($vv['description']);
	            $teacher_list[$kk]['description'] = str_replace('\n','<br>', $description );
	        }
	    }
	     
	    $this->setRenderData(array(
	        'dqk_list' =>  $dqk_list,
	        'seller_info'  =>  $seller_info,
	        'brand_info'   =>  $brand_info,
	        'dqk_list_json'    =>  json_encode($dqk_list),
	        'price_level'  =>  $price_level,
	        'user_id'      =>  $user_id,
	        'max_promotion_commission' =>  max($goods_promotion_commission),
	        'type'         =>  $type,
	        'teacher_list' =>  $teacher_list,
	    ));
	     
	    // 设定微信分享的信息
	    if ( IClient::isWechat() )
	    {
	        $siteConfig = new Config("site_config");
	        $share_link = 'http://www.dsanke.com/site/chit1_detail/id/' . $seller_id;
	        if ( $user_id )
	            $share_link .= '/promote/' . $user_id;
	        $this->sharedata = json_encode(array(
	            'imgUrl'    =>  'http://www.dsanke.com/views/mobile/skin/blue/images/wechat_share_logo.jpg',
	            'desc'      =>  $brand_info['brief'],
	            'title'     =>  $brand_info['shortname'],
	            'link'      =>  $share_link,
	        ));
	    }

	    $this->title = '学习通优惠详情';
	    $this->redirect('manual_discount_detail');
	}
	
	/**
	 * 获取学校列表
	 */
	function get_brand_list_ajax()
	{
	    $area_id = IFilter::act(IReq::get('area_id'),'int');
	    $page = intval(IReq::get('page'));
	    $page = max( $page, 1 );
	    $page_size = 10;
	    $keywords = IFilter::act(IReq::get('keywords'));

	    $where = '';
	    $cat = IFilter::act(IReq::get('cat'),'int');//分类id
	    
	    // 分类
        if ( $cat )
        {
            $category_ids = category_class::get_child_category($cat);
            if ( $category_ids )
            {
                $category_extend_db = new IQuery('category_extend');
                $goods_db = new IQuery('goods as g');
                $goods_db->join = 'left join category_extend as ce on g.id = ce.goods_id left join seller as s on g.seller_id = s.id';
                $goods_db->where = "g.is_del = 0 and ce.category_id in ($category_ids) and s.is_authentication = 1 and s.is_del = 0 and s.is_lock = 0";
                $goods_db->fields = 'distinct(g.seller_id) as seller_id';
                $seller_list = $goods_db->find();
                if ($seller_list)
                {
                    foreach($seller_list as $kk => $vv )
                    {
                        $seller_list[$kk] = $vv['seller_id'];
                    }
                }
                $where .= " and " . db_create_in($seller_list,'s.id');
            }
        }
	    
        // 区域
	    if ( $area_id )
	    {
	        $area_ids = area::get_child_area_id_list($area_id);
	        $area_ids[] = $area_id;
	        if ( $area_ids )
	        {
	            $area_ids = implode(',', $area_ids);
	            $where .= " and s.area in ($area_ids)";
	        }
	    }
	    
	    // 关键词
	    if ( $keywords )
	    {
	        $where .= " and (s.shortname like '%$keywords%' or s.true_name like '%$keywords%')";
	    }
	    
	    $length = 18;
	    $brand_db = new IQuery('brand AS b');
	    $brand_db->join = "left join seller AS s ON b.id = s.brand_id";
	    //$brand_db->where = "s.is_authentication = 1 and b.logo != '' AND b.description != '' AND b.shortname != '' $where";
	    $brand_db->where = "s.is_authentication = 1 and b.logo != '' AND b.shortname != '' $where";
	    $brand_db->order = 's.sale desc,id desc';
	    $brand_db->fields = 'b.*,s.sale,s.area,s.address';
	    $brand_db->page = $page;
	    $brand_db->pagesize = $page_size;
	    $brand_list = $brand_db->find();
	    $paging = $brand_db->paging;
	    
	    // 截取字符串
	    if ( $brand_list )
	    {
	        foreach($brand_list as $kk => $vv )
	        {
	            if ( strlen($vv['brief']) > $length * 2)
	                $brand_list[$kk]['brief'] = mb_substr($vv['brief'], 0, $length, 'utf-8') . '...';
	            $brand_list[$kk]['address'] = ($vv['area']) ? area::getName($vv['area']) . $vv['address'] : $vv['address']; 
	        }
	    }
	    
	    if ( $brand_list )
	    {
	        $brand_list['num'] = sizeof($brand_list);
	        $brand_list['page'] = $page + 1;
	    } else {
	        $brand_list['num'] = 0;
	        $brand_list['page'] = 1;
	    }

	    if ( $page > $paging->totalpage )
	    {
	        $brand_list = array();
	        $brand_list['num'] = 0;
	        $brand_list['page'] = 1;
	    }
	    
	    echo json_encode($brand_list);
	}
	
	function get_dqk_seller_list_ajax()
	{
	    $cat_id = IFilter::act(IReq::get('cat_id'),'int');
	    $keyword = IFilter::act(IReq::get('keyword'));
	    $type = IFilter::act(IReq::get('type'),'int');
	    $where = '';
	    if ($cat_id)
	    {
	        $where = ' and manual_category_id = ' . $cat_id;
	    }
	    
	    if ( $keyword )
	    {
	        $goods_ids = array();
	        $goods_db = new IQuery('goods');
	        $goods_db->where = "search_words like '%$keyword%' or name like '%$keyword%'";
	        $goods_db->fields = 'id';
	        $goods_list = $goods_db->find();
	        if ( $goods_list )
	        {
	            foreach($goods_list as $kk => $vv )
	            {
	                $goods_ids[] = $vv['id'];
	            }
	            $where .= ' and ' . db_create_in($goods_ids, 'bc.goods_id');
	        }
	    }
	    
	    if ( $type > 0 )
	    {
	        switch( $type )
	        {
	            case 1:
	                $where .= ' and bc.commission = 0';
	                break;
	            case 2:
	                $where .= ' and bc.commission > 0';
	                break;
	        }
	    }
	    
	    // 获取所有短期课商户列表
	    $brand_chit_db = new IQuery('brand_chit as bc');
	    $brand_chit_db->where = 'g.is_del = 0 and bc.is_del = 0 and bc.category = 2' . $where;
	    $brand_chit_db->order = 'is_top desc,c_sale desc';
	    $brand_chit_db->join = 'left join goods as g on bc.goods_id = g.id left join seller as s on bc.seller_id = s.id left join brand as b on s.brand_id = b.id';
	    $brand_chit_db->fields = 'distinct(bc.seller_id) as seller_id,sum(bc.sale) as c_sale,bc.*,s.area,s.shortname as seller_name,g.market_price,b.brief,b.logo as b_logo,s.address';
	    $brand_chit_db->group = 'bc.seller_id';
	    $chits = $brand_chit_db->find();
	    if ($chits)
	    {
	        foreach($chits as $kk => $vv )
	        {
	            $chits[$kk]['brief'] = ($vv['brief']) ? $vv['brief'] : '';
	            $chits[$kk]['address'] = ($vv['area']) ? area::getName($vv['area']) . $vv['address'] : $vv['address'];
	        }
	    }
	    
	    $this->json_result($chits);
	}
	
	function manual_activation()
	{
	    $code = IFilter::act(IReq::get('code'));
	    if ( !$code )
	    {
	        IError::show(403,'激活码不能为空');
	    }
	    
	    $user_id = $this->user['user_id'];
	    $result = manual_class::is_avalible($code, $user_id);
	    $user_id = $this->user['user_id'];
        switch($result)
        {
            case -1:
                $msg = '激活码不正确';
                break;
            case -2:
                $msg = '激活码不能为空';
                break;
            case 0:
                $msg = '该手册已被激活';
                break;
            default:
                if ( $user_id )
                {
                    $this->redirect('/ucenter/manual_activation/code/' . $code);
                    exit();
                } else {
                    header("location: /simple/login?tourist&callback=/site/manual_activation/code/$code");
                }
                break;
        }
        
        IError::show(403,$msg);
	}
	
// 	function check_use_manual()
// 	{
// 	    $user_id = $this->user['user_id'];
// 	    $id = IFilter::act(IReq::get('id'),'int');
// 	    $manual_id = IFilter::act(IReq::get('manual_id'),'int');
// 	    $dqk_info = brand_chit_class::get_dqk_info($id);
// 	    if ( !$dqk_info || $dqk_info['is_del'])
// 	    {
// 	        $this->json_error('该短期课不存在');
// 	        exit();
// 	    }
// 	    $goods_info = goods_class::get_goods_info($dqk_info['goods_id']);
// 	    if ( !$goods_info || $goods_info['is_del'] )
// 	    {
// 	        $this->json_error('课程不存在');
// 	        exit();
// 	    }
	    
// 	    $seller_info = seller_class::get_seller_info($dqk_info['seller_id']);
// 	    if ( !$seller_info['manual_category_id'] )
// 	    {
// 	        $this->json_error('该学校无短期课分类');
// 	        exit();
// 	    }
	    
// 	    // 获取用户的手册信息
// 	    $manual_info = manual_class::get_manual_info($manual_id);
// 	    if ( !$manual_info )
// 	    {
// 	        $this->json_error('手册不存在');
// 	        exit();
// 	    }
// 	    if ( !$manual_info['is_activation'] )
// 	    {
// 	        $this->json_error('手册未激活，请先激活手册');
// 	        exit();
// 	    }
// 	    if ( $manual_info['user_id'] != $user_id )
// 	    {
// 	        $this->json_error('您未绑定该手册，无法使用');
// 	        exit();
// 	    }
	    
// 	    $manual_category_arr = explode(',', $manual_info['category_id']);
	    
// 	    // 验证激活的分类
// 	    if ( !in_array($seller_info['manual_category_id'], $manual_category_arr))
// 	    {
// 	        $this->json_error('您尚未购买该分类，无法使用手册');
// 	        exit();
// 	    }
	    
// 	    // 获取该手册在该商户下的使用记录
// 	    $can_use = false;
// 	    $use_list = manual_use_list_class::get_manual_use_list_by_seller_id($user_id, $manual_id, $seller_info['id']);
// 	    if ( $use_list === false )
// 	    {
// 	        $this->json_error('参数不正确');
// 	        exit();
// 	    } else if ( !$use_list ) {
// 	        $can_use = true;
// 	    } else {
// 	        $list = current($use_list);
// 	        if ( $list['dqk_id'] == $id && $dqk_info['use_times'] > sizeof($use_list))
// 	        {
//     	        $can_use = true;
// 	        } else {
// 	            if ( $list['dqk_id'] != $id )
// 	            {
// 	                $this->json_error('每个学校仅限选择一门短期课');
// 	                exit();
// 	            } else {
// 	                $this->json_error('您该学校短期课权益已使用完');
// 	                exit();
// 	            }
// 	        }
// 	    }
	    
// 	    if ( $can_use )
// 	    {
// 	        $data = array(
// 	            'user_id'      =>  $user_id,
// 	            'seller_id'    =>  $seller_info['id'],
// 	            'dqk_id'       =>  $id,
// 	            'manual_id'    =>  $manual_id,
// 	            'time'         =>  time(),
// 	        );
// 	        $manual_use_list_db = new IModel('manual_use_list');
// 	        $manual_use_list_db->setData($data);
// 	        $manual_use_list_db->add();
	        
// 	        $this->json_result();
// 	    }
// 	}
	
	function seller_receipt()
	{
	    $seller_id = IFilter::act(IReq::get('id'),'int');
	    if ( !$seller_id )
	    {
	        IError::show('参数不正确',403);
	        exit();
	    }

	    $seller_info = seller_class::get_seller_info($seller_id);
	    if ( !$seller_info || !$seller_info['is_authentication'])
	    {
	        IError::show('商户未认证，暂时不能进行交易',403);
	        exit();
	    }
	    
	    // 获取商家折扣列表
	    $seller_discount_list = seller_discount_level_class::get_seller_discount_level_list($seller_id);

	    $this->title = '面对面付款';
	    $this->setRenderData(array(
	        'id'            =>  $seller_id,
	        'seller_info'      =>  $seller_info,
	        'seller_discount_list' =>  json_encode($seller_discount_list),
	    ));
	    $this->redirect('seller_receipt');
	}
	
	// 选择手册
	function manual_choose()
	{
	    $user_id = $this->user['user_id'];
	    $id = IFilter::act(IReq::get('dqk_id'),'int');
	    if ( !$user_id )
	    {
	        $this->redirect('/simple/login?tourist&callback=/site/manual_choose/dqk_id/' . $id);
	        exit();
	    }
	    
		$dqk_info = brand_chit_class::get_dqk_info($id);
	    if ( !$dqk_info )
	    {
	        IError::show('该短期课可能已被下架',403);
	        exit();
	    }
	    
	    $manual_list = manual_class::get_manual_list_by_userid($user_id);
	    
	    // 去掉未激活的手册
	    if ( $manual_list )
	    {
	        foreach($manual_list as $kk => $vv )
	        {
	            if ( !$vv['is_activation'] )
	            {
	                unset($manual_list[$kk]);
	            } else {
	                $manual_list[$kk]['year'] = calcAge(date('Y-m-d', $vv['birthday']));
	            }
	        }
	    }
	    
	    if ( !$manual_list )
	    {
	        IError::show('您尚未绑定任何学习通',403);
	        exit();
	    } else if ( sizeof($manual_list) == 1)
	    {
	        $this->redirect('/site/manual_use/manual_id/' . $manual_list[0]['id'] . '/id/' . $id);
	    } else {
	        $this->title = '选择学习通';
	        $this->setRenderData(array(
	            'manual_list'  =>  $manual_list,
	            'id'           =>  $id,
	        ));
	        $this->redirect('manual_choose');
	    }
	}
	
	// 使用手册
	function manual_use()
	{
	    $user_id = $this->user['user_id'];
	    $manual_id = IFilter::act(IReq::get('manual_id'),'int');
	    $id = IFilter::act(IReq::get('id'),'int');
        
	    if ( !$manual_id || !$id )
	    {
	        IError::show('参数不正确，操作失败',403);
	        exit();
	    }

	    $dqk_info = brand_chit_class::get_dqk_info($id);
	    if ( !$dqk_info || $dqk_info['is_del'])
	    {
	        IError::show('该短期课不存在',403);
	        exit();
	    }
	    
	    $goods_info = goods_class::get_goods_info($dqk_info['goods_id']);
	    if ( !$goods_info || $goods_info['is_del'] )
	    {
	        IError::show('课程不存在',403);
	        exit();
	    }

	    $seller_info = seller_class::get_seller_info($dqk_info['seller_id']);
	    if ( !$seller_info['manual_category_id'] )
	    {
	        IError::show('该学校无短期课分类',403);
	        exit();
	    }
	     
	    // 获取用户的手册信息
	    $manual_info = manual_class::get_manual_info($manual_id);
	    if ( !$manual_info )
	    {
	        IError::show('学习通不存在',403);
	        exit();
	    }
	    if ( !$manual_info['is_activation'] )
	    {
	        IError::show('学习通未激活，请先激活',403);
	        exit();
	    }
	    if ( $manual_info['user_id'] != $user_id )
	    {
	        IError::show('您未绑定该学习通，无法使用',403);
	        exit();
	    }
	     
	    $manual_category_arr = explode(',', $manual_info['category_id']);
	     
	    // 验证激活的分类
	    if ( !in_array($seller_info['manual_category_id'], $manual_category_arr))
	    {
	        IError::show('您尚未购买该分类，无法使用学习通',403);
	        exit();
	    }
	    
	    // 获取该手册在该商户下的使用记录
	    $can_use = false;
	    $use_list = manual_use_list_class::get_manual_use_list_by_seller_id($user_id, $manual_id, $seller_info['id']);
	    if ( $use_list === false )
	    {
	        IError::show('参数不正确',403);
	        exit();
	    } else if ( !$use_list ) {
	        $can_use = true;
	    } else {
	        $list = current($use_list);
	        if ( $list['dqk_id'] == $id && $dqk_info['use_times'] > sizeof($use_list))
	        {
	            $can_use = true;
	        } else {
	            if ( $list['dqk_id'] != $id )
	            {
	                IError::show('每个学校仅限选择一门短期课',403);
	                exit();
	            } else {
	                IError::show('您该学校短期课权益已使用完',403);
	                exit();
	            }
	        }
	    }
	    
	    $manual_info['year'] = calcAge(date('Y-m-d', $manual_info['birthday']));

	    $this->title = '使用学习通';
	    $this->setRenderData(array(
	        'user_id'      =>  $user_id,
	        'manual_id'    =>  $manual_id,
	        'id'           =>  $id,
	        'manual_info'  =>  $manual_info,
	        'dqk_info'     =>  $dqk_info,
	        'seller_info'  =>  $seller_info,
	    ));
	    $this->redirect('manual_use');
	}
	
	// 核销学习通
	function manual_check_use()
	{
	    $manual_id = IFilter::act(IReq::get('manual_id'),'int');
	    $id = IFilter::act(IReq::get('id'),'int');
	    
		if ( !$manual_id || !$id )
	    {
	        IError::show('参数不正确，操作失败',403);
	        exit();
	    }

	    $dqk_info = brand_chit_class::get_dqk_info($id);
	    if ( !$dqk_info || $dqk_info['is_del'])
	    {
	        IError::show('该短期课不存在',403);
	        exit();
	    }
	    
	    $goods_info = goods_class::get_goods_info($dqk_info['goods_id']);
	    if ( !$goods_info || $goods_info['is_del'] )
	    {
	        IError::show('课程不存在',403);
	        exit();
	    }

	    $seller_info = seller_class::get_seller_info($dqk_info['seller_id']);
	    if ( !$seller_info['manual_category_id'] )
	    {
	        IError::show('该学校无短期课分类',403);
	        exit();
	    }

	    // 获取用户的手册信息
	    $manual_info = manual_class::get_manual_info($manual_id);
	    $user_id = $manual_info['user_id'];
	    if ( !$manual_info )
	    {
	        IError::show('学习通不存在',403);
	        exit();
	    }
	    if ( !$manual_info['is_activation'] )
	    {
	        IError::show('学习通未激活，请先激活',403);
	        exit();
	    }
	    if ( !$user_id )
	    {
	        IError::show('用户未绑定学习通，无法使用',403);
	        exit();
	    }

	    $manual_category_arr = explode(',', $manual_info['category_id']);

	    // 验证激活的分类
	    if ( !in_array($seller_info['manual_category_id'], $manual_category_arr))
	    {
	        IError::show('用户尚未购买该分类，无法使用学习通',403);
	        exit();
	    }

	    if ( IS_POST )
	    {
	        $password = IFilter::act(IReq::get('password'));
	        if ( !$password )
	        {
	            IError::show('请输入交易密码',403);
	            exit();
	        }
	        if ( !$seller_info['draw_password'] )
	        {
	            IError::show(403,'商户未设置交易密码');
	            exit();
	        }
	        
	        $password = md5($password);
	        if ( $password != $seller_info['draw_password'] )
	        {
	            IError::show('交易密码不正确',403);
	            exit();
	        }

	        // 获取该手册在该商户下的使用记录
	        $can_use = false;
	        $use_list = manual_use_list_class::get_manual_use_list_by_seller_id($user_id, $manual_id, $seller_info['id']);
	        if ( $use_list === false )
	        {
	            IError::show('参数不正确',403);
	            exit();
	        } else if ( !$use_list ) {
	            $can_use = true;
	        } else {
	            $list = current($use_list);
	            if ( $list['dqk_id'] == $id && $dqk_info['use_times'] > sizeof($use_list))
	            {
	                $can_use = true;
	            } else {
	                if ( $list['dqk_id'] != $id )
	                {
	                    IError::show('每个学校仅限选择一门短期课',403);
	                    exit();
	                } else {
	                    IError::show('您该学校短期课权益已使用完',403);
	                    exit();
	                }
	            }
	        }

	        if ( $can_use )
	        {
	            $remaining_times = ($dqk_info['use_times'] - sizeof($use_list)) / $dqk_info['each_times'] - 1;
	            $dqk_info['each_times'] = max($dqk_info['each_times'], 1);
	            for( $i = 0; $i < $dqk_info['each_times']; $i++ )
	            {
	                $data = array(
	                    'user_id'      =>  $user_id,
	                    'seller_id'    =>  $seller_info['id'],
	                    'dqk_id'       =>  $id,
	                    'manual_id'    =>  $manual_id,
	                    'time'         =>  time(),
	                );
	                $manual_use_list_db = new IModel('manual_use_list');
	                $manual_use_list_db->setData($data);
	                $manual_use_list_db->add();
	            }
	            
	            // 发送短信给双方
	            // 发送短信给用户
	            $member_info = member_class::get_member_info($user_id);
	            $user_mobile[] = $member_info['mobile'];
	            $user_mobile[] = $manual_info['parents_tel'];
	            $user_mobile = array_filter(array_unique($user_mobile));
	            if ( $user_mobile )
	            {
	                $user_mobile = implode(',', $user_mobile);
	                $user_sms_content = '学习通课程验证成功。' . $seller_info['shortname'] . '学校' . $dqk_info['name'] . '课程，还剩' . $remaining_times . '次。0731-28308258【第三课】';
	                $sms = new Sms_class();
	                $result = $sms->send( $user_mobile, $user_sms_content );
	            }
	            
	            // 发送短信给商户
	            if ( $seller_info['mobile'] )
	            {
	                $seller_sms_content = '用户' . $manual_info['parents_name'] . '成功使用第三课学习通完成' . $dqk_info['name'] . '课程，还剩' . $remaining_times . '次。0731-28308258【第三课】';
	                $sms = new Sms_class();
	                $result = $sms->send( $seller_info['mobile'], $seller_sms_content );
	            }
	            
	            $this->redirect('/site/success/message/'.urlencode("核销成功").'/?callback=/site');
	        } else {
	            IError::show('操作失败',403);
	            exit();
	        }
	    } else {
	        $this->title = '请输入交易密码';
            $this->setRenderData(array(
                'seller_info'   =>  $seller_info,
                'dqk_info'      =>  $dqk_info,
                'id'            =>  $id,
                'manual_id'     =>  $manual_id,
            ));
	        $this->redirect('manual_check_use');
	    }
	    
	}
	
	// 短期课核销
	function brand_chit_check_use()
	{
	    $id = IFilter::act(IReq::get('id'),'int');
	    $use_id = IFilter::act(IReq::get('use_id'),'int');
	    
	    if ( !$id || !$use_id )
	    {
	        IError::show('参数不正确',403);
	        exit();
	    }
	    $order_info = order_class::get_order_info($id);
	    if ( !$order_info )
	    {
	        IError::show(403,'订单信息不存在');
	        exit();
	    }
	    
	    $brand_chit_use_info = brand_chit_zuhe_use_list_class::get_brand_chit_zuhe_use_list_info($use_id);
	    if ( !$brand_chit_use_info )
	    {
	        IError::show(403,'短期课购买信息不存在');
	        exit();
	    }
	    if ( $brand_chit_use_info['order_id'] != $id)
	    {
	        IError::show(403,'参数不正确');
	        exit();
	    }
	    
	    $brand_chit_info = brand_chit_class::get_dqk_info($brand_chit_use_info['brand_chit_id']);
	    if ( !$brand_chit_info )
	    {
	        IError::show(403,'短期课不存在');
	        exit();
	    }
	    
	    $seller_info = seller_class::get_seller_info($brand_chit_info['seller_id']);
	    
	    if ( IS_POST )
	    {
	        $password =  IFilter::act(IReq::get('password'));
	        if ( !$password )
	        {
	            IError::show(403,'交易密码不能为空');
	            exit();
	        } else if ( !$seller_info['draw_password'] )
	        {
	            IError::show(403,'商户未设置交易密码');
	            exit();
	        }
	        else if ( md5($password) != $seller_info['draw_password'] )
	        {
	            IError::show(403,'交易密码不正确');
	            exit();
	        } else {
	            $result = order_class::update_dqk_use_info($use_id,$id);
	            if ( $result )
	            {
	                $this->redirect('/site/success/message/'.urlencode("核销短期课成功").'/?callback=/site');
	            } else {
	                $this->redirect('/site/success/message/'.urlencode("核销短期课失败，参数不正确").'/?callback=/site');
	            }
	        }
	    } else {
	        $this->title = '核销短期课';
	        $this->setRenderData(array(
	            'id'               =>  $id,
	            'use_id'           =>  $use_id,
	            'brand_chit_info'  =>  $brand_chit_info,
	            'seller_info'      =>  $seller_info,
	        ));
	        $this->redirect('brand_chit_check_use');
	    }
	}
	
	// 微信扫描二维码购买学习通的连接
	function study_book()
	{
	    header("location:http://www.dsanke.com/simple/cart2n/id/1980/num/1/type/goods");
	}
	
	// 错误信息提示
	function error()
	{
	    $this->title = '错误提示';
	    $this->redirect('error');
	}
	
	// 康桌定制，幼儿潜能规划 1280元
	function kz_buy_url_1()
	{
	    header("location: http://www.dsanke.com/simple/cart2n/id/1957/num/1/type/goods");
	}
	
	// 康桌定制，ICID-学业规划 1980元
	function kz_buy_url_2()
	{
	    header("location: http://www.dsanke.com/simple/cart2n/id/1922/num/1/type/goods");
	}
	
	
	// 手册预约
	function make_appointment_ajax()
	{
	    $user_id = $this->user['user_id'];
	    $id = IFilter::act(IReq::get('id'),'int');
	    $parent_name = IFilter::act(IReq::get('parents_name'));
	    $parent_tel = IFilter::act(IReq::get('parents_tel'));
	    $manual_id = IFilter::act(IReq::get('manual_id'));
	    
	    if ( !$user_id )
	    {
	        $this->json_error('请登录再进行操作');
	    } else if ( !$id ) {
	        $this->json_error('请选择要预约的短期课');
	    } else if ( !$parent_name ){
	        $this->json_error('请输入姓名');
	    } else if ( !$parent_tel ) {
	        $this->json_error('请输入联系电话');
	    } else {
	        $brand_chit_info = brand_chit_class::get_chit_info($id);
	        if ( !$brand_chit_info )
	        {
	            $this->json_error('短期课不存在');
	        } else {
	            $manual_info = manual_class::get_manual_info($manual_id);
	            if ( !$manual_info )
	            {
	                $this->json_error('学习通不存在');
	            } else if ( $manual_info['user_id'] != $user_id ) {
	                $this->json_error('您无法使用该学习通');
	            } else if ( !$manual_info['is_activation'] ) {
	                $this->json_error('学习通未激活');
	            } else {
	                $manual_age = calcAge(date('Y-m-d', $manual_info['birthday']));
	                $gender = get_sex($manual_info['sex']);
	                $content = $parent_name . '(' . $manual_age . '岁,' . $gender . ')已在第三课预约贵校的' . $brand_chit_info['name'] . '，联系电话为' . $parent_tel . '，请及时联系。0731-28308258【第三课】';
	                $seller_info = seller_class::get_seller_info($brand_chit_info['seller_id']);
	                $seller_info['mobile'] = (!$seller_info['mobile']) ? '18073338177' : $seller_info['mobile'];
	                 
	                $sms_db = new IModel('sms');
	                $sms = new Sms_class();
	                $result = $sms->send( $seller_info['mobile'], $content );
	                 
	                 
	                // 插入数据库
	                $data = array(
	                    'user_id'  =>  $user_id,
	                    'brand_chit_id'    =>  $id,
	                    'parent_name'  =>  $parent_name,
	                    'parent_tel'   =>  $parent_tel,
	                    'time'     =>  time(),
	                );
	                $brand_chit_appointment = new IModel('brand_chit_appointment');
	                $brand_chit_appointment->setData($data);
	                $brand_chit_appointment->add();
	                 
	                $this->json_result();
	            }
	        }	        
	    }
	}
	
}
