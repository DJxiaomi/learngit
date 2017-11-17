<?php
/**
 * @brief 商家模块
 * @class Seller
 * @author chendeshan
 * @datetime 2014/7/19 15:18:56
 */
class Seller extends IController implements sellerAuthorization
{
	public $layout = 'seller';

	/**
	 * @brief 初始化检查
	 */
	public function init()
	{

	}
	
	public function index()
	{
	    if(IClient::getDevice() == 'pc')
	    {
	        $this->title ='概要信息';
	        	
	        $this->redirect('index');
	    }
	    else
	    {
	        header("location: " . IUrl::creatUrl('/seller/meau_index'));
	    }
	}
	
	public function meau_index()
	{
	    $this->title ='学校后台管理中心';
	    $this->seller_info = seller_class::get_seller_info($this->seller['seller_id']);
	    $this->brand_info = brand_class::get_brand_info($this->seller_info['brand_id']);
	    $this->redirect('meau_index');
	}
	
	/**
	 * @brief 商品添加和修改视图
	 */
	public function goods_edit()
	{
		$goods_id = IFilter::act(IReq::get('id'),'int');

		//初始化数据
		$goods_class = new goods_class($this->seller['seller_id']);

		//获取所有商品扩展相关数据
		$data = $goods_class->edit($goods_id);

		if($goods_id && !$data)
		{
			die("没有找到相关商品！");
		}

		$this->setRenderData($data);
		$this->redirect('goods_edit');
	}
	
		/**
	 * @brief 商品添加和修改视图
	 */
	public function goods_edit_1()
	{
		$goods_id = IFilter::act(IReq::get('id'),'int');

		//初始化数据
		$goods_class = new goods_class($this->seller['seller_id']);

		//获取所有商品扩展相关数据
		$data = $goods_class->edit($goods_id);

		if($goods_id && !$data)
		{
			die("没有找到相关商品！");
		}
		
		
		$cat_db = new IQuery('category');
		$cat_db->where = "parent_id = '0'";
		$cats = $cat_db->find();
		foreach($cats AS $idx => $cat)
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
		$catname = array();
		if($data['goods_category'])
		{
		    $categoryDB = new IModel('category');
		    $cateData   = $categoryDB->query("id in (".join(",",$data['goods_category']).")");
		    foreach($cateData AS $cat)
		    {
		        array_push($catname, $cat['name']);
		    }
		}
		$this->setRenderData(array('jsoncats'   => json_encode($jsoncat), 'catname' => implode(',', $catname)));

		$this->title = '编辑课程';
		$this->setRenderData($data);
		$this->redirect('goods_edit_1');
	}
	
	
	
	//商品更新动作
	public function goods_update()
	{
		$id       = IFilter::act(IReq::get('id'),'int');
		$callback = IReq::get('callback');
		$callback = strpos($callback,'seller/goods_list') === false ? '' : $callback;

		//检查表单提交状态
		if(!$_POST)
		{
			die('请确认表单提交正确');
		}
		
		// 手动添加规格信息
		if ( (sizeof($_POST['_sell_price']) == sizeof($_POST['_market_price'])) && (sizeof($_POST['_sell_price']) != sizeof($_POST['_spec_array'])) && IClient::getDevice() == 'mobile')
		{
		    $price_count = sizeof($_POST['_sell_price']);
		    $spec_count = sizeof($_POST['_spec_array']);
		
		    // 获取所有的规格信息
		    $spec_db = new IQuery('spec');
		    $spec_db->where = '1=1 and id = 6';
		    $spec_list = $spec_db->find();
		    $arr = array();
		
		    if ( $spec_list )
		    {
		        foreach( $spec_list as $kk => $vv )
		        {
		            $value = json_decode($vv['value']);
		            $value = get_object_vars($value);
		            if ( $value )
		            {
		                foreach( $value as $k => $v )
		                {
		                    $arr[] = json_encode(array(
		                        'id' => $vv['id'],
		                        'type'    =>  1,
		                        'name'    =>  $vv['name'],
		                        'value'   =>  $k,
		                        'tip'     =>  $v,
		                    ));
		                }
		            }
		        }
		    }
		
		    $defaultNo = goods_class::createGoodsNo();
		    if ( $price_count > $spec_count )
		    {
		        $t = $price_count - $spec_count;
		        $t_rand = array_rand($arr,$t);
		        if ( !isset($_POST['_spec_array']))
		            $_POST['_spec_array'] = array();
		
		        if ( $t_rand )
		        {
		            foreach( $t_rand as $k => $v )
		            {
		                $ar = $arr[$v];
		                $_POST['_spec_array'][][] = $ar;
		                $_POST['_goods_no'][] = $defaultNo . '_' . $k;
		            }
		        }
		    }
		}

		if($_POST['uploadButton']){
			$_img = array();
			foreach($_POST['uploadButton'] as $key => $val){
				if($val){
					if(stristr($val,'base64')){
						$img_tmp = explode(',',$val);
						$img = base64_decode($img_tmp[1]);

						$filename = '/upload/'.date('Y/m/d').'/'.date('Ymdhis').rand(10000,99999).'.jpg';
						$re = file_put_contents('./'.$filename, $img);

						$filename = trim($filename,'/');
						if($re){						
							$_img[] = $filename;
						}
					}else{
						$_img[] = $val;
					}					
				}
			}
			$_POST['img'] = $_img[0];

			$tb_photo = new IModel('goods_photo');
			foreach($_img as $v){
				$sel = $tb_photo->getObj('id="'.md5($v).'"');
				
				if( $sel ){
					continue;
				}
				$tb_photo->setData(array('id'=>md5($v),'img'=>$v));
				$tb_photo->add();
			}

			$_POST['_imgList'] = implode(',', $_img);
		}

		//初始化商品数据
		unset($_POST['id']);
		unset($_POST['callback']);
		unset($_POST['uploadButton']);

		$goodsObject = new goods_class($this->seller['seller_id']);
		$goodsObject->update($id,$_POST);

		$callback ? $this->redirect($callback) : $this->redirect("goods_list");
	}
	//商品列表
	public function goods_list()
	{
		$seller_id = $this->seller['seller_id'];
		$searchArray = Util::getUrlParam('search');
		$searchParam = http_build_query($searchArray);
		$condition = Util::goodsSearch(IReq::get('search'));
		$where = "go.seller_id='$seller_id' ";
		$where .= $condition ? " and ".$condition : "";
		$join = isset($searchArray['search']['category_id']) ? " left join category_extend as ce on ce.goods_id = go.id " : "";
		$page   = IReq::get('page') ? IFilter::act(IReq::get('page'),'int') : 1;

		$goodHandle = new IQuery('goods as go');
		$goodHandle->order  = "go.id desc";
		$goodHandle->fields = "distinct go.id,go.name,go.sell_price,go.market_price,go.store_nums,go.img,go.is_del,go.seller_id,go.is_share,go.sort";
		$goodHandle->where  = $where;
		$goodHandle->page	= $page;
		$goodHandle->join	= $join;

		$this->goodHandle = $goodHandle;

		$goods_info = array();
		$goods_info['seller_id'] = $seller_id;
		$goods_info['searchParam'] = $searchParam;
		$this->setRenderData($goods_info);
		$this->redirect('goods_list');
	}
	
	public function goods_list_1()
	{
	    $this->title = '课程列表';
	    $this->redirect('goods_list_1');
	}

	//商品列表
	public function goods_report()
	{
		$seller_id = $this->seller['seller_id'];
		$condition = Util::goodsSearch(IReq::get('search'));

		$where  = 'go.seller_id='.$seller_id;
		$where .= $condition ? " and ".$condition : "";
		$join = isset($_GET['search']['category_id']) ? " left join category_extend as ce on ce.goods_id = go.id " : "";

		$goodHandle = new IQuery('goods as go');
		$goodHandle->order  = "go.id desc";
		$goodHandle->fields = "go.*";
		$goodHandle->where  = $where;
		$goodHandle->join	= $join;
		$goodList = $goodHandle->find();

		$reportObj = new report('goods');
		$reportObj->setTitle(array("商品名称","分类","售价","库存"));
		foreach($goodList as $k => $val)
		{
			$insertData = array(
				$val['name'],
				goods_class::getGoodsCategory($val['id']),
				$val['sell_price'],
				$val['store_nums'],
			);
			$reportObj->setData($insertData);
		}
		$reportObj->toDownload();
	}

	//商品删除
	public function goods_del()
	{
		//post数据
	    $id = IFilter::act(IReq::get('id'),'int');

	    //生成goods对象
	    $goods = new goods_class();
	    $goods->seller_id = $this->seller['seller_id'];

	    if($id)
		{
			if(is_array($id))
			{
				foreach($id as $key => $val)
				{
					$goods->del($val);
				}
			}
			else
			{
				$goods->del($id);
			}
		}
		$this->redirect("goods_list_1");
	}


	//商品状态修改
	public function goods_status()
	{
	    $id        = IFilter::act(IReq::get('id'),'int');
		$is_del    = IFilter::act(IReq::get('is_del'),'int');
		$is_del    = $is_del === 0 ? 3 : $is_del; //不能等于0直接上架
		$seller_id = $this->seller['seller_id'];

		$goodsDB = new IModel('goods');
		$goodsDB->setData(array('is_del' => $is_del));

	    if($id)
		{
			$id = is_array($id) ? join(",",$id) : $id;
			$goodsDB->update("id in (".$id.") and seller_id = ".$seller_id);
		}
		$this->redirect("goods_list");
	}

	//规格删除
	public function spec_del()
	{
		$id = IFilter::act(IReq::get('id'),'int');

		if($id)
		{
			$idString = is_array($id) ? join(',',$id) : $id;
			$specObj  = new IModel('spec');
			$specObj->del("id in ( {$idString} ) and seller_id = ".$this->seller['seller_id']);
			$this->redirect('spec_list');
		}
		else
		{
			$this->redirect('spec_list',false);
			Util::showMessage('请选择要删除的规格');
		}
	}
	//修改排序
	public function ajax_sort()
	{
		$id   = IFilter::act(IReq::get('id'),'int');
		$sort = IFilter::act(IReq::get('sort'),'int');

		$goodsDB = new IModel('goods');
		$goodsDB->setData(array('sort' => $sort));
		$goodsDB->update("id = {$id} and seller_id = ".$this->seller['seller_id']);
	}

	//咨询回复
	public function refer_reply()
	{
		$rid     = IFilter::act(IReq::get('refer_id'),'int');
		$content = IFilter::act(IReq::get('content'),'text');

		if($rid && $content)
		{
			$tb_refer = new IModel('refer');
			$seller_id = $this->seller['seller_id'];//商户id
			$data = array(
				'answer' => $content,
				'reply_time' => ITime::getDateTime(),
				'seller_id' => $seller_id,
				'status' => 1
			);
			$tb_refer->setData($data);
			$tb_refer->update("id=".$rid);
		}
		$this->redirect('refer_list');
	}
	/**
	 * @brief查看订单
	 */
	public function order_show()
	{
		//获得post传来的值
		$order_id = IFilter::act(IReq::get('id'),'int');
		$data = array();
		if($order_id)
		{
			$order_show = new Order_Class();
			$data = $order_show->getOrderShow($order_id,0,$this->seller['seller_id']);
			if($data)
			{
		 		//获取地区
		 		$data['area_addr'] = join('&nbsp;',area::name($data['province'],$data['city'],$data['area']));
			 	$this->setRenderData($data);
			 	$this->title = '订单详情';
				$this->redirect('order_show',false);
			}
		}
		if(!$data)
		{
			$this->redirect('order_list');
		}
	}
	
	/**
	 * @brief查看短期课订单
	 */
	public function order_show_dqk()
	{
	    //获得post传来的值
	    $order_id = IFilter::act(IReq::get('id'),'int');
	    $data = array();
	    if($order_id)
	    {
// 	        $order_show = new Order_Class();
// 	        $data = $order_show->getOrderShow($order_id,0,$this->seller['seller_id']);
// 	        if($data)
// 	        {
// 	            //获取地区
// 	            $data['area_addr'] = join('&nbsp;',area::name($data['province'],$data['city'],$data['area']));
	
// 	            $this->setRenderData($data);
// 	            $this->redirect('order_show',false);
// 	        }

            $order_db = new IQuery('order as o');
            $order_db->join = 'left join brand_chit_zuhe as bcz on o.zuhe_id = bcz.id left join brand_chit_zuhe_detail as bczd on bcz.id = bczd.zuhe_id left join brand_chit as bc on bczd.brand_chit_id = bc.id';
            $order_db->fields = 'o.*';
            $order_db->where = 'o.statement = 2 and o.id = ' . $order_id . ' and o.zuhe_id > 0 and bc.seller_id = ' . $this->seller['seller_id'] . ' and bc.category = 2';
            $data = $order_db->getOne();
            
            // 获取短期课订单中该商户的短期课列表
            $brand_chit_db = new IQuery('brand_chit as bc');
            $brand_chit_db->join = 'left join brand_chit_zuhe_use_list as bczul on bc.id = bczul.brand_chit_id';
            $brand_chit_db->fields = 'bc.*,bczul.availeble_use_times,bczul.id as use_list_id,bczul.status';
            $brand_chit_db->where = 'bczul.order_id = ' . $order_id . ' and bczul.seller_id = ' . $this->seller['seller_id'];
            $brand_chit_list = $brand_chit_db->find();
            $data['dqk_list'] = $brand_chit_list;
            
            $this->setRenderData($data);
            $this->setRenderData(array('order_id' => $order_id));
            $this->title = '短期课订单详情';
            $this->redirect('order_show_dqk');
	    }
	    if(!$data)
	    {
	        $this->redirect('order_list_dqk');
	    }
	}
	
	
	/**
	 * @brief 发货订单页面
	 */
	public function order_deliver()
	{
		$order_id = IFilter::act(IReq::get('id'),'int');
		$data     = array();

		if($order_id)
		{
			$order_show = new Order_Class();
			$data = $order_show->getOrderShow($order_id,0,$this->seller['seller_id']);
			if($data)
			{
			    $this->title = '确认授课';
				$this->setRenderData($data);
				$this->redirect('order_deliver');
			}
		}
		if(!$data)
		{
			IError::show("订单信息不存在",403);
		}
	}
	/**
	 * @brief 发货操作
	 */
	public function order_delivery_doc()
	{
	 	//获得post变量参数
	 	$order_id = IFilter::act(IReq::get('id'),'int');

	 	//发送的商品关联
	 	$sendgoods = IFilter::act(IReq::get('sendgoods'),'int');

	 	if(!$sendgoods)
	 	{
	 		die('请选择要发货的商品');
	 	}

	 	$result = Order_Class::sendDeliveryGoods($order_id,$sendgoods,$this->seller['seller_id'],'seller');
	 	if($result === true)
	 	{
	 		$this->redirect('order_list');
	 	}
	 	else
	 	{
	 		IError::show($result);
	 	}
	}
	/**
	 * @brief 订单列表
	 */
	public function order_list()
	{
		$seller_id = $this->seller['seller_id'];
		$searchArray = Util::getUrlParam('search');
		$searchParam = http_build_query($searchArray);
		$condition = Util::orderSearch(IReq::get('search'));
		$where  = "o.seller_id='$seller_id' and o.if_del=0 and o.status not in(3,4) and statement in (1)";
		$where .= $condition ? " and ".$condition : "";
		$page   = IReq::get('page') ? IFilter::act(IReq::get('page'),'int') : 1;
		$orderHandle = new IQuery('order as o');
		$orderHandle->order  = "o.id desc";
		$orderHandle->where  = $where;
		$orderHandle->page	 = $page;
		$this->orderHandle   = $orderHandle;
		$order_info = array();
		$order_info['seller_id'] = $seller_id;
		$order_info['searchParam'] = $searchParam;
		$this->setRenderData($order_info);
		
		$this->title = '正式课列表';
		$this->redirect('order_list');
	}
	
	/**
	 * @brief 商户收款订单列表
	 */
	public function order_list_receive()
	{
	    $seller_id = $this->seller['seller_id'];
	    $searchArray = Util::getUrlParam('search');
	    $searchParam = http_build_query($searchArray);
	    $condition = Util::orderSearch(IReq::get('search'));
	    $where  = "o.seller_id='$seller_id' and o.if_del=0 and o.status not in(3,4) and statement in (4)";
	    $where .= $condition ? " and ".$condition : "";
	    $page   = IReq::get('page') ? IFilter::act(IReq::get('page'),'int') : 1;
	    $orderHandle = new IQuery('order as o');
	    $orderHandle->order  = "o.id desc";
	    $orderHandle->where  = $where;
	    $orderHandle->page	 = $page;
	    $this->orderHandle   = $orderHandle;
	    $order_info = array();
	    $order_info['seller_id'] = $seller_id;
	    $order_info['searchParam'] = $searchParam;
	    $this->setRenderData($order_info);
	    
	    $this->title = '商户收款列表';
	    $this->redirect('order_list_receive');
	}
	
	/**
	 * 短期课列表
	 */
	public function order_list_dqk()
	{
	    $page = IFilter::act(IReq::get('page'),'int');
	    $page = max($page,1);
	    $page_size = 12;
	    
	    $seller_id = $this->seller['seller_id'];
	    $order_db = new IQuery('order as o');
	    $order_db->join = 'left join brand_chit_zuhe as bcz on o.zuhe_id = bcz.id left join brand_chit_zuhe_detail as bczd on bcz.id = bczd.zuhe_id left join brand_chit as bc on bczd.brand_chit_id = bc.id';
	    $order_db->fields = 'o.*';
	    $order_db->page = $page;
	    $order_db->pagesize = $page_size;
	    $order_db->where = 'o.statement = 2 and o.zuhe_id > 0 and bc.seller_id = ' . $seller_id . ' and bc.category = 2';
	    $order_db->order = 'id desc';
	    $order_list = $order_db->find();
	    
	    $this->setRenderData(array(
	        'order_list'   =>  $order_list,
	        'page_info'    =>  $order_db->getPageBar(),
	    ));
	    
	    $this->title = '短期课订单列表';
	    $this->redirect('order_list_dqk');
	}

	//订单导出 Excel
	public function order_report()
	{
		$seller_id = $this->seller['seller_id'];
		$condition = Util::orderSearch(IReq::get('search'));

		$where  = "o.seller_id = ".$seller_id." and o.if_del=0 and o.status not in(3,4)";
		$where .= $condition ? " and ".$condition : "";

		//拼接sql
		$orderHandle = new IQuery('order as o');
		$orderHandle->order  = "o.id desc";
		$orderHandle->fields = "o.*,p.name as payment_name";
		$orderHandle->join   = "left join payment as p on p.id = o.pay_type";
		$orderHandle->where  = $where;
		$orderList = $orderHandle->find();

		$reportObj = new report('order');
		$reportObj->setTitle(array("订单编号","日期","收货人","电话","订单金额","实际支付","支付方式","支付状态","发货状态","商品信息"));

		foreach($orderList as $k => $val)
		{
			$orderGoods = Order_class::getOrderGoods($val['id']);
			$strGoods   = "";
			foreach($orderGoods as $good)
			{
				$strGoods .= "商品编号：".$good['goodsno']." 商品名称：".$good['name'];
				if ($good['value']!='') $strGoods .= " 规格：".$good['value'];
				$strGoods .= "<br />";
			}

			$insertData = array(
				$val['order_no'],
				$val['create_time'],
				$val['accept_name'],
				$val['telphone'].'&nbsp;'.$val['mobile'],
				$val['payable_amount'],
				$val['real_amount'],
				$val['payment_name'],
				Order_Class::getOrderPayStatusText($val),
				Order_Class::getOrderDistributionStatusText($val),
				$strGoods,
			);
			$reportObj->setData($insertData);
		}
		$reportObj->toDownload();
	}

	//修改商户信息
	public function seller_edit()
	{
		$seller_id = $this->seller['seller_id'];
		$sellerDB        = new IModel('seller');
		$this->sellerRow = $sellerDB->getObj('id = '.$seller_id);
		$jsonregion = json_encode(area::getJsonArea());
		$this->setRenderData(array('regiondata' => $jsonregion));
		$this->title = '基本信息';
		$this->redirect('seller_edit');
	}

	//修改商户信息
	public function seller_edit3()
	{
		$seller_id = $this->seller['seller_id'];
		$sellerDB        = new IModel('seller');
		$this->sellerRow = $sellerDB->getObj('id = '.$seller_id);
		$this->title = '功能设置';
		$this->redirect('seller_edit3');
	}

	public function seller_edit4()
	{
		$seller_id = $this->seller['seller_id'];
		$sellerDB        = new IModel('seller');
		$this->sellerRow = $sellerDB->getObj('id = '.$seller_id);
		$this->title = '结算账户';
		$this->redirect('seller_edit4');
	}

	public function seller_edit5()
	{
		$seller_id = $this->seller['seller_id'];
		$sellerDB        = new IModel('seller');
		$this->sellerRow = $sellerDB->getObj('id = '.$seller_id);
		$this->title = '账户安全';
		$this->redirect('seller_edit5');
	}

	public function seller_edit6()
	{
		$seller_id = $this->seller['seller_id'];
		$sellerDB        = new IModel('seller');
		$this->sellerRow = $sellerDB->getObj('id = '.$seller_id);
		$this->title = '认证信息';
		$this->redirect('seller_edit6');
	}

	/**
	 * @brief 商户的增加动作
	 */
	public function seller_add()
	{
		$seller_id   = $this->seller['seller_id'];
		$email       = IFilter::act(IReq::get('email'));
		$password    = IFilter::act(IReq::get('password'));
		$repassword  = IFilter::act(IReq::get('repassword'));
		$phone       = IFilter::act(IReq::get('phone'));
		$mobile      = IFilter::act(IReq::get('mobile'));
		$province    = IFilter::act(IReq::get('province'),'int');
		$city        = IFilter::act(IReq::get('city'),'int');
		$area        = IFilter::act(IReq::get('area'),'int');
		$address     = IFilter::act(IReq::get('address'));
		$account     = IFilter::act(IReq::get('account'));
		$server_num  = IFilter::act(IReq::get('server_num'));
		$home_url    = IFilter::act(IReq::get('home_url'));
		$tax         = IFilter::act(IReq::get('tax'),'float');
		//$charge         = IFilter::act(IReq::get('charge'),'float');

		if(!$seller_id && $password == '')
		{
			$errorMsg = '请输入密码！';
		}

		if($password != $repassword)
		{
			$errorMsg = '两次输入的密码不一致！';
		}

		//操作失败表单回填
		if(isset($errorMsg))
		{
			$this->sellerRow = $_POST;
			$this->redirect('seller_edit',false);
			Util::showMessage($errorMsg);
		}

		//待更新的数据
		$sellerRow = array(
			'account'   => $account,
			'phone'     => $phone,
			'mobile'    => $mobile,
			'email'     => $email,
			'address'   => $address,
			'province'  => $province,
			'city'      => $city,
			'area'      => $area,
			'server_num'=> $server_num,
			'home_url'  => $home_url,
			'tax'      => $tax,
			//'charge'	=>	$charge, 
		);

		//logo图片处理
		if(isset($_FILES['logo']['name']) && $_FILES['logo']['name']!='')
		{
			$uploadObj = new PhotoUpload();
			$uploadObj->setIterance(false);
			$photoInfo = $uploadObj->run();
			if(isset($photoInfo['logo']['img']) && file_exists($photoInfo['logo']['img']))
			{
				$sellerRow['logo'] = $photoInfo['logo']['img'];
			}
		}

		//创建商家操作类
		$sellerDB   = new IModel("seller");

		//修改密码
		if($password)
		{
			$sellerRow['password'] = md5($password);
		}

		$sellerDB->setData($sellerRow);
		$sellerDB->update("id = ".$seller_id);

		$this->redirect('seller_edit');
	}


	public function seller_add3()
	{
		$seller_id   = $this->seller['seller_id'];
		$is_support_zxkt        = IFilter::act(IReq::get('is_support_zxkt'),'int');
		$is_support_dp        = IFilter::act(IReq::get('is_support_dp'),'int');
		$is_virtual        = IFilter::act(IReq::get('is_virtual'),'int');
		$is_vote        = IFilter::act(IReq::get('is_vote'),'int');

		//创建商家操作类
		$sellerDB = new IModel("seller");

		//操作失败表单回填
		if(isset($errorMsg))
		{
			$this->sellerRow = $_POST;
			$this->redirect('seller_edit3',false);
			Util::showMessage($errorMsg);
		}

		//待更新的数据
		$sellerRow = array(
			'is_support_zxkt'      => $is_support_zxkt,
			'is_support_dp'      => $is_support_dp,
			'is_virtual'      => $is_virtual,
			'is_vote'      => $is_vote,
		);

		$sellerDB->setData($sellerRow);
		$sellerDB->update("id = ".$seller_id);		
		$this->redirect('seller_edit3');
	}

	public function seller_add4()
	{
		$seller_id   = $this->seller['seller_id'];	
		$account_bank_name    = IFilter::act(IReq::get('account_bank_name'));
		$account_name        = IFilter::act(IReq::get('account_name'));
		$account_bank_branch = IFilter::act(IReq::get('account_bank_branch'));
		$account_cart_no        = IFilter::act(IReq::get('account_cart_no'));
		$cash        = IFilter::act(IReq::get('cash'),'float');
		$deposit        = IFilter::act(IReq::get('deposit'),'float');

		//创建商家操作类
		$sellerDB = new IModel("seller");

		//操作失败表单回填
		if(isset($errorMsg))
		{
			$this->sellerRow = $_POST;
			$this->redirect('seller_edit4',false);
			Util::showMessage($errorMsg);
		}

		//待更新的数据
		$sellerRow = array(
			'cash'      => $cash,
			'account_bank_name'      => $account_bank_name,
			'account_name'      => $account_name,
			'deposit'      => $deposit,
			'account_cart_no'      => $account_cart_no,
		    'account_bank_branch' =>  $account_bank_branch,
		);

		$sellerDB->setData($sellerRow);
		$sellerDB->update("id = ".$seller_id);		
		$this->redirect('seller_edit4');
	}


	public function seller_add5()
	{
		$seller_id   = $this->seller['seller_id'];	
		$password    = IFilter::act(IReq::get('password'));
		$repassword    = IFilter::act(IReq::get('repassword'));
		$draw_password    = IFilter::act(IReq::get('draw_password'));
		$re_draw_password    = IFilter::act(IReq::get('re_draw_password'));
		$mobile    = IFilter::act(IReq::get('mobile'));
		
		//创建商家操作类
		$sellerDB = new IModel("seller");

		if( $password && $password != $repassword ){
			$errorMsg = "两次输入的密码不一致！";
		}

		if( $draw_password && $draw_password != $re_draw_password ){
			$errorMsg = "两次输入的取款密码不一致！";
		}

		//操作失败表单回填
		if(isset($errorMsg))
		{
			$this->sellerRow = $_POST;
			$this->redirect('seller_edit5',false);
			Util::showMessage($errorMsg);
		}

		//待更新的数据
		$sellerRow = array(
			'mobile'      => $mobile,
		);

		if($password){
			$sellerRow['password'] = md5($password);
		}
		if($draw_password){
			$sellerRow['draw_password'] = md5($draw_password);
		}

		$sellerDB->setData($sellerRow);
		$sellerDB->update("id = ".$seller_id);
		
	 
		//更改微信user表数据
		$conn=mysqli_connect("localhost","lelele999net","lelele999net");
		mysqli_select_db($conn,"lelele999net");
		mysqli_query($conn,"set names UTF8");
		//如果了修改密码
		if($sellerRow['password']){
		$sql="update `wp_user` set `password` = '{$sellerRow['password']}',
	    `truename`='{$sellerRow['true_name']}',`password`='{$sellerRow['password']}',
		`mobile`='{$sellerRow['mobile']}' where `nickname`='{$sellerDBinfo['seller_name']}'";
		}
		//如果没有修改密码
		$sql="update `wp_user` set `password` = '{$sellerRow['password']}',
	    `truename`='{$sellerRow['true_name']}',`mobile`='{$sellerRow['mobile']}' where `nickname`='{$sellerDBinfo['seller_name']}'";
		$res=mysqli_query($conn,$sql);
		$this->redirect('seller_edit5');
	}

	public function seller_add6()
	{
		$seller_id   = $this->seller['seller_id'];	
		$truename    = IFilter::act(IReq::get('true_name'));
		$papersn    = IFilter::act(IReq::get('papersn'));
		$legal    = IFilter::act(IReq::get('legal'));
		$cardsn    = IFilter::act(IReq::get('cardsn'));
		$safe_mobile    = IFilter::act(IReq::get('safe_mobile'));
		$contacter    = IFilter::act(IReq::get('contacter'));
		$contactcardsn    = IFilter::act(IReq::get('contactcardsn'));

		//创建商家操作类
		$sellerDB = new IModel("seller");

		//操作失败表单回填
		if(isset($errorMsg))
		{
			$this->sellerRow = $_POST;
			$this->redirect('seller_edit6',false);
			Util::showMessage($errorMsg);
		}

		//待更新的数据
		$sellerRow = array(
			'true_name' => $truename,
			'papersn' => $papersn,
			'legal' => $legal,
			'cardsn' => $cardsn,
			'safe_mobile' => $safe_mobile,
			'contacter' => $contacter,
			'contactcardsn' => $contactcardsn,		
		);

		$uploadObj = new PhotoUpload();
		$uploadObj->setIterance(false);
		$photoInfo = $uploadObj->run();

		//商户资质上传
		if(isset($_FILES['paper_img']['name']) && $_FILES['paper_img']['name'])
		{
			if(isset($photoInfo['paper_img']['img']) && file_exists($photoInfo['paper_img']['img']))
			{
				$sellerRow['paper_img'] = $photoInfo['paper_img']['img'];
			}
		}
		if(isset($_FILES['upphoto']['name']) && $_FILES['upphoto']['name'])
		{
			if(isset($photoInfo['upphoto']['img']) && file_exists($photoInfo['upphoto']['img']))
			{
				$sellerRow['upphoto'] = $photoInfo['upphoto']['img'];
			}
		}
		if(isset($_FILES['downphoto']['name']) && $_FILES['downphoto']['name'])
		{
			if(isset($photoInfo['downphoto']['img']) && file_exists($photoInfo['downphoto']['img']))
			{
				$sellerRow['downphoto'] = $photoInfo['downphoto']['img'];
			}
		}
		if(isset($_FILES['cupphoto']['name']) && $_FILES['cupphoto']['name'])
		{
			if(isset($photoInfo['cupphoto']['img']) && file_exists($photoInfo['cupphoto']['img']))
			{
				$sellerRow['cupphoto'] = $photoInfo['cupphoto']['img'];
			}
		}
		if(isset($_FILES['cdownphoto']['name']) && $_FILES['cdownphoto']['name'])
		{
			if(isset($photoInfo['cdownphoto']['img']) && file_exists($photoInfo['cdownphoto']['img']))
			{
				$sellerRow['cdownphoto'] = $photoInfo['cdownphoto']['img'];
			}
		}	

		$sellerDB->setData($sellerRow);
		$sellerDB->update("id = ".$seller_id);
		$this->redirect('seller_edit6');
	}

	//[团购]添加修改[单页]
	function regiment_edit()
	{
		$id = IFilter::act(IReq::get('id'),'int');

		if($id)
		{
			$regimentObj = new IModel('regiment');
			$where       = 'id = '.$id.' and seller_id = '.$this->seller['seller_id'];
			$regimentRow = $regimentObj->getObj($where);
			if(!$regimentRow)
			{
				$this->redirect('regiment_list');
			}

			//促销商品
			$goodsObj = new IModel('goods');
			$goodsRow = $goodsObj->getObj('id = '.$regimentRow['goods_id']);

			$result = array(
				'isError' => false,
				'data'    => $goodsRow,
			);
			$regimentRow['goodsRow'] = JSON::encode($result);
			$this->regimentRow = $regimentRow;
		}
		$this->redirect('regiment_edit');
	}

	//[团购]删除
	function regiment_del()
	{
		$id = IFilter::act(IReq::get('id'),'int');
		if($id)
		{
			$regObj = new IModel('regiment');
			if(is_array($id))
			{
				$id    = join(',',$id);
			}
			$where = ' id in ('.$id.') and seller_id = '.$this->seller['seller_id'];
			$regObj->del($where);
			$this->redirect('regiment_list');
		}
		else
		{
			$this->redirect('regiment_list',false);
			Util::showMessage('请选择要删除的id值');
		}
	}

	//[团购]添加修改[动作]
	function regiment_edit_act()
	{
		$id      = IFilter::act(IReq::get('id'),'int');
		$goodsId = IFilter::act(IReq::get('goods_id'),'int');

		$dataArray = array(
			'id'        	=> $id,
			'title'     	=> IFilter::act(IReq::get('title','post')),
			'start_time'	=> IFilter::act(IReq::get('start_time','post')),
			'end_time'  	=> IFilter::act(IReq::get('end_time','post')),
			'is_close'      => 1,
			'intro'     	=> IFilter::act(IReq::get('intro','post')),
			'goods_id'      => $goodsId,
			'store_nums'    => IFilter::act(IReq::get('store_nums','post')),
			'limit_min_count' => IFilter::act(IReq::get('limit_min_count','post'),'int'),
			'limit_max_count' => IFilter::act(IReq::get('limit_max_count','post'),'int'),
			'regiment_price'=> IFilter::act(IReq::get('regiment_price','post')),
			'seller_id'     => $this->seller['seller_id'],
		);

		$dataArray['limit_min_count'] = $dataArray['limit_min_count'] <= 0 ? 1 : $dataArray['limit_min_count'];
		$dataArray['limit_max_count'] = $dataArray['limit_max_count'] <= 0 ? $dataArray['store_nums'] : $dataArray['limit_max_count'];

		if($goodsId)
		{
			$goodsObj = new IModel('goods');
			$where    = 'id = '.$goodsId.' and seller_id = '.$this->seller['seller_id'];
			$goodsRow = $goodsObj->getObj($where);

			//商品信息不存在
			if(!$goodsRow)
			{
				$this->regimentRow = $dataArray;
				$this->redirect('regiment_edit',false);
				Util::showMessage('请选择商户自己的商品');
			}

			//处理上传图片
			if(isset($_FILES['img']['name']) && $_FILES['img']['name'] != '')
			{
				$uploadObj = new PhotoUpload();
				$photoInfo = $uploadObj->run();
				$dataArray['img'] = $photoInfo['img']['img'];
			}
			else
			{
				$dataArray['img'] = $goodsRow['img'];
			}

			$dataArray['sell_price'] = $goodsRow['sell_price'];
		}
		else
		{
			$this->regimentRow = $dataArray;
			$this->redirect('regiment_edit',false);
			Util::showMessage('请选择要关联的商品');
		}

		$regimentObj = new IModel('regiment');
		$regimentObj->setData($dataArray);

		if($id)
		{
			$where = 'id = '.$id.' and seller_id = '.$this->seller['seller_id'];
			$regimentObj->update($where);
		}
		else
		{
			$regimentObj->add();
		}
		$this->redirect('regiment_list');
	}

	//结算单修改
	public function bill_edit()
	{
		$id = IFilter::act(IReq::get('id'),'int');
		$billRow = array();

		if($id)
		{
			$billDB  = new IModel('bill');
			$billRow = $billDB->getObj('id = '.$id.' and seller_id = '.$this->seller['seller_id']);
		}

		$this->billRow = $billRow;
		$this->redirect('bill_edit');
	}

	//结算单删除
	public function bill_del()
	{
		$id = IFilter::act(IReq::get('id'),'int');

		if($id)
		{
			$billDB = new IModel('bill');
			$billDB->del('id = '.$id.' and seller_id = '.$this->seller['seller_id'].' and is_pay = 0');
		}

		$this->redirect('bill_list');
	}

	//结算单更新
	public function bill_update()
	{
		$id            = IFilter::act(IReq::get('id'),'int');
		$start_time    = IFilter::act(IReq::get('start_time'));
		$end_time      = IFilter::act(IReq::get('end_time'));
		$apply_content = IFilter::act(IReq::get('apply_content'));

		$billDB = new IModel('bill');

		if($id)
		{
			$billRow = $billDB->getObj('id = '.$id);
			if($billRow['is_pay'] == 0)
			{
				$billDB->setData(array('apply_content' => $apply_content));
				$billDB->update('id = '.$id.' and seller_id = '.$this->seller['seller_id']);
			}
		}
		else
		{
			//判断是否存在未处理的申请
			$isSubmitBill = $billDB->getObj(" seller_id = ".$this->seller['seller_id']." and is_pay = 0");
			if($isSubmitBill)
			{
				$this->redirect('bill_list',false);
				Util::showMessage('请耐心等待管理员结算后才能再次提交申请');
			}

			//获取未结算的订单
			$queryObject = CountSum::getSellerGoodsFeeQuery($this->seller['seller_id'],$start_time,$end_time,0);
			$countData   = CountSum::countSellerOrderFee($queryObject->find());

			if($countData['countFee'] > 0)
			{
				$countData['start_time'] = $start_time;
				$countData['end_time']   = $end_time;

				$billString = AccountLog::sellerBillTemplate($countData);
				$data = array(
					'seller_id'     => $this->seller['seller_id'],
					'apply_time'    => ITime::getDateTime(),
					'apply_content' => IFilter::act(IReq::get('apply_content')),
					'start_time'    => $start_time,
					'end_time'      => $end_time,
					'log'           => $billString,
					'order_ids'     => join(",",$countData['order_ids']),
					'amount'        => $countData['countFee'],
				);
				$billDB->setData($data);
				$billDB->add();
			}
			else
			{
				$this->redirect('bill_list',false);
				Util::showMessage('当前时间段内没有任何结算货款');
			}
		}
		$this->redirect('bill_list');
	}

	//计算应该结算的货款明细
	public function countGoodsFee()
	{
		$seller_id   = $this->seller['seller_id'];
		$start_time  = IFilter::act(IReq::get('start_time'));
		$end_time    = IFilter::act(IReq::get('end_time'));

		$queryObject = CountSum::getSellerGoodsFeeQuery($seller_id,$start_time,$end_time,0);
		$countData   = CountSum::countSellerOrderFee($queryObject->find());

		if($countData['countFee'] > 0)
		{
			$countData['start_time'] = $start_time;
			$countData['end_time']   = $end_time;

			$billString = AccountLog::sellerBillTemplate($countData);
			$result     = array('result' => 'success','data' => $billString);
		}
		else
		{
			$result = array('result' => 'fail','data' => '当前没有任何款项可以结算');
		}

		die(JSON::encode($result));
	}

	/**
	 * @brief 显示评论信息
	 */
	function comment_edit()
	{
		$cid = IFilter::act(IReq::get('cid'),'int');

		if(!$cid)
		{
			$this->comment_list();
			return false;
		}
		$query = new IQuery("comment as c");
		$query->join = "left join goods as goods on c.goods_id = goods.id left join user as u on c.user_id = u.id";
		$query->fields = "c.*,u.username,goods.name,goods.seller_id";
		$query->where = "c.id=".$cid." and goods.seller_id = ".$this->seller['seller_id'];
		$items = $query->find();

		if($items)
		{
			$this->comment = current($items);
			$this->redirect('comment_edit');
		}
		else
		{
			$this->comment_list();
			$msg = '没有找到相关记录！';
			Util::showMessage($msg);
		}
	}

	/**
	 * @brief 回复评论
	 */
	function comment_update()
	{
		$id = IFilter::act(IReq::get('id'),'int');
		$recontent = IFilter::act(IReq::get('recontents'));
		if($id)
		{
			$commentDB = new IQuery('comment as c');
			$commentDB->join = 'left join goods as go on go.id = c.goods_id';
			$commentDB->where= 'c.id = '.$id.' and go.seller_id = '.$this->seller['seller_id'];
			$checkList = $commentDB->find();
			if(!$checkList)
			{
				IError::show(403,'该商品不属于您，无法对其评论进行回复');
			}

			$updateData = array(
				'recontents' => $recontent,
				'recomment_time' => ITime::getDateTime(),
			);
			$commentDB = new IModel('comment');
			$commentDB->setData($updateData);
			$commentDB->update('id = '.$id);
		}
		$this->redirect('comment_list');
	}

	//商品退款详情
	function refundment_show()
	{
	 	//获得post传来的退款单id值
	 	$refundment_id = IFilter::act(IReq::get('id'),'int');
	 	$data = array();
	 	if($refundment_id)
	 	{
	 		$tb_refundment = new IQuery('refundment_doc as c');
	 		$tb_refundment->join=' left join order as o on c.order_id=o.id left join user as u on u.id = c.user_id';
	 		$tb_refundment->fields = 'u.username,c.*,o.*,c.id as id,c.pay_status as pay_status';
	 		$tb_refundment->where = 'c.id='.$refundment_id.' and c.seller_id = '.$this->seller['seller_id'];
	 		$refundment_info = $tb_refundment->find();
	 		if($refundment_info)
	 		{
	 			$data = current($refundment_info);
	 			$this->data = $data;
	 			$this->setRenderData($data);
	 			$this->redirect('refundment_show',false);
	 		}
	 	}

	 	if(!$data)
		{
			$this->redirect('refundment_list');
		}
	}

	//商品退款操作
	function refundment_update()
	{
		$id           = IFilter::act(IReq::get('id'),'int');
		$pay_status   = IFilter::act(IReq::get('pay_status'),'int');
		$dispose_idea = IFilter::act(IReq::get('dispose_idea'));
		$amount       = IFilter::act(IReq::get('amount'),'float');

		if(!$pay_status)
		{
			die('选择处理状态');
		}

		//商户处理退款
		if($id && Order_Class::isSellerRefund($id,$this->seller['seller_id']) == 2)
		{
			$updateData = array(
				'dispose_time' => ITime::getDateTime(),
				'dispose_idea' => $dispose_idea,
				'pay_status'   => $pay_status,
				'amount'       => $amount,
			);
			$tb_refundment_doc = new IModel('refundment_doc');
			$tb_refundment_doc->setData($updateData);
			$tb_refundment_doc->update('id = '.$id);

			if($pay_status == 2)
			{
				$result = Order_Class::refund($id,$this->seller['seller_id'],'seller');
				if(is_string($result))
				{
					$tb_refundment_doc->rollback();
					die($result);
				}
			}
		}
		$this->redirect('refundment_list');
	}

	//商品复制
	function goods_copy()
	{
		$idArray = explode(',',IReq::get('id'));
		$idArray = IFilter::act($idArray,'int');

		$goodsDB     = new IModel('goods');
		$goodsAttrDB = new IModel('goods_attribute');
		$goodsPhotoRelationDB = new IModel('goods_photo_relation');
		$productsDB = new IModel('products');

		$goodsData = $goodsDB->query('id in ('.join(',',$idArray).') and is_share = 1 and is_del = 0 and seller_id = 0','*');
		if($goodsData)
		{
			foreach($goodsData as $key => $val)
			{
				//判断是否重复
				if( $goodsDB->getObj('seller_id = '.$this->seller['seller_id'].' and name = "'.$val['name'].'"') )
				{
					die('商品不能重复复制');
				}

				$oldId = $val['id'];

				//商品数据
				unset($val['id'],$val['visit'],$val['favorite'],$val['sort'],$val['comments'],$val['sale'],$val['grade'],$val['is_share']);
				$val['seller_id'] = $this->seller['seller_id'];
				$val['goods_no'] .= '-'.$this->seller['seller_id'];
				$val['name']      = IFilter::act($val['name'],'text');
				$val['content']   = IFilter::act($val['content'],'text');

				$goodsDB->setData($val);
				$goods_id = $goodsDB->add();

				//商品属性
				$attrData = $goodsAttrDB->query('goods_id = '.$oldId);
				if($attrData)
				{
					foreach($attrData as $k => $v)
					{
						unset($v['id']);
						$v['goods_id'] = $goods_id;
						$goodsAttrDB->setData($v);
						$goodsAttrDB->add();
					}
				}

				//商品图片
				$photoData = $goodsPhotoRelationDB->query('goods_id = '.$oldId);
				if($photoData)
				{
					foreach($photoData as $k => $v)
					{
						unset($v['id']);
						$v['goods_id'] = $goods_id;
						$goodsPhotoRelationDB->setData($v);
						$goodsPhotoRelationDB->add();
					}
				}

				//货品
				$productsData = $productsDB->query('goods_id = '.$oldId);
				if($productsData)
				{
					foreach($productsData as $k => $v)
					{
						unset($v['id']);
						$v['products_no'].= '-'.$this->seller['seller_id'];
						$v['goods_id']    = $goods_id;
						$productsDB->setData($v);
						$productsDB->add();
					}
				}
			}
			die('success');
		}
		else
		{
			die('复制的商品不存在');
		}
	}

	/**
	 * @brief 添加/修改发货信息
	 */
	public function ship_info_edit()
	{
		// 获取POST数据
    	$id = IFilter::act(IReq::get("sid"),'int');
    	if($id)
    	{
    		$tb_ship   = new IModel("merch_ship_info");
    		$ship_info = $tb_ship->getObj("id=".$id." and seller_id = ".$this->seller['seller_id']);
    		if($ship_info)
    		{
    			$this->data = $ship_info;
    		}
    		else
    		{
    			die('数据不存在');
    		}
    	}
    	$this->setRenderData($this->data);
		$this->redirect('ship_info_edit');
	}
	/**
	 * @brief 设置发货信息的默认值
	 */
	public function ship_info_default()
	{
		$id = IFilter::act( IReq::get('id'),'int' );
        $default = IFilter::string(IReq::get('default'));
        $tb_merch_ship_info = new IModel('merch_ship_info');
        if($default == 1)
        {
            $tb_merch_ship_info->setData(array('is_default'=>0));
            $tb_merch_ship_info->update("seller_id = ".$this->seller['seller_id']);
        }
        $tb_merch_ship_info->setData(array('is_default' => $default));
        $tb_merch_ship_info->update("id = ".$id." and seller_id = ".$this->seller['seller_id']);
        $this->redirect('ship_info_list');
	}
	/**
	 * @brief 保存添加/修改发货信息
	 */
	public function ship_info_update()
	{
		// 获取POST数据
    	$id = IFilter::act(IReq::get('sid'),'int');
    	$ship_name = IFilter::act(IReq::get('ship_name'));
    	$ship_user_name = IFilter::act(IReq::get('ship_user_name'));
    	$sex = IFilter::act(IReq::get('sex'),'int');
    	$province =IFilter::act(IReq::get('province'),'int');
    	$city = IFilter::act(IReq::get('city'),'int');
    	$area = IFilter::act(IReq::get('area'),'int');
    	$address = IFilter::act(IReq::get('address'));
    	$postcode = IFilter::act(IReq::get('postcode'),'int');
    	$mobile = IFilter::act(IReq::get('mobile'));
    	$telphone = IFilter::act(IReq::get('telphone'));
    	$is_default = IFilter::act(IReq::get('is_default'),'int');

    	$tb_merch_ship_info = new IModel('merch_ship_info');

    	//判断是否已经有了一个默认地址
    	if(isset($is_default) && $is_default==1)
    	{
    		$tb_merch_ship_info->setData(array('is_default' => 0));
    		$tb_merch_ship_info->update('seller_id = 0');
    	}
    	//设置存储数据
    	$arr['ship_name'] = $ship_name;
	    $arr['ship_user_name'] = $ship_user_name;
	    $arr['sex'] = $sex;
    	$arr['province'] = $province;
    	$arr['city'] =$city;
    	$arr['area'] =$area;
    	$arr['address'] = $address;
    	$arr['postcode'] = $postcode;
    	$arr['mobile'] = $mobile;
    	$arr['telphone'] =$telphone;
    	$arr['is_default'] = $is_default;
    	$arr['is_del'] = 1;
    	$arr['seller_id'] = $this->seller['seller_id'];

    	$tb_merch_ship_info->setData($arr);
    	//判断是添加还是修改
    	if($id)
    	{
    		$tb_merch_ship_info->update('id='.$id." and seller_id = ".$this->seller['seller_id']);
    	}
    	else
    	{
    		$tb_merch_ship_info->add();
    	}
		$this->redirect('ship_info_list');
	}
	/**
	 * @brief 删除发货信息到回收站中
	 */
	public function ship_info_del()
	{
		// 获取POST数据
    	$id = IFilter::act(IReq::get('id'),'int');
		//加载 商家发货点信息
    	$tb_merch_ship_info = new IModel('merch_ship_info');
		if($id)
		{
			$tb_merch_ship_info->del(Util::joinStr($id)." and seller_id = ".$this->seller['seller_id']);
			$this->redirect('ship_info_list');
		}
		else
		{
			$this->redirect('ship_info_list',false);
			Util::showMessage('请选择要删除的数据');
		}
	}

	/**
	 * @brief 配送方式修改
	 */
    public function delivery_edit()
	{
		$data = array();
        $delivery_id = IFilter::act(IReq::get('id'),'int');

        if($delivery_id)
        {
            $delivery = new IModel('delivery_extend');
            $data = $delivery->getObj('delivery_id = '.$delivery_id.' and seller_id = '.$this->seller['seller_id']);
		}
		else
		{
			die('配送方式');
		}

		//获取省份
		$areaData = array();
		$areaDB = new IModel('areas');
		$areaList = $areaDB->query('parent_id = 0');
		foreach($areaList as $val)
		{
			$areaData[$val['area_id']] = $val['area_name'];
		}
		$this->areaList  = $areaList;
		$this->data_info = $data;
		$this->area      = $areaData;
        $this->redirect('delivery_edit');
	}

	/**
	 * 配送方式修改
	 */
    public function delivery_update()
    {
        //首重重量
        $first_weight = IFilter::act(IReq::get('first_weight'),'float');
        //续重重量
        $second_weight = IFilter::act(IReq::get('second_weight'),'float');
        //首重价格
        $first_price = IFilter::act(IReq::get('first_price'),'float');
        //续重价格
        $second_price = IFilter::act(IReq::get('second_price'),'float');
        //是否支持物流保价
        $is_save_price = IFilter::act(IReq::get('is_save_price'),'int');
        //地区费用类型
        $price_type = IFilter::act(IReq::get('price_type'),'int');
        //启用默认费用
        $open_default = IFilter::act(IReq::get('open_default'),'int');
        //支持的配送地区ID
        $area_groupid = serialize(IReq::get('area_groupid'));
        //配送地址对应的首重价格
        $firstprice = serialize(IReq::get('firstprice'));
        //配送地区对应的续重价格
        $secondprice = serialize(IReq::get('secondprice'));
        //保价费率
        $save_rate = IFilter::act(IReq::get('save_rate'),'float');
        //最低保价
        $low_price = IFilter::act(IReq::get('low_price'),'float');
		//配送ID
        $delivery_id = IFilter::act(IReq::get('deliveryId'),'int');

        $deliveryDB  = new IModel('delivery');
        $deliveryRow = $deliveryDB->getObj('id = '.$delivery_id);
        if(!$deliveryRow)
        {
        	die('配送方式不存在');
        }

        //如果选择指定地区配送就必须要选择地区
        if($price_type == 1 && !$area_groupid)
        {
			die('请设置配送地区');
        }

        $data = array(
        	'first_weight' => $first_weight,
        	'second_weight'=> $second_weight,
        	'first_price'  => $first_price,
        	'second_price' => $second_price,
        	'is_save_price'=> $is_save_price,
        	'price_type'   => $price_type,
        	'open_default' => $open_default,
        	'area_groupid' => $area_groupid,
        	'firstprice'   => $firstprice,
        	'secondprice'  => $secondprice,
        	'save_rate'    => $save_rate,
        	'low_price'    => $low_price,
        	'seller_id'    => $this->seller['seller_id'],
        	'delivery_id'  => $delivery_id,
        );
        $deliveryExtendDB = new IModel('delivery_extend');
        $deliveryExtendDB->setData($data);
        $deliveryObj = $deliveryExtendDB->getObj("delivery_id = ".$delivery_id." and seller_id = ".$this->seller['seller_id']);
        //已经存在了
        if($deliveryObj)
        {
        	$deliveryExtendDB->update('delivery_id = '.$delivery_id.' and seller_id = '.$this->seller['seller_id']);
        }
        else
        {
        	$deliveryExtendDB->add();
        }
		$this->redirect('delivery');
    }

	//[促销活动] 添加修改 [单页]
	function pro_rule_edit()
	{
		$id = IFilter::act(IReq::get('id'),'int');
		if($id)
		{
			$promotionObj = new IModel('promotion');
			$where = 'id = '.$id.' and seller_id='.$this->seller['seller_id'];
			$this->promotionRow = $promotionObj->getObj($where);
		}
		$this->redirect('pro_rule_edit');
	}

	//[促销活动] 添加修改 [动作]
	function pro_rule_edit_act()
	{
		$id           = IFilter::act(IReq::get('id'),'int');
		$user_group   = IFilter::act(IReq::get('user_group','post'));
		$promotionObj = new IModel('promotion');
		if(is_string($user_group))
		{
			$user_group_str = $user_group;
		}
		else
		{
			$user_group_str = ",".join(',',$user_group).",";
		}

		$dataArray = array(
			'name'       => IFilter::act(IReq::get('name','post')),
			'condition'  => IFilter::act(IReq::get('condition','post')),
			'is_close'   => IFilter::act(IReq::get('is_close','post')),
			'start_time' => IFilter::act(IReq::get('start_time','post')),
			'end_time'   => IFilter::act(IReq::get('end_time','post')),
			'intro'      => IFilter::act(IReq::get('intro','post')),
			'award_type' => IFilter::act(IReq::get('award_type','post')),
			'type'       => 0,
			'user_group' => $user_group_str,
			'award_value'=> IFilter::act(IReq::get('award_value','post')),
			'seller_id'  => $this->seller['seller_id'],
		);

		if(!in_array($dataArray['award_type'],array(1,2,6)))
		{
			IError::show('促销类型不符合规范',403);
		}

		$promotionObj->setData($dataArray);

		if($id)
		{
			$where = 'id = '.$id;
			$promotionObj->update($where);
		}
		else
		{
			$promotionObj->add();
		}
		$this->redirect('pro_rule_list');
	}

	//[促销活动] 删除
	function pro_rule_del()
	{
		$id = IFilter::act(IReq::get('id'),'int');
		if(!empty($id))
		{
			$promotionObj = new IModel('promotion');
			if(is_array($id))
			{
				$idStr = join(',',$id);
				$where = ' id in ('.$idStr.')';
			}
			else
			{
				$where = 'id = '.$id;
			}
			$promotionObj->del($where.' and seller_id = '.$this->seller['seller_id']);
			$this->redirect('pro_rule_list');
		}
		else
		{
			$this->redirect('pro_rule_list',false);
			Util::showMessage('请选择要删除的促销活动');
		}
	}

	//修改订单价格
	public function order_discount()
	{
		$order_id = IFilter::act(IReq::get('order_id'),'int');
		$discount = IFilter::act(IReq::get('discount'),'float');
		$orderDB  = new IModel('order');
		$orderRow = $orderDB->getObj('id = '.$order_id.' and status = 1 and distribution_status = 0 and seller_id = '.$this->seller['seller_id']);
		if($orderRow)
		{
			//还原价格
			$newOrderAmount = ($orderRow['order_amount'] - $orderRow['discount']) + $discount;
			$newOrderAmount = $newOrderAmount <= 0 ? 0 : $newOrderAmount;
			$orderDB->setData(array('discount' => $discount,'order_amount' => $newOrderAmount));
			if($orderDB->update('id = '.$order_id))
			{
				die(JSON::encode(array('result' => true,'orderAmount' => $newOrderAmount)));
			}
		}
		die(JSON::encode(array('result' => false)));
	}

	// 消息通知
	public function message_list()
	{
		$page   = IReq::get('page') ? IFilter::act(IReq::get('page'),'int') : 1;
		$seller_messObject = new seller_mess($this->seller['seller_id']);
		$msgIds = $seller_messObject->getAllMsgIds();
		$msgIds = empty($msgIds) ? 0 : $msgIds;
		$needReadNum = $seller_messObject->needReadNum();

		$seller_messageHandle = new IQuery('seller_message');
		$seller_messageHandle->where = "id in(".$msgIds.")";
		$seller_messageHandle->order= "id desc";
		$seller_messageHandle->page = $page;

		$this->needReadNum = $needReadNum;
		$this->seller_messObject = $seller_messObject;
		$this->seller_messageHandle = $seller_messageHandle;

		$this->redirect("message_list");
	}

	// 消息详情
	public function message_show()
	{
		$id = IFilter::act(IReq::get('id'),'int');
		$messageRow = null;
		if($id)
		{
			$seller_messObject = new seller_mess($this->seller['seller_id']);
			$seller_messObject->writeMessage($id, 1);
			$messageRow = $seller_messObject->read($id);
		}

		if(!$messageRow)
		{
			die('信息不存在');
		}
		$this->setRenderData(array('messageRow' => $messageRow));
		$this->redirect('message_show');
	}

	// 消息删除
	public function message_del()
	{
		$id = IFilter::act(IReq::get('id'),'int');
		if (!empty($id))
		{
			$seller_messObject = new seller_mess($this->seller['seller_id']);
			if (is_array($id)) {
				foreach ($id as $val)
				{
					$seller_messObject->delMessage($val);
				}
			}else {
				$seller_messObject->delMessage($id);
			}
		}
		$this->redirect('message_list');
	}

	//订单备注
	public function order_note()
	{
	 	//获得post数据
	 	$order_id = IFilter::act(IReq::get('order_id'),'int');
	 	$note = IFilter::act(IReq::get('note'),'text');

	 	//获得order的表对象
	 	$tb_order =  new IModel('order');
	 	$tb_order->setData(array(
	 		'note'=>$note
	 	));
	 	$tb_order->update('id = '.$order_id.' and seller_id = '.$this->seller['seller_id']);
	 	$this->redirect("/seller/order_show/id/".$order_id,true);
	}

	/**
	 * @brief 删除咨询信息
	 */
	function refer_del()
	{
		$refer_ids = IFilter::act(IReq::get('id'),'int');
		$refer_ids = is_array($refer_ids) ? $refer_ids : array($refer_ids);
		if($refer_ids)
		{
			$ids = join(',',$refer_ids);
			if($ids)
			{
				//查询咨询的商品是否属于当前商户
				$referDB        = new IQuery('refer as re,goods as go');
				$referDB->where = "re.id in (".$ids.") and re.goods_id = go.id and go.seller_id = ".$this->seller['seller_id'];
				$referDB->fields= "re.id";
				$referGoods     = $referDB->find();
				$referModel     = new IModel('refer');
				foreach($referGoods as $reId)
				{
					$referModel->del("id = ".$reId['id']);
				}
			}
		}
		$this->redirect('refer_list');
	}


	/**
	 * @brief 修改品牌
	 */
	function brand_edit()
	{
		$seller_id   = $this->seller['seller_id'];
		$tb_seller = new IModel('seller');
		$seller_info = $tb_seller->getObj('id='.$seller_id);

        if($seller_info['brand_id']){
            $obj_brand = new IModel('brand');
            $brand_info = $obj_brand->getObj('id='.$seller_info['brand_id']);
            if($brand_info)
            {
                $brand_info['img'] = explode(',',$brand_info['img']);
                $brand_info['class_desc_img'] = explode(',',$brand_info['class_desc_img']);
                $brand_info['shop_desc_img'] = explode(',',$brand_info['shop_desc_img']);
                $this->data['brand'] = $brand_info;
            }
            else
            {
                $this->redirect('category_list');
                Util::showMessage("没有找到相关品牌分类！");
                return;
            }       

            $this->setRenderData($this->data);
        }		
		
        $this->title = '页面信息';
		$this->redirect('brand_edit');
	}


	/**
	 * @brief 保存品牌
	 */
	function brand_save()
	{
		$seller_id   = $this->seller['seller_id'];
		$brand_id = (int)IReq::get('brand_id');
		$name = IFilter::act(IReq::get('name'));
		$sort = IFilter::act(IReq::get('sort'),'int');
		$url = IFilter::act(IReq::get('url'));
		$category = IFilter::act(IReq::get('category'),'int');
		$description = IFilter::act(IReq::get('description'));

		$tb_brand = new IModel('brand');
		$brand = array(
			'name'=>$name,
			'sort'=>$sort,
			'url'=>$url,
			'description' => $description,
		);

		if($category && is_array($category))
		{
			$categorys = join(',',$category);
			$brand['category_ids'] = $categorys;
		}
		else
		{
			$brand['category_ids'] = '';
		}		

		$uploadButton = array(
			'logo' => isset($_POST['logo'])?$_POST['logo']:'',
			'pc_logo' => isset($_POST['pc_logo'])?$_POST['pc_logo']:'',
			'img' => isset($_POST['img'])?$_POST['img']:'',
			'class_desc_img' => isset($_POST['class_desc_img'])?$_POST['class_desc_img']:'',
			'shop_desc_img' => isset($_POST['shop_desc_img'])?$_POST['shop_desc_img']:'',
		);

		foreach($uploadButton as $key => $val){
			if($val){
				$_img = array();
				foreach($val as $k => $v){
					if(stristr($v,'base64')){
						$img_tmp = explode(',',$v);
						$img = base64_decode($img_tmp[1]);

						$filename = 'upload/'.date('Y/m/d').'/'.date('Ymdhis').rand(10000,99999).'.jpg';
						$re = file_put_contents('./'.$filename, $img);

						if($re){						
							$_img[] = $filename;
						}
					}else{
						$_img[] = $v;
					}
		
				}
				$brand[$key] = implode(',',$_img);
			}
		}
		
		$tb_brand->setData($brand);
		if($brand_id)
		{
			//保存修改分类信息
			$where = "id=".$brand_id;
			$tb_brand->update($where);
		}
		else
		{
			//添加新品牌
			$bid = $tb_brand->add();

			if($bid){
				$tb_seller = new IModel('seller');
				$tb_seller->setData(array('brand_id'=>$bid));
				$tb_seller->update('id='.$seller_id);
			}
		}
		$this->redirect('brand_edit');
	}
	
		public function order_verification()
	{
	    $this->title = '订单核销';
	    $this->redirect('order_verification');
	}
	
		// 订单核销
	public function order_verification_update()
	{
	    $seller_id = $this->seller['seller_id'];
	    $verification_code = IFilter::act(IReq::get('verification_code'),'int');
	
	    $order_goods_db = new IQuery('order_goods as og');
	    $order_goods_db->join = 'left join order as o on og.order_id = o.id';
	    $order_goods_db->fields = 'o.*,og.verification_code';
	    $order_goods_db->where = "og.verification_code = '$verification_code' and (o.seller_id = " . $seller_id . ' or o.seller_id = 366 or o.seller_id = 0)';
	    $order_goods_info = $order_goods_db->getOne();
	
	    if ( !$order_goods_info )
	    {
	        IError::show('验证码不存在',403);
	    } else {
	        if ( $order_goods_info['pay_status'] != 1)
	        {
	            IError::show('操作失败，该订单未付款成功',403);
	        } else if ( $order_goods_info['status'] == 5) {
	            IError::show('操作失败，订单已完成，请勿重新操作',403);
	        }
	        	
	        if ( $order_goods_info['zuhe_id'] > 0 )
	        {
	            $brand_chit_zuhe_use_list_db = new IQuery('brand_chit_zuhe_use_list');
	            $brand_chit_zuhe_use_list_db->where = 'seller_id = ' . $seller_id . ' and order_id = ' . $order_goods_info['id'] . ' and availeble_use_times > 0';
	            $detail_info = $brand_chit_zuhe_use_list_db->getOne();
	            if ( !$detail_info )
	            {
	                IError::show('验证码不存在2',403);
	            }
	
	            $data = array(
	                'availeble_use_times' => $detail_info['availeble_use_times'] - 1,
	            );
	
	            $brand_chit_zuhe_use_list_db = new IModel('brand_chit_zuhe_use_list');
	            $brand_chit_zuhe_use_list_db->setData($data);
	            $brand_chit_zuhe_use_list_db->update('id = ' . $detail_info['id']);
	
	            // 结算给商户
	            Bill_class::add_sale($detail_info['seller_id'], floor($detail_info['commission'] / $detail_info['use_times']));
	
	            $order_goods_db = new IModel('order_goods');
	            $order_goods_db->setData(array(
	                'verification_code' => Order_goods_class::get_verification_code(),
	            ));
	            $order_goods_db->update('order_id = ' . $order_goods_info['id']);
	
	            die("<script>alert('核销成功');location.href = '/seller/order_verification';</script>");
	        }
	         
	        // 订单核销
	        header("location: " . IUrl::creatUrl('/seller/order_prop_verification/order_id/' . $order_goods_info['id'] . '/code/' . $verification_code));
	    }
	}
	
	function order_prop_verification()
	{
	    $seller_id = $this->seller['seller_id'];
	    $order_id = IFilter::act(IReq::get('order_id'),'int');
	    $code = IFilter::act(IReq::get('code'),'int');
	    $order_info = order_class::get_order_info($order_id);
	    $order_goods_list = Order_goods_class::get_order_goods_list($order_id);
	    $order_goods_list = current($order_goods_list);
	    $order_goods_list['goods_array'] = json_decode($order_goods_list['goods_array']);
	     
	    if ( $order_info['chit_id'])
	        $chit_info = brand_chit_class::get_chit_info($order_info['chit_id']);
	
	    $this->setRenderData(array(
	        'order_info'   =>  $order_info,
	        'chit_info'    =>  $chit_info,
	        'order_goods_list'    =>  $order_goods_list,
	    ));
	     
	    $this->redirect('order_prop_verification');
	}
	
	// 验证码确认订单
	public function order_prop_verification_confirm()
	{
	    //获得post变量参数
	    $order_id = IFilter::act(IReq::get('id'),'int');
	    if ( !$order_id )
	    {
	        IError::show("参数不正确",403);
	    }
	
	    $order_info = order_class::get_order_info($order_id);
	
	    if ( !$order_info )
	    {
	        IError::show(403,'订单信息不存在');
	    }
	
	    if ( order_class::getOrderStatus( $order_info ) == 13 )
	    {
	        $order_db = new IModel('order');
	        $order_db->setData(array(
	            'is_confirm'   =>  1,
	        ));
	
	        if ( $order_db->update('id = ' . $order_id ) )
	        {
	            $mobile = $order_info['mobile'];
	            $seller_info = Seller_class::get_seller_info($order_info['seller_id'] );
	            $order_goods = Order_goods_class::get_order_goods_list( $order_id );
	        }
	
	        // 生成订单日志
	        order_log_class::add_log( $order_info['id'], 4 );
	
	        // 发货
	        $order_goods_list = Order_goods_class::get_order_goods_list($order_id);
	
	        if ( !$order_goods_list )
	        {
	            IError::show(403,'该订单下无任何课程');
	        }
	
	        foreach( $order_goods_list as $kk => $vv )
	        {
	            if ( $vv['is_send'] == 1)
	            {
	                IError::show(403,'该订单已确认，不能重复确认');
	            }
	        }
	         
	        $sendgoodsarr = array( $order_goods_list[0]['id'] );
	        $result=Order_Class::sendDeliveryGoods($order_id,$sendgoodsarr,$this->seller['seller_id'],'seller');
	         
	        // 订单完成
	        $model = new IModel('order');
	        if ( $order_info['statement'] == 1)
	            $model->setData(array('status' => 5,'completion_time' => ITime::getDateTime()));
	        else if ( $order_info['statement'] == 2)
	            $model->setData(array('status' => 5,'used_seller_id' => $this->seller['seller_id'],'completion_time' => ITime::getDateTime()));
	        $user_id = $order_info['user_id'];
	        if($model->update("id = ".$order_id." and distribution_status = 1 and user_id = ".$user_id))
	        {
	            $orderRow = $order_info;
	
	            //确认收货后进行支付
	            Order_Class::updateOrderStatus($orderRow['order_no']);
	
	            //增加用户评论商品机会
	            Order_Class::addGoodsCommentChange($order_id);
	        }
	         
	        $code = $order_goods_list[0]['verification_code'];
	         
	        if ( IClient::getDevice() == IClient::MOBILE)
	        {
	            $this->show_message('核销成功','返回',"/seller/order_prop_verification/order_id/$order_id/code/$code");
	        } else {
	            $this->redirect("/seller/order_prop_verification/order_id/$order_id/code/$code");
	        }
	    } else {
	        IError::show(403,'操作失败!');
	    }
	
	}

	// 教师列表
	function teacher_list()
	{
	    $seller_id = $this->seller['seller_id'];
	    $page = max( IFilter::act(IReq::get('page'),'int'), 1);
	    $page_size = 12;
	     
	    $search = IFilter::act(IReq::get('search'),'strict');
	    $condition = Util::search($search);
	    $condition .= ( $condition ) ? ' and seller_id = ' . $seller_id : 'seller_id = ' . $seller_id;
	    $teacher_list_info = Teacher_class::get_teacher_list( $condition, $page, $page_size );
	     
	    // 获取商家信息
	    $this->setRenderData(array(
	        'teacher_list_info'    =>  $teacher_list_info,
	    ));
	    $this->redirect('teacher_list');
	}


	// 修改教师资料
	function teacher_edit()
	{
	    $id = IFilter::act(IReq::get('id'),'int');
	    $seller_id = $this->seller['seller_id'];
	    $seller_info = seller_class::get_seller_info($seller_id);
	    $brand_info = brand_class::get_brand_info($seller_info['brand_id']);
	    if ( $brand_info['category_ids'] == 16 )
	    {
	        $teacher_db = new IQuery('teacher');
	        $teacher_db->where = 'seller_id = ' . $seller_id;
	        $info = $teacher_db->getOne();
	        if ( $info )
	            $id = $info['id'];
	    }
	    if ( $id )
	    {
	        $teacher_info = Teacher_class::get_teacher_info( $id );
	        $teacher_info['birth_date'] = ( $teacher_info['birth_date'] ) ? date('Y-m-d', $teacher_info['birth_date'] ) : '';
	        $this->setRenderData(array(
	            'teacher_info'     =>  $teacher_info
	        ));
	    }
	    
	    $this->seller_info = $seller_info;
	    $this->brand_info = $brand_info;
	    $this->redirect('teacher_edit');
	}
	
	// 保存教师信息
	function teacher_save()
	{
	    $id = IFilter::act(IReq::get('id'),'int');
	    $seller_id = $this->seller['seller_id'];
	    $seller_info = seller_class::get_seller_info($seller_id);
	    $brand_info = brand_class::get_brand_info($seller_info['brand_id']);
	    $teaching_type = IFilter::act(IReq::get('teaching_type'));
	    $teaching_type = ( $teaching_type ) ? implode(',', array_values($teaching_type)) : '';
	    $callback = IFilter::act(IReq::get('callback'));
	    $data = array(
	        'name'         =>  IFilter::act(IReq::get('name')),
	        'seller_id'    =>  $this->seller['seller_id'],
	        'sex'          =>  IFilter::act(IReq::get('sex'),'int'),
	        'mobile'       =>  IFilter::act(IReq::get('mobile')),
	        'birth_date'   =>  IFilter::act(IReq::get('birth_date')),
	        'graduate'     =>  IFilter::act(IReq::get('graduate')),
	        'major'        =>  IFilter::act(IReq::get('major')),
	        'teaching_direction'   =>  IFilter::act(IReq::get('teaching_direction')),
	        'teaching_experience'  =>  IFilter::act(IReq::get('teaching_experience'), 'text'),
	        'description'  =>  IFilter::act(IReq::get('description'), 'text'),
	        'awards'       =>  IFilter::act(IReq::get('awards'), 'text'),
	        'education'    =>  IFilter::act(IReq::get('education'),'int'),
	        'teaching_type'    =>  $teaching_type,
	        'brief'    =>  IFilter::act(IReq::get('brief')),
	        'good_at_course'   =>  IFilter::act(IReq::get('good_at_course')),
	        'teaching_time'   =>  IFilter::act(IReq::get('teaching_time')),
	    );
	    
	    if ( $brand_info['category_ids'] == 16 )
	    {
	        $data['name'] = $seller_info['true_name'];
	        $data['mobile'] = $seller_info['mobile'];
	    }
	     
	    $data['birth_date'] = ( $data['birth_date'] ) ? strtotime( $data['birth_date'] ) : 0;
	    if ( $brand_info['category_ids'] != 16 )
	    {
	        if ( !$data['name'] )
	            $errorMsg = '请输入教师姓名';
	    }


	    if($_POST['icon']){
			if(stristr($_POST['icon'],'base64')){
				$img_tmp = explode(',',$_POST['icon']);
				$img = base64_decode($img_tmp[1]);

				$filename = 'upload/'.date('Y/m/d').'/'.date('Ymdhis').rand(10000,99999).'.jpg';
				$re = file_put_contents('./'.$filename, $img);

				if($re){						
					$data['icon'] = $filename;
				}
			}else{
				$data['icon'] = $_POST['icon'];
			}			
		}

	    
	    /*if(isset($_FILES['icon']['name']) && $_FILES['icon']['name'])
	    {
	        $uploadObj = new PhotoUpload();
	        $uploadObj->setIterance(false);
	        $photoInfo = $uploadObj->run();
	        if(isset($photoInfo['icon']['img']) && file_exists($photoInfo['icon']['img']))
	        {
	            $data['icon'] = $photoInfo['icon']['img'];
	        }
	    }
	    else
	    {
	        $icon = IFilter::act(IReq::get('icon'));
	    	if(!empty($icon))
	    	{
	    		$data['icon'] = $icon;
	    	}
	    }*/
	    
	    //操作失败表单回填
	    if(isset($errorMsg))
	    {
	        $this->userInfo = $_POST;
	        $this->redirect('teacher_edit',false);
	        Util::showMessage($errorMsg);
	    }
	     
	    $teacher_db = new IModel('teacher');
	    $teacher_db->setData( $data );
	    if ( !$id )
	    {
	        $teacher_db->add();
	    } else {
	        $teacher_db->update('id = ' . $id );
	    }
	     
	    if ( $brand_info['category_ids'] == 16 )
	    {
	        $teacher_info = Teacher_class::get_teacher_info( $id );
	        $this->setRenderData(array(
	            'teacher_info' =>  $teacher_info,
	        ));
	        $this->redirect('teacher_edit',false);
	        Util::showMessage('修改成功');
	    }
	    else
	    	$callback ? $this->redirect($callback) : $this->redirect("teacher_list");
	}


	// 删除教师
	function teacher_del()
	{
	    $seller_id = $this->seller['seller_id'];
	    $id = IFilter::act(IReq::get('id'),'int');
	    if ( !$id )
	        IError::show(403,'参数不正确，操作失败');
	     
	    $teacher_info = Teacher_class::get_teacher_info( $id );
	    if ( !$teacher_info )
	        IError::show(403,'该教师可能已被删除');
	    
	    if ( $teacher_info['seller_id'] != $seller_id )
	        IError::show(403,'您没有权限删除该教师');
	     
	    if ( !Teacher_class::del_teacher( $id ) )
	    {
	        IError::show(403,'操作失败');
	    }
	     
	    $this->redirect('teacher_list');
	}
	
	function pic_upload()
	{
	    if(isset($_FILES['pic']['name']) && $_FILES['pic']['name']!='')
	    {
	        $uploadObj = new PhotoUpload();
	        $uploadObj->setIterance(false);
	        $photoInfo = $uploadObj->run();
	        if(isset($photoInfo['pic']['img']) && file_exists($photoInfo['pic']['img']))
	        {
	            $arr['success'] = 1;
	            $arr['fileurl'] = $photoInfo['pic']['img'];
	        }
	        else
	        {
	            $arr['success'] = 0;
	        }
	    }
	    else
	    {
	        $arr['success'] = 0;
	    }
	
	    echo json_encode($arr);
	}
	
	public function ajax_goods_list()
	{
	    $seller_id = $this->seller['seller_id'];
	    $where = "go.seller_id='$seller_id' and is_del = 0";
	    $page   = IReq::get('page') ? IFilter::act(IReq::get('page'),'int') : 1;
	
	    $goodHandle = new IQuery('goods as go');
	    $goodHandle->order  = "go.id desc";
	    $goodHandle->fields = "distinct go.id,go.name,go.goods_brief,go.sell_price,go.market_price,go.store_nums,go.img,go.is_del,go.seller_id,go.is_share,go.sort";
	    $goodHandle->where  = $where;
	    $goodHandle->page	= $page;
	    $goodHandle->pagesize	= 10;	
	    $goods_info = $goodHandle->find();
	    foreach($goods_info AS $idx => $goods)
	    {
	        $goods_info[$idx]['brief'] = strip_tags($goods['content']);
	    }
	    $goods_info['num'] = count($goods_info);
	    $goods_info['page'] = $page + 1;
	    echo json_encode($goods_info);
	}
	
	public function sale_tixian()
	{
	    $seller_id = $this->seller['seller_id'];
	    $sellerRow = seller_class::get_seller_info($seller_id);
	     
	    /**
	     $can_tixian = true;
	     if ( !$sellerRow['account_name'] || !$sellerRow['account_cart_no'] || !$sellerRow['account_bank_name'] )
	     {
	     //$this->show_warning('操作失败，请完善您的账户资料', '完善信息', '/seller/seller_edit');
	     $can_tixian = false;
	     }
	    **/
	     
	    // 通过是否认证判断商户是否可以体现
	    $can_tixian = ( $sellerRow['is_authentication'] == 1 ) ? true : false;
	    //dump($sellerRow);
	     
	    $this->setRenderData(array(
	        'sellerRow'   =>  $sellerRow,
	        'can_tixian'      =>  $can_tixian,
	        'mobile'          =>  $sellerRow['mobile'],
	        'seller_id'       =>  $seller_id,
	        'frozen_amount'   =>  order_tutor_rebates_class::get_seller_rebate_amount($seller_id),
	    ));
	    $this->title = '商户提现';
	    $this->redirect('sale_tixian');
	}
	
	/**
	 * 商户提现获取验证码
	 */
	public function get_withdraw_code_ajax()
	{
	    $seller_id = $this->seller['seller_id'];
	    $seller_info = Seller_class::get_seller_info($seller_id);
	    $mobile = $seller_info['mobile'];
	    if( !$mobile)
	    {
	        $brand_info = brand_class::get_brand_info($seller_info['brand_id']);
	        $mobile = $brand_info['mobile'];
	    }
	     		
	    if ( !$mobile || !IValidate::mobi($mobile) )
	    {
	        $this->json_error('请先绑定手机号码');
	    }
	
	    $time = time();
	    $sms_info = Sms_class::get_sms_info($mobile, 5 );
	    if ( $sms_info['addtime'] && ( $time - $sms_info['addtime'] <= 60 ))
	    {
	        $this->json_error("请".(60-$time + $sms_info['addtime'])."s后再试");
	    }

	    $mobile_code = Sms_class::get_rand_code();
	    $sms_db = new IModel('sms');
	    $sms_db->setData(array(
	        'mobile'      =>  $mobile,
	        'code'        =>  $mobile_code,
	        'action'      =>  5,
	        'addtime'     =>  $time,
	    ));
	
	    if ( $sms_info )
	        $result = $sms_db->update('id = ' . $sms_info['id'] );
	    else
	        $result = $sms_db->add();
	
	    if ( $result )
	    {
	        $content = '您好，您正在申请乐享生活商户货款提现，验证码为：' . $mobile_code . '。此验证码的有效时间为5分钟，请按时提交。【乐享生活】';
	        $sms = new Sms_class();
	        $result = $sms->send( $mobile, $content );
	        if( $result['stat']=='100')
	        {
	            $this->json_result('发送成功');
	        } else {
	            $this->json_error('发送验证码失败，请联系管理员');
	        }
	    } else {
	        $this->json_error('操作失败');
	    }
	}
	
	public function sale_withdraw(){
	    $type = IReq::get('type');
	    $num = number_format(IReq::get('sale'), 2, '.', '');
	    $seller_id = $this->seller['seller_id'];
	    $mobile_code = IFilter::act(IReq::get('mobile_code'), 'int');
	
	    if( !$type || !$num || !$seller_id || !$mobile_code)
	    {
	        IError::show('参数错误',403);
	    }
	
	    $sellerInfo=seller_class::get_seller_info($seller_id);
	    $mobile = $sellerInfo['mobile'];
	    $sms_info = Sms_class::get_sms_info($mobile, 5 );
	    if ( !$sms_info || $mobile_code != $sms_info['code'] )
	    {
	        IError::show('手机验证码不正确',403);
	        exit();
	    }
	
	    if($type==1){//销售额提现
	
// 	        if(!Lexiangshenghuo::check_saletixian($this->seller['seller_id'])){
// 	            //$this->redirect('tixian_list',false);
// 	            //Util::showMessage('还有未完成的提现申请！');
// 	            IError::show('还有未完成的提现申请',403);
// 	        }
	        if($sellerInfo['sale_balance']<$num){
	            //$this->redirect('sale_tixian',false);
	            //Util::showMessage('可提现额度不足');
	            IError::show('可提现额度不足',403);
	        }
	        $tixianObj  = new IModel('sale_tixian');
	        $dataArray = array(
	            'seller_id' => $seller_id,
	            'create_time' => time(),
	            'num' => $num,
	            'status' =>0,
	        );
	         
	        // 减少销售额
	        $seller_db = new IModel('seller');
	        $data = array(
	            'sale_balance' => $sellerInfo['sale_balance']-$num,
	        );
	        $seller_db->setData($data);
	        $seller_db->update('id = '.$seller_id);
	
	        $tixianObj->setData($dataArray);
	        $id = $tixianObj->add();
	
	        if($id)
	        {
	            // 发送邮件提示
// 	            $email = '799345360@qq.com,837452239@qq.com,370885997@qq.com,513734750@qq.com';
// 	            $content = mailTemplate::sale_withdraw(array(
// 	                'name'   =>  $sellerInfo['true_name'],
// 	                'num'    =>  $num,
	
// 	            ));
	
// 	            $smtp   = new SendMail();
// 	            $result = $smtp->send($email,"商家提现申请",$content);
	
	            //删除验证码的短信内容
	            if ( $sms_info['id'])
	                Sms_class::drop_info("id = " . $sms_info['id'] );
	             
	            //$this->redirect('tixian_list');
	            //Util::showMessage('申请成功');
	            $this->redirect('/site/success/message/'.urlencode("申请成功").'/?callback=/seller/tixian_list');
	        }else{
	            //$this->redirect('tixian_list',false);
	            //Util::showMessage('申请失败，请尝试重新申请');
	            IError::show('申请失败，请尝试重新申请',403);
	        }
	
	    }else{
	        IError::show('参数错误',403);
	    }
	}
	
	public function tixian_list()
	{
	    $seller_id = $this->seller['seller_id'];
	    $searchParam = http_build_query(Util::getUrlParam('search'));
	    $condition = Util::search(IReq::get('search'));$where = $condition ? " and ".$condition : "";
	    $page= (isset($_GET['page'])&&(intval($_GET['page'])>0))?intval($_GET['page']):1;
	    $page_size = 12;
	
	    $sale_tixian_db = new IQuery('sale_tixian');
	    $sale_tixian_db->where = 'seller_id = ' . $seller_id;
	    $sale_tixian_db->page = $page;
	    $sale_tixian_db->pagesize = $page_size;
	    $sale_tixian_db->order = 'id desc';
	    $sale_tixian_list = $sale_tixian_db->find();
	    $page_info = $sale_tixian_db->getPageBar();
	
	    $this->setRenderData(array(
	        'seller_id'        =>  $seller_id,
	        'searchParam'      =>  $searchParam,
	        'condition'        =>  $condition,
	        'page'             =>  $page,
	        'sale_tixian_list' =>  $sale_tixian_list,
	        'page_info'        =>  $page_info,
	
	    ));
	
	    $this->title = '提现列表';
	    $this->redirect('tixian_list');
	}
	
	/**
	 * @brief 商品添加中图片上传的方法
	 */
	public function goods_img_upload()
	{
	    //调用文件上传类
	    $photoObj = new PhotoUpload();
	    $photo    = current($photoObj->run());
	
	    //判断上传是否成功，如果float=1则成功
	    if($photo['flag'] == 1)
	    {
	        $result = array(
	            'flag'=> 1,
	            'img' => $photo['img']
	        );
	    }
	    else
	    {
	        $result = array('flag'=> $photo['flag']);
	    }
	    echo JSON::encode($result);
	}
	
	public function refundment_list()
	{
	    $this->title = '退款申请列表';
	    $this->redirect('refundment_list');
	}
	
}