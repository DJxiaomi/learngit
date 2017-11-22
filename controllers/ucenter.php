<?php
/**
 * @brief 用户中心模块
 * @class Ucenter
 * @note  前台
 */
class Ucenter extends IController implements userAuthorization
{
	public $layout = '';

	public function init()
	{

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

		//获取用户成长币
		$balance = member_class::get_member_balance($this->user['user_id']);

		//获取用户消费总额
		$user_order_consume = order_class::get_user_order_consume($this->user['user_id']);

		$this->setRenderData(array(
			"user"       => $user,
			"statistics" => $statistics,
			"msgNum"     => $msgNum,
		    'balance'    => $balance,
		    'user_order_consume'  =>  $user_order_consume,
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
		$this->layout = '';
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
        $this->layout = '';
        $id = IFilter::act(IReq::get('id'),'int');

        $orderObj = new order_class();
        $this->order_info = $orderObj->getOrderShow($id,$this->user['user_id']);

        if(!$this->order_info)
        {
        	IError::show(403,'订单信息不存在');
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

    //[个人资料]展示 单页
    function info()
    {
        $this->layout = '';
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
    		'mobile'       => $mobile,
    		'telephone'    => IFilter::act( IReq::get('telephone'),'string'),
    		'area'         => $areaArr ? ",".join(",",$areaArr)."," : "",
    	);

    	$memberObj->setData($dataArray);
    	$memberObj->update($where);

    	$this->redirect('/site/success/message/'.urlencode("信息修改成功").'/?callback=/ucenter');
    }

    //[账户余额] 展示[单页]
    function withdraw()
    {
        $this->layout = '';
        $user_id   = $this->user['user_id'];
        $memberObj = new IModel('member','balance');
        $userModel = new IModel('user');
        $where     = 'user_id = '.$user_id;
        $trade = $userModel->getObj("id = '$user_id'");
        $this->memberRow = $memberObj->getObj($where);
        
        
        $this->setRenderData(array(
            "trade"       => $trade,
            'balance_count'  =>  member_class::get_member_balance($user_id),
            'balance_1'   =>  member_class::get_member_balance($user_id, 1),
            'balance_2'   =>  member_class::get_member_balance($user_id, 2),
        ));
        $this->title = '我要提现';
        $this->redirect('withdraw');
    }
    
    function withdraw_list()
    {
        $this->layout = '';
        $user_id   = $this->user['user_id'];
        
        $withdrwa_db = new IQuery('withdraw');
        $withdrwa_db->where = 'user_id = ' . $user_id;
        $withdraw_list = $withdrwa_db->find();
        
        $this->title = '提现记录';
        $this->setRenderData(array(
            'withdraw_list' =>  $withdraw_list,
        ));
        
        $this->redirect('withdraw_list');
    }

	//[账户余额] 提现动作
    function withdraw_act()
    {
    	$user_id = $this->user['user_id'];
    	$amount  = IFilter::act( IReq::get('amount','post') ,'float' );
    	$message = '';

    	$dataArray = array(
    		'name'   => IFilter::act( IReq::get('name','post') ,'string'),
    	    'cart_no'=> IFilter::act( IReq::get('cart_no','post') ,'string'),
    	    'bank_name'=> IFilter::act( IReq::get('bank_name','post') ,'string'),
    	    'bank_branch'=> IFilter::act( IReq::get('bank_branch','post') ,'string'),
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
			IError::show(403,'提现的金额必须大于'.$mixAmount.'元');
		}
		else if($amount > $memberRow['balance'])
		{
			IError::show(403,'提现的金额不能大于您的帐户余额');
		} else if ( !$dataArray['cart_no']) {
		    IError::show(403,'卡号不能为空');
		} else if ( !$dataArray['bank_name']) {
		    IError::show(403,'银行名称不能为空');
		} else if ( !$dataArray['bank_branch']) {
		    IError::show(403,'银行支行名称不能为空');
		}
		else
		{
	    	$obj = new IModel('withdraw');
	    	$obj->setData($dataArray);
	    	$obj->add();
	    	
	    	//提现成功
	    	$this->redirect('/site/success/message/'.urlencode("申请提现成功").'/?callback=/ucenter');
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
    
    // 我的成长币
    function balance()
    {
        $this->layout = '';
        $user_id   = $this->user['user_id'];
        $where     = 'user_id = '.$user_id;

        $this->setRenderData(array(
            'balance_count'  =>  member_class::get_member_balance($user_id),
            'balance_1'   =>  member_class::get_member_balance($user_id, 1),
            'balance_2'   =>  member_class::get_member_balance($user_id, 2),
        ));
        $this->title = '我的成长币';
        $this->redirect('balance');
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
        $this->layout = '';
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

    /**
     * 采集核销的二维码页面
     */
    function order_confirm_qrcode()
    {
        $order_id = IFilter::act(IReq::get('order_id'),'int');

        $orderObj = new order_class();
        $this->order_info = $orderObj->getOrderShow($order_id,$this->user['user_id']);

        if(!$this->order_info)
        {
        	IError::show(403,'订单信息不存在');
        }

        $this->setRenderData(array(
            'id'    =>  $order_id,
        ));
        $this->title = '采集核销';
        $this->redirect('order_confirm_qrcode');
    }


    // 我的推广二维码
    function promote_qrcode()
    {
        $this->layout = '';
        $user_id = $this->user['user_id'];
        $member_info = member_class::get_member_info($user_id);
        if ( !$member_info['promote_qrcode'] )
        {
            $this->redirect('promote_qrcode_choose');
            exit();
        }
        
        $this->setRenderData(array(
            'member_info'   =>  $member_info,
        ));
        $this->title = '我的推广二维码';
        $this->redirect('promote_qrcode');
    }
    
    // 选择推广二维码样式
    function promote_qrcode_choose()
    {
        $this->layout = '';
        $user_id = $this->user['user_id'];
        
        $my_promote_code = promote_class::get_promote_code($user_id);
        $this->title = '选择二维码样式';
        $this->redirect('promote_qrcode_choose');
    }
    
    // ajax生成推广二维码
    function promote_qrcode_confirm()
    {
        $this->layout = '';
        $user_id = $this->user['user_id'];
        $background_id = IFilter::act(IReq::get('background_id'),'int');
        
        $background_arr = array(
            0 => array(140,275,),array(140,215),array(140,215),array(140,190)
        );
        $background_info = $background_arr[$background_id - 1];
        if ( !$background_info )
        {
            $this->json_error('样式不存在');
            exit();
        }
        
        $my_promote_code = promote_class::get_promote_code($user_id);
        
        $path_1 = "./images/mobile/Qr_bg/$background_id.png";
        $path_2 = "http://" . get_host() . "/plugins/phpqrcode/index.php?data=http://" . get_host() . "/site/index/promote/$my_promote_code";
        $path_2 = Thumb::get($path_2, 190, 190);
        $path_2_temp = $path_2 . '.png';
        rename($path_2, $path_2_temp);
        $path_2 = $path_2_temp;
        
        //将背景和二维码图片分别取到两个画布中
        $image_1 = imagecreatefrompng($path_1);
        $image_2 = imagecreatefrompng($path_2);
        //创建一个和背景图片一样大小的真彩色画布（ps：只有这样才能保证后面copy二维码图片的时候不会失真）
        $image_3 = imageCreatetruecolor(imagesx($image_1),imagesy($image_1));
        //为真彩色画布创建白色背景，再设置为透明
        $color = imagecolorallocate($image_3, 255, 255, 255);
        imagefill($image_3, 0, 0, $color);
        imageColorTransparent($image_3, $color);
        //首先将背景画布采样copy到真彩色画布中，不会失真
        imagecopyresampled($image_3,$image_1,0,0,0,0,imagesx($image_1),imagesy($image_1),imagesx($image_1),imagesy($image_1));
        //再将二维码图片copy到已经具有背景图像的真彩色画布中，同样也不会失真
        imagecopymerge($image_3,$image_2, $background_info[0],$background_info[1],0,0,imagesx($image_2),imagesy($image_2), 100);
        //将画布保存到指定的gif文件
        
        $file = 'upload/promote_qrcode/' . ITime::getDateTime('YmdHis').mt_rand(100,999).'.gif';
        $result = imagegif($image_3, "./" . $file);
        
        if ( $result )
        {
            $member_db = new IModel('member');
            $data = array(
                'promote_qrcode' => $file,
            );
            $member_db->setData($data);
            $member_db->update('user_id = ' . $user_id);
            $this->json_result();
        }
        else
           $this->json_error('生成失败！');
    }
}
