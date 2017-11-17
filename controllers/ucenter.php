<?php
/**
 * @brief 用户中心模块
 * @class Ucenter
 * @note  前台
 */
class Ucenter extends IController implements userAuthorization
{
	public $layout = 'site';

	public function init()
	{

	}
	function tutor_add()
    {
        $id = IFilter::act(IReq::get('id'),'int');
        $user_id = $this->user['user_id'];
        
        // 获取家教信息
        if ($id)
        {
            $tutor_info = tutor_class::get_tutor_info($id);
            if ( !$tutor_info )
            {
                IError::show(403,'该信息可能已被删除');
                exit();
            }
        }
        
        $tutor_info['test_reward'] = ( $tutor_info['test_reward'] ) ? unserialize($tutor_info['test_reward']) : array();
        
        // 获取家教分类
        $tutor_cate_list = category_class::get_site_category(0);
        
        if ($tutor_info['category_id'])
            $tutor_info['category_name'] = $tutor_cate_list[$tutor_info['category_id']]['name'];
        if ( $tutor_info['teaching_time'])
            $tutor_info['teaching_time'] = unserialize($tutor_info['teaching_time']);
        
        // 读取区域的数据
        $region_list = area::get_child_area_list(430200);
        
        // 读取区域的json数据
        $region_list_json = array();
        if ($region_list)
        {
            foreach($region_list as $kk => $vv)
            {
                $region_list_json[] = array(
                    'value' =>  $vv['area_id'],
                    'text'  =>  $vv['area_name'],
                );
            }
        }
        
        // 获取用户信息
        $member_info = member_class::get_member_info($user_id);
        
        // 读取年级的json数据
        $grade_arr = tutor_class::get_grade_arr();
        $grade_arr_json = array();
        if ( $grade_arr )
        {
            foreach($grade_arr as $kk => $vv)
            {
                $grade_arr_json[] = array(
                    'value' =>  $kk,
                    'text'  =>  $vv,
                );
            }
        }
        
        // 获取年纪的json数据
        $grade_level_arr = array();
        $i = 0;
        while($i < 6) {
            $i++;
            $grade_level_arr[] = array(
                'value' =>  $i,
                'text'  =>  $i,
            );
        }
        
        // 获取预计补课的时间
        $teaching_time = tutor_class::get_teaching_time();
        $teaching_time_json = array();
        if ( $teaching_time )
        {
            foreach($teaching_time as $kk => $vv )
            {
                $teaching_time_json[] = array(
                    'value' => $kk,
                    'text'  => $vv,
                );
            }
        }
        
        // 获取区域
        if ( $tutor_info['region_id'] > 0 )
        {
            $region_name = area::getName($tutor_info['region_id']);
            $tutor_info['region_name'] = $region_name;
        }
        
        // 获取用户信息
        $member_info = member_class::get_member_info($user_id);
        
        $this->setRenderData(array(
            'tutor_info'    =>  $tutor_info,
	        'tutor_cate_list'       => $tutor_cate_list,
	        'tutor_cate_list_json'  =>  json_encode($tutor_cate_list),
            'region_list'   =>  $region_list,
            'grade_arr'     =>  tutor_class::get_grade_arr(),
            'id'            =>  $id,
            'member_info'   =>  $member_info,
            'teaching_time' =>  $teaching_time,
            
            'grade_arr_json'   =>  json_encode($grade_arr_json),
            'grade_level_arr_json' =>  json_encode($grade_level_arr),
            'teaching_time_json'    => json_encode($teaching_time_json),
            'region_list_json'  =>  json_encode($region_list_json),
            
            'teaching_time_arr'    =>  tutor_class::get_teaching_time2(),
            'teaching_time_arr3'   =>  tutor_class::get_teaching_time3(),
        ));
        
        $this->title = '发布家教';
        
        $this->redirect('tutor_add');
    }
	 function tutor_update()
    {
        $user_id = $this->user['user_id'];
        $data = array(
            'gender'            =>  IFilter::act(IReq::get('gender'),'int'),
            'age'               =>  IFilter::act(IReq::get('age'),'int'),
            'grade_level'       =>  IFilter::act(IReq::get('grade_level'),'int'),
            'grade'             =>  IFilter::act(IReq::get('grade'),'int'),
            'category_id'       =>  IFilter::act(IReq::get('category_id'),'int'),
            'lastest_scores'    =>  IFilter::act(IReq::get('lastest_scores'),'float'),
            'expected_scores'   =>  IFilter::act(IReq::get('expected_scores'),'float'),
            'lowest_reward'     =>  IFilter::act(IReq::get('lowest_reward'),'float'),
            'highest_reward'     => IFilter::act(IReq::get('highest_reward'),'float'),
            'expected_hours'    =>  IFilter::act(IReq::get('expected_hours'),'int'),
            'is_provide_transportation_fee'    =>  IFilter::act(IReq::get('is_provide_transportation_fee'),'int'),
            'is_provide_repast' =>  IFilter::act(IReq::get('is_provide_repast'),'int'),
            'region_id'         =>  IFilter::act(IReq::get('region_id'),'int'),
            'address'           =>  IFilter::act(IReq::get('address')),
            'description'       =>  IFilter::act(IReq::get('description')),
            'user_id'           =>  $user_id,
        );
        
        $time1 = IFilter::act(IReq::get('time1'));
        $time2 = IFilter::act(IReq::get('time2'));
        $time3 = IFilter::act(IReq::get('time3'));
        $teaching_time = array();
        if ( $time3 )
        {
            foreach( $time3 as $kk => $vv )
            {
                if ( $vv )
                {
                    $teaching_time[] = array(
                        'time1' => $time1[$kk],
                        'time2' => $time2[$kk],
                        'time3' => $time3[$kk],
                    );
                }
            }
        }
        if ( $teaching_time )
        {
            $data['teaching_time'] = serialize($teaching_time);
        }
        
        $test_time = IFilter::act(IReq::get('test_time'));
        $test_type = IFilter::act(IReq::get('test_type'));
        $test_condition = IFilter::act(IReq::get('test_condition'));
        $test_money = IFilter::act(IReq::get('test_money'));
        $test_reward = array();
        if ( $test_time )
        {
            foreach( $test_time as $kk => $vv )
            {
                if ( $test_time[$kk] && $test_type[$kk] && $test_condition[$kk] && $test_money[$kk] )
                {
                    $test_reward[] = array(
                        'test_time' => $test_time[$kk],
                        'test_type' => $test_type[$kk],
                        'test_condition' => $test_condition[$kk],
                        'test_money' => $test_money[$kk],
                    );
                }
            }
        }
        if ( $test_reward )
        {
            $data['test_reward'] = serialize($test_reward);
        }
        
        // 判断内容合法性
        if ( !$data['lastest_scores'] )
        {
            IError::show(403,'请输入最近一次考分');
            exit();
        }
        if ( !$data['lowest_reward'] )
        {
            IError::show(403,'请输入支付的最低报酬');
            exit();
        }
        if ( !$data['expected_hours'] )
        {
            IError::show(403,'请输入预计补课的课时');
            exit();
        }
        
        // 数据库操作
        $id = IFilter::act(IReq::get('id'),'int');
        $tutor_db = new IModel('tutor');
        
        // 修改
        if ($id)
        {
            $tutor_db->setData($data);
            $tutor_info = tutor_class::get_tutor_info($id);
            if ( !$tutor_info )
            {
                IError::show(403,'该信息可能已被删除');
                exit();
            }
            
            $result = $tutor_db->update('id = ' . $id);
        } else {
            // 添加
            $data['create_time'] = time();
            $data['status'] = 1;
            $tutor_db->setData($data);
            $result = $tutor_db->add();
            $id = $result;
        }
        
        $tutor_info2 = tutor_class::get_tutor_info($id);
        
        // 如果用户通过实名认证，则所家教信息自动发布 is_publish = 1
        $member_info = member_class::get_member_info($user_id);
        if ( $member_info['is_auth'] )
        {
            $tutor_db = new IModel('tutor');
            $tutor_db->setData(array('is_publish' => 1));
            $tutor_db->update('user_id = ' . $user_id);
        }
        
        // 生成合同
        if ( !$tutor_info2['contract_addr'] )
        {
            tutor_class::create_contract($id);
        }
        
        $this->redirect('tutor_list');
    }
    public function index()
    {
    	//获取用户基本信息
		$user = Api::run('getMemberInfo',$this->user['user_id']);

		//获取用户各项统计数据
		$statistics = Api::run('getMemberTongJi',$this->user['user_id']);

		//获取用户站内信条数
		$msgObj = new Mess($this->user['user_id']);
		$msgNum = $msgObj->needReadNum();

		//获取用户代金券
		$propIds = trim($user['prop'],',');
		$propIds = $propIds ? $propIds : 0;
		$propData= Api::run('getPropTongJi',$propIds);

		$this->setRenderData(array(
			"user"       => $user,
			"statistics" => $statistics,
			"msgNum"     => $msgNum,
			"propData"   => $propData,
		));

        $this->initPayment();
        $this->title = '会员中心';
        $this->redirect('index');
    }

	//[用户头像]上传
	function user_ico_upload()
	{
		$result = array(
			'isError' => true,
		);

		if(isset($_FILES['attach']['name']) && $_FILES['attach']['name'] != '')
		{
			$photoObj = new PhotoUpload();
			$photo    = $photoObj->run();

			if(isset($photo['attach']['img']) && $photo['attach']['img'])
			{
				$user_id   = $this->user['user_id'];
				$user_obj  = new IModel('user');
				$dataArray = array(
					'head_ico' => $photo['attach']['img'],
				);
				$user_obj->setData($dataArray);
				$where  = 'id = '.$user_id;
				$isSuss = $user_obj->update($where);

				if($isSuss !== false)
				{
					$result['isError'] = false;
					$result['data'] = IUrl::creatUrl().$photo['attach']['img'];
					ISafe::set('head_ico',$dataArray['head_ico']);
				}
				else
				{
					$result['message'] = '上传失败';
				}
			}
			else
			{
				$result['message'] = '上传失败';
			}
		}
		else
		{
			$result['message'] = '请选择图片';
		}
		echo '<script type="text/javascript">parent.callback_user_ico('.JSON::encode($result).');</script>';
	}

    /**
     * @brief 我的订单列表
     */
    public function order()
    {
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0",false);
		
		$page_size = 15;
		$page = IFilter::act(IReq::get('page'),'int');
		$page = max( $page, 1 );
		$user_id = $this->user['user_id'];
		$type = IFilter::act(IReq::get('type'),'int');		
		$type = max($type, 1);
		$order_list_info = order_class::get_order_list($user_id, $type, $page);		
		if ( $order_list_info )
		{
		    $order_list = $order_list_info['list'];
		    $page_info = $order_list_info['page_info'];
		    $page_count = $order_list_info['page_count'];
		}
		
		$goodsModel = new IModel('goods');		
		$ordergoodsModel = new IModel('order_goods');		
		$productsModel = new IModel('products');		
		$seller_list = array();		
		if ( $order_list )		
		{
		    foreach( $order_list as $kk => $vv )		
		    {		
		        if ( !isset( $seller_list[$vv['seller_id']]))		
		        {
		            $seller_list[$vv['seller_id']] = Seller_class::get_seller_info( $vv['seller_id'] );
		        }
		        $order_list[$kk]['seller_info'] = $seller_list[$vv['seller_id']];
		        $order_list[$kk]['status_str'] = Order_Class::orderStatusText(Order_Class::getOrderStatus($vv), 1, $vv['statement']);
		        $order_list[$kk]['order_status_t'] = Order_Class::getOrderStatus($vv);
		        
		        if ( $vv['statement'] == 1)
		        {
		            $order_goods_list = Order_goods_class::get_order_goods_list($vv['id'] );
		            $order_list[$kk]['goods'] = current( $order_goods_list );
		            $order_list[$kk]['goods']['goods_array'] = json_decode( $order_list[$kk]['goods']['goods_array'] );
		            $order_list[$kk]['goods']['name'] = $order_list[$kk]['goods']['goods_array']->name;
		            $order_list[$kk]['goods']['value'] = $order_list[$kk]['goods']['goods_array']->value;
		            $info = $ordergoodsModel->getObj('order_id = ' . $vv['id'], 'product_id');
		            $order_list[$kk]['products'] = $productsModel->getObj("id = '$info[product_id]'");
		            if ( $order_list[$kk]['goods']['goods_id'] )
		            {
		                $goods_info = goods_class::get_goods_info($order_list[$kk]['goods']['goods_id'] );
		                $order_list[$kk]['goods']['is_refer'] = $goods_info['is_refer'];
		            } 
		        } else if ( $vv['statement'] == 2 ) {
		            // 短期课组合
		            if ( $vv['zuhe_id'] > 0 )
		            {
		                $zuhe_list = brand_chit_zuhe_detail::get_detail_list($vv['zuhe_id']);
		                $order_list[$kk]['brand_chit_list'] = $zuhe_list;
		            }
		        } else if ($vv['statement'] == 4) {
		            $order_goods_list = Order_goods_class::get_order_goods_list($vv['id'] );
		            $order_list[$kk]['goods'] = current( $order_goods_list );
		            $order_list[$kk]['goods']['goods_array'] = json_decode( $order_list[$kk]['goods']['goods_array'] );
		            $order_list[$kk]['goods']['name'] = $order_list[$kk]['goods']['goods_array']->name;
		            $order_list[$kk]['goods']['value'] = $order_list[$kk]['goods']['goods_array']->value;
		        }

		    }		
		}

		$this->initPayment();
		$this->setRenderData(array(
		    'order_list'    =>  $order_list,
		    'page_info'     =>  $page_info,
		    'page'          =>  $page,
		    'page_size'     =>  $page_size,
		    'type'          =>  $type,
		    'page_count'    =>  $page_count,
		    'is_set_trade_passwd'   =>  $is_set_trade_passwd,
		    'type'          =>  $type,
		));
		
		$this->title = '订单列表';
        $this->initPayment();
        $this->redirect('order');

    }
    /**
     * @brief 初始化支付方式
     */
    private function initPayment()
    {
        $payment = new IQuery('payment');
        $payment->fields = 'id,name,type';
        $payments = $payment->find();
        $items = array();
        foreach($payments as $pay)
        {
            $items[$pay['id']]['name'] = $pay['name'];
            $items[$pay['id']]['type'] = $pay['type'];
        }
        $this->payments = $items;
    }
    /**
     * @brief 订单详情
     * @return String
     */
    public function order_detail()
    {
        $id = IFilter::act(IReq::get('id'),'int');

        $orderObj = new order_class();
        $this->order_info = $orderObj->getOrderShow($id,$this->user['user_id']);

        if(!$this->order_info)
        {
        	IError::show(403,'订单信息不存在');
        }
        
        // 页面跳转
        if ( $this->order_info['statement'] == 2)
        {
            if( $this->order_info['zuhe_id'] > 0 )
            {
                $this->redirect('/ucenter/redpacket_zuhe_detail/id/' . $id);
                exit();
            }
        }
        
        //$is_set_trade_passwd = member_class::is_set_trade_passwd($this->user['user_id']);
        
        if ($this->order_info['chit_id'] > 0 && $this->order_info['statement'] == 2)
        {
            $chit_info = brand_chit_class::get_chit_info($this->order_info['chit_id']);
        }
        
        $seller_info = seller_class::get_seller_info($this->order_info['seller_id']);
        $orderStatus = Order_Class::getOrderStatus($this->order_info);
        $this->setRenderData(array('orderStatus' => $orderStatus, 'order_id' => $id, 'is_set_trade_passwd' => $is_set_trade_passwd, 'chit_info' => $chit_info, 'seller_info' => $seller_info ));
        
        $this->title = '订单详情';
        $this->redirect('order_detail',false);
    }

    //操作订单状态
	public function order_status()
	{
		$op    = IFilter::act(IReq::get('op'));
		$id    = IFilter::act( IReq::get('order_id'),'int' );
		$model = new IModel('order');

		switch($op)
		{
			case "cancel":
			{
				$model->setData(array('status' => 3));
				if($model->update("id = ".$id." and distribution_status = 0 and status = 1 and user_id = ".$this->user['user_id']))
				{
					order_class::resetOrderProp($id);
				}
			}
			break;

			case "confirm":
			{
				$model->setData(array('status' => 5,'completion_time' => ITime::getDateTime()));
				if($model->update("id = ".$id." and distribution_status = 1 and user_id = ".$this->user['user_id']))
				{
					$orderRow = $model->getObj('id = '.$id);

					//确认收货后进行支付
					Order_Class::updateOrderStatus($orderRow['order_no']);

		    		//增加用户评论商品机会
		    		Order_Class::addGoodsCommentChange($id);

		    		//确认收货以后直接跳转到评论页面
		    		$this->redirect('evaluation');
				}
			}
			break;
		}
		$this->redirect("order_detail/id/$id");
	}
	
	public function order_status_ajax()
	{
	    $op    = IFilter::act(IReq::get('op'));
	    $id    = IFilter::act( IReq::get('order_id'),'int' );
	    $model = new IModel('order');
	    
	    switch($op)
	    {
	        case "cancel":
	            {
	                $model->setData(array('status' => 3));
	                if($model->update("id = ".$id." and distribution_status = 0 and status = 1 and user_id = ".$this->user['user_id']))
	                {
	                    order_class::resetOrderProp($id);
	                }
	            }
	            break;
	    
	        case "confirm":
	            {
	                $model->setData(array('status' => 5,'completion_time' => ITime::getDateTime()));
	                if($model->update("id = ".$id." and distribution_status = 1 and user_id = ".$this->user['user_id']))
	                {
	                    $orderRow = $model->getObj('id = '.$id);
	    
	                    //确认收货后进行支付
	                    Order_Class::updateOrderStatus($orderRow['order_no']);
	    
	                    //增加用户评论商品机会
	                    Order_Class::addGoodsCommentChange($id);
	    
	                    //确认收货以后直接跳转到评论页面
	                    $this->redirect('evaluation');
	                }
	            }
	            break;
	    }
	    die('1');
	}
	
    /**
     * @brief 我的地址
     */
    public function address()
    {
		//取得自己的地址
		$query = new IQuery('address');
        $query->where = 'user_id = '.$this->user['user_id'];
		$address = $query->find();
		$areas   = array();

		if($address)
		{
			foreach($address as $ad)
			{
				$temp = area::name($ad['province'],$ad['city'],$ad['area']);
				if(isset($temp[$ad['province']]) && isset($temp[$ad['city']]) && isset($temp[$ad['area']]))
				{
					$areas[$ad['province']] = $temp[$ad['province']];
					$areas[$ad['city']]     = $temp[$ad['city']];
					$areas[$ad['area']]     = $temp[$ad['area']];
				}
			}
		}

		$this->areas = $areas;
		$this->address = $address;
        $this->redirect('address');
    }
    /**
     * @brief 收货地址管理
     */
	public function address_edit()
	{
		$id          = IFilter::act(IReq::get('id'),'int');
		$accept_name = IFilter::act(IReq::get('accept_name'),'name');
		$province    = IFilter::act(IReq::get('province'),'int');
		$city        = IFilter::act(IReq::get('city'),'int');
		$area        = IFilter::act(IReq::get('area'),'int');
		$address     = IFilter::act(IReq::get('address'));
		$zip         = IFilter::act(IReq::get('zip'),'zip');
		$telphone    = IFilter::act(IReq::get('telphone'),'phone');
		$mobile      = IFilter::act(IReq::get('mobile'),'mobile');
		$default     = IReq::get('is_default')!= 1 ? 0 : 1;
        $user_id     = $this->user['user_id'];

		$model = new IModel('address');
		$data  = array('user_id'=>$user_id,'accept_name'=>$accept_name,'province'=>$province,'city'=>$city,'area'=>$area,'address'=>$address,'zip'=>$zip,'telphone'=>$telphone,'mobile'=>$mobile,'is_default'=>$default);

        //如果设置为首选地址则把其余的都取消首选
        if($default==1)
        {
            $model->setData(array('is_default' => 0));
            $model->update("user_id = ".$this->user['user_id']);
        }

		$model->setData($data);

		if($id == '')
		{
			$model->add();
		}
		else
		{
			$model->update('id = '.$id);
		}
		$this->redirect('address');
	}
    /**
     * @brief 收货地址删除处理
     */
	public function address_del()
	{
		$id = IFilter::act( IReq::get('id'),'int' );
		$model = new IModel('address');
		$model->del('id = '.$id.' and user_id = '.$this->user['user_id']);
		$this->redirect('address');
	}
    /**
     * @brief 设置默认的收货地址
     */
    public function address_default()
    {
        $id = IFilter::act( IReq::get('id'),'int' );
        $default = IFilter::act(IReq::get('is_default'));
        $model = new IModel('address');
        if($default == 1)
        {
            $model->setData(array('is_default' => 0));
            $model->update("user_id = ".$this->user['user_id']);
        }
        $model->setData(array('is_default' => $default));
        $model->update("id = ".$id." and user_id = ".$this->user['user_id']);
        $this->redirect('address');
    }
    /**
     * @brief 退款申请页面
     */
    public function refunds_update()
    {
        $order_goods_id = IFilter::act( IReq::get('order_goods_id'),'int' );
        $order_id       = IFilter::act( IReq::get('order_id'),'int' );
        $user_id        = $this->user['user_id'];
        $content        = IFilter::act(IReq::get('content'),'text');
        $message        = '';

        if(!$content || !$order_goods_id)
        {
        	$message = "请填写退款理由和选择要退款的商品";
	        $this->redirect('refunds',false);
	        Util::showMessage($message);
        }

        $orderDB      = new IModel('order');
        $orderRow     = $orderDB->getObj("id = ".$order_id." and user_id = ".$user_id);
        $refundResult = Order_Class::isRefundmentApply($orderRow,$order_goods_id);

        //判断退款申请是否有效
        if($refundResult === true)
        {
			//退款单数据
    		$updateData = array(
				'order_no'       => $orderRow['order_no'],
				'order_id'       => $order_id,
				'user_id'        => $user_id,
				'time'           => ITime::getDateTime(),
				'content'        => $content,
				'seller_id'      => $orderRow['seller_id'],
				'order_goods_id' => join(",",$order_goods_id),
			);

    		//写入数据库
    		$refundsDB = new IModel('refundment_doc');
    		$refundsDB->setData($updateData);
    		$refundsDB->add();

    		$this->redirect('refunds');
        }
        else
        {
        	$message = $refundResult;
	        $this->redirect('refunds',false);
	        Util::showMessage($message);
        }
    }
    /**
     * @brief 退款申请删除
     */
    public function refunds_del()
    {
        $id = IFilter::act( IReq::get('id'),'int' );
        $model = new IModel("refundment_doc");
        $result= $model->del("id = ".$id." and pay_status = 0 and user_id = ".$this->user['user_id']);
        $this->redirect('refunds');
    }
    /**
     * @brief 查看退款申请详情
     */
    public function refunds_detail()
    {
        $id = IFilter::act( IReq::get('id'),'int' );
        $refundDB = new IModel("refundment_doc");
        $refundRow = $refundDB->getObj("id = ".$id." and user_id = ".$this->user['user_id']);
        if($refundRow)
        {
        	//获取商品信息
        	$orderGoodsDB   = new IModel('order_goods');
        	$orderGoodsList = $orderGoodsDB->query("id in (".$refundRow['order_goods_id'].")");
        	if($orderGoodsList)
        	{
        		$refundRow['goods'] = $orderGoodsList;
        		$this->data = $refundRow;
        	}
        	else
        	{
	        	$this->redirect('refunds',false);
	        	Util::showMessage("没有找到要退款的商品");
        	}
        	$this->redirect('refunds_detail');
        }
        else
        {
        	$this->redirect('refunds',false);
        	Util::showMessage("退款信息不存在");
        }
    }
    /**
     * @brief 查看退款申请详情
     */
	public function refunds_edit()
	{
		$order_id = IFilter::act(IReq::get('order_id'),'int');
		if($order_id)
		{
			$orderDB  = new IModel('order');
			$orderRow = $orderDB->getObj('id = '.$order_id.' and user_id = '.$this->user['user_id']);
			if($orderRow)
			{
				$this->orderRow = $orderRow;
				$this->redirect('refunds_edit');
				return;
			}
		}
		$this->redirect('refunds');
	}

    /**
     * @brief 建议中心
     */
    public function complain_edit()
    {
        $id = IFilter::act( IReq::get('id'),'int' );
        $title = IFilter::act(IReq::get('title'),'string');
        $content = IFilter::act(IReq::get('content'),'string' );
        $user_id = $this->user['user_id'];
        $model = new IModel('suggestion');
        $model->setData(array('user_id'=>$user_id,'title'=>$title,'content'=>$content,'time'=>ITime::getDateTime()));
        if($id =='')
        {
            $model->add();
        }
        else
        {
            $model->update('id = '.$id.' and user_id = '.$this->user['user_id']);
        }
        $this->redirect('complain');
    }
    //站内消息
    public function message()
    {
    	$msgObj = new Mess($this->user['user_id']);
    	$msgIds = $msgObj->getAllMsgIds();
    	$msgIds = $msgIds ? $msgIds : 0;
		$this->setRenderData(array('msgIds' => $msgIds,'msgObj' => $msgObj));
    	$this->redirect('message');
    }
    /**
     * @brief 删除消息
     * @param int $id 消息ID
     */
    public function message_del()
    {
        $id = IFilter::act( IReq::get('id') ,'int' );
        $msg = new Mess($this->user['user_id']);
        $msg->delMessage($id);
        $this->redirect('message');
    }
    public function message_read()
    {
        $id = IFilter::act( IReq::get('id'),'int' );
        $msg = new Mess($this->user['user_id']);
        echo $msg->writeMessage($id,1);
    }
    
    function password()
    {
        $this->title = '修改密码';
        $this->redirect('password');
    }
    
    public function update_trade_password_ver()
    {
        $user_id    = $this->user['user_id'];
        $order_id = IFilter::act( IReq::get('order_id'));
        $this->order_id = $order_id;
        $this->title = '修改交易密码';
        $this->redirect('update_trade_password_ver');
    }

    //[修改密码]修改动作
    function password_edit()
    {
    	$user_id    = $this->user['user_id'];

    	$fpassword  = IReq::get('fpassword');
    	$password   = IReq::get('password');
    	$repassword = IReq::get('repassword');

    	$userObj    = new IModel('user');
    	$where      = 'id = '.$user_id;
    	$userRow    = $userObj->getObj($where);

		if(!preg_match('|\w{6,32}|',$password))
		{
			$message = '密码格式不正确，请重新输入';
		}
    	else if($password != $repassword)
    	{
    		$message  = '二次密码输入的不一致，请重新输入';
    	}
    	else if(md5($fpassword) != $userRow['password'])
    	{
    		$message  = '原始密码输入错误';
    	}
    	else
    	{
    		$passwordMd5 = md5($password);
	    	$dataArray = array(
	    		'password' => $passwordMd5,
	    	);

	    	$userObj->setData($dataArray);
	    	$result  = $userObj->update($where);
	    	if($result)
	    	{
	    		ISafe::set('user_pwd',$passwordMd5);
	    		$message = '密码修改成功';
	    	}
	    	else
	    	{
	    		$message = '密码修改失败';
	    	}
		}

    	$this->redirect('password',false);
    	//Util::showMessage($message);
    	echo "<script>mui.toast('$message');</script>";
    }
    
    // 实名认证
    function authentication()
    {
        $user_id = $this->user['user_id'];
        $userObj       = new IModel('user');
        $where         = 'id = '.$user_id;
        $this->userRow = $userObj->getObj($where);
        $back      = IFilter::act(IReq::get('back'));
    
        $memberObj       = new IModel('member');
        $where           = 'user_id = '.$user_id;
        $memberRow = $memberObj->getObj($where);
    
        $jsonregion = json_encode(area::getJsonArea());
        $this->setRenderData(array('regiondata' => $jsonregion, 'back' => $back));
        if(!empty($memberRow['area']))
        {
            $areas = explode(',', trim($memberRow['area'], ','));
            $memberRow['provinceval'] = area::getName($areas[0]);
            $memberRow['cityval'] = area::getName($areas[1]);
            $memberRow['discrictval'] = area::getName($areas[2]);
        }
    
        $this->memberRow = $memberRow;
        $this->title = '实名认证';
        $this->redirect('authentication');
    }

    //[个人资料]展示 单页
    function info()
    {
    	$user_id = $this->user['user_id'];

    	$userObj       = new IModel('user');
    	$where         = 'id = '.$user_id;
    	$this->userRow = $userObj->getObj($where);

    	$memberObj       = new IModel('member');
    	$where           = 'user_id = '.$user_id;
    	$this->memberRow = $memberObj->getObj($where);
    	
    	$this->title = '个人信息';
    	$this->redirect('info');
    }

    //[个人资料] 修改 [动作]
    function info_edit_act()
    {
		$email     = IFilter::act( IReq::get('email'),'string');
		$mobile    = IFilter::act( IReq::get('mobile'),'string');

    	$user_id   = $this->user['user_id'];
    	$memberObj = new IModel('member');
    	$where     = 'user_id = '.$user_id;

		if($email)
		{
			$memberRow = $memberObj->getObj('user_id != '.$user_id.' and email = "'.$email.'"');
			if($memberRow)
			{
				IError::show('邮箱已经被注册');
			}
		}

		if($mobile)
		{
			$memberRow = $memberObj->getObj('user_id != '.$user_id.' and mobile = "'.$mobile.'"');
			if($memberRow)
			{
				IError::show('手机已经被注册');
			}
		}

    	//地区
    	$province = IFilter::act( IReq::get('province','post') ,'string');
    	$city     = IFilter::act( IReq::get('city','post') ,'string' );
    	$area     = IFilter::act( IReq::get('area','post') ,'string' );
    	$areaArr  = array_filter(array($province,$city,$area));

    	$dataArray       = array(
    		'email'        => $email,
    		'true_name'    => IFilter::act( IReq::get('true_name') ,'string'),
    		'sex'          => IFilter::act( IReq::get('sex'),'int' ),
    		'birthday'     => IFilter::act( IReq::get('birthday') ),
    		'zip'          => IFilter::act( IReq::get('zip') ,'string' ),
    		'qq'           => IFilter::act( IReq::get('qq') , 'string' ),
    		'contact_addr' => IFilter::act( IReq::get('contact_addr'), 'string'),
    		//'mobile'       => $mobile,
    		'telephone'    => IFilter::act( IReq::get('telephone'),'string'),
    		'area'         => $areaArr ? ",".join(",",$areaArr)."," : "",
    	);

    	$memberObj->setData($dataArray);
    	$memberObj->update($where);
    	//$this->info();
    	
    	$this->memberRow = $memberObj->getObj($where);
    	
    	$this->redirect('info', false);
    	echo "<script>mui.toast('修改成功');</script>";
    	
    }

    //[账户余额] 展示[单页]
    function withdraw()
    {
        $user_id   = $this->user['user_id'];
        $memberObj = new IModel('member','balance');
        $userModel = new IModel('user');
        $where     = 'user_id = '.$user_id;
        $trade = $userModel->getObj("id = '$user_id'");
        $this->memberRow = $memberObj->getObj($where);
        $this->setRenderData(array(
            "trade"       => $trade
        ));
        $this->title = '我要提现';
        $this->redirect('withdraw');
    }

	//[账户余额] 提现动作
    function withdraw_act()
    {
    	$user_id = $this->user['user_id'];
    	$amount  = IFilter::act( IReq::get('amount','post') ,'float' );
    	$message = '';

    	$dataArray = array(
    		'name'   => IFilter::act( IReq::get('name','post') ,'string'),
    		'note'   => IFilter::act( IReq::get('note','post'), 'string'),
			'amount' => $amount,
			'user_id'=> $user_id,
			'time'   => ITime::getDateTime(),
    	);

		$mixAmount = 0;
		$memberObj = new IModel('member');
		$where     = 'user_id = '.$user_id;
		$memberRow = $memberObj->getObj($where,'balance');

		//提现金额范围
		if($amount <= $mixAmount)
		{
			$message = '提现的金额必须大于'.$mixAmount.'元';
		}
		else if($amount > $memberRow['balance'])
		{
			$message = '提现的金额不能大于您的帐户余额';
		}
		else
		{
	    	$obj = new IModel('withdraw');
	    	$obj->setData($dataArray);
	    	$obj->add();
	    	$this->redirect('withdraw');
		}

		if($message != '')
		{
			$this->memberRow = array('balance' => $memberRow['balance']);
			$this->withdrawRow = $dataArray;
			$this->redirect('withdraw',false);
			Util::showMessage($message);
		}
    }
    
    function online_recharge()
    {
        $this->title = '在线充值';
        $this->redirect('online_recharge');
    }

    //[账户余额] 提现详情
    function withdraw_detail()
    {
    	$user_id = $this->user['user_id'];

    	$id  = IFilter::act( IReq::get('id'),'int' );
    	$obj = new IModel('withdraw');
    	$where = 'id = '.$id.' and user_id = '.$user_id;
    	$this->withdrawRow = $obj->getObj($where);
    	$this->redirect('withdraw_detail');
    }

    //[提现申请] 取消
    function withdraw_del()
    {
    	$id = IFilter::act( IReq::get('id'),'int');
    	if($id)
    	{
    		$dataArray   = array('is_del' => 1);
    		$withdrawObj = new IModel('withdraw');
    		$where = 'id = '.$id.' and user_id = '.$this->user['user_id'];
    		$withdrawObj->setData($dataArray);
    		$withdrawObj->update($where);
    	}
    	$this->redirect('withdraw');
    }

    //[余额交易记录]
    function account_log()
    {
    	$user_id   = $this->user['user_id'];

    	$memberObj = new IModel('member');
    	$where     = 'user_id = '.$user_id;
    	$this->memberRow = $memberObj->getObj($where);
    	
    	$page= (isset($_GET['page'])&&(intval($_GET['page'])>0))?intval($_GET['page']):1;
    	$page_size = 10;
    	$queryAccountLogList = Api::run('getUcenterAccoutLog',$user_id);
    	$queryAccountLogList->pagesize = $page_size;
    	$result_list = $queryAccountLogList->find();
    	$paging = $queryAccountLogList->paging;
    	 
    	// 获取用户冻结待返还的金额总数
    	//$frozen_amount = order_tutor_rebates_class::get_user_rebate_amount($this->user['user_id']);
    	
    	 
    	
    	$this->setRenderData(array(
    	
    	    'page'         =>  $page,
    	
    	    'page_size'    =>  $page_size,
    	
    	    'page_count'   =>  $paging->totalpage,
    	    	
    	    'frozen_amount'    =>  $frozen_amount,
    	
    	    'result_list'  =>  $result_list,
    	    'isctrl' => array('url' => '/ucenter/withdraw', 'text' => '提现')
    	
    	));
    	
    	$this->title = '第三课账户';
    	$this->redirect('account_log');
    }

    //[收藏夹]备注信息
    function edit_summary()
    {
    	$user_id = $this->user['user_id'];

    	$id      = IFilter::act( IReq::get('id'),'int' );
    	$summary = IFilter::act( IReq::get('summary'),'string' );

    	//ajax返回结果
    	$result  = array(
    		'isError' => true,
    	);

    	if(!$id)
    	{
    		$result['message'] = '收藏夹ID值丢失';
    	}
    	else if(!$summary)
    	{
    		$result['message'] = '请填写正确的备注信息';
    	}
    	else
    	{
	    	$favoriteObj = new IModel('favorite');
	    	$where       = 'id = '.$id.' and user_id = '.$user_id;

	    	$dataArray   = array(
	    		'summary' => $summary,
	    	);

	    	$favoriteObj->setData($dataArray);
	    	$is_success = $favoriteObj->update($where);

	    	if($is_success === false)
	    	{
	    		$result['message'] = '更新信息错误';
	    	}
	    	else
	    	{
	    		$result['isError'] = false;
	    	}
    	}
    	echo JSON::encode($result);
    }
    
    function favorite()
    {
        $this->title = '收藏夹';
        $this->redirect('favorite');
    }

    //[收藏夹]删除
    function favorite_del()
    {
    	$user_id = $this->user['user_id'];
    	$id      = IReq::get('id');

		if(!empty($id))
		{
			$id = IFilter::act($id,'int');

			$favoriteObj = new IModel('favorite');

			if(is_array($id))
			{
				$idStr = join(',',$id);
				$where = 'user_id = '.$user_id.' and id in ('.$idStr.')';
			}
			else
			{
				$where = 'user_id = '.$user_id.' and id = '.$id;
			}

			$favoriteObj->del($where);
			$this->redirect('favorite');
		}
		else
		{
			$this->redirect('favorite',false);
			Util::showMessage('请选择要删除的数据');
		}
    }

    //[我的积分] 单页展示
    function integral()
    {
    	/*获取积分增减的记录日期时间段*/
    	$this->historyTime = IFilter::string( IReq::get('history_time','post') );
    	$defaultMonth = 3;//默认查找最近3个月内的记录

		$lastStamp    = ITime::getTime(ITime::getNow('Y-m-d')) - (3600*24*30*$defaultMonth);
		$lastTime     = ITime::getDateTime('Y-m-d',$lastStamp);

		if($this->historyTime != null && $this->historyTime != 'default')
		{
			$historyStamp = ITime::getDateTime('Y-m-d',($lastStamp - (3600*24*30*$this->historyTime)));
			$this->c_datetime = 'datetime >= "'.$historyStamp.'" and datetime < "'.$lastTime.'"';
		}
		else
		{
			$this->c_datetime = 'datetime >= "'.$lastTime.'"';
		}

    	$memberObj         = new IModel('member');
    	$where             = 'user_id = '.$this->user['user_id'];
    	$this->memberRow   = $memberObj->getObj($where,'point');
    	
    	$this->title = '我的积分';
    	$this->redirect('integral',false);
    }

    //[我的积分]积分兑换代金券 动作
    function trade_ticket()
    {
    	$ticketId = IFilter::act( IReq::get('ticket_id','post'),'int' );
    	$message  = '';
    	if(intval($ticketId) == 0)
    	{
    		$message = '请选择要兑换的代金券';
    	}
    	else
    	{
    		$nowTime   = ITime::getDateTime();
    		$ticketObj = new IModel('ticket');
    		$ticketRow = $ticketObj->getObj('id = '.$ticketId.' and point > 0 and start_time <= "'.$nowTime.'" and end_time > "'.$nowTime.'"');
    		if(empty($ticketRow))
    		{
    			$message = '对不起，此代金券不能兑换';
    		}
    		else
    		{
	    		$memberObj = new IModel('member');
	    		$where     = 'user_id = '.$this->user['user_id'];
	    		$memberRow = $memberObj->getObj($where,'point');

	    		if($ticketRow['point'] > $memberRow['point'])
	    		{
	    			$message = '对不起，您的积分不足，不能兑换此类代金券';
	    		}
	    		else
	    		{
	    			//生成红包
					$dataArray = array(
						'condition' => $ticketRow['id'],
						'name'      => $ticketRow['name'],
						'card_name' => 'T'.IHash::random(8),
						'card_pwd'  => IHash::random(8),
						'value'     => $ticketRow['value'],
						'start_time'=> $ticketRow['start_time'],
						'end_time'  => $ticketRow['end_time'],
						'is_send'   => 1,
					);
					$propObj = new IModel('prop');
					$propObj->setData($dataArray);
					$insert_id = $propObj->add();

					//更新用户prop字段
					$memberArray = array('prop' => "CONCAT(IFNULL(prop,''),'{$insert_id},')");
					$memberObj->setData($memberArray);
					$result = $memberObj->update('user_id = '.$this->user["user_id"],'prop');

					//代金券成功
					if($result)
					{
						$pointConfig = array(
							'user_id' => $this->user['user_id'],
							'point'   => '-'.$ticketRow['point'],
							'log'     => '积分兑换代金券，扣除了 -'.$ticketRow['point'].'积分',
						);
						$pointObj = new Point;
						$pointObj->update($pointConfig);
					}
	    		}
    		}
    	}

    	//展示
    	if($message != '')
    	{
    		$this->integral();
    		Util::showMessage($message);
    	}
    	else
    	{
    		$this->redirect('redpacket');
    	}
    }

    /**
     * 余额付款
     * T:支付失败;
     * F:支付成功;
     */
    function payment_balance()
    {
    	$urlStr  = '';
    	$user_id = intval($this->user['user_id']);

    	$return['attach']     = IReq::get('attach');
    	$return['total_fee']  = IReq::get('total_fee');
    	$return['order_no']   = IReq::get('order_no');
    	$return['sign']       = IReq::get('sign');

		$paymentDB  = new IModel('payment');
		$paymentRow = $paymentDB->getObj('class_name = "balance" ');
		if(!$paymentRow)
		{
			IError::show(403,'余额支付方式不存在');
		}

		$paymentInstance = Payment::createPaymentInstance($paymentRow['id']);
		$payResult       = $paymentInstance->callback($return,$paymentRow['id'],$money,$message,$orderNo);
		if($payResult == false)
		{
			IError::show(403,$message);
		}

    	$memberObj = new IModel('member');
    	$memberRow = $memberObj->getObj('user_id = '.$user_id);

    	if(empty($memberRow))
    	{
    		IError::show(403,'用户信息不存在');
    	}

    	if($memberRow['balance'] < $return['total_fee'])
    	{
    		IError::show(403,'账户余额不足');
    	}

		//检查订单状态
		$orderObj = new IModel('order');
		$orderRow = $orderObj->getObj('order_no  = "'.$return['order_no'].'" and pay_status = 0 and status = 1 and user_id = '.$user_id);
		if(!$orderRow)
		{
			IError::show(403,'订单号【'.$return['order_no'].'】已经被处理过，请查看订单状态');
		}

		//扣除余额并且记录日志
		$logObj = new AccountLog();
		$config = array(
			'user_id'  => $user_id,
			'event'    => 'pay',
			'num'      => $return['total_fee'],
			'order_no' => str_replace("_",",",$return['attach']),
		);
		$is_success = $logObj->write($config);
		if(!$is_success)
		{
			$orderObj->rollback();
			IError::show(403,$logObj->error ? $logObj->error : '用户余额更新失败');
		}

		//订单批量结算缓存机制
		$moreOrder = Order_Class::getBatch($orderNo);
		if($money >= array_sum($moreOrder))
		{
			foreach($moreOrder as $key => $item)
			{
				$order_id = Order_Class::updateOrderStatus($key);
				if(!$order_id)
				{
					$orderObj->rollback();
					IError::show(403,'订单修改失败');
				}
			}
		}
		else
		{
			$orderObj->rollback();
			IError::show(403,'付款金额与订单金额不符合');
		}

		//支付成功结果
		// 读取订单销售的商品
		$order_goods_list = Order_goods_class::get_order_goods_list($order_id);
		$order_goods_list = current($order_goods_list);
			
		// 如果用户刚刚购买完学习通后，跳转到手册激活页面
		if ( $order_goods_list['goods_id'] == 1980 )
		{
		    $this->redirect('/site/success/message/'.urlencode("支付成功").'/?callback=/ucenter/manual_info');
		} else {
		    $this->redirect('/site/success/message/'.urlencode("支付成功").'/?callback=/ucenter/order');
		}
    }

    //我的代金券
    function redpacket()
    {
		$member_info = Api::run('getMemberInfo',$this->user['user_id']);
		$propIds     = trim($member_info['prop'],',');
		$propIds     = $propIds ? $propIds : 0;
		$this->setRenderData(array('propId' => $propIds));
		
		$this->title ='代金券列表';
		$this->redirect('redpacket');
    }
    
    // 代金券线下使用详情页
    function redpacket_detail()
    {
        $id = IFilter::act(IReq::get('id'),'int');
        $order_id = IFilter::act(IReq::get('order_id'),'int');
        $brand_chit_info = brand_chit_class::get_chit_info($id);
        $order_info = order_class::get_order_info($order_id);
        if ( !$id || !$brand_chit_info )
        {
            IError::show(403,'代金券不存在');
        }
        if ( !$order_id || !$order_info )
        {
            IError::show(403,'订单不存在');
        }
        
        $goods_info = goods_class::get_goods_info($brand_chit_info['goods_id']);
        if ( $goods_info['products'] && $brand_chit_info['product_id'] > 0 )
        {
            foreach( $goods_info['products'] as $kk => $vv )
            {
                if ( $brand_chit_info['product_id'] == $vv['id'] )
                {
                    $product_info = $vv;
                }
            }
        }
        
        $price = ($product_info) ? $product_info['sell_price'] : $goods_info['sell_price'];
        $rest_price = ($price > $brand_chit_info['max_order_chit']) ? $price - $brand_chit_info['max_order_chit'] : 0;
        $this->setRenderData(array(
            'brand_chit_info'   =>  $brand_chit_info,
            'order_info'        =>  $order_info,
            'goods_info'        =>  $goods_info,
            'product_info'      =>  $product_info,
            'rest_price'        =>  $rest_price,
        ));
        $this->title = '代金券线下使用详情';
        $this->redirect('redpacket_detail');
    }
    
    // 代金券线下使用
    function redpacket_confirm_use_ajax()
    {
        $id = IFilter::act(IReq::get('id'),'int');
        $order_id = IFilter::act(IReq::get('order_id'),'int');
        $brand_chit_info = brand_chit_class::get_chit_info($id);
        $order_info = order_class::get_order_info($order_id);
        
        // 发货
        $order_goods_list = Order_goods_class::get_order_goods_list($order_id);
        $sendgoods = array();
        if ( $order_goods_list )
        {
            foreach( $order_goods_list as $kk => $vv )
            {
                $sendgoods[] = $vv['id'];
            }
        }
        if ( !$sendgoods )
        {
            die('-1');
        }
        
        $result = Order_Class::sendDeliveryGoods($order_id,$sendgoods,3);
        if ( $result !== true )
        {
            die($result);
        }
        
        // 确认收货
        $model = new IModel('order');
        
        $model->setData(array('status' => 5,'completion_time' => ITime::getDateTime()));
        if($model->update("id = ".$order_id." and distribution_status = 1 and user_id = ".$this->user['user_id']))
        {
            // 更新代金券使用状态
            prop_class::update_prop_use_status($order_info['prop']);
            
            $orderRow = $model->getObj('id = '.$id);
        
            //确认收货后进行支付
            Order_Class::updateOrderStatus($orderRow['order_no']);
       }
       die('1');
        
    }
    
    function redpacket_zuhe()
    {
        $this->title ='短期课列表';
        $this->redirect('redpacket_zuhe');
    }
	
	function promote()
    {
        $user_id = $this->user['user_id'];
        
        // 读取推广信息
        $month = date('m', strtotime("-1 months"));
                
        // 获取用户的推广码
        $my_promote_code = promote_class::get_promote_code($user_id);
        $promote_statics = array(

            // 获取上月推广用户的总数
            'user_count_by_month'       =>  promote_class::get_promote_user_count($my_promote_code, $month),
 
            // 获取所有推广用户的总数
            'user_count'                =>  promote_class::get_promote_user_count($my_promote_code),

            // 获取上月推广的商户的总数
            'seller_count_by_month'     =>  promote_class::get_promote_seller_count($my_promote_code,$month),

            // 获取所有推广的商户总数
            'seller_count'     =>  promote_class::get_promote_seller_count($my_promote_code),
            
            // 获取上月下级推广人总额
            'get_promote_list_by_account_by_month'   =>  promote_class::get_subordinate_promote_user_list_count($my_promote_code, $month),
            
            // 获取下级推广人总额
            'get_promote_list_by_account'   =>  promote_class::get_subordinate_promote_user_list_count($my_promote_code),
            
            // 获取上月个人用户提成总额
            'user_prommission_count_by_month'   =>  prom_commission_class::get_user_commision_count($user_id, 1, $month),
            
            // 获取个人用户提成总额
            'user_prommission_count'    =>  prom_commission_class::get_user_commision_count($user_id),
            
            // 获取上月商户提成总额
            'seller_prommission_count_by_month' =>  prom_commission_class::get_seller_commision_count($user_id, 1, $month),
            
            // 获取商户提成总额
            'seller_prommission_count' =>  prom_commission_class::get_seller_commision_count($user_id),
            
            // 获取上月下级返佣总额
            'other_commision_count_by_month'   =>  prom_commission_class::get_other_commision_count($user_id, 1, $month),
            
            // 获取下级返佣总额
            'other_commision_count'   =>  prom_commission_class::get_other_commision_count($user_id),

        );
        //dump($promote_statics);
        
        $type = IFilter::act(IReq::get('type'),'int');
        $page = IFilter::act(IReq::get('page'),'int');
        $type = max($type,1);
        $page = max($page,1);
        
        $promotelistorder = Member_class::getPromoteListOrderByCode($user_id);
        $promotelist = Member_class::getPromoteListByCode($user_id);
        $promotelistseller = Member_class::getPromoteSellerByCode($user_id);
        $promotelistperson = Member_class::getPromotePersonByCode($user_id);
        $this->setRenderData(array(

            'promotelistorder' =>  $promotelistorder,
            'promotelist' =>  $promotelist,
            'promotelistseller' =>  $promotelistseller,
            'promotelistperson' =>  $promotelistperson,
            
            'type'          =>  $type,
            'page'          =>  $page,
            
            'my_promote_code'   =>  $my_promote_code,
            'promote_statics'   =>  $promote_statics,  

        ));
        
        $this->title = '我的推广';
        
        $this->redirect('promote');
    }
    
    function promote_user_list()
    {
        $user_id = $this->user['user_id'];
        // 获取用户的推广码
        $my_promote_code = promote_class::get_promote_code($user_id);
        $promote_user_list = promote_class::get_promote_user_list_info($my_promote_code);
        if ( $promote_user_list )
        {
            foreach( $promote_user_list as $kk => $vv )
            {
                $promote_user_list[$kk]['pay_count'] = order_class::get_user_pay_count($vv['user_id']);
            }
        }
        
        $this->setRenderData(array(
            'promote_user_list' =>  $promote_user_list,
        ));
        
        $this->title = '我的推广 - 个人用户列表';
        
        $this->redirect('promote_user_list');
    }
    
    function promote_seller_list()
    {
        $user_id = $this->user['user_id'];
        // 获取用户的推广码
        $my_promote_code = promote_class::get_promote_code($user_id);
        $promote_seller_list = promote_class::get_promote_seller_list_info($my_promote_code);

        if ( $promote_seller_list )
        {
            foreach( $promote_seller_list as $kk => $vv )
            {
                $promote_seller_list[$kk]['order_count'] = order_class::get_seller_order_count($vv['id']);
            }
        }
        
        $this->setRenderData(array(
            'promote_seller_list'   =>  $promote_seller_list,
        ));
        
        $this->title = '我的推广 - 机构列表';
        
        $this->redirect('promote_seller_list');
    }
    
    function promote_subordinate_user_list()
    {
        $user_id = $this->user['user_id'];
        // 获取用户的推广码
        $my_promote_code = promote_class::get_promote_code($user_id);
        $promote_subordinate_user_list = promotor_class::get_my_promotor_list($my_promote_code);
        
        $arr = array();
        if ( $promote_subordinate_user_list )
        {
            foreach( $promote_subordinate_user_list as $kk => $vv )
            {
                foreach( $vv as $key => $val )
                {
                    if ( $kk == 'users')
                    {
                        $info = user_class::get_user_info($val);
                        $name = $info['username'];
                        $promote_code = promote_class::get_promote_code($val);
                        $user_commission = prom_commission_class::get_user_commision_count($val);
                        $seller_commission = prom_commission_class::get_seller_commision_count($val);
                    } else {
                        $val = substr($val, 1);
                        $info = seller_class::get_seller_info($val);
                        $name = $info['shortname'];
                        $promote_code = promote_class::get_promote_code($val,2);
                        $user_commission = prom_commission_class::get_user_commision_count($val,2);
                        $seller_commission = prom_commission_class::get_seller_commision_count($val,2);
                    }
                    
                    $arr[] = array(
                        'name'  =>  $name,
                        'promote_user_count'    =>  promote_class::get_promote_user_count($promote_code),
                        'promote_seller_count'  =>  promote_class::get_promote_seller_count($promote_code),
                        'subordinate_promote_user_count'    =>  promote_class::get_subordinate_promote_user_list_count($promote_code),
                        'commission_count'      =>  $user_commission + $seller_commission,
                    );
                }
            }
        }
        
        $this->setRenderData(array(
            'promote_subordinate_user_list' =>  $arr,
        ));
        
        $this->title = '我的推广 - 下级推广列表';
        
        $this->redirect('promote_subordinate_user_list');
    }
    
    function promote_previous_month()
    {
        $type = IFilter::act(IReq::get('type'),'int');
        $page = IFilter::act(IReq::get('page'),'int');
        $type = max($type,1);
        $page = max($page,1);
        
        $user_id = $this->user['user_id'];
        $promotelistorder = Member_class::getPromoteListOrderByCode($user_id,0);
        $promotelist = Member_class::getPromoteListByCode($user_id, 0);
        $this->setRenderData(array(
            'promotelistorder' =>  $promotelistorder,
            'promotelist' =>  $promotelist,
            'type'          =>  $type,
            'page'          =>  $page,
        ));
        $this->redirect('promote_previous_month');
    }
    
    // 获取用户收藏夹信息
    function get_favorite_list_ajax()
    {
        $user_id = $this->user['user_id'];
        $page = $_GET['page'] + 0;
        $page = max( $page, 1);
        $page_size = 10;
        $db = $this->get_favorite_db($page_size);
        $favorite_list = $db->find();
        if ( $favorite_list )
        {
            foreach($favorite_list as $kk => $vv )
            {
                $favorite_list[$kk]['category_str'] = Category_extend_class::get_category_name_by_store( $vv['seller_id'] );
            }
        }
    
        if ( $favorite_list )
        {
            $favorite_list['num'] = count($favorite_list);
            $favorite_list['page'] = $page + 1;
        } else {
            $resultData['num'] = 0;
            $resultData['page'] = 1;
        }
    
        echo json_encode($favorite_list);
    }
    
    //[收藏夹]获取收藏夹数据
    function get_favorite_db($page_size = 0 )
    {
        //获取收藏夹信息
        $page = (isset($_GET['page'])&&(intval($_GET['page'])>0))?intval($_GET['page']):1;
        $favoriteObj = new IQuery("favorite as f");
        $cat_id = intval(IReq::get('cat_id'));
        $where = '';
        if($cat_id != 0)
        {
            $where = ' and f.cat_id = '.$cat_id;
        }
    
        $favoriteObj->join = 'left join goods as g on f.rid = g.id left join seller as s on g.seller_id = s.id';
        $favoriteObj->where = "f.user_id = ".$this->user['user_id'].$where;
        $favoriteObj->fields = 'f.*,g.seller_id,s.seller_name,s.shortname,s.logo,s.address';
        $favoriteObj->page  = $page;
    
        if ( $page_size > 0 )
            $favoriteObj->pagesize = $page_size;
    
        return $favoriteObj;
    }
    
    // 手机版获取代金券
    function ajaxredpacket()
    {
        $type = IFilter::act(IReq::get('type'),'int');    
        $my_prop_list_ing = $this->format_prop(API::run('getUserPropListing', $this->user['user_id']));    
        $my_prop_list_ed = $this->format_prop(API::run('getUserPropListed', $this->user['user_id']));    
        $my_prop_list_notpay = $this->format_prop(API::run('getUserPropListNotPay', $this->user['user_id']));
    
        if($type == 1){
            $my_prop_list_ing['num'] = count($my_prop_list_ing);
            echo json_encode($my_prop_list_ing);
        }elseif($type == 2){
            $my_prop_list_ed['num'] = count($my_prop_list_ed);
            echo json_encode($my_prop_list_ed);
        }else{
            $my_prop_list_notpay['num'] = count($my_prop_list_notpay);
            echo json_encode($my_prop_list_notpay);
        }
    }
    
    // 填写交易密码
    public function check_trade_password()
    {
        $user_id    = $this->user['user_id'];
        $user_info = member_class::get_member_info($user_id);
        $order_id = IFilter::act( IReq::get('order_id'));
        $order_info = order_class::get_order_info($order_id);
    
        $this->order_id = $order_id;
        $this->redirect('check_trade_password');
    }
    
    // 验证交易密码
    public function check_trade_password_update()
    {
        $input_trade_passwd = IFilter::act( IReq::get('trade_password'));
        $order_id = IFilter::act( IReq::get('order_id'));    
        $this->order_id = $order_id;    
        $user_id    = $this->user['user_id'];            
        if ( !$input_trade_passwd )    
        {    
            IError::show(403,"交易密码不能为空");    
        }    
        $trade_passwd = member_class::get_user_trade_passwd($user_id);    
        if ( md5( $input_trade_passwd) != $trade_passwd )    
        {    
            IError::show(403,"交易密码不正确");    
        }
        
        if ( $order_id )
        {
            header("location: " . IUrl::creatUrl('/block/doPay/order_id/' . $this->order_id));
        } else {
            header("location: " . IUrl::creatUrl('/ucenter/order'));
        }
    }
    
    function format_prop($my_prop_list)
    {
        if ( $my_prop_list )
        {
            foreach( $my_prop_list as $kk => $vv )
            {
                if ( !isset( $seller_list[$vv['seller_id']]))
                {
                    $seller_list[$vv['seller_id']] = Seller_class::get_seller_info( $vv['seller_id'] );
                }
                $order_list[$kk]['seller_info'] = $seller_list[$vv['seller_id']];
                $my_prop_list[$kk]['status_str'] = Order_Class::orderStatusText(Order_Class::getOrderStatus($vv), 1, $vv['statement']);
                $my_prop_list[$kk]['order_status_t'] = Order_Class::getOrderStatus($vv);
                if($vv['chit_id'])
                {
                    $my_prop_list[$kk]['chit_info'] = brand_chit_class::get_chit_info($vv['chit_id']);
                    $my_prop_list[$kk]['chit'] = $my_prop_list[$kk]['chit_info']['max_order_chit'];
                    $my_prop_list[$kk]['seller_info'] = seller_class::get_seller_info($my_prop_list[$kk]['chit_info']['seller_id']);
                    $my_prop_list[$kk]['goods_info'] = goods_class::get_goods_info($my_prop_list[$kk]['chit_info']['goods_id']);
                    if ( !$my_prop_list[$kk]['chit_info']['id'] )
                        unset($my_prop_list[$kk]);
                }
                else
                {
                    $my_prop_list[$kk]['chit'] = number_format( order_class::get_real_order_chit( $my_prop_list[$kk]['goods']['market_price'], $my_prop_list[$kk]['goods']['cost_price'], $vv['order_amount'] ), 2, '.','');
                }    
            }    
        }
    
        sort( $my_prop_list );
        return $my_prop_list;
    }
    
    function send_password_sms()
    {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $mobile = IFilter::act(IReq::get('mobile'));
        $type = IFilter::act(IReq::get('type')); //3 修改密码验证
        if ( !$mobile)
        {
            die('请输入正确的手机号码');
        }

        // 通过手机号获取用户信息，判断手机号是否已注册
        $user_info = Member_class::get_member_info_by_mobile( $mobile );

        // 查找是否有发送过注册短信验证码，如果存在则判断时间间隔
        $sms_info = Sms_class::get_sms_info( $mobile, $type );
        $now = time();    
        if ( $sms_info )    
        {    
            $send_time = $sms_info['addtime'];    
            $send_time = strtotime("+ 60 seconds", $send_time );            
            if ( $now < $send_time )    
            {    
                $time = 60 - ( $now - $sms_info['addtime'] ) % 60;    
                die("发送验证码时间间隔为1分钟，请在 $time 秒后再试");    
            }    
        }        
    
        $rand_code = Sms_class::get_rand_code();    
        $sms_db = new IModel('sms');    
        $sms_db->setData(array(
            'mobile'    =>  $mobile,
            'code'      =>  $rand_code,
            'action'    =>  $type,
            'addtime'   => time(),
        ));
        if ( $sms_info )
        {
            $result = $sms_db->update('id = ' . $sms_info['id'] );
        } else {
            $result = $sms_db->add();
        }
        
        if ( $result )
        {
            $content = '您的验证码是' . $rand_code . '。【乐享生活】';
            $sms = new Sms_class();    
            $result = $sms->send( $mobile, $content );    
            if($result['stat']=='100')    
                die('success');    
            else    
                die('发送失败');    
        } else {
            die('操作失败');
        }
    }
    
    function ajaxredpacket_zuhe()
    {
        $type = IFilter::act(IReq::get('type'),'int');
        $type = max($type, 1);
    
        $my_prop_list_ing = API::run('getUserPropZuheListing', $this->user['user_id']);
        $my_prop_list_notpay = API::run('getUserPropZuheListNotPay', $this->user['user_id']);
    
        if ( $type == 1 )
        {
            $my_prop_list = $my_prop_list_ing;
        } else {
            $my_prop_list = $my_prop_list_notpay;
        }
    
        if ( $my_prop_list )
        {
            foreach($my_prop_list as $kk => $vv )
            {
                $my_prop_list[$kk]['start_time'] = ($vv['start_time'] > 0 ) ? date('Y-m-d H:i', $vv['start_time']) : '';
                $my_prop_list[$kk]['end_time'] = ($vv['end_time'] > 0 ) ? date('Y-m-d H:i', $vv['end_time']) : '';
            }
        }
    
        $my_prop_list['num'] = sizeof($my_prop_list);
        echo json_encode($my_prop_list);
    }
    
    function redpacket_zuhe_detail()
    {
    
        $id = IFilter::act(IReq::get('id'),'int');
        $orderObj = new order_class();
        $this->order_info = $orderObj->getOrderShow($id,$this->user['user_id']);
        $user_id = $this->user['user_id'];
    
        if(!$this->order_info)
        {
            IError::show(403,'订单信息不存在');
        }
    
        $orderStatus = Order_Class::getOrderStatus($this->order_info);    
        $this->orderStep = Order_Class::orderStep($this->order_info);    
        $this->order_log_list = order_log_class::get_order_logs($id);        
    
        $goods_list = Api::run('getOrderGoodsListByGoodsid',array('#order_id#',$this->order_info['order_id']));    
        if ( $goods_list )    
        {    
            $productsModel = new IModel('products');    
            foreach( $goods_list as $kk => $vv )    
            {    
                $goods_list[$kk]['goods_array'] = json_decode($vv['goods_array']);    
                $goods_array = $goods_list[$kk]['goods_array'];    
                $goods_list[$kk]['spec'] = explode(':',$goods_array->value );    
                $goods_list[$kk]['name'] = $goods_array->name;    
                if ( $vv['product_id'] )    
                {    
                    $products = $productsModel->getObj("id = '$vv[product_id]'");    
                    $goods_list[$kk]['discount'] = $products['discount'];    
                }
            }
        }

        $is_set_trade_passwd = member_class::is_set_trade_passwd($user_id);
    
        $zuhe_db = new IQuery('brand_chit_zuhe');
        $zuhe_db->where = 'id = ' . $this->order_info['zuhe_id'];
        $zuhe_info = $zuhe_db->getOne();
    
        $zuhe_db = new IQuery('brand_chit_zuhe');
        $zuhe_db->where = 'id = ' . $this->order_info['zuhe_id'];
        $zuhe_info = $zuhe_db->getOne();
    
        $zuhe_detail_db = new IQuery('brand_chit_zuhe_detail as d');
        $zuhe_detail_db->join = 'left join brand_chit as c on d.brand_chit_id = c.id ';
        $zuhe_detail_db->where = 'zuhe_id = ' . $this->order_info['zuhe_id'];
        $detail_list = $zuhe_detail_db->find();
    
        $seller_ids = array();
        if ( $detail_list )
        {
            $brand_chit_zuhe_use_list_db = new IQuery('brand_chit_zuhe_use_list');
            foreach( $detail_list as $kk => $vv )
            {
                if ( $vv['seller_id'] )
                {
                    $brand_chit_zuhe_use_list_db->where = 'order_id = ' . $this->order_info['id'] . ' and brand_chit_id = ' . $vv['brand_chit_id'] . ' and seller_id = ' . $vv['seller_id'];
                    $info = $brand_chit_zuhe_use_list_db->getOne();
                    $detail_list[$kk]['availeble_use_times'] = ($info['availeble_use_times']) ? $info['availeble_use_times'] : 0;
                    $detail_list[$kk]['use_list_id'] = $info['id'];
                    $detail_list[$kk]['status'] = $info['status'];
                    $seller_ids[] = $vv['seller_id'];
                }
            }
        }
    
        $seller_db = new IQuery('seller as s');
        $seller_db->where = db_create_in($seller_ids,'id');
        $seller_db->fields = 'id,shortname';
        $seller_list = $seller_db->find();
    
        $this->setRenderData( array(
            'seller_info'   =>  $seller_info,
            'chit_info'   =>  $chit_info,
            'goods_list'    =>  $goods_list,
            'orderStatus'   =>  $orderStatus,
            'order_id'      =>  $id,
            'is_set_trade_passwd'   =>  $is_set_trade_passwd,
            'detail_list'	=> $detail_list,
            'seller_list' => $seller_list,
            'zuhe_info' => $zuhe_info,
        ) );
    
        $this->title = '订单详情';
        $this->redirect('redpacket_zuhe_detail');
    }
    
    function tutor_list()
    {
        $user_id = $this->user['user_id'];
        $page = IFilter::act(IReq::get('page'),'int');
        $page = max($page, 1);
    
        // 读取家教列表信息
        $tutor_db = tutor_class::get_tutor_list_db($user_id, 0, $page);
        $tutor_list = $tutor_db->find();
    
        // 获取用户信息
        $member_info = member_class::get_member_info($user_id);
    
        $this->setRenderData(array(
            'tutor_list'    =>  $tutor_list,
            //'page_info'     =>  $tutor_db->getPageBar(),
            'member_info'   =>  $member_info,
            'is_auth'       =>  ( $this->_check_user_auth($user_id) ) ? 1 : 0,
        ));
    
        $this->title = '我的家教';
    
        $this->redirect('tutor_list');
    }
    
    // 我的文章
    function article_list()
    {
        $page = IFilter::act(IReq::get('page'),'int');    
        $page = max( $page, 1 );    
        $page_size = 12;    
        $page = max( $page, 1 );    
        $article_db = new IQuery('article');    
        $article_db->where = 'user_id = ' . $this->user['user_id'] . ' and category_id = 7';    
        $article_db->page = $page;    
        $article_db->pagesize = $page_size;    
        $article_db->order = 'id desc';    
        $article_list = $article_db->find();    
        $paging = $article_db->paging;        
    
        $this->setRenderData(array(    
            'article_list'  =>  $article_list,    
            'page_info'     =>  $article_db->getPageBar(),    
            'page_count'    =>  $paging->totalpage,    
            'page'          =>  $page,
            'page_size'     =>  $page_size,
            'isctrl' => array('url' => '/ucenter/article_add', 'text' => '发表')
        ));
        $this->title = '我的文章';
        $this->redirect('article_list');
    }
    
    function article_add()
    {
        $id = IFilter::act(IReq::get('id'));
        if($id)
        {
            $article_db = new IModel('article');
            $article = $article_db->getObj("id = '$id'");
            $article['formats'] = explode('||', $article['formatcontent']);
            $this->setRenderData(array(
                "article"       => $article
            ));
        }
        $this->title = '发表文章';
        $this->redirect('article_add');
    }
    
    function article_list2()
    {
        $page = IFilter::act(IReq::get('page'),'int');
        $page = max( $page, 1 );
        $page_size = 12;
        $page = max( $page, 1 );
        $article_db = new IQuery('article');
        $article_db->where = 'user_id = ' . $this->user['user_id'] . ' and category_id = 7';
        $article_db->page = $page;
        $article_db->pagesize = $page_size;
        $article_db->order = 'id desc';
        $article_list = $article_db->find();
        $paging = $article_db->paging;
        $this->setRenderData(array(
            'article_list'  =>  $article_list,
            'page_info'     =>  $article_db->getPageBar(),
            'page_count'    =>  $paging->totalpage,
            'page'          =>  $page,
            'page_size'     =>  $page_size,
            'isctrl' => array('url' => '/ucenter/article_add2', 'text' => '发表')
        ));
        $this->title = '试听报告';
        $this->redirect('article_list2');
    }
    
    function article_add2()
    {
        $id = IFilter::act(IReq::get('id'));
        if($id)
        {
            $article_db = new IModel('article');
            $article = $article_db->getObj("id = '$id'");
            $article['formats'] = explode('||', $article['formatcontent']);
            $this->setRenderData(array(
                "article"       => $article
            ));
        }
        $this->title = '发表课程报告';
        $this->redirect('article_add2');
    }
	//更新文章
	function article_update()

	{

	    $id = IFilter::act(IReq::get('id'), 'int');

	    $title = IFilter::act(IReq::get('title'), 'string');

	    $content = IFilter::act(IReq::get('content'), 'text');

	    $user_id = $this->user['user_id'];

	

	    $bad_file = IWEB_ROOT . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'bad_words.php';

	    if ( file_exists($bad_file))

	    {

	        $bad_words = include_once($bad_file);

	        $title_bad_words = check_bad_words($title, $bad_words );

	        $content_bad_words = check_bad_words($content, $bad_words );

	

	        $title = ( $title_bad_words ) ? str_replace($title_bad_words, '', $title ) : $title;

	        $content = ( $content_bad_words ) ? str_replace($content_bad_words, '', $content ) : $content;

	        unset( $bad_words );

	    }

	

	    if ( $id )

	    {

	        $article_info = article::get_info( $id );

	        if ( !$article_info )

	        {

	            IError::show(403,'文章不存在');

	            exit();

	        }

	        if ( $article_info['user_id'] != $user_id )

	        {

	            IError::show(403,'您没有权限修改该文章');

	            exit();

	        }

	    }

	

	    $article_db = new IQuery('article');

	    $article_model = new IModel('article');

	    if ( $id )

	    {

	        $article_db->where = "title = '$title' and id !=  $id";

	    } else {

	        $article_db->where = "title = '$title'";

	    }

	

	    $article_row = $article_db->getOne();

	    if ( $article_row )

	    {

	        //$this->show_warning('标题已存在');

	        IError::show(403,'标题已存在');

	        exit();

	    }

	

	    $data = array(

	        'title'         =>  $title,

	        'content'       =>  $content,

	        'category_id'   =>  7,

	        'create_time'   =>  date('Y-m-d H:i:s'),

	        'user_id'       =>  $user_id,

	    );

	    $article_model->setData($data);

	    if ( $id )

	    {

	        $result = $article_model->update('id = ' . $id );

	    } else {

	        $result = $article_model->add();

	    }

	

	    if ( $result )

	    {

	        //$title = ( $id ) ? '修改文章成功' : '添加文章成功';

	        //$this->show_message($title, '返回文章列表', IUrl::creatUrl('/ucenter/article_list'));

	        header("location: " . IUrl::creatUrl('/ucenter/article_list'));

	    } else {

	        //$this->show_warning('添加失败');

	        IError::show(403,'添加失败');

	    }

	    exit();

	}

    
    // 皮纹检测报名
    function article_add3()
    {
        $id = IFilter::act(IReq::get('id'));
    
        if($id)
    
        {
    
            $article_db = new IModel('article');
    
            $article = $article_db->getObj("id = '$id'");
    
            $article['formats'] = explode('||', $article['formatcontent']);
    
            $this->setRenderData(array(
    
                "article"       => $article
    
            ));
    
        }
    
        $user_id = $this->user['user_id'];
        $article_db = new IQuery('article');
        $article_db->where = 'category_id = 17 and user_id = ' . $user_id;
        $result = $article_db->getOne();
        if ( $result )
        {
            //header("location: " . IUrl::creatUrl('/site/article_detail3/id/' . $result['id']));
            IError::show(403,'您已经报名成功，请勿重复报名!');
        }
 
        $this->title = '提交报名表';
    
        $this->redirect('article_add3');
    
    }
    
    // 保存试听报告
    function article_update_mobile2()
    {
        $id = IFilter::act(IReq::get('id','post'));
        $title = IFilter::act(IReq::get('title','post'));
        $content = IFilter::act(IReq::get('content','post'),'text');
        $name = IFilter::act(IReq::get('name','post'));
        $tel = IFilter::act(IReq::get('tel','post'));
        $formatcontent = IFilter::act(IReq::get('formatcontent','post'),'text');
    
        if ( !$title )
        {
            IError::show(403,'标题不能为空!');
            exit();
        }
    
        if ( !$content )
        {
            IError::show(403,'内容不能为空!');
            exit();
        }
        
        if ( !$name )
        {
            IError::show(403,'姓名不能为空!');
            exit();
        }
        
        if ( !$tel )
        {
            IError::show(403,'电话号码不能为空!');
            exit();
        }
    
        $article_db = new IModel('article');
        $article_db->setData(array(
            'user_id'   =>  $this->user['user_id'],
            'title'     =>  $title,
            'content'   =>  $content,
            'name'      =>  $name,
            'tel'       =>  $tel,
            'formatcontent'   =>  $formatcontent,
            'category_id'   =>  7,
            'create_time'   =>  date('Y-m-d H:i:s', time())
        ));
    
        if($id)
        {
            $article_db->update("id = '$id'");
        }
        else
        {
            $id = $article_db->add();
        }
    
        //$this->redirect('article_list2');
        //$this->redirect('/site/article_detail2/id/' . $id);
        $this->redirect('/site/success/message/'.urlencode("发布成功").'/callback_str/' . urlencode('查看报告') . '/?callback=/site/article_detail2/id/' . $id);
    }
    
    // 皮纹检测报名保存
    function article_update_mobile3()
    {
    
        $time = time();    
        $id = IFilter::act(IReq::get('id','post'));
    
        $title = IFilter::act(IReq::get('title','post'));
    
        $content = IFilter::act(IReq::get('images','post'));
    
        $age =  IFilter::act(IReq::get('age','post'));
    
        $tel =  IFilter::act(IReq::get('tel','post'));
        
        $is_teacher = IFilter::act(IReq::get('is_teacher','post'));
        
        $property = array(
            'is_teacher'    =>  $is_teacher,
        );
    
    
    
        if ( !$title )
    
        {
    
            $this->show_message('标题不能为空');
    
            exit();
    
        }
    
    
    
        if ( !$content )
    
        {
    
            $this->show_message('内容不能为空');
    
            exit();
    
        }
    
    
    
        $article_db = new IModel('article');
    
        $article_db->setData(array(
    
            'user_id'   =>  $this->user['user_id'],
    
            'title'     =>  $title,
    
            'keywords'       =>  $age,
    
            'description'       =>  $tel,
    
            'content'   =>  $content,
    
            'category_id'   =>  17,
    
            'create_time'   =>  date('Y-m-d H:i:s', time()),
            
            'property'      =>  serialize($property),
    
        ));
    
        if($id)
    
        {
    
            $article_db->update("id = '$id'");
    
        }
    
        else
    
        {
    
            $id = $article_db->add();
    
        }
    
        $this->redirect('/site/success/message/'.urlencode("报名成功").'/?callback=/ucenter');
    }
    
    public function consult()
    {
        $page_size = 10;
        $page= (isset($_GET['page'])&&(intval($_GET['page'])>0))?intval($_GET['page']):1;
        $user_id = $this->user['user_id'];
        $queryConsultList = Api::run('getUcenterConsult',$user_id);
        $consult_list = $queryConsultList->find();
        $result_count = sizeof( $consult_list );
        $page_count = ceil( $result_count / $page_size );
    
        $queryConsultList = Api::run('getUcenterConsult',$user_id);
        $queryConsultList->pagesize = $page_size;
        $consult_list = $queryConsultList->find();
    
        if ( $consult_list )
        {
            foreach( $consult_list as $kk => $vv )
            {
                $goods_info = goods_class::get_goods_info( $vv['gid'] );
                $consult_list[$kk]['img'] = $goods_info['img'];
            }
        }
    
        $this->setRenderData(array(
            'consult_list'  =>  $consult_list,
            'user_id'       =>  $user_id,
            'page'          =>  $page,
            'page_size'     =>  $page_size,
            'page_count'    =>  $page_count,
        ));
    
        $this->title = '报名咨询';
    
        $this->redirect('consult');
    }
    
    public function evaluation()
    {
        $page = IFilter::act(IReq::get('page'),'int');
        $page = max( $page, 1);
        $page_size = 10;
        $user_id = $this->user['user_id'];
         
        $queryEvaluationList2 = Api::run('getUcenterEvaluation',$user_id,0);
        $result = $queryEvaluationList2->find();
        $result_count = sizeof( $result );
        $page_count = ( $result_count ) ? ceil( $result_count / $page_size ) : 0;
         
        $queryEvaluationList = Api::run('getUcenterEvaluation',$user_id,0);
        $queryEvaluationList->pagesize = $page_size;
        $result_list = $queryEvaluationList->find();
         
        if ( $result_list )
        {
            foreach( $result_list as $kk => $vv )
            {
                $order_info = order_class::get_order_info($vv['order_no'],2);
                if ( $order_info )
                {
                    $goods_list = Api::run('getOrderGoodsListByGoodsid',array('#order_id#',$order_info['id'] ));
                    $result_list[$kk]['goods_list'] = $goods_list;
                    $result_list[$kk]['order_info'] = order_class::get_order_info($vv['order_no'],2);
                }
                if ( $result_list[$kk]['order_info']['statement'] == 4)
                {
                    $seller_info = seller_class::get_seller_info($vv['seller_id']);
                    $result_list[$kk]['name'] = $seller_info['true_name'];
                }
            }
        }
         
        $this->setRenderData(array(
            'result_list'  =>  $result_list,
            'page'         =>  $page,
            'page_size'    =>  $page_size,
            'page_count'   =>  $page_count,
        ));
    
        $this->title = '课后评价 - 未评价';
         
        $this->redirect('evaluation');
    }
    
    public function isevaluation()
    {
        $page = IFilter::act(IReq::get('page'),'int');
        $page = max( $page, 1);
        $page_size = 10;
        $user_id = $this->user['user_id'];
    
        $queryIevaluationList2 = Api::run('getUcenterEvaluation',$user_id,1);
        $result = $queryIevaluationList2->find();
        $result_count = sizeof( $result );
        $page_count = ( $result_count ) ? ceil( $result_count / $page_size ) : 0;
         
        $queryIevaluationList = Api::run('getUcenterEvaluation',$user_id,1);
        $queryIevaluationList->pagesize = $page_size;
        $result_list = $queryIevaluationList->find();
         
        if ( $result_list )
        {
            foreach( $result_list as $kk => $vv )
            {
                $order_info = order_class::get_order_info($vv['order_no'],2);
                if ( $order_info )
                {
                    $goods_list = Api::run('getOrderGoodsListByGoodsid',array('#order_id#',$order_info['id'] ));
                    $result_list[$kk]['goods_list'] = $goods_list;
                    $result_list[$kk]['order_info'] = order_class::get_order_info($vv['order_no'],2);
                }
                if ( $result_list[$kk]['order_info']['statement'] == 4)
                {
                    $seller_info = seller_class::get_seller_info($vv['seller_id']);
                    $result_list[$kk]['name'] = $seller_info['true_name'];
                }
            }
        }
         
        $this->setRenderData(array(
            'result_list'  =>  $result_list,
            'page'         =>  $page,
            'page_size'    =>  $page_size,
            'page_count'   =>  $page_count,
            'page_info'    =>  $queryIevaluationList->getPagebar(),
        ));
    
        $this->title = '课后评价 - 已评价';
         
        $this->redirect('isevaluation');
    }
    
    function complain()
    {
        $this->title = '站点建议';
        $this->redirect('complain');
    }
    
    function setting()
    {
        $this->title = '设置';
        $this->redirect('setting');
    }
        
    //[修改交易密码]修改动作
    function update_trade_password_edit()
    {
        $user_id    = $this->user['user_id'];
        $password   = IReq::get('password');
        $repassword = IReq::get('repassword');
        $order_id = IFilter::act( IReq::get('order_id'));
        $userObj    = new IModel('user');
        $where      = 'id = '.$user_id;
        $userRow    = $userObj->getObj($where);
        if(!preg_match('|\w{6,32}|',$password))
        {
            $message = '密码格式不正确，请重新输入';
        }
        else if($password != $repassword)
        {
            $message  = '二次密码输入的不一致，请重新输入';
        }
        else
        {
            $passwordMd5 = md5($password);
            $dataArray = array(
                'trade_password' => $passwordMd5,
            );
 
            $userObj->setData($dataArray);
            $result  = $userObj->update($where);
            if($result)
            {
                $message = '交易密码修改成功';
            }
            else
            {
                $message = '交易密码修改失败';
            }
        }
    
        if ( $order_id > 0 )
        {
            header("location: " . IUrl::creatUrl('/ucenter/order_detail/id/' . $order_id));
            exit();
        } else {
            header("location: " . IUrl::creatUrl('/ucenter/order/type/2'));
            exit();
        }

        //$this->redirect('update_trade_password',false);
        //Util::showMessage($message);
    }
    
    // 实名认证 提交
    function authentication_edit_act()
    {
        $user_id = $this->user['user_id'];
        $data = array(
            'true_name'      =>  IFilter::act(IReq::get('true_name')),
            'id_card'        =>  IFilter::act(IReq::get('id_card')),
            'contact_addr'   =>  IFilter::act(IReq::get('contact_addr')),
            'upphoto'   =>  IFilter::act(IReq::get('upphoto')),
            'downphoto'   =>  IFilter::act(IReq::get('downphoto')),
            'bankname'  =>  IFilter::act(IReq::get('bankname')),
            'accountname'  =>  IFilter::act(IReq::get('accountname')),
            'account'  =>  IFilter::act(IReq::get('account')),
            //'is_promoter'   =>  IFilter::act(IReq::get('is_promoter')),
        );
        $user_info = member_class::get_member_info($user_id);
        if ($user_info['is_auth'])
        {
            unset($data['bankname']);
            unset($data['accountname']);
            unset($data['account']);
        }
    
        $type = IFilter::act(IReq::get('type'),'int');
        $back = IFilter::act(IReq::get('back'));
    
        if ( !$data['true_name'])
        {
            IError::show(403, '请输入真实姓名');
            exit();
        }
        if ( !$data['id_card'] )
        {
            IError::show(403, '请输入身份证号码');
            exit();
        }
        if ( !$data['upphoto'] )
        {
            IError::show(403, '请上传身份证正面');
            exit();
        }
        if ( !$data['downphoto'] )
        {
            IError::show(403, '请上传身份证反面');
            exit();
        }
    
        if (!$user_info['is_auth'])
        {
            if ( !$data['bankname'] )
            {
                IError::show(403, '请输入开户银行');
                exit();
            }
            if ( !$data['accountname'] )
            {
                IError::show(403, '请输入银行账户');
                exit();
            }
            if ( !$data['account'] )
            {
                IError::show(403, '请输入卡号');
                exit();
            }
        }
    
        $member_db = new IModel('member');
        $member_db->setData($data);
        $member_db->update('user_id = ' . $user_id);
    
        if ( $type != 2 )
        {
            $this->redirect('authentication');
        } else {
            $member_info = member_class::get_member_info($user_id);
    
            $auth_arr = array(
                'name'     =>  $member_info['true_name'],
                'mobile'   =>  $member_info['mobile'],
                'cardsn'   =>  $member_info['id_card'],
                'account'  =>  $member_info['account'],
            );
    
            if ( check_auth($auth_arr['name'], $auth_arr['mobile'], $auth_arr['cardsn'], $auth_arr['account']) )
            {
                $member_db = new IModel('member');
                $member_db->setData(array(
                    'is_auth' => 1,
                ));
                $member_db->update('user_id = ' . $user_id);
    
                $tutor_db = new IModel('tutor');
                $tutor_db->setData(array('is_publish' => 1));
                $tutor_db->update('user_id = ' . $user_id);
                $this->redirect('authentication');
            }
        }
    }
    
    // 手机端获取订单列表
    public function get_order_list_ajax()
    {
    
        $page_size = 15;
    
        $page = IFilter::act(IReq::get('page'),'int');
    
        $page = max( $page, 1 );
    
        $user_id = $this->user['user_id'];
    
        $type = IFilter::act(IReq::get('type'),'int');
    
        $type = max($type, 1);
    
        //$queryOrderList = Api::run('getOrderList',$user_id, $type);
    
        //$queryOrderList->pagesize = $page_size;
    
        //$order_list = $queryOrderList->find();
    
        //$paging = $queryOrderList->paging;
    
        $order_list_info = order_class::get_order_list($user_id, $type, $page );
        if ( $order_list_info )
        {
            $order_list = $order_list_info['list'];
            $page_info = $order_list_info['page_info'];
            $page_count = $order_list_info['page_count'];
        }
    
    
        $goodsModel = new IModel('goods');
    
        $ordergoodsModel = new IModel('order_goods');
    
        $productsModel = new IModel('products');
    
        $seller_list = array();
    
        $return = '';
    
        $is_set_trade_passwd = member_class::is_set_trade_passwd($user_id);
    
        if ( $order_list )
    
        {
    
            foreach( $order_list as $kk => $vv )
    
            {
    
                if ( !isset( $seller_list[$vv['seller_id']]))
    
                {
    
                    $seller_list[$vv['seller_id']] = Seller_class::get_seller_info( $vv['seller_id'] );
    
                }
    
                $order_list[$kk]['seller_info'] = $seller_list[$vv['seller_id']];
    
                $order_list[$kk]['status_str'] = Order_Class::orderStatusText(Order_Class::getOrderStatus($vv), 1, $vv['statement']);
    
                $order_list[$kk]['order_status_t'] = Order_Class::getOrderStatus($vv);
    
                $order_goods_list = Order_goods_class::get_order_goods_list($vv['id'] );
    
                $order_list[$kk]['goods'] = current( $order_goods_list );
    
                $order_list[$kk]['goods']['goods_array'] = json_decode( $order_list[$kk]['goods']['goods_array'] );
    
                $order_list[$kk]['goods']['name'] = $order_list[$kk]['goods']['goods_array']->name;
    
                $order_list[$kk]['goods']['value'] = $order_list[$kk]['goods']['goods_array']->value;
    
                $info = $ordergoodsModel->getObj('order_id = ' . $vv['id'], 'product_id');
    
                $order_list[$kk]['products'] = $productsModel->getObj("id = '$info[product_id]'");
    
            }
    
    
    
            foreach( $order_list as $kk => $vv )
    
            {
    
                $return .= '<div class="mui-card">';
                if ( $vv['statement'] != 3)
                    $return .= '<div class="mui-card-header">' .$vv['goods']['name'] . '</div>';
                else
                    $return .= '<div class="mui-card-header">' .$vv['goods']['name'] . '(定金)</div>';
                $return .= '<div class="mui-card-content">';
                $return .= '<ul class="mui-table-view">';
                $return .= '<li class="mui-table-view-cell mui-media">';
                $return .= '<a href="' . IUrl::creatUrl('/ucenter/order_detail/id/' . $vv['id']) . '">';
                if ( $vv['statement'] != 2)
                    $return .= '<img class="mui-media-object mui-pull-left" src="' . IUrl::creatUrl('/pic/thumb/img/' . $vv['goods'][img] . '/w/80/h/80') . '">';
                else
                    $return .= '<img class="mui-media-object mui-pull-left" src="/views/default/skin/default/images/xuexiquan.jpg">';
                $return .= '<div class="mui-media-body">';
                $return .= '<p class="ordbigbt"><span>课程属性：</span>' . $vv['goods']['value'] . '</p>';
                $return .= '<p class="ordbigbt"><span>订单号：</span>' . $vv['order_no'] . '</p>';
                $return .= '<p class="ordbigbt"><span>下单日期：</span>' . $vv['create_time'] .'</p>';
                $return .= '</div>';
                $return .= '</a>';
                $return .= '</li>';
                $return .= '</ul>';
                $return .= '<div class="mui-card-content-inner">';
                $return .= '<p class="ordbigbt">';
                $return .= '<span>订单状态：</span><i class="ordbigbt-price">' . $vv['status_str'] . '</i>';
                if ($vv['order_status_t'] == 2)
                {
                    $pay_url = IUrl::creatUrl('/block/doPay/order_id/' . $vv['id']);
                    $return .= '<a href="' . $pay_url . '">付款</a>';
                }
                $return .= '</p>';
                $return .= '<p class="ordbigbt"><span>学费价格：</span>&yen;' . number_format($vv['goods']['market_price'] * $vv['goods']['goods_nums'], 2, '.', '') . '</p>';
    
                if ($vv['order_chit'] > 0)
                    $return .= '<p class="ordbigbt"><span>已付学费：</span>&yen;' . $vv['order_chit'] . '</p>';
    
                if ($vv['statement'] == 3)
                    $return .= '<p class="ordbigbt"><span>已付定金：</span>&yen;' . $vv['order_amount'] . '</p>';
    
                if ($vv['rest_price'] > 0)
                    $return .= '<p class="ordbigbt"><span>未付学费：</span>&yen;' . $vv['rest_price'] . '</p>';
    
                $return .= '</div>';
                $return .= '</div>';
    
                $return .= '<div class="mui-card-footer">';
                $return .= '<a href="' . IUrl::creatUrl('/ucenter/order_detail/id/' . $vv[id]) . '" class="mui-card-link">查看详情</a>';
    
                if($vv['order_status_t'] == 2)
                {
                    $pay_url = IUrl::creatUrl('/block/doPay/order_id/' . $vv['id']);
                    $return .= '<a href="' . $pay_url . '">付款</a>';
                }
    
                if ($vv['order_status_t'] == 13)
                {
                    if ($vv['statement'] == 4)
                        $return .= '<a href="{url:/ucenter/order_confirm/order_id/$item[id]}" class="mui-card-link">确认聘用</a>';
                    else
                        $return .= '<a href="{url:/ucenter/order_confirm/order_id/$item[id]}" class="mui-card-link">确认报到</a>';
                }
    
                $return .= '</div>';
                $return .= '</div>';
            }
    
        }
        echo $return;
    
    }
    
    function article_upload()
    
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
    
    function article_ajax_del()
    {
        $arr = array();
        $id = IFilter::act(IReq::get('id','get'),'int');
        if ( !$id )
        {
            $arr['msg'] = -1;
        }
        else
        {
            $article_info = Article::get_info($id);
            if ( !$article_info )
            {
                $arr['msg'] = -2;
            }
            else
            {
                $article_db = new IModel('article');
                $article_db->del('id = ' . $id );
                $arr['msg'] = 1;
            }
        }
    
        echo json_encode($arr);
    }
    
    function jiance()
    {
        $user_id = $this->user['user_id'];
        $article_db = new IQuery('article');
        $article_db->where = 'user_id = ' . $user_id . ' and category_id = 17 and title !="" and keywords != ""';
        $jiance_info = $article_db->getOne();

        $this->setRenderData(array(
            'jiance_info'   =>  $jiance_info,
        ));
        $this->title = '皮纹检测';
        $this->redirect('jiance');
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
    
    function manual_info()
    {
        $this->title = '手册详情';
        
        $manual_list = manual_class::get_manual_list_by_userid($this->user['user_id']);
        if ( !$manual_list )
        {
            IError::show(403,'您没有绑定任何手册');
            exit();
        }
        
        // 获取短期课分类列表
        $category_list = array();
        $manual_category_list = manual_category_class::get_category_list();
        if ( $manual_category_list )
        {
            foreach( $manual_category_list as $kk => $vv )
            {
                $category_list[$vv['id']] = $vv;
            }
        }
        
        $unactivation = array();
        $time = time();
        foreach ( $manual_list as $kk => $vv )
        {
            $manual_list[$kk]['year'] = calcAge(date('Y-m-d', $vv['birthday']));
            if ( !$vv['is_activation'])
                $unactivation[] = $vv;
            
            $category_arr = explode(',', $vv['category_id']);
            if ( $category_arr )
            {
                foreach( $category_arr as $k => $v )
                {
                    $category_arr[$k] = $category_list[$v]['name'];
                }
            }
            
            $category_arr = array_chunk($category_arr,2);
            $manual_list[$kk]['category'] = $category_arr;
        }

        $this->setRenderData(array(
            'manual_list'  =>  $manual_list,
            'unactivation' =>  $unactivation,
            'category_list' =>  $category_list,
        ));
        $this->redirect('manual_info');
    }
    
    function manual_activation()
    {
        $this->title = '手册激活';
        
        $code = IFilter::act(IReq::get('code'));
        $user_id = $this->user['user_id'];
        $manual_category_list = manual_category_class::get_category_list();
        $manual_category_arr = array();
        if ( $manual_category_list )
        {
            foreach( $manual_category_list as $kk => $vv )
            {
                $manual_category_arr[] = array(
                    'value' =>  $vv['id'],
                    'text'  =>  $vv['name'],
                );
            }
        }
        
        $result = manual_class::is_avalible($code, $user_id);
        if ( $result <= 0 )
        {
            IError::show(403,'激活失败');
            exit();
        }
        
        $this->setRenderData(array(
            'manual_category_list_json' =>  json_encode($manual_category_arr),
            'code'    =>  $code,
        ));
        $this->redirect('manual_activation');
    }
    
    function save_manual_activation()
    {
        $user_id = $this->user['user_id'];
        $parents_name = IFilter::act(IReq::get('parents_name'));
        $parents_tel = IFilter::act(IReq::get('parents_tel'),'int');
        $name = IFilter::act(IReq::get('name'));
        $birthday = IFilter::act(IReq::get('birthday'));
        $birthday = strtotime($birthday);
        $sex = IFilter::act(IReq::get('sex'),'int');
        $guardian = IFilter::act(IReq::get('guardian'),'int');
        $category_id = IFilter::act(IReq::get('category_id'),'int');
        $logo = IFilter::act(IReq::get('logo'));
        $is_agree = IFilter::act(IReq::get('is_agree'),'int');
        $code = IFilter::act(IReq::get('code'));
        
        
        if ( !$is_agree )
        {
            IError::show(403,'请勾选阅读声明');
            exit();
        }
        
        if ( !$parents_name )
        {
            IError::show(403,'请输入家长姓名');
            exit();
        }
        
        if ( !$parents_tel )
        {
            IError::show(403,'请输入家长电话');
            exit();
        }
        
        if ( !$name )
        {
            IError::show(403,'请输入宝宝姓名');
            exit(); 
        }
        
        if ( !$birthday )
        {
            IError::show(403,'请输入宝宝的生日');
            exit();
        }
       
        // 暂时关闭选择激活分类功能，激活开放所有分类
        /**
        if ( !$category_id )
        {
            IError::show(403,'请选择要激活的分类');
            exit();
        }
        **/
        
        $result = manual_class::is_avalible($code, $user_id);
        if ( $result <= 0 )
        {
            IError::show(403,'激活失败');
            exit();
        }
        
        $time = time();
        $data = array(
            'parents_name'  =>  $parents_name,
            'parents_tel'   =>  $parents_tel,
            'name'          =>  $name,
            'birthday'      =>  $birthday,
            'sex'           =>  $sex,
            'guardian'      =>  $guardian,
            'category_id'   =>  '1,2,3,4',
            'logo'          =>  $logo,
            'user_id'       =>  $this->user['user_id'],
            'is_activation' =>  1,
            'start_time'    =>  $time,
            'end_time'      =>  strtotime("+1 years", $time),
        );
        $manual_db = new IModel('manual');
        $manual_db->setData($data);
        $manual_db->update('id = ' . $result);
        $this->redirect('/site/success/message/'.urlencode("激活成功").'/?callback=/ucenter/manual_info');
    }
    
    function manual_use_list()
    {
        $id = IFilter::act(IReq::get('id'),'int');
        $user_id = $this->user['user_id'];
        $manual_info = manual_class::get_manual_info($id);
        if ( !$manual_info || $manual_info['user_id'] != $user_id )
        {
            IError::show(403,'手册不存在');
            exit();
        }
        if ( !$manual_info['is_activation'] )
        {
            IError::show(403,'手册未激活');
            exit();
        }
        
        $this->setRenderData(array(
            'id'    =>  $id,
        ));
        $this->title = '手册使用记录';
        $this->redirect('manual_use_list');
    }
    
    function get_manual_use_list_ajax()
    {
        $page = IFilter::act(IReq::get('page'),'int');
        $page = max($page,1);
        $id = IFilter::act(IReq::get('id'),'int');
        $user_id = $this->user['user_id'];
        
        $manual_use_list_db = new IQuery('manual_use_list as mul');
        $manual_use_list_db->join = 'left join manual as m on mul.manual_id = m.id left join brand_chit as bc on mul.dqk_id = bc.id left join seller as s on mul.seller_id = s.id';
        $manual_use_list_db->fields = 'count(mul.dqk_id) as c_count,mul.*,bc.use_times,bc.name,s.shortname,bc.logo';
        $manual_use_list_db->group = 'mul.dqk_id';
        $manual_use_list_db->where = 'manual_id = ' . $id . ' and mul.user_id = ' . $user_id;
        $list = $manual_use_list_db->find();
        
        if ( $list )
        {
            $list['num'] = sizeof($list);
            $list['page'] = $page + 1;
        } else {
            $list['num'] = 0;
            $list['page'] = 1;
        }
        
        echo json_encode($list);
    }
    
    function manual_use_dqk_info()
    {
        $id = IFilter::act(IReq::get('id'),'int');
        $dqk_id = IFilter::act(IReq::get('dqk_id'),'int');
        $user_id = $this->user['user_id'];
        
        if ( !$id || !$dqk_id )
        {
            IError::show(403,'参数不正确');
            exit();
        }
        
        $manual_info = manual_class::get_manual_info($id);
        $dqk_info = brand_chit_class::get_dqk_info($dqk_id);
        
        if ( !$manual_info )
        {
            IError::show(403,'手册不存在');
            exit();
        }
        
        if ( !$dqk_info )
        {
            IError::show(403,'短期课不存在');
            exit();
        }
        
        $use_list = manual_use_list_class::get_manual_use_list_by_dqk_id($user_id, $id, $dqk_id);
        $seller_info = seller_class::get_seller_info($dqk_info['seller_id']);
        $dqk_info['seller_name'] = $seller_info['shortname'];
        
        $this->setRenderData(array(
            'dqk_info'  =>  $dqk_info,
            'use_list'  =>  $use_list,
        ));
        
        $this->title = '短期课使用记录';
        $this->redirect('manual_use_dqk_info');
    }
    
    // 我的推广二维码
    function promote_qrcode()
    {
        $user_id = $this->user['user_id'];
        $my_promote_code = promote_class::get_promote_code($user_id);
        $this->title = '我的推广二维码';
        $this->redirect('promote_qrcode');
    }
    
    // 验证短期课订单
    function redpacket_use()
    {
        $user_id = $this->user['user_id']; 
        $id = IFilter::act(IReq::get('id'),'int');
        $use_id = IFilter::act(IReq::get('use_id'),'int');
        $orderObj = new order_class();
        $this->order_info = $orderObj->getOrderShow($id,$this->user['user_id']);
        $user_id = $this->user['user_id'];
        
        if(!$this->order_info)
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
        if ( !$brand_chit_use_info['availeble_use_times'] )
        {
            IError::show(403,'该短期课已经完成，不能再次使用');
            exit();
        }
        
        $brand_chit_info = brand_chit_class::get_dqk_info($brand_chit_use_info['brand_chit_id']);
        if ( !$brand_chit_info )
        {
            IError::show(403,'短期课不存在');
            exit();
        }
        
        $seller_info = seller_class::get_seller_info($brand_chit_info['seller_id']);
        
        $this->title = '短期课使用';
        $this->setRenderData(array(
            'brand_chit_info' =>    $brand_chit_info,
            'seller_info'       =>  $seller_info,
            'id'            =>  $id,
            'use_id'        =>  $use_id,
        ));
        
        $this->redirect('redpacket_use');
    }
}