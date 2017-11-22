<?php
/**
 * @copyright Copyright(c) 2011 aircheng.com
 * @file Simple.php
 * @brief
 * @author webning
 * @date 2011-03-22
 * @version 0.6
 * @note
 */
/**
 * @brief Simple
 * @class Simple
 * @note
 */
class Simple extends IController
{
    public $layout='site';

	function init()
	{

	}

	function login()
	{
	    $callback = IReq::get('callback');

		//如果已经登录，就跳到ucenter页面
		if($this->user)
		{
			$this->redirect("/ucenter/index");
		}
		else
		{
		    if ( $callback )
		    {
		        $this->setRenderData(array(
		            'callback'    =>  $callback,
		        ));
		        $this->callback = $callback;
		    }
		    $this->title = '用户登录';
			$this->redirect('login');
		}
	}

	 function reg_pc_ajax()

    {

        $postdata = file_get_contents("php://input");

        $request = json_decode($postdata);



        $mobile     = IFilter::act(IReq::get('mobile','post'));

        $mobile_code = IFilter::act(IReq::get('mobile_code','post'));

        $promo_code = IFilter::act(IReq::get('promo_code','post'));

        $promo_code = ($promo_code) ? lcfirst($promo_code) : $promo_code;

        $username   = IFilter::act(IReq::get('username','post'));

        $password   = IFilter::act(IReq::get('password','post'));

        // $repassword = IFilter::act(IReq::get('repassword','post'));

        //$captcha    = strtolower( IFilter::act(IReq::get('captcha','post')) );

        //$_captcha   = strtolower( ISafe::get('captcha') );



        //获取注册配置参数

        $siteConfig = new Config('site_config');

        $reg_option = $siteConfig->reg_option;



        $mobile_ere = "/^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/";



        // 验证码信息

        $sms_info = Sms_class::get_sms_info( $mobile, 1 );

        // 读取推广码信息
        if ( $promo_code != '')
        {
            $promotor_info = promotor_class::get_promotor_info($promo_code);
        }

        $userObj = new IModel('user');

        $where = "username = '$username'";

        $userRow = $userObj->getObj($where);



        $user_info = Member_class::get_member_info_by_mobile( $mobile );

        /*注册信息校验*/

        if ( $promo_code != '' && !$promotor_info )
        {
            $message = '推广码错误';
        }
        else if($reg_option == 2)

        {

            $message = '当前网站禁止新用户注册';

        }else if(empty($username)) {

            $message = '请输入用户名';

        }elseif($userRow['id']){

            $message = '用户名已存在';

        } else if (!preg_match('|\S{6,32}|',$password)) {

            $message = '密码为6-32位字符';

        }
		// else if ( $password != $repassword ) {

            // $message = '2次密码输入不一致';

        // }
		else if ( !preg_match( $mobile_ere, $mobile ) ) {

            $message = '请输入正确的手机号码';

        }elseif($user_info){

            $message = '该号码已存在';

        } else if ( !$sms_info || ( $sms_info['code'] != $mobile_code ) ) {

            $message = '手机验证码不正确';

        } else if ( time() > strtotime("+10 minutes", $sms_info['addtime'])) {

            $message = '手机验证码已过期';

        }  else {



            $userArray = array(

                'username' => $username,

                'password' => md5($password),
                'promo_code' => $promo_code

                //'email'    => $email,

            );

            $userObj->setData($userArray);

            $user_id = $userObj->add();



            if($user_id)

            {

                //member表

                $memberArray = array(

                    'user_id' => $user_id,

                    'time'    => ITime::getDateTime(),

                    'status'  => $reg_option == 1 ? 3 : 1,

                    'mobile'  => $mobile,

                );



                $memberObj = new IModel('member');

                $memberObj->setData($memberArray);

                $memberObj->add();


                // 添加推广人
                 if ( $promo_code != '' && $promotor_info ) {
                      promotor_class::insert_promotor($promo_code, $promotor_info['promo_code'] );
                 }


                //用户私密数据

                ISafe::set('username',$username);

                ISafe::set('user_id',$user_id);

                ISafe::set('user_pwd',$userArray['password']);



                echo 1;

                exit();

            }



            $message = '失败';

        }

        if($message)

        {

            $arr['msg'] = $message;

        }

        else

        {

            $arr['msg'] = 0;

        }

        echo json_encode($arr);

        exit;

    }




	//退出登录
    function logout()
    {
    	plugin::trigger('clearUser');
    	$this->redirect('login');
    }

    //用户注册
    function reg_act()
    {
    	//调用_userInfo注册插件
    	$result = plugin::trigger("userRegAct",$_POST);
    	if(is_array($result))
    	{
			//自定义跳转页面
			$this->redirect('/site/success?message='.urlencode("注册成功！"));
    	}
    	else
    	{
    		$this->setError($result);
    		$this->redirect('reg',false);
    		Util::showMessage($result);
    	}
    }

    //用户登录
    function login_act()
    {
    	//调用_userInfo登录插件
		$result = plugin::trigger('userLoginAct',$_POST);
		if(is_array($result))
		{
			//自定义跳转页面
			$callback = plugin::trigger('getCallback');
			if($callback)
			{
				$this->redirect($callback);
			}
			else
			{
				$this->redirect('/ucenter/index');
			}
		}
		else
		{
			$this->setError($result);
			$this->redirect('login',false);
			Util::showMessage($result);
		}
    }

    //商品加入购物车[ajax]
    function joinCart()
    {
    	$link      = IReq::get('link');
    	$goods_id  = IFilter::act(IReq::get('goods_id'),'int');
    	$goods_num = IFilter::act(IReq::get('goods_num'),'int');
    	$goods_num = $goods_num == 0 ? 1 : $goods_num;
		$type      = IFilter::act(IReq::get('type'));

		//加入购物车
    	$cartObj   = new Cart();
    	$addResult = $cartObj->add($goods_id,$goods_num,$type);

    	if($link != '')
    	{
    		if($addResult === false)
    		{
    			$this->cart(false);
    			Util::showMessage($cartObj->getError());
    		}
    		else
    		{
    			$this->redirect($link);
    		}
    	}
    	else
    	{
	    	if($addResult === false)
	    	{
		    	$result = array(
		    		'isError' => true,
		    		'message' => $cartObj->getError(),
		    	);
	    	}
	    	else
	    	{
		    	$result = array(
		    		'isError' => false,
		    		'message' => '添加成功',
		    	);
	    	}
	    	echo JSON::encode($result);
    	}
    }

    //根据goods_id获取货品
    function getProducts()
    {
    	$id           = IFilter::act(IReq::get('id'),'int');
    	$productObj   = new IModel('products');
    	$productsList = $productObj->query('goods_id = '.$id,'sell_price,id,spec_array,goods_id','store_nums desc',7);
		if($productsList)
		{
			foreach($productsList as $key => $val)
			{
				$productsList[$key]['specData'] = Block::show_spec($val['spec_array']);
			}
		}
		echo JSON::encode($productsList);
    }

    //删除购物车
    function removeCart()
    {
    	$link      = IReq::get('link');
    	$goods_id  = IFilter::act(IReq::get('goods_id'),'int');
    	$type      = IFilter::act(IReq::get('type'));

    	$cartObj   = new Cart();
    	$cartInfo  = $cartObj->getMyCart();
    	$delResult = $cartObj->del($goods_id,$type);

    	if($link != '')
    	{
    		if($delResult === false)
    		{
    			$this->cart(false);
    			Util::showMessage($cartObj->getError());
    		}
    		else
    		{
    			$this->redirect($link);
    		}
    	}
    	else
    	{
	    	if($delResult === false)
	    	{
	    		$result = array(
		    		'isError' => true,
		    		'message' => $cartObj->getError(),
	    		);
	    	}
	    	else
	    	{
		    	$goodsRow = $cartInfo[$type]['data'][$goods_id];
		    	$cartInfo['sum']   -= $goodsRow['sell_price'] * $goodsRow['count'];
		    	$cartInfo['count'] -= $goodsRow['count'];

		    	$result = array(
		    		'isError' => false,
		    		'data'    => $cartInfo,
		    	);
	    	}

	    	echo JSON::encode($result);
    	}
    }

    //清空购物车
    function clearCart()
    {
    	$cartObj = new Cart();
    	$cartObj->clear();
    	$this->redirect('cart');
    }

    //购物车div展示
    function showCart()
    {
    	$cartObj  = new Cart();
    	$cartList = $cartObj->getMyCart();
    	$data['data'] = array_merge($cartList['goods']['data'],$cartList['product']['data']);
    	$data['count']= $cartList['count'];
    	$data['sum']  = $cartList['sum'];
    	echo JSON::encode($data);
    }

    //购物车页面及商品价格计算[复杂]
    function cart($redirect = false)
    {
      $this->layout ='';
    	//防止页面刷新
    	header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);

		//开始计算购物车中的商品价格
    	$countObj = new CountSum();
    	$result   = $countObj->cart_count();

    	if(is_string($result))
    	{
    		IError::show($result,403);
    	}

    	//返回值
    	$this->final_sum = $result['final_sum'];
    	$this->promotion = $result['promotion'];
    	$this->proReduce = $result['proReduce'];
    	$this->sum       = $result['sum'];
    	$this->goodsList = $result['goodsList'];
    	$this->count     = $result['count'];
    	$this->reduce    = $result['reduce'];
    	$this->weight    = $result['weight'];

		//渲染视图
		$this->title = '课程清单';
    	$this->redirect('cart',$redirect);
    }

    //计算促销规则[ajax]
    function promotionRuleAjax()
    {
    	$goodsId   = IFilter::act(IReq::get("goodsId"),'int');
    	$productId = IFilter::act(IReq::get("productId"),'int');
    	$num       = IFilter::act(IReq::get("num"),'int');

    	if(!$goodsId || !$num)
    	{
			return;
    	}

		$goodsArray  = array();
		$productArray= array();

    	foreach($goodsId as $key => $goods_id)
    	{
    		$pid = $productId[$key];
    		$nVal= $num[$key];

    		if($pid > 0)
    		{
    			$productArray[$pid] = $nVal;
    		}
    		else
    		{
    			$goodsArray[$goods_id] = $nVal;
    		}
    	}

		$countSumObj    = new CountSum();
		$cartObj        = new Cart();
		$countSumResult = $countSumObj->goodsCount($cartObj->cartFormat(array("goods" => $goodsArray,"product" => $productArray)));
    	echo JSON::encode($countSumResult);
    }

    //填写订单信息cart2
    function cart2()
    {
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0",false);
		$id        = IFilter::act(IReq::get('id'),'int');
		$type      = IFilter::act(IReq::get('type'));//goods, product
		$promo     = IFilter::act(IReq::get('promo'));
		$active_id = IFilter::act(IReq::get('active_id'),'int');
		$buy_num   = IReq::get('num') ? IFilter::act(IReq::get('num'),'int') : 1;
		$tourist   = IReq::get('tourist');//游客方式购物
		/*
		$url = '/simple/cart2n/id/' . $id . '/type/' . $type .'/num/' . $buy_num;
		if ( $promo )
		    $url .= '/promo/' . $promo;
		if ($active_id )
		    $url .= '/active_id/' . $active_id;
		header("location:" . IUrl::creatUrl($url));
		exit();*/

    	//必须为登录用户
    	if($tourist === null && $this->user['user_id'] == null)
    	{
    		if($id == 0 || $type == '')
    		{
    			$this->redirect('/simple/login?tourist&callback=/simple/cart2');
    		}
    		else
    		{
    			$url  = '/simple/login?tourist&callback=/simple/cart2/id/'.$id.'/type/'.$type.'/num/'.$buy_num;
    			$url .= $promo     ? '/promo/'.$promo         : '';
    			$url .= $active_id ? '/active_id/'.$active_id : '';
    			$this->redirect($url);
    		}
    	}

		//游客的user_id默认为0     	$user_id = ($this->user['user_id'] == null) ? 0 : $this->user['user_id'];

        $user_id = $this->user['user_id'];

		//计算商品

		$countSumObj = new CountSum($user_id);

		$result = $countSumObj->cart_count($id,$type,$buy_num,$promo,$active_id);

		if($countSumObj->error)
		{
			IError::show(403,$countSumObj->error);
		}

    	//获取收货地址
    	$addressObj  = new IModel('address');
    	$addressList = $addressObj->query('user_id = '.$user_id,"*","is_default desc");

		//更新$addressList数据
    	foreach($addressList as $key => $val)
    	{
    		$temp = area::name($val['province'],$val['city'],$val['area']);
    		if(isset($temp[$val['province']]) && isset($temp[$val['city']]) && isset($temp[$val['area']]))
    		{
	    		$addressList[$key]['province_val'] = $temp[$val['province']];
	    		$addressList[$key]['city_val']     = $temp[$val['city']];
	    		$addressList[$key]['area_val']     = $temp[$val['area']];
    		}
    	}

		//获取习惯方式
		$memberObj = new IModel('member');
		$memberRow = $memberObj->getObj('user_id = '.$user_id,'custom');
		if(isset($memberRow['custom']) && $memberRow['custom'])
		{
			$this->custom = unserialize($memberRow['custom']);
		}
		else
		{
			$this->custom = array(
				'payment'  => '',
				'delivery' => '',
			);
		}

    	//返回值
		$this->gid       = $id;
		$this->type      = $type;
		$this->num       = $buy_num;
		$this->promo     = $promo;
		$this->active_id = $active_id;
    	$this->final_sum = $result['final_sum'];
    	$this->promotion = $result['promotion'];
    	$this->proReduce = $result['proReduce'];
    	$this->sum       = $result['sum'];
    	$this->goodsList = $result['goodsList'];
    	$this->count       = $result['count'];
    	$this->reduce      = $result['reduce'];
    	$this->weight      = $result['weight'];
    	$this->freeFreight = $result['freeFreight'];
    	$this->seller      = $result['seller'];

		//收货地址列表
		$this->addressList = $addressList;

		//获取商品税金
		$this->goodsTax    = $result['tax'];

    	//渲染页面
    	$this->redirect('cart2');
    }

	/**
	 * 生成订单
	 */
    function cart3()
    {
		//防止表单重复提交
    	if(IReq::get('timeKey'))
    	{
    		if(ISafe::get('timeKey') == IReq::get('timeKey'))
    		{
	   		IError::show(403,'订单数据不能被重复提交');
    		}
    		ISafe::set('timeKey',IReq::get('timeKey'));
    	}

    	$address_id    = IFilter::act(IReq::get('radio_address'),'int');
    	$delivery_id   = 1;//IFilter::act(IReq::get('delivery_id'),'int');
    	$accept_time   = IFilter::act(IReq::get('accept_time'));
    	$payment       = IFilter::act(IReq::get('payment'),'int');
    	$order_message = IFilter::act(IReq::get('message'));
    	$ticket_id     = IFilter::act(IReq::get('ticket_id'),'int');
    	$taxes         = IFilter::act(IReq::get('taxes'),'float');
    	$tax_title     = IFilter::act(IReq::get('tax_title'));
    	$gid           = IFilter::act(IReq::get('direct_gid'),'int');
    	$num           = IFilter::act(IReq::get('direct_num'),'int');
    	$type          = IFilter::act(IReq::get('direct_type'));//商品或者货品
    	$promo         = IFilter::act(IReq::get('direct_promo'));
    	$active_id     = IFilter::act(IReq::get('direct_active_id'),'int');
    	$takeself      = IFilter::act(IReq::get('takeself'),'int');
    	$order_type    = 0;
    	$dataArray     = array();
    	$user_id       = ($this->user['user_id'] == null) ? 0 : $this->user['user_id'];

		//获取商品数据信息
    	$countSumObj = new CountSum($user_id);
		$goodsResult = $countSumObj->cart_count($gid,$type,$num,$promo,$active_id);

		if($countSumObj->error)
		{
			IError::show(403,$countSumObj->error);
		}

		//处理收件地址
		//1,访客; 2,注册用户
		if($user_id == 0)
		{
			$addressRow = ISafe::get('address');
		}
		else
		{
			$addressDB = new IModel('address');
			//$addressRow= $addressDB->getObj('id = '.$address_id.' and user_id = '.$user_id);
			$addressRow= $addressDB->getObj('id = 1');
		}

		if(!$addressRow)
		{
			IError::show(403,"收货地址信息不存在");
		}
    	$accept_name   = IFilter::act($addressRow['accept_name'],'name');
    	$province      = $addressRow['province'];
    	$city          = $addressRow['city'];
    	$area          = $addressRow['area'];
    	$address       = IFilter::act($addressRow['address']);
    	$mobile        = IFilter::act($addressRow['mobile'],'mobile');
    	$telphone      = IFilter::act($addressRow['telphone'],'phone');
    	$zip           = IFilter::act($addressRow['zip'],'zip');


		//检查订单重复
    	$checkData = array(
    		"accept_name" => $accept_name,
    		"address"     => $address,
    		"mobile"      => $mobile,
    		"distribution"=> $delivery_id,
    	);
    	$result = order_class::checkRepeat($checkData,$goodsResult['goodsList']);
    	if( is_string($result) )
    	{
			IError::show(403,$result);
    	}

		//配送方式,判断是否为货到付款
		$deliveryObj = new IModel('delivery');
		$deliveryRow = $deliveryObj->getObj('id = '.$delivery_id);
		if(!$deliveryRow)
		{
			IError::show(403,'配送方式不存在');
		}

		if($deliveryRow['type'] == 0)
		{
			if($payment == 0)
			{
				IError::show(403,'请选择正确的支付方式');
			}
		}
		else if($deliveryRow['type'] == 1)
		{
			$payment = 0;
		}
		else if($deliveryRow['type'] == 2)
		{
			if($takeself == 0)
			{
				IError::show(403,'请选择正确的自提点');
			}
		}
		//如果不是自提方式自动清空自提点
		if($deliveryRow['type'] != 2)
		{
			$takeself = 0;
		}

		if(!$gid)
		{
			//清空购物车
			IInterceptor::reg("cart@onFinishAction");
		}

    	//判断商品是否存在
    	if(is_string($goodsResult) || empty($goodsResult['goodsList']))
    	{
    		IError::show(403,'商品数据错误');
    	}

    	//加入促销活动
    	if($promo && $active_id)
    	{
    		$activeObject = new Active($promo,$active_id,$user_id,$gid,$type,$num);
    		$order_type = $activeObject->getOrderType();
    	}

		$paymentObj = new IModel('payment');
		$paymentRow = $paymentObj->getObj('id = '.$payment,'type,name');
		if(!$paymentRow)
		{
			IError::show(403,'支付方式不存在');
		}
		$paymentName= $paymentRow['name'];
		$paymentType= $paymentRow['type'];

		//最终订单金额计算
		$orderData = $countSumObj->countOrderFee($goodsResult,$province,$delivery_id,$payment,$taxes,0,$promo,$active_id);
		if(is_string($orderData))
		{
			IError::show(403,$orderData);
		}

		//根据商品所属商家不同批量生成订单
		$orderIdArray  = array();
		$orderNumArray = array();
		$final_sum     = 0;
		foreach($orderData as $seller_id => $goodsResult)
		{
			//生成的订单数据
			$dataArray = array(
				'order_no'            => Order_Class::createOrderNum(),
				'user_id'             => $user_id,
				'accept_name'         => $accept_name,
				'pay_type'            => $payment,
				'distribution'        => $delivery_id,
				'postcode'            => $zip,
				'telphone'            => $telphone,
				'province'            => $province,
				'city'                => $city,
				'area'                => $area,
				'address'             => $address,
				'mobile'              => $mobile,
				'create_time'         => ITime::getDateTime(),
				'postscript'          => $order_message,
				'accept_time'         => $accept_time,
				'exp'                 => $goodsResult['exp'],
				'point'               => $goodsResult['point'],
				'type'                => $order_type,

				//商品价格
				'payable_amount'      => $goodsResult['sum'],
				'real_amount'         => $goodsResult['final_sum'],

				//运费价格
				'payable_freight'     => $goodsResult['deliveryOrigPrice'],
				'real_freight'        => $goodsResult['deliveryPrice'],

				//手续费
				'pay_fee'             => $goodsResult['paymentPrice'],

				//税金
				'invoice'             => $tax_title ? 1 : 0,
				'invoice_title'       => $tax_title,
				'taxes'               => $goodsResult['taxPrice'],

				//优惠价格
				'promotions'          => $goodsResult['proReduce'] + $goodsResult['reduce'],

				//订单应付总额
				'order_amount'        => $goodsResult['orderAmountPrice'],

				//订单保价
				'insured'             => $goodsResult['insuredPrice'],

				//自提点ID
				'takeself'            => $takeself,

				//促销活动ID
				'active_id'           => $active_id,

				//商家ID
				'seller_id'           => $seller_id,

				//备注信息
				'note'                => '',

			    //推广人
			    //'promo_code'          => ICookie::get('promote'),
			);


			//获取红包减免金额
			if($ticket_id)
			{
				$memberObj = new IModel('member');
				$memberRow = $memberObj->getObj('user_id = '.$user_id,'prop,custom');
				foreach($ticket_id as $tk => $tid)
				{
					//游客手动添加或注册用户道具中已有的代金券
					if(ISafe::get('ticket_'.$tid) == $tid || stripos(','.trim($memberRow['prop'],',').',',','.$tid.',') !== false)
					{
						$propObj   = new IModel('prop');
						$ticketRow = $propObj->getObj('id = '.$tid.' and NOW() between start_time and end_time and type = 0 and is_close = 0 and is_userd = 0 and is_send = 1');
						if(!$ticketRow)
						{
							IError::show(403,'代金券不可用');
						}

						if($ticketRow['seller_id'] == 0 || $ticketRow['seller_id'] == $seller_id)
						{
							$ticketRow['value']         = $ticketRow['value'] >= $goodsResult['final_sum'] ? $goodsResult['final_sum'] : $ticketRow['value'];
							$dataArray['prop']          = $tid;
							$dataArray['promotions']   += $ticketRow['value'];
							$dataArray['order_amount'] -= $ticketRow['value'];
							$goodsResult['promotion'][] = array("plan" => "代金券","info" => "使用了￥".$ticketRow['value']."代金券");

							//锁定红包状态
							$propObj->setData(array('is_close' => 2));
							$propObj->update('id = '.$tid);

							unset($ticket_id[$tk]);
							break;
						}
					}
				}
			}

			//促销规则
			if(isset($goodsResult['promotion']) && $goodsResult['promotion'])
			{
				foreach($goodsResult['promotion'] as $key => $val)
				{
					$dataArray['note'] .= join("，",$val)."。";
				}
			}

			$dataArray['order_amount'] = $dataArray['order_amount'] <= 0 ? 0 : $dataArray['order_amount'];

			//生成订单插入order表中
			$orderObj  = new IModel('order');
			$orderObj->setData($dataArray);
			$order_id = $orderObj->add();

			if($order_id == false)
			{
				IError::show(403,'订单生成错误');
			}

			/*将订单中的商品插入到order_goods表*/
	    	$orderInstance = new Order_Class();
	    	$orderInstance->insertOrderGoods($order_id,$goodsResult['goodsResult']);

			//订单金额小于等于0直接免单
			if($dataArray['order_amount'] <= 0)
			{
				Order_Class::updateOrderStatus($dataArray['order_no']);
			}
			else
			{
				$orderIdArray[]  = $order_id;
				$orderNumArray[] = $dataArray['order_no'];
				$final_sum      += $dataArray['order_amount'];
			}
		}

		//记录用户默认习惯的数据
		if(!isset($memberRow['custom']))
		{
			$memberObj = new IModel('member');
			$memberRow = $memberObj->getObj('user_id = '.$user_id,'custom');
		}

		$memberData = array(
			'custom' => serialize(
				array(
					'payment'  => $payment,
					'delivery' => $delivery_id,
				)
			),
		);
		$memberObj->setData($memberData);
		$memberObj->update('user_id = '.$user_id);

		//收货地址的处理
		if($user_id)
		{
			$addressDefRow = $addressDB->getObj('user_id = '.$user_id.' and is_default = 1');
			if(!$addressDefRow)
			{
				$addressDB->setData(array('is_default' => 1));
				$addressDB->update('user_id = '.$user_id.' and id = '.$address_id);
			}
		}

		//获取备货时间
		$this->stockup_time = $this->_siteConfig->stockup_time ? $this->_siteConfig->stockup_time : 2;

		//数据渲染
		$this->order_id    = join("_",$orderIdArray);
		$this->final_sum   = $final_sum;
		$this->order_num   = join(" ",$orderNumArray);
		$this->payment     = $paymentName;
		$this->paymentType = $paymentType;
		$this->delivery    = $deliveryRow['name'];
		$this->tax_title   = $tax_title;
		$this->deliveryType= $deliveryRow['type'];
		plugin::trigger('setCallback','/ucenter/order');
		//订单金额为0时，订单自动完成
		if($this->final_sum <= 0)
		{
			$this->redirect('/site/success/message/'.urlencode("订单确认成功，等待发货"));
		}
		else
		{
			$this->setRenderData($dataArray);
			$this->redirect('cart3');
		}
    }


    //到货通知处理动作
	function arrival_notice()
	{
		$user_id  = $this->user['user_id'];
		$email    = IFilter::act(IReq::get('email'));
		$mobile   = IFilter::act(IReq::get('mobile'));
		$goods_id = IFilter::act(IReq::get('goods_id'),'int');
		$register_time = ITime::getDateTime();

		if(!$goods_id)
		{
			IError::show(403,'商品ID不存在');
		}

		$model = new IModel('notify_registry');
		$obj = $model->getObj("email = '{$email}' and user_id = '{$user_id}' and goods_id = '$goods_id'");
		if(empty($obj))
		{
			$model->setData(array('email'=>$email,'user_id'=>$user_id,'mobile'=>$mobile,'goods_id'=>$goods_id,'register_time'=>$register_time));
			$model->add();
		}
		else
		{
			$model->setData(array('email'=>$email,'user_id'=>$user_id,'mobile'=>$mobile,'goods_id'=>$goods_id,'register_time'=>$register_time,'notify_status'=>0));
			$model->update('id = '.$obj['id']);
		}
		$this->redirect('/site/success',true);
	}

	/**
	 * @brief 邮箱找回密码进行
	 */
    function find_password_email()
	{
		$username = IReq::get('username');
		if($username === null || !IValidate::name($username)  )
		{
			IError::show(403,"请输入正确的用户名");
		}

		$email = IReq::get("email");
		if($email === null || !IValidate::email($email ))
		{
			IError::show(403,"请输入正确的邮箱地址");
		}

		$tb_user  = new IModel("user as u,member as m");
		$username = IFilter::act($username);
		$email    = IFilter::act($email);
		$user     = $tb_user->getObj(" u.id = m.user_id and u.username='{$username}' AND m.email='{$email}' ");
		if(!$user)
		{
			IError::show(403,"对不起，用户不存在");
		}
		$hash = IHash::md5( microtime(true) .mt_rand());

		//重新找回密码的数据
		$tb_find_password = new IModel("find_password");
		$tb_find_password->setData( array( 'hash' => $hash ,'user_id' => $user['id'] , 'addtime' => time() ) );

		if($tb_find_password->query("`hash` = '{$hash}'") || $tb_find_password->add())
		{
			$url     = IUrl::getHost().IUrl::creatUrl("/simple/restore_password/hash/{$hash}/user_id/".$user['id']);
			$content = mailTemplate::findPassword(array("{url}" => $url));

			$smtp   = new SendMail();
			$result = $smtp->send($user['email'],"您的密码找回",$content);

			if($result===false)
			{
				IError::show(403,"发信失败,请重试！或者联系管理员查看邮件服务是否开启");
			}
		}
		else
		{
			IError::show(403,"生成HASH重复，请重试");
		}
		$message = "恭喜您，密码重置邮件已经发送！请到您的邮箱中去激活";
		$this->redirect("/site/success/message/".urlencode($message));
	}

	//手机短信找回密码
	function find_password_mobile()
	{
		$username = IReq::get('username');
		if($username === null || !IValidate::name($username))
		{
			IError::show(403,"请输入正确的用户名");
		}

		$mobile = IReq::get("mobile");
		if($mobile === null || !IValidate::mobi($mobile))
		{
			IError::show(403,"请输入正确的电话号码");
		}

		$mobile_code = IFilter::act(IReq::get('mobile_code'));
		if($mobile_code === null)
		{
			IError::show(403,"请输入短信校验码");
		}

		$userDB = new IModel('user as u , member as m');
		$userRow = $userDB->getObj('u.username = "'.$username.'" and m.mobile = "'.$mobile.'" and u.id = m.user_id');
		if($userRow)
		{
			$findPasswordDB = new IModel('find_password');
			$dataRow = $findPasswordDB->getObj('user_id = '.$userRow['user_id'].' and hash = "'.$mobile_code.'"');
			if($dataRow)
			{
				//短信验证码已经过期
				if(time() - $dataRow['addtime'] > 3600)
				{
					$findPasswordDB->del("user_id = ".$userRow['user_id']);
					IError::show(403,"您的短信校验码已经过期了，请重新找回密码");
				}
				else
				{
					$this->redirect('/simple/restore_password/hash/'.$mobile_code.'/user_id/'.$userRow['user_id']);
				}
			}
			else
			{
				IError::show(403,"您输入的短信校验码错误");
			}
		}
		else
		{
			IError::show(403,"用户名与手机号码不匹配");
		}
	}


    //发送手机验证码短信
    function send_message_mobile()
    {
        $username = IFilter::act(IReq::get('username'));
        $mobile = IFilter::act(IReq::get('mobile'));
        $type = IFilter::act(IReq::get('type'));
        $type = ( !$type ) ? 'user' : $type;

        if( !$username || !IValidate::name($username))
        {
            die("请输入正确的用户名");
        }

        if( !$mobile || !IValidate::mobi($mobile))
        {
            die("请输入正确的手机号码");
        }

        //用户类型为客户账户
        if($type=='user')
        {
            $userDB = new IModel('user as u , member as m');
            $userRow = $userDB->getObj('u.username = "'.$username.'" and m.mobile = "'.$mobile.'" and u.id = m.user_id');

            if($userRow)
            {
                $findPasswordDB = new IModel('find_password');
                $dataRow = $findPasswordDB->query('user_id = '.$userRow['user_id'].' and type = 0 ','*','addtime','desc');
                $dataRow = current($dataRow);

                //60秒是短信发送的间隔
                if( isset($dataRow['addtime']) && (time() - $dataRow['addtime'] <= 60) )
                {
                    die("申请验证码时间间隔为1分钟，请".(60-time() + $dataRow['addtime'])."s后再试");
                }
                $mobile_code = rand(100000,999999);
                $findPasswordDB->setData(array(
                    'user_id' => $userRow['user_id'],
                    'hash'    => $mobile_code,
                    'addtime' => time(),
                    'type' => 0,
                ));
                if($findPasswordDB->add())
                {
                    // updated by jack 20160720
                    $content = '您好！为了保障您的隐私，此次验证码为' . $mobile_code . '，在5分钟内使用，请勿外泄【乐享生活】';
                    $sms = new Sms_class();
                    $result = $sms->send( $mobile, $content );
                    if($result['stat']=='100')
                        die('success');
                    else
                    {
                        //dump( $result );
                        die('发送失败');
                    }
                }
            }
            else
            {
                die('手机号码与用户名不符合');
            }
        } elseif($type=='business') {
            //用户类型为商户
            $userDB = new IModel('seller');
            $userRow = $userDB->getObj('seller_name = "'.$username.'" and mobile = "'.$mobile.'"');

            if($userRow)
            {
                $findPasswordDB = new IModel('find_password');
                $dataRow = $findPasswordDB->query('user_id = "'.$userRow['id'].'" and type = 1 ','*','addtime','desc');
                $dataRow = current($dataRow);

                //60秒是短信发送的间隔
                if( isset($dataRow['addtime']) && (time() - $dataRow['addtime'] <= 60) )
                {
                    die("申请验证码时间间隔为1分钟，请".(60-time() + $dataRow['addtime'])."s后再试");
                }
                $mobile_code = rand(100000,999999);
                $findPasswordDB->setData(array(
                    'user_id' => $userRow['id'],
                    'hash'    => $mobile_code,
                    'addtime' => time(),
                    'type' => 1,
                ));
                if($findPasswordDB->add())
                {
                    // updated by jack 20160720
                    $content = '您好！为了保障您的隐私，此次验证码为' . $mobile_code . '，在5分钟内使用，请勿外泄【乐享生活】';
                    $sms = new Sms_class();
                    $result = $sms->send( $mobile, $content );
                    if($result['stat']=='100')
                        die('success');
                    else
                        die('发送失败');
                }
            }
            else
            {
                die('手机号码与用户名不符合');
            }
        }
    }

	/**
	 * @brief 重置密码验证
	 */
	function restore_password()
	{
		$hash = IFilter::act(IReq::get("hash"));
		$user_id = IFilter::act(IReq::get("user_id"),'int');
		$type = IReq::get("type");

		if(!$hash)
		{
			IError::show(403,"找不到校验码");
		}
		$tb = new IModel("find_password");
		$addtime = time() - 3600*72;
// 		$where  = " `hash`='$hash' AND addtime > $addtime ";
// 		$where .= $this->user['user_id'] ? " and user_id = ".$this->user['user_id'] : "";

		$where  = " `hash`='$hash' AND addtime > $addtime and type='".$type."' ";
		$where .= ( $user_id > 0 ) ? ' and user_id = ' . $user_id : 0;

		$row = $tb->getObj($where);
		if(!$row)
		{
			IError::show(403,"校验码已经超时");
		}

		if($row['user_id'] != $user_id)
		{
			IError::show(403,"验证码不属于此用户");
		}

		$this->setRenderData(array(
		    'user_id' =>  $user_id,
		    'hash'    =>  $hash,
		    'type'    =>  $type,
		));
		$this->formAction = IUrl::creatUrl("/simple/do_restore_password/hash/$hash/user_id/".$user_id);
		$this->redirect("restore_password");
	}

	/**
	 * @brief 执行密码修改重置操作
	 */
	function do_restore_password()
	{
		$hash = IFilter::act(IReq::get("hash"));
		$user_id = IFilter::act(IReq::get("user_id"),'int');

		if(!$hash)
		{
			IError::show(403,"找不到校验码");
		}
		$tb = new IModel("find_password");
		$addtime = time() - 3600*72;
		$where  = " `hash`='$hash' AND addtime > $addtime ";
		$where .= $this->user['user_id'] ? " and user_id = ".$this->user['user_id'] : "";

		$row = $tb->getObj($where);
		if(!$row)
		{
			IError::show(403,"校验码已经超时");
		}

		if($row['user_id'] != $user_id)
		{
			IError::show(403,"验证码不属于此用户");
		}

		//开始修改密码
		$pwd   = IReq::get("password");
		$repwd = IReq::get("repassword");
		if($pwd == null || strlen($pwd) < 6 || $repwd!=$pwd)
		{
			IError::show(403,"新密码至少六位，且两次输入的密码应该一致。");
		}
		$pwd = md5($pwd);
		$tb_user = new IModel("user");
		$tb_user->setData(array("password" => $pwd));
		$re = $tb_user->update("id='{$row['user_id']}'");
		if($re !== false)
		{
			$message = "修改密码成功";
			$tb->del("`hash`='{$hash}'");
			$this->redirect("/site/success/message/".urlencode($message));
			return;
		}
		IError::show(403,"密码修改失败，请重试");
	}

    //添加收藏夹
    function favorite_add()
    {
    	$goods_id = IFilter::act(IReq::get('goods_id'),'int');
    	$message  = '';

    	if($goods_id == 0)
    	{
    		$message = '商品id值不能为空';
    	}
    	else if(!isset($this->user['user_id']) || !$this->user['user_id'])
    	{
    		$message = '请先登录';
    	}
    	else
    	{
    		$favoriteObj = new IModel('favorite');
    		$goodsRow    = $favoriteObj->getObj('user_id = '.$this->user['user_id'].' and rid = '.$goods_id);
    		if($goodsRow)
    		{
    			$message = '您已经收藏过此件商品';
    		}
    		else
    		{
    			$catObj = new IModel('category_extend');
    			$catRow = $catObj->getObj('goods_id = '.$goods_id);
    			$cat_id = $catRow ? $catRow['category_id'] : 0;

	    		$dataArray   = array(
	    			'user_id' => $this->user['user_id'],
	    			'rid'     => $goods_id,
	    			'time'    => ITime::getDateTime(),
	    			'cat_id'  => $cat_id,
	    		);
	    		$favoriteObj->setData($dataArray);
	    		$favoriteObj->add();
	    		$message = '收藏成功';

	    		//商品收藏信息更新
	    		$goodsDB = new IModel('goods');
	    		$goodsDB->setData(array("favorite" => "favorite + 1"));
	    		$goodsDB->update("id = ".$goods_id,'favorite');
    		}
    	}
		$result = array(
			'isError' => true,
			'message' => $message,
		);

    	echo JSON::encode($result);
    }

    //获取oauth登录地址
    public function oauth_login()
    {
    	$id = IFilter::act(IReq::get('id'),'int');
    	if($id)
    	{
    		$oauthObj = new OauthCore($id);
			$result   = array(
				'isError' => false,
				'url'     => $oauthObj->getLoginUrl(),
			);
    	}
    	else
    	{
			$result   = array(
				'isError' => true,
				'message' => '请选择要登录的平台',
			);
    	}
    	echo JSON::encode($result);
    }

    //第三方登录回调
    public function oauth_callback()
    {
    	$oauth_name = IFilter::act(IReq::get('oauth_name'));
    	$oauthObj   = new IModel('oauth');
    	$oauthRow   = $oauthObj->getObj('file = "'.$oauth_name.'"');

    	if(!$oauth_name && !$oauthRow)
    	{
    		IError::show(403,"{$oauth_name} 第三方平台信息不存在");
    	}
		$id       = $oauthRow['id'];
    	$oauthObj = new OauthCore($id);
    	$result   = $oauthObj->checkStatus($_GET);

    	if($result === true)
    	{
    		$oauthObj->getAccessToken($_GET);
	    	$userInfo = $oauthObj->getUserInfo();

	    	if(isset($userInfo['id']) && isset($userInfo['name']) && $userInfo['id'] && $userInfo['name'])
	    	{
	    		$this->bindUser($userInfo,$id);
	    		return;
	    	}
    	}
    	else
    	{
    		IError::show("回调URL参数错误");
    	}
    }

    //同步绑定用户数据
    public function bindUser($userInfo,$oauthId)
    {
    	$userObj      = new IModel('user');
    	$oauthUserObj = new IModel('oauth_user');
    	$oauthUserRow = $oauthUserObj->getObj("oauth_user_id = '{$userInfo['id']}' and oauth_id = '{$oauthId}' ",'user_id');
		if($oauthUserRow)
		{
			//清理oauth_user和user表不同步匹配的问题
			$tempRow = $userObj->getObj("id = '{$oauthUserRow['user_id']}'");
			if(!$tempRow)
			{
				$oauthUserObj->del("oauth_user_id = '{$userInfo['id']}' and oauth_id = '{$oauthId}' ");
			}
		}

    	//存在绑定账号oauth_user与user表同步正常！
    	if(isset($tempRow) && $tempRow)
    	{
    		$userRow = plugin::trigger("isValidUser",array($tempRow['username'],$tempRow['password']));
    		plugin::trigger("userLoginCallback",$userRow);
    		$callback = plugin::trigger('getCallback');
    		$callback = $callback ? $callback : "/ucenter/index";
			$this->redirect($callback);
    	}
    	//没有绑定账号
    	else
    	{
	    	$userCount = $userObj->getObj("username = '{$userInfo['name']}'",'count(*) as num');

	    	//没有重复的用户名
	    	if($userCount['num'] == 0)
	    	{
	    		$username = $userInfo['name'];
	    	}
	    	else
	    	{
	    		//随即分配一个用户名
	    		$username = $userInfo['name'].$userCount['num'];
	    	}
			$userInfo['name'] = $username;
	    	ISession::set('oauth_id',$oauthId);
	    	ISession::set('oauth_userInfo',$userInfo);
	    	$this->setRenderData($userInfo);
	    	$this->redirect('bind_user',false);
    	}
    }

	//执行绑定已存在用户
    public function bind_exists_user()
    {
    	$login_info     = IReq::get('login_info');
    	$password       = IReq::get('password');
    	$oauth_id       = IFilter::act(ISession::get('oauth_id'));
    	$oauth_userInfo = IFilter::act(ISession::get('oauth_userInfo'));

    	if(!$oauth_id || !$oauth_userInfo || !isset($oauth_userInfo['id']))
    	{
    		IError::show("缺少oauth信息");
    	}

    	if($userRow = plugin::trigger("isValidUser",array($login_info,md5($password))))
    	{
    		$oauthUserObj = new IModel('oauth_user');

    		//插入关系表
    		$oauthUserData = array(
    			'oauth_user_id' => $oauth_userInfo['id'],
    			'oauth_id'      => $oauth_id,
    			'user_id'       => $userRow['user_id'],
    			'datetime'      => ITime::getDateTime(),
    		);
    		$oauthUserObj->setData($oauthUserData);
    		$oauthUserObj->add();

    		plugin::trigger("userLoginCallback",$userRow);

			//自定义跳转页面
			$this->redirect('/site/success?message='.urlencode("登录成功！"));
    	}
    	else
    	{
    		$this->setError("用户名和密码不匹配");
    		$_GET['bind_type'] = 'exists';
    		$this->redirect('bind_user',false);
    		Util::showMessage("用户名和密码不匹配");
    	}
    }

	//执行绑定注册新用户用户
    public function bind_not_exists_user()
    {
    	$oauth_id       = IFilter::act(ISession::get('oauth_id'));
    	$oauth_userInfo = IFilter::act(ISession::get('oauth_userInfo'));

    	if(!$oauth_id || !$oauth_userInfo || !isset($oauth_userInfo['id']))
    	{
    		IError::show("缺少oauth信息");
    	}

    	//调用_userInfo注册插件
		$result = plugin::trigger('userRegAct',$_POST);
		if(is_array($result))
		{
			//插入关系表
			$oauthUserObj = new IModel('oauth_user');
			$oauthUserData = array(
				'oauth_user_id' => $oauth_userInfo['id'],
				'oauth_id'      => $oauth_id,
				'user_id'       => $result['id'],
				'datetime'      => ITime::getDateTime(),
			);
			$oauthUserObj->setData($oauthUserData);
			$oauthUserObj->add();
			$this->redirect('/site/success?message='.urlencode("注册成功！"));
		}
		else
		{
    		$this->setError($result);
    		$this->redirect('bind_user',false);
    		Util::showMessage($result);
		}
    }

	//添加地址ajax
	function address_add()
	{
		$id          = IFilter::act(IReq::get('id'),'int');
		$accept_name = IFilter::act(IReq::get('accept_name'));
		$province    = IFilter::act(IReq::get('province'),'int');
		$city        = IFilter::act(IReq::get('city'),'int');
		$area        = IFilter::act(IReq::get('area'),'int');
		$address     = IFilter::act(IReq::get('address'));
		$zip         = IFilter::act(IReq::get('zip'));
		$telphone    = IFilter::act(IReq::get('telphone'));
		$mobile      = IFilter::act(IReq::get('mobile'));
        $user_id     = $this->user['user_id'];

		//整合的数据
        $sqlData = array(
        	'user_id'     => $user_id,
        	'accept_name' => $accept_name,
        	'zip'         => $zip,
        	'telphone'    => $telphone,
        	'province'    => $province,
        	'city'        => $city,
        	'area'        => $area,
        	'address'     => $address,
        	'mobile'      => $mobile,
        );

        $checkArray = $sqlData;
        unset($checkArray['telphone'],$checkArray['zip'],$checkArray['user_id']);
        foreach($checkArray as $key => $val)
        {
        	if(!$val)
        	{
        		$result = array('result' => false,'msg' => '请仔细填写收货地址');
				die(JSON::encode($result));
        	}
        }

        if($user_id)
        {
        	$model = new IModel('address');
        	$model->setData($sqlData);
        	if($id)
        	{
        		$model->update("id = ".$id." and user_id = ".$user_id);
        	}
        	else
        	{
        		$id = $model->add();
        	}
        	$sqlData['id'] = $id;
        }
        //访客地址保存
        else
        {
        	ISafe::set("address",$sqlData);
        }

        $areaList = area::name($province,$city,$area);
		$sqlData['province_val'] = $areaList[$province];
		$sqlData['city_val']     = $areaList[$city];
		$sqlData['area_val']     = $areaList[$area];
		$result = array('data' => $sqlData);
		die(JSON::encode($result));
	}

	/**
	* 用户和商户入住，发送短信验证码
	*/
	function send_reg_sms()
	{
	    $postdata = file_get_contents("php://input");
	    $request = json_decode($postdata);
	    $mobile = IFilter::act(IReq::get('mobile'));
	    $type = IFilter::act(IReq::get('type'));
	    $type = ( !$type ) ? 1 : $type;     //  1 => 用户注册, 2 => 商户入住

	    if ( !$mobile)
	    {
	        die('请输入正确的手机号码');
	    }

	    // 通过手机号获取用户信息，判断手机号是否已注册
	    if ( $type == 1 )
	        $user_info = Member_class::get_member_info_by_mobile( $mobile );
	    else
	        $user_info = Seller_class::get_seller_info_by_mobile( $mobile );

	    if ( $user_info )

	    {

	    die('手机号码已注册');

	    }


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

	// ajax注册验证
	function reg_ajax()
	{
	    $arr = array();
	    $mobile     = IFilter::act(IReq::get('mobile','post'));
	    $mobile_code = IFilter::act(IReq::get('mobile_code','post'));
	    $promo_code = IFilter::act(IReq::get('promo_code','post'));
	    $promo_code = ($promo_code) ? lcfirst($promo_code) : $promo_code;
	    $username   = $mobile;
	    $password   = IFilter::act(IReq::get('password','post'));
	    // $repassword = IFilter::act(IReq::get('repassword','post'));
	    // $repassword = $password;
	    $captcha    = strtolower( IFilter::act(IReq::get('captcha','post')) );
	    $_captcha   = strtolower( ISafe::get('captcha') );

	    //获取注册配置参数
	    $siteConfig = new Config('site_config');
	    $reg_option = $siteConfig->reg_option;

	    //$mobile_ere = "/^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/";
	    $mobile_ere = "/^1[34578]\d{9}$/";

	    // 验证码信息
	    $sms_info = Sms_class::get_sms_info( $mobile, 1 );

	    if ( $promo_code != '')
	    {
	        $promotor_info = promotor_class::get_promotor_info($promo_code);
	    }

	    /*注册信息校验*/
	    if ( $promo_code != '' && !$promotor_info )
	    {
	        $message = '推广码不存在';
	    }
	    else if($reg_option == 2)
	    {
	        $message = '当前禁止注册';
	    } /* else if(!Util::is_username($username)) {
	    $message = '用户名由2-20位字符';
	    }  */else if (!preg_match('|\S{6,32}|',$password)) {
	    $message = '密码为6-32位字符';
	    }
		// else if ( $password != $repassword ) {
	        // $message = '2次密码输入不一致';
	    // }
		else if ( !preg_match( $mobile_ere, $mobile ) ) {
	        $message = '请输入正确的手机号码';
	    } else if ( !$sms_info || ( $sms_info['code'] != $mobile_code ) ) {
	        $message = '验证码错误';
	    } else if ( time() > strtotime("+10 minutes", $sms_info['addtime'])) {
	        $message = '验证码已过期';
	    } else {
	        $userObj = new IModel('user');
	        $where = "username = '$username'";
	        $userRow = $userObj->getObj($where);

	        // 通过mobile获取用户信息
	        $user_info = Member_class::get_member_info_by_mobile( $mobile );

	        if ( $userRow || $user_info )
	        {
	            if ( $userRow )
	                $message = "用户名已注册";
	            else
	                $message = '手机号码已注册';
	        }
	        else
	        {
	            //user表
	            $userArray = array(
	                'username' => $username,
	                'password' => md5($password),
	                'promo_code'    => $promo_code
	            );
	            $userObj->setData($userArray);
	            $user_id = $userObj->add();

	            if($user_id)
	            {
	                //member表
	                $memberArray = array(
	                    'user_id' => $user_id,
	                    'time'    => ITime::getDateTime(),
	                    'status'  => $reg_option == 1 ? 3 : 1,
	                    'mobile'  => $mobile,
	                );

	                $memberObj = new IModel('member');
	                $memberObj->setData($memberArray);
	                $memberObj->add();

	                // 添加推广人
	                if ( $promo_code != '' && $promotor_info ) {
	                    promotor_class::insert_promotor($promo_code, $promotor_info['promo_code'] );
	                }

	                //用户私密数据
	                ISafe::set('username',$username);
	                ISafe::set('user_id',$user_id);
	                ISafe::set('user_pwd',$userArray['password']);

	                $message = 1;
	            }
	            else
	            {
	                $message = '注册失败';
	            }
	        }
	    }
	    $arr['message'] = $message;
	    echo json_encode( $arr );
	}
	//pc版用户登陆验证
	 function login_pc_ajax()

    {

        //usephp://input to get angular form value ---- added by jack 20160817

        //$postdata = file_get_contents("php://input");

        //$request = json_decode($postdata);



        //$login_info = IFilter::act($request->login_info);

        //$password   = IFilter::act($request->password);

        $login_info = IFilter::act(IReq::get('login_info','post'));

        $password   = IReq::get('password','post');

        $remember   = IFilter::act(IReq::get('remember','post'));

        $autoLogin  = IFilter::act(IReq::get('autoLogin','post'));

        $callback   = IFilter::act(IReq::get('callback'),'text');



        if($login_info == '')

        {

            $message = '请填写用户名或者邮箱';

        }

        else if(!preg_match('|\S{6,32}|',$password))

        {

            $message = '密码格式不正确,请输入6-32个字符';

        } else {

            //$password   = md5($password);

            //CheckRights::isValidUser($login_info,$password);

            //if($userRow = CheckRights::isValidUser($login_info,$password))

            $result = plugin::trigger('userLoginAct',$_POST);

            if ( is_array($result) )

            {

                //CheckRights::loginAfter($userRow);

                //记住帐号



                /**

                if($remember == 1)

                {

                    ICookie::set('loginName',$login_info);

                }



                //自动登录

                if($autoLogin == 1)

                {

                    ICookie::set('autoLogin',$autoLogin);

                }

                **/

                $message = '';

            } else {

                //邮箱未验证

                $userDB = new IModel('user as u,member as m');

                $userRow= $userDB->getObj(" (u.email = '{$login_info}' or u.username = '{$login_info}') and password = '{$password}' and u.id = m.user_id");

                if($userRow)

                {

                    $siteConfig = new Config('site_config');

                    if($userRow['status'] == 3)

                    {

                        if($siteConfig->reg_option == 1)

                        {

                            $message = "您的邮箱还未验证";

                        }

                        else

                        {

                            $message = '请联系管理员';

                        }

                    }

                    else if($userRow['status'] == 2)

                    {

                        $message = '请与管理员联系';

                    }

                }

                else

                {

                    $message = '用户名和密码错误';

                }

            }



        }

        if($message)

        {

            $arr['msg'] = $message;

            $arr['code'] = 0;

        }

        else

        {
            $arr['msg'] = '';
            $arr['code'] = 1;
            $arr['back'] = IUrl::creatUrl('/ucenter');


        }



        echo json_encode($arr);

        exit;

        //echo $message;

        //exit();

    }


	// 手机版用户登录ajax
	function login_ajax()
	{
	    $login_info = IFilter::act(IReq::get('login_info','post'));
	    $password   = IReq::get('password','post');
	    $autoLogin  = IFilter::act(IReq::get('autoLogin','post'));
	    $_POST['login_info'] = $login_info;
	    $_POST['password'] = $password;
	    $_POST['autoLogin'] = $autoLogin;
	    $arr = array();

	    if($login_info == '')
	    {
	        $message = '请填写用户名或者邮箱';
	    }
	    else if(!preg_match('|\S{6,32}|',$password))
	    {
	        $message = '密码长度6-32个字符';
	    }
	    else
	    {
	        $result = plugin::trigger('userLoginAct',$_POST);
	        if(is_array($result))
	        {
	            $message = 1;
	        } else {
	            //邮箱未验证
	            $userDB = new IModel('user as u,member as m');
	            $userRow= $userDB->getObj(" (u.email = '{$login_info}' or u.username = '{$login_info}') and password = '{$password}' and u.id = m.user_id");
	            if($userRow)
	            {
	                $siteConfig = new Config('site_config');
	                if($userRow['status'] == 3)
	                {
	                    if($siteConfig->reg_option == 1)
	                    {
	                        $message = "请验证邮箱";
	                    }
	                    else
	                    {
	                        $message = '请联系管理员';
	                    }
	                }
	                else if($userRow['status'] == 2)
	                {
	                    $message = '请与管理员联系';
	                }
	            }
	            else
	            {
	                $message = '用户名和密码错误';
	            }
	        }
	    }
	    $arr['message'] = $message;
	    echo json_encode($arr);
	}

	// 找回密码手机版
	function find_password_mobile_ajax()
	{
	    $username = IFilter::act( IReq::get('username') );
	    $mobile = IFilter::act( IReq::get('mobile') );
	    $mobile_code = IFilter::act( IReq::get('mobile_code') );
	    $type=IReq::get("type") + 0;
	    $result = array(
	        'status'   =>  0,
	        'str'      =>  '',
	    );

	    if($username === null || !IValidate::name($username))
	    {
	        $result['str'] = '请输入正确的用户名';
	        die( json_encode( $result ));
	    }


	    if($mobile === null || !IValidate::mobi($mobile))
	    {
	        $result['str'] = '请输入正确的电话号码';
	        die( json_encode( $result ));
	    }


	    if($mobile_code === null)
	    {
	        $result['str'] = '请输入短信校验码';
	        die( json_encode( $result ));
	    }

	    if($type==0){
	        $userDB = new IModel('user as u , member as m');
	        $userRow = $userDB->getObj('u.username = "'.$username.'" and m.mobile = "'.$mobile.'" and u.id = m.user_id');
	        $id=$userRow['user_id'];
	    }elseif($type==1){
	        $userDB = new IModel('seller');
	        $userRow = $userDB->getObj('seller_name = "'.$username.'" and mobile = "'.$mobile.'"');
	        $id=$userRow['id'];
	    }else{
	        $result['str'] = '未找到符合条件的记录';
	        die( json_encode( $result ));
	    }

	    if($userRow)
	    {
	        $findPasswordDB = new IModel('find_password');
	        $dataRow = $findPasswordDB->getObj('user_id = '.$id.' and hash = "'.$mobile_code.'" and type="'.$type.'"');
	        if($dataRow)
	        {
	            //短信验证码已经过期
	            if(time() - $dataRow['addtime'] > 300)
	            {
	                $findPasswordDB->del("user_id = ".$id." and type=".$type);
	                $result['str'] = '您的短信校验码已经过期了';
	                die( json_encode( $result ));
	            }
	            else
	            {
	                $result['status'] = 1;
	                $result['user_id'] = $id;
	                $result['str'] = IUrl::creatUrl('/simple/restore_password/hash/'.$mobile_code.'/user_id/'.$id.'/type/'.$type);
	                die( json_encode( $result ));
	            }
	        }
	        else
	        {
	            $result['str'] = '您输入的短信校验码错误';
	            die( json_encode( $result ));
	        }
	    }
	    else
	    {
	        $result['str'] = '用户名与手机号码不匹配';
	        die( json_encode( $result ));
	    }
	}


	// 重置密码手机版
	function do_restore_password_ajax()
	{
	    $hash = IFilter::act(IReq::get("hash"));
	    $user_id = IFilter::act(IReq::get("user_id"),'int');
	    $type = IReq::get("type");
	    $type = ( !$type ) ? 0 : 1;

	    //开始修改密码
	    $pwd   = IReq::get("password");
	    $repwd = IReq::get("repassword");

	    if(!$hash)
	    {
	        die('找不到校验码');
	    }
	    $tb = new IModel("find_password");
	    $addtime = time() - 3600;
	    $where  = " `hash`='$hash' AND addtime > $addtime and type=$type";
	    $where .= ( $user_id > 0 ) ? ' and user_id = ' . $user_id : 0;

	    $row = $tb->getObj($where);
	    if(!$row)
	    {
	        die('校验码已经超时3');
	    }

	    if($row['user_id'] != $user_id)
	    {
	        die('验证码不属于此用户');
	    }


	    if($pwd == null || strlen($pwd) < 6 || $repwd!=$pwd)
	    {
	        die('新密码至少六位，且两次输入的密码应该一致');
	    }
	    if(!preg_match('|\S{6,32}|',$pwd))
	    {
	        die('密码必须是字母，数字，下划线组成的6-32个字符');
	    }

	    $pwd = md5($pwd);
	    if($type==0){
	        $tb_user = new IModel("user");
	    }elseif($type==1){
	        $tb_user = new IModel("seller");
	    }else{
	        die('用户组参数错误，请重试');
	    }
	    $tb_user->setData(array("password" => $pwd));
	    $re = $tb_user->update("id='{$row['user_id']}'");
	    if($re !== false)
	    {
	        $message = "修改密码成功";
	        $tb->del("`hash`='{$hash}'");
	        //$this->redirect("/site/success/message/".urlencode($message));
	        //exit;
	        die('1');
	    }
	    die('密码修改失败，请重试');
	}

	function reg()
	{
	    $this->title = '用户注册';
	    $this->callback = IFilter::act(IReq::get('callback'));
	    $this->redirect('reg');
	}

	function find_password()
	{
	    $this->title = '找回密码';
	    $this->redirect('find_password');
	}

	function pay_wx()
	{
	    include dirname(__FILE__) . "/../plugins/payments/pay_wxpc/WxPayPubHelper"."/WxPayPubHelper.php";
	    $ordersn = IFilter::act(IReq::get('trade_no'));
	    $real_amount = IFilter::act(IReq::get('real_amount'));
	    $ordermodel = new IModel('order');
	    $order = $ordermodel->getObj("order_no = '$ordersn'", 'id');
	    if(IClient::isWechat())
	    {
	        $jsApi = new JsApi_pub();
	        if (!isset($_GET['code']))
	        {
	            //触发微信返回code码
	            $rurl = 'http://'.$_SERVER['HTTP_HOST'].'/simple/pay_wx/?type=order&trade_no=' . $ordersn . '&real_amount=' . $real_amount ;
	            $url = $jsApi->createOauthUrlForCode(urlencode($rurl));
	            header("Location: $url");
	        }else
	        {
	            //获取code码，以获取openid
	            $code = $_GET['code'];
	            $jsApi->setCode($code);
	            $openid = $jsApi->getOpenId();
	        }

	        $unifiedOrder = new UnifiedOrder_pub();
	        $unifiedOrder->setParameter("openid", $openid);//商品描述
	        $unifiedOrder->setParameter("body", '第三课');//商品描述
	        //自定义订单号，此处仅作举例
	        $timeStamp = time();
	        $unifiedOrder->setParameter("out_trade_no", $ordersn);//商户订单号
	        $unifiedOrder->setParameter("total_fee", $real_amount);//总金额
	        $unifiedOrder->setParameter("notify_url", WxPayConf_pub::NOTIFY_URL);//通知地址
	        $unifiedOrder->setParameter("trade_type", "JSAPI");//交易类型

	        $prepay_id = $unifiedOrder->getPrepayId();
	        //=========步骤3：使用jsapi调起支付============
	        $jsApi->setPrepayId($prepay_id);

	        $jsApiParameters = $jsApi->getParameters();
	        $this->setRenderData( array(
	            'jsApiParameters'    =>  $jsApiParameters,
	            'ordersn' => $ordersn
	        ) );
	    }
	    else
	    {
	        $unifiedOrder = new UnifiedOrder_pub();
	        $unifiedOrder->setParameter("body","第三课");//商品描述
	        //自定义订单号，此处仅作举例
	        $timeStamp = time();
	        $out_trade_no = $ordersn;
	        $money = $real_amount;
	        $unifiedOrder->setParameter("out_trade_no","$out_trade_no");//商户订单号
	        $unifiedOrder->setParameter("total_fee",$money);//总金额
	        $unifiedOrder->setParameter("notify_url","http://".$_SERVER['HTTP_HOST']."/block/wxcallback");//通知地址
	        $unifiedOrder->setParameter("trade_type","NATIVE");//交易类型
	        $unifiedOrderResult = $unifiedOrder->getResult();

	        if ($unifiedOrderResult["return_code"] == "FAIL")
	        {
	            //商户自行增加处理流程
	            echo "通信出错：".$unifiedOrderResult['return_msg']."<br>";
	        }
	        elseif($unifiedOrderResult["result_code"] == "FAIL")
	        {
	            //商户自行增加处理流程
	            echo "错误代码：".$unifiedOrderResult['err_code']."<br>";
	            echo "错误代码描述：".$unifiedOrderResult['err_code_des']."<br>";
	        }
	        elseif($unifiedOrderResult["code_url"] != NULL)
	        {
	            //从统一支付接口获取到code_url
	            $code_url = $unifiedOrderResult["code_url"];
	        }
	        $this->setRenderData( array(
	            'codeurl'    =>  $code_url,
	            'ordersn' => $out_trade_no
	        ) );
	    }

	    $this->title = '微信支付';
	    $this->redirect('pay_wx');
	}

	function login2()
	{
	    $user_id = ISafe::get('user_id');
	    if ( IClient::isWechat() && empty($use_id) )
	    {
	        signup_class::quick_signup();
	    } else {
	        if ( !IClient::isWechat() )
	        {
	            IError::show('请从微信里面打开此页面',403);
	            exit();
	        }
	        $url = ISafe::get('jump_url');
	        header("location:" . $url);
	    }
	}
}
