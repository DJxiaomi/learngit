<?php

class Site extends IController
{
    public $layout='';
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

	    if ( IClient::getDevice() == IClient::PC )
	    {
	        die('<center><br><br><br><H1>系统已关闭PC端，请在微信中打开 ！</H1></center>');
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


	function indextest()
	{
		$x = new Config('config.php');
    var_dump($x);
	}

/*
	function success()
	{
	    $this->layout = '';
	    $this->redirect('success');
	}	*/

	function index()
	{
	    $goods_list = goods_class::get_goods_list_by_seller_id(255, 100);

    	// 设定微信分享的信息
    	if ( IClient::isWechat() )
    	{
    	    $siteConfig = new Config("site_config");
    	    $share_link = "http://".$_SERVER['HTTP_HOST'];
    	    if ( $user_id )
    	        $share_link .= '/promote/' . $user_id;
    	    $this->sharedata = json_encode(array(
    	        'imgUrl'    =>  $share_link.'views/mobile/skin/blue/images/wechat_share_logo.jpg',
    	        'desc'      =>  $siteConfig->index_seo_description,
    	        'title'     =>  $siteConfig->index_seo_title,
    	        'link'      =>  $share_link,
    	    ));
    	}

	    $this->setRenderData(array(
	        'goods_list'   => $goods_list,
	    ));

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
	
	/**
	 * 订单采集核销
	 */
	function order_confirm()
	{
	    // 获取订单信息
	    $order_id = IFilter::act(IReq::get('id'),'int');
	    $order_info = order_class::get_order_info($order_id);
	    
	    // 获取订单商品列表
	    $order_goods_list = Order_goods_class::get_order_goods_list($order_id);
	    
	    if ( !$order_info )
	    {
	        IError::show('订单信息不存在');
	    } else if ( !$order_info['pay_status'] ) {
	        IError::show('订单未付款');
	    } else if ( $order_info['status'] != 2 ) {
	        IError::show('订单信息不正确，无法核销');
	    } else {
	        
	        if ( !IS_POST )
	        {
	            if ($order_goods_list )
	            {
	                foreach($order_goods_list as $kk => $vv )
	                {
	                    $goods_array = json_decode($vv['goods_array']);
	                    $order_goods_list[$kk]['goods_name'] = $goods_array->name;
	                }
	            }
	            
	            $this->setRenderData(array(
	                'order_info'   =>  $order_info,
	                'order_goods_list' =>  $order_goods_list,
	            ));
	            $this->title = '订单采集核销';
	            $this->redirect('order_confirm');
	        } else {
	            $code = IFilter::act(IReq::get('code'));
	            if ( !$code )
	            {
	                IError::show('请输入验证码');
	            }
	            $institution_info = institution_class::get_institution_info_by_code($code);
	            if ( !$institution_info )
	            {
	                IError::show('验证码不正确');
	            }
	            
	            // 更新订单表，记录线下核销的机构ID
	            $data = array(
	                'institution_id'   =>  $institution_info['id'],
	            );
	            $order_db = new IModel('order');
	            $order_db->setData($data);
	            $order_db->update('id = '. $order_id);
	            
	            // 自动发货
	            $sendgoods = array($order_goods_list[0]['id']);
	            $result = Order_Class::sendDeliveryGoods($order_id,$sendgoods,1);
	            
	            // 自动确认收货
	            $model = new IModel('order');
	            $model->setData(array('status' => 5,'completion_time' => ITime::getDateTime()));
	            if($model->update("id = ".$order_id." and distribution_status = 1 and user_id = ".$this->user['user_id']))
	            {            
	                //确认收货后进行支付
	                Order_Class::updateOrderStatus($order_info['order_no']);
	            
	                //增加用户评论商品机会
	                Order_Class::addGoodsCommentChange($order_id);
	            }
	            
	            $this->redirect('/site/success/message/'.urlencode("核销成功").'/?callback=/site');
	        }
	    }
	}
}
