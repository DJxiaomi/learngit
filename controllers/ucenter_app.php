<?php 


class Ucenter_app extends IController
{
    private $user = array();
    function init()
    {
        header( "Access-Control-Allow-Origin:*" );
        $user_id = IFilter::act(IReq::get('user_id'),'int');
        $token = IFilter::act(IReq::get('token'));

        $user_info = $this->check_user_token($user_id, $token);
        if ( !$user_info )
        {
            $this->json_error('请先登录');
            exit();
        }
        
        $this->user['user_id'] = $user_id;
        
        //用户私密数据
        
        ISafe::set('user_id',$user_info['id']);
        ISafe::set('username',$user_info['username']);
        ISafe::set('user_pwd',$user_info['password']);
        ISafe::set('head_ico',isset($userRow['head_ico']) ? $user_info['head_ico'] : '');
        ISafe::set('last_login',isset($userRow['last_login']) ? $user_info['last_login'] : '');
    }
    
    function get_user_statics_info()
    {
        
        //获取用户各项统计数据
        $statistics = Api::run('getMemberTongJi',$this->user['user_id']);
        $user_wait_comment_order_sum = statistics::countUserWaitComment($this->user['user_id']);
        $user_wait_pay_order_sum = statistics::countUserWaitPay($this->user['user_id']);
        $user_has_pay_order_sum = statistics::countUserHasPay($this->user['user_id']);
        $user_wait_commit_order_sum = statistics::countUserWaitCommit($this->user['user_id']);
        
        $arr = array(
            'user_wait_comment_order_sum'  =>  $user_wait_comment_order_sum,
            'user_wait_pay_order_sum'      =>  $user_wait_pay_order_sum,
            'user_has_pay_order_sum'       =>  $user_has_pay_order_sum,
            'user_wait_commit_order_sum'   =>  $user_wait_commit_order_sum,
        );
        
        $this->json_result($arr);
    }
    
    function get_user_info()
    {
        $user_info = user_class::get_user_info($this->user['user_id']);
        $member_info = member_class::get_member_info($this->user['user_id']);
        $info = array_merge($user_info,$member_info);
        
        if(!empty($info['area']))
        {
            $areas = explode(',', trim($info['area'], ','));
            $info['provinceval'] = area::getName($areas[0]);
            $info['cityval'] = area::getName($areas[1]);
            $info['discrictval'] = area::getName($areas[2]);
            $info['areas'] = $areas;
        } else {
            $info['provinceval'] = $info['cityval'] = $info['discrictval'] = '';
            $info['areas'] = array();
        }
        
        $jsonregion = area::getJsonArea();
        $info['regiondata'] = $jsonregion;
        $this->json_result($info);
    }
    
    function save_user_info()
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
                $this->json_error('邮箱已经被注册');
                exit();
            }
        }

        if($mobile)
        {
            $memberRow = $memberObj->getObj('user_id != '.$user_id.' and mobile = "'.$mobile.'"');
            if($memberRow)
            {
                $this->json_error('手机已经被注册');
                exit();
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
            'contact_addr' => IFilter::act( IReq::get('contact_addr'), 'string'),
            'mobile'       => $mobile,
            'area'         => $areaArr ? ",".join(",",$areaArr)."," : "",
        );

        $memberObj->setData($dataArray);
        $memberObj->update($where);
        $this->json_result();
    }
    
    function get_user_cart()
    {
        //开始计算购物车中的商品价格
        $countObj = new CountSum($this->user['user_id']);
        $result   = $countObj->cart_count();
        $sum = 0;
        if ( $result && $result['goodsList'] )
        {
            foreach ( $result['goodsList'] as $kk => $vv )
            {
                $result['goodsList'][$kk]['sum'] = $vv['market_price'] * $vv['count'];
                $sum += $vv['market_price'] * $vv['count'];
            }
            $result['final_sum'] = $sum;
            $result['sum'] = $sum;
        }
        
        if(is_string($result))
        {
            $this->json_error($result);
            exit();
        }
         
        if ( $result['goodsList'] )
        {
            foreach( $result['goodsList'] as $kk => $vv )
            {
                $result['goodsList'][$kk]['seller_info'] = seller_class::get_seller_info($vv['seller_id']);
            }
        }
        
        $this->json_result($result);
    }
    
    //商品加入购物车[ajax]
    
    function joinCart()
    {
        $link      = IReq::get('link');
        $goods_id  = IFilter::act(IReq::get('goods_id'),'int');
        $goods_num = IReq::get('goods_num') === null ? 1 : intval(IReq::get('goods_num'));
        $type      = IFilter::act(IReq::get('type'));
    
        //加入购物车
        $cartObj   = new Cart();
        $addResult = $cartObj->add($goods_id,$goods_num,$type);

        if ( $addResult === false )
        {
            $this->json_error($cartObj->getError());
            exit();
        } else {
            $this->json_result();
        }
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

        if ( $delResult === false )
        {
            $this->json_error($cartObj->getError());
            exit();
        } else {
            $this->json_result();
        }
    }
    
    function get_user_cart2()
    {
        $id        = IFilter::act(IReq::get('id'),'int');
        $type      = IFilter::act(IReq::get('type'));//goods,product
        $promo     = IFilter::act(IReq::get('promo'));
        $active_id = IFilter::act(IReq::get('active_id'),'int');
        $buy_num   = IReq::get('num') ? IFilter::act(IReq::get('num'),'int') : 1;
        $buy_num = max($buy_num, 1);
        $tourist   = IReq::get('tourist');//游客方式购物
        $stime     = IFilter::act(IReq::get('stime'),'int');
        $dprice    = IFilter::act(IReq::get('dprice'),'float');
        $statement = IFilter::act(IReq::get('statement'),'int');
        $statement = max( $statement, 1);
        $choose_date = IFilter::act(IReq::get('choose_date'));
        $ischit = IFilter::act(IReq::get('ischit'),'int');
        $chitid = IFilter::act(IReq::get('chitid'),'int');
        $seller_tutor_id = IFilter::act(IReq::get('seller_tutor_id'),'int');
        $user_tutor_id = IFilter::act(IReq::get('user_tutor_id'),'int');
        $seller_id = IFilter::act(IReq::get('seller_id'),'int');
        $seats      = IFilter::act(IReq::get('seats'));
        
        // 验证总数
        if ( $id == 5426 )
        {
            $order_db = new IQuery('order as o');
            $order_db->join = 'left join order_goods as og on og.order_id = o.id';
            $order_db->where = 'og.product_id = ' . $id . ' and o.pay_status = 1';
            $lists = $order_db->find();
            if ( sizeof($lists) >= 23 )
            {
                $this->json_error('超过购买数量限制');
                exit();
            }
        }
        
        // 家教购买的验证
        if ( $statement == 4 )
        {
            // 用户找家教
            if ( $seller_tutor_id )
            {
                $seller_tutor_info = seller_tutor_class::get_seller_tutor_info($seller_tutor_id);
                if ( !$seller_tutor_info )
                {
                    $this->json_error('该家教已停止授课');
                    exit();
                }
        
                if (!seller_class::is_tutor_seller($seller_tutor_info['seller_id']))
                {
                    $this->json_error('没有这个老师');
                    exit();
                }
        
                $seller_info = seller_class::get_seller_info($seller_tutor_info['seller_id']);
                if ( !seller_class::is_tutor_seller_receive_booking($seller_info['id']))
                {
                    $this->json_error('老师课已排满，重新找一个老师吧');
                    exit();
                }
                if ( !$seller_info['is_authentication'])
                {
                    $this->json_error('该教师未实名认证');
                    exit();
                }
            }
            if ( $user_tutor_id )
            {
                $seller_info = seller_class::get_seller_info($seller_id);
                $brand_info = brand_class::get_brand_info($seller_info['brand_id']);
                $user_tutor_info = tutor_class::get_tutor_info($user_tutor_id);
                $user_tutor_info['test_reward'] = ($user_tutor_info['test_reward']) ? unserialize($user_tutor_info['test_reward']) : array();
        
                if ( !$user_tutor_info )
                {
                    $this->json_error('该家教已停止授课');
                    exit();
                }
                if ( !$seller_info )
                {
                    $this->json_error('没有这个老师');
                    exit();
                }
                if ( $brand_info['category_ids'] != 16 )
                {
                    $this->json_error('请检查教师类型');
                    exit();
                }
            }
        
            $id = 5280;
            $type = 'product';
        
            // 默认只购买1个
            $is_rehired = seller_class::check_seller_hired($seller_info['id'], $this->user['user_id']);
            $buy_num = ($is_rehired) ? $buy_num : 1;
        }
        
        // 定金模式
        $site_config=new Config('site_config');
        $dcommission = $site_config->dcommission;
        $this->min_cprice = 10;
        
        if ( $statement == 3 )
        {
            if ( $type == 'goods')
            {
                $goods_info = goods_class::get_goods_info($id);
                $dprice = $goods_info['market_price'] * $dcommission / 100 * $buy_num;
            } else {
                $product_info = products_class::get_product_info($id);
                $dprice = $product_info['market_price'] * $dcommission / 100 * $buy_num;
            }
        } else if ( $statement == 2 && !$chitid ) {
//             if ( $dprice < $this->min_cprice )
//             {
//                 $this->json_error('最低允许的购券价格为10元');
//                 exit();
//             }
        } else if ( $statement == 4 ) {
            if ( $seller_tutor_info )
                $dprice = ($is_rehired) ? $seller_tutor_info['price'] : seller_tutor_class::get_tutor_dprice($seller_tutor_id);
            else if ( $user_tutor_info )
                $dprice = $user_tutor_info['lowest_reward'];
            if ( !$dprice )
            {
                $this->json_error('获取家教价格失败');
                exit();
            }
        } else if( $statement == 5 ){
            //获取主体信息
            $seat_db = new IQuery('seat as s');
            $seat_db->join = " left join seat_goods as g on s.goods_id = g.goods_id";
            $seat_db->where = 's.goods_id='.$id;
            $seat_data = $seat_db->getOne();
        
            $table_name = substr($seat_data['table_name'],strpos($seat_data['table_name'],'seat'));
        
            //分解座位
            $seat_pos = '';
            $exp_arr = explode('-',$seats);
            foreach($exp_arr as $v){
                $sub_exp = explode('_',$v);
                $seat_pos[] = $sub_exp;
            }
        
            $seat_list = '';
            $seat_market = '';
            $seat_info_db = new IQuery($table_name);
            foreach($seat_pos as $v){
                $seat_info_db->where = 'rows='.$v[0].' and cols='.$v[1];
                $tmp_list = $seat_info_db->getOne();
                $tmp_list['position'] = $v[0] . '排' . $v[1] . '座';
                $seat_market = $seat_market + $tmp_list['price'];
        
                $seat_list[] = $tmp_list;
            }
        
            $seat_arr = explode('-',$seats);
            $new_seat = implode(',',$seat_arr);
            $give_seats = seat_class::get_nearby_seat($id,$seats);
        
            if($give_seats){
                $give_arr = explode('_',$give_seats);
        
                $seat_list[] = array(
                    'rows' => $give_arr[0],
                    'cols' => $give_arr[1],
                    'price' => 0,
                    'info' => '赠送',
                    'type' => 'give',
                    'position' => $give_arr[0].'排'. $give_arr[1] . '座'
                );
        
                $new_seat .= ','.$give_seats;
            }
        
            $this->setRenderData(array(
                'cinema_info' => $seat_data,
                'seat_list' => $seat_list,
                'seat_market' => $seat_market,
                'seat_str' => $new_seat,
                'is_seat' => 1
            ));
        
            $dprice = $seat_market;
        }
        
        //游客的user_id默认为0
        $user_id = ($this->user['user_id'] == null) ? 0 : $this->user['user_id'];
        
        if($chitid)
        {
            $check_chit = brand_chit_class::check_chit_by_id($chitid, $user_id);
            if($check_chit == -1)
            {
                $this->json_error('购券时间已结束');
                exit();
            }
            elseif($check_chit == -2)
            {
                $this->json_error('超出购券数量');
                exit();
            }
        }
        
        //计算商品
        $countSumObj = new CountSum($user_id);
        $result = $countSumObj->cart_count($id,$type,$buy_num,$promo,$active_id, $dprice, $statement, $stime );
        if($countSumObj->error )
        {
            $this->json_error($countSumObj->error);
            exit();
        }
        
        //获取收货地址
        $addressObj  = new IModel('address');
        $addressList = $addressObj->query('user_id = '.$user_id,"*","is_default desc");
        
        //更新$addressList数据
        foreach($addressList as $key => $val)
        {
            $temp = area::name($val['province'],$val['city'],$val['area']);
            $addressList[$key]['province_val'] = $temp[$val['province']];
            $addressList[$key]['city_val']     = $temp[$val['city']];
            $addressList[$key]['area_val']     = $temp[$val['area']];
            if($val['is_default'] == 1)
            {
                $this->defaultAddressId = $val['id'];
            }
        }
        
        //获取习惯方式
        $this->prop = array();
        $memberObj = new IModel('member');
        $memberRow = $memberObj->getObj('user_id = '.$user_id,'prop,custom,balance,true_name,telephone,mobile');

        $orderObj = new IModel('order');
        $orderRow = $orderObj->query('user_id = '.$user_id,'accept_name,mobile', 'id', 'DESC', 1);
        //$memberRow = $memberObj->getObj('user_id = '.$user_id,'custom');
        
        $this->mtruename = !empty($memberRow['true_name']) ? $memberRow['true_name'] : '';
        $this->mtelephone = !empty($memberRow['telephone']) ? $memberRow['telephone'] : (!empty($memberRow['mobile']) ? $memberRow['mobile'] : '');
        if(!empty($orderRow[0]['accept_name']) && !empty($orderRow[0]['mobile']))
        {
            $defaultAddress = $addressObj->getObj("user_id = ".$user_id . " AND accept_name='" . $orderRow[0]['accept_name'] . "' AND mobile='" . $orderRow[0]['mobile'] . "'", 'id');
            if(!empty($defaultAddress))
            {
                $this->defaultAddressId = $defaultAddress['id'];
            }
        }
        if($memberRow['balance'] >= $result['final_sum'])
        {
            $this->custom = array(
                'payment'  => '1',
                'delivery' => '1',
                'takeself' => '1',
            );
        } else {
            $this->custom = array(
                'payment'  => '10',
                'delivery' => '1',
                'takeself' => '1',
            );
        }
        
        // 获取学校信息
        $sell_count = 0;        
        $market_count = 0;        
        if ( $result['goodsList'] )        
        {        
            foreach( $result['goodsList'] as $kk => $vv )        
            {        
                $result['goodsList'][$kk]['seller_info'] = Seller_class::get_seller_info($vv['seller_id']);        
                if ( $statement == 1 )        
                {        
                    $sell_count += $vv['sell_price'] * $vv['count'];
                    $market_count += $vv['market_price'] * $vv['count'];
                } else {
                    $sell_count += $dprice * $vv['count'];
                    $market_count += $sell_count;
                }
            }
        }

        if ( $promo && $active_id )
        {
            $sell_count = $result['final_sum'];
            $market_count = $result['final_sum'];
            $result['max_prop_info']['max_cprice'] = 0;
            $result['max_prop_info']['order_chit'] = 0;
        }
        
        // 获取家教分类
        $tutor_cate_list = category_class::get_site_category(0);
        
        $this->setRenderData(array(
            'grade_level_arr'     =>  tutor_class::get_grade_level_arr(),
            'grade_arr'          =>  tutor_class::get_grade_arr(),
            'tutor_cate_list'    =>  $tutor_cate_list,
            'tutor_cate_list_json'  =>  json_encode($tutor_cate_list),
            'teaching_time'      =>  tutor_class::get_teaching_time(),
            'region_list'        =>  area::get_child_area_list(430200),
            'teaching_time2'     =>  tutor_class::get_teaching_time2(),
        ));
        
        // 如果是家教订单，并且有奖励机制，则付款金额加上奖励的金额
        if ( $user_tutor_info && $user_tutor_info['test_reward'] )
        {
            foreach( $user_tutor_info['test_reward'] as $kk => $vv )
            {
                $market_count += $vv['test_money'];
            }
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
        $this->max_cprice = $result['max_prop_info']['max_cprice'];
        $this->order_chit = $result['max_prop_info']['order_chit'];
        $this->sell_count = $sell_count;
        $this->market_count = $market_count;
        $this->seller_tutor_id = $seller_tutor_id;
        $this->user_tutor_id = $user_tutor_id;
        $this->seller_id = $seller_info['id'];
         
        $brand_chit_list = brand_chit_class::get_chit_list_by_seller_id($result['goodsList'][0]['seller_id']);
        if ( $brand_chit_list )
            $my_prop_list = prop_class::get_user_prop_list_on_cart($user_id, $result['goodsList'][0]['seller_id'], $this->market_count);
        else
            $my_prop_list = prop_class::get_user_prop_list_on_cart($user_id, 366, $this->market_count);

        $this->prop_list = $my_prop_list;
        
        //收货地址列表
        $this->addressList = $addressList;
        $this->addressListJson = json_encode( $addressList );
        
        // 是否显示详细信息
        //$this->is_show_tutor_detail = tutor_class::is_show_tutor_detail($user_id, $statement );
        $this->is_show_tutor_detail = false;
        
        //获取商品税金
        $this->goodsTax    = $result['tax'];
        $this->checkval = $checkval;
        $this->stime = $stime;
        $this->dprice = $dprice;
        $this->statement = $statement;
        $this->user_prop_count = $result['user_prop_count'];
        $this->choose_date = $choose_date;
        $this->ischit = $ischit;
        $this->chitid = $chitid;
        $this->is_rehired = $is_rehired;
        
        if ( $this->statement == 2 && $this->ischit && $this->chitid > 0 )
        {
            $chit_info = brand_chit_class::get_chit_info($this->chitid);
            $chit_info['name'] = brand_chit_class::get_chit_name($chit_info['max_price'], $chit_info['max_order_chit']) . '(' . $chit_info['shortname'] . ')';
            $this->chit_info = $chit_info;
        }
        
        // 家教模式
        if ( $this->statement == 4 )
        {
            $this->order_chit = $this->max_cprice = $this->order_chit = 0;
            if ( $this->seller_tutor_id )
            {
                $this->seller_tutor_info = $seller_tutor_info;
            } else {
                $this->user_tutor_info = $user_tutor_info;
            }
        }
        
        $arr = array(
            'grade_level_arr'     =>  tutor_class::get_grade_level_arr(),
            'grade_arr'          =>  tutor_class::get_grade_arr(),
            'tutor_cate_list'    =>  $tutor_cate_list,
            'tutor_cate_list_json'  =>  json_encode($tutor_cate_list),
            'teaching_time'      =>  tutor_class::get_teaching_time(),
            'region_list'        =>  area::get_child_area_list(430200),
            'teaching_time2'     =>  tutor_class::get_teaching_time2(),
            'paymentList'       =>  Api::run('getPaymentList'),
            'this'               => array(
                'mtruename' => $this->mtruename,
                'mtelephone'	=>	$this->mtelephone,
                'defaultAddressId'	=>	$this->defaultAddressId,
                'custom'	=>	$this->custom,
                'gid'	=>	$this->gid,
                'type'	=>	$this->type,
                'num'	=>	$this->num,
                'promo'	=>	$this->promo,
                'active_id'	=>	$this->active_id,
                'final_sum'	=>	$this->final_sum,
                'promotion'	=>	$this->promotion,
                'proReduce'	=>	$this->proReduce,
                'sum'		=>	$this->sum,
                'goodsList'	=>	$this->goodsList,
                'count'		=>	$this->count,
                'reduce'	=>	$this->reduce,
                'weight'	=>	$this->weight,
                'freeFreight'	=>	$this->freeFreight,
                'seller'	=>	$this->seller,
                'max_cprice'	=>	$this->max_cprice,
                'order_chit'	=>	$this->order_chit,
                'sell_count'	=>	$this->sell_count,
                'market_count'	=>	$this->market_count,
                'seller_tutor_id'	=>	$this->seller_tutor_id,
                'user_tutor_id'		=>	$this->user_tutor_id,
                'seller_id'		=>	$this->seller_id,
                'prop_list'		=>	$this->prop_list,
                'addressList'	=>	$this->addressList,
                'addressListJson'	=>	$this->addressListJson,
                'is_show_tutor_detail'	=>	$this->is_show_tutor_detail,
                'goodsTax'		=>	$this->goodsTax,
                'checkval'		=>	$this->checkval,
                'stime'			=>	$this->stime,
                'dprice'		=>	$this->dprice,
                'statement'		=>	$this->statement,
                'user_prop_count'	=>	$this->user_prop_count,
                'choose_date'	=>	$this->choose_date,
                'ischit'		=>	$this->ischit,
                'chitid'		=>	$this->chitid,
                'is_rehired'	=>	$this->is_rehired,
                'chit_info'		=>	$this->chit_info,
                'seller_tutor_info'	=>	$this->seller_tutor_info,
                'user_tutor_info'	=>	$this->user_tutor_info
            ),
        );
        
        $this->json_result($arr);
    }
    
    function get_user_cart3()
    {
    	$address_id    = IFilter::act(IReq::get('radio_address'),'int');
    	$delivery_id   = IFilter::act(IReq::get('delivery_id'),'int');
    	$delivery_id   = 1;
    	$accept_time   = IFilter::act(IReq::get('accept_time'));
    	$payment       = IFilter::act(IReq::get('payment'),'int');
    	$order_message = IFilter::act(IReq::get('message'));
    	$ticket_id     = IFilter::act(IReq::get('ticket_id'));
    	$taxes         = IFilter::act(IReq::get('taxes'),'float');
    	$tax_title     = IFilter::act(IReq::get('tax_title'));
    	$gid           = IFilter::act(IReq::get('direct_gid'),'int');
    	$num           = IFilter::act(IReq::get('direct_num'),'int');
    	$type          = IFilter::act(IReq::get('direct_type'));//商品或者货品
    	$promo         = IFilter::act(IReq::get('direct_promo'));
    	$active_id     = IFilter::act(IReq::get('direct_active_id'),'int');
    	$takeself      = IFilter::act(IReq::get('takeself'),'int');
	    $ticketUserd   = IFilter::act(IReq::get('ticketUserd'),'int');
    	$order_type    = 0;
    	$dataArray     = array();
    	$user_id       = $this->user['user_id'];
    	$stime         = IFilter::act(IReq::get('stime'),'int');
    	$dprice        = IFilter::act(IReq::get('dprice'),'float');
    	$statement     = IFilter::act(IReq::get('statement'),'float');
    	$statement = max( $statement, 1);
		$ischit = IFilter::act(IReq::get('ischit'),'int');
		$chitid = IFilter::act(IReq::get('chitid'),'int');
	    $seats    = IFilter::act(IReq::get('seats'));
    	// 全款模式下使用代金券

    	$use_coupon    = IFilter::act(IReq::get('use_coupon'),'int');
    	$use_coupon    = ( $statement == 1 && !$use_coupon ) ? 2 : $use_coupon;
    	$coupon_nums   = IFilter::act(IReq::get('coupon_nums'),'float');
    	
    	// 优惠券的ID
    	$user_prop_ids = IFilter::act(IReq::get('user_prop_ids'));
    	$user_prop_ids = explode(',', $user_prop_ids);
    	$choose_date = IFilter::act(IReq::get('choose_date'));
    	
    	// 家教模式
    	$seller_tutor_id = IFilter::act(IReq::get('seller_tutor_id'),'int');
    	$user_tutor_id = IFilter::act(IReq::get('user_tutor_id'),'int');
    	$is_tutor_detail = isset($_POST['tutor_detail']) ? true : false;
    	$receive_method  = IFilter::act(IReq::get('receive_method'),'int');
    	$teaching_time = IFilter::act(IReq::get('teaching_time'));
    	$teaching_time2 = IFilter::act(IReq::get('teaching_time2'));
    	$test_time = IFilter::act(IReq::get('test_time'));
    	$test_type = IFilter::act(IReq::get('test_type'));
    	$test_condition = IFilter::act(IReq::get('test_condition'));
    	$test_money = IFilter::act(IReq::get('test_money'));
    	$this->seller_id = IFilter::act(IReq::get('seller_id'), 'int');
    	
    	$tutor_data = array(
    	    'gender'            =>  IFilter::act(IReq::get('gender'),'int'),
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
    	    'address2'           =>  IFilter::act(IReq::get('address2')),
    	    'description'       =>  IFilter::act(IReq::get('description')),
    	    'user_id'           =>  $user_id,
    	    'teaching_time'     =>  IFilter::act(IReq::get('teaching_time')),
    	    'create_time'       =>  time(),
    	);

		//获取商品数据信息
    	$countSumObj = new CountSum($user_id);
		$goodsResult = $countSumObj->cart_count($gid,$type,$num,$promo,$active_id, $dprice, $statement, $stime, $use_coupon, $coupon_nums );
		if($countSumObj->error)
		{
			$this->json_error($countSumObj->error);
			exit();
		}
		
		// 家教购买的验证
		if ( $statement == 4 )
		{
		    if ( $seller_tutor_id )
		    {
		        $seller_tutor_info = seller_tutor_class::get_seller_tutor_info($seller_tutor_id);
		        if ( !$seller_tutor_info )
		        {
		            $this->json_error('该家教信息可能已被删除');
		            exit();
		        }
		        if (!seller_class::is_tutor_seller($seller_tutor_info['seller_id']))
		        {
		            $this->json_error('该学校无家教信息');
		            exit();
		        }
		    }
		    if ( $user_tutor_id )
		    {
		        $user_tutor_info = tutor_class::get_tutor_info($user_tutor_id);
		        if ( !$user_tutor_info )
		        {
		            $this->json_error('该家教信息可能已被删除');
		            exit();
		        }
		    }
		}


		//处理收件地址
        $addressDB = new IModel('address');
        if(!$address_id)
        {
            $accept_name   = IFilter::act(IReq::get('accept_name'));
            $mobile   = IFilter::act(IReq::get('mobile'));
            $addressRow= $addressDB->getObj("accept_name = '$accept_name' and mobile = '$mobile' and user_id = '$user_id'");
        } else {
            $addressRow= $addressDB->getObj('id = '.$address_id.' and user_id = '.$user_id);
        }

		if(!$addressRow && !$chitid)
		{
		    $this->json_error('收货地址信息不存在');
		    exit();
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
		    "pay_type"    => $payment,
    	);

    	/**
    	 * 取消重复的检查
    	$result = order_class::checkRepeat($checkData,$goodsResult['goodsList']);
    	if( is_string($result) )
    	{
			IError::show(403,$result);
    	}
    	**/

		//配送方式,判断是否为货到付款
		$deliveryObj = new IModel('delivery');
		$deliveryRow = $deliveryObj->getObj('id = '.$delivery_id);
		if(!$deliveryRow)
		{
		    $this->json_error('配送方式不存在');
		    exit();
		}

		if($deliveryRow['type'] == 0)
		{
			if($payment == 0)
			{
				$this->json_error('请选择正确的支付方式');
				exit();
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
				$this->json_error('请选择正确的自提点');
				exit();
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
			// 暂时不清空购物车，用于测试
		    $cartObj = new Cart();
		    $cartObj->clear();
		}

    	//判断商品是否存在
    	if(is_string($goodsResult) || empty($goodsResult['goodsList']))
    	{
    		$this->json_error('商品数据错误');
    		exit();
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
			$this->json_error('支付方式不存在');
			exit();
		}
		$paymentName= $paymentRow['name'];
		$paymentType= $paymentRow['type'];

		//最终订单金额计算
		$orderData = $countSumObj->countOrderFee($goodsResult,$province,$delivery_id,$payment,$taxes,0,$promo,$active_id, $dprice, $statement, $stime, $use_coupon, $coupon_nums  );
		if(is_string($orderData))
		{
			$this->json_error($orderData);
			exit();
		}
		
		//根据商品所属商家不同批量生成订单
		$orderIdArray  = array();
		$orderNumArray = array();
		$final_sum     = 0;
		$goods_arr     = array();
		$seller_arr    = array();
		$tuition       = 0;
		$tutor_db = new IModel('tutor');
		foreach($orderData as $seller_id => $goodsResult)
		{
		    // 商品拆单
    		foreach( $goodsResult['goodsList'] as $Kk => $vv )
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
    				'exp'                 => $vv['exp'],
    				'point'               => $vv['point'],
    				'type'                => $order_type,
    				//商品价格
    				'payable_amount'      => $vv['sum'],
    				'real_amount'         => $vv['sum'],
    				//运费价格
    				'payable_freight'     => $goodsResult['deliveryOrigPrice'],
    				'real_freight'        => $goodsResult['deliveryPrice'],
    				//手续费
    				'pay_fee'             => $goodsResult['paymentPrice'],
    				//税金
    				'invoice'             => $tax_title ? 1 : 0,
    				'invoice_title'       => $tax_title,
    				//'taxes'               => $goodsResult['taxPrice'],
    				'taxes'               => 0,
    				//优惠价格
    				//'promotions'          => $goodsResult['proReduce'] + $goodsResult['reduce'],
    				'promotions'	    	=> $vv['reduce'],
    				//订单应付总额
    				//'order_amount'        => $goodsResult['orderAmountPrice'],
    				'order_amount'		    => $vv['sum'],
    				//订单保价
    				//'insured'             => $goodsResult['insuredPrice'],
    				'insured'		        => 0,
    				//自提点ID
    				'takeself'            => $takeself,
    				//促销活动ID
    				'active_id'           => $active_id,
    				//商家ID
    				'seller_id'           => $seller_id,
    				//备注信息
    				'note'                => '',
    			    'order_chit'          => ( $use_coupon == 1 && $coupon_nums > 0 ) ? $vv['order_chit'] : 0,
    			);

    			// 如果是订金结算，则计算低佣金额和尾款
    			if ( $statement == 2 )
    			{
    			    $goods_info = $goodsResult['goodsList'][0];
    			    $cprice = $dprice;
    			    $dataArray['dprice'] = order_class::get_dprice_by_cprice( $cprice );
    			    $dataArray['rprice'] = order_class::get_rprice_by_cprice( $cprice, $dataArray['dprice'] );
    			    $dataArray['rest_price'] = $vv['rest_price'];
    			} else if ( $statement == 3 ) {
    			    $goods_info = $goodsResult['goodsList'][0];
    			    $cprice = $dprice;
    			    $dataArray['dprice'] = $cprice * $goods_info['count'];
    			    $dataArray['rest_price'] = $vv['rest_price'];
    			    $dataArray['choose_date'] = strtotime( $choose_date );
    			} else if ( $statement == 4 ) {
    			    $goods_info = $goodsResult['goodsList'][0];
    			    $dataArray['dprice'] = 0;
    			    $dataArray['rprice'] = 0;
    			    $dataArray['rest_price'] = 0;
    			    
    			    // 无奖励机制，读取商户发布的家教信息
    			    if ( $seller_tutor_info )
    			    {
    			        $dataArray['seller_id'] = $seller_tutor_info['seller_id'];
    			        $vv['seller_id'] = $dataArray['seller_id'];
    			        $dataArray['seller_tutor_id'] = $seller_tutor_id;
    			        	
    			        $seller_info = seller_class::get_seller_info($seller_tutor_info['seller_id']);
    			        $vv['name'] = $seller_info['true_name'];
    			        $vv['spec'] = category_class::get_category_title($seller_tutor_info['grade_level']) . category_class::get_category_title($seller_tutor_info['grade']);
    			        	
    			        $teacher_info = Teacher_class::get_teacher_info_by_seller2($seller_tutor_info['seller_id']);
    			        	
    			        // 是否续聘
    			        $dataArray['is_rehired'] = seller_class::check_seller_hired($seller_tutor_info['seller_id'], $user_id);
    			    }
    			    
    			    // 有奖励机制，读取用户发布的家教信息
    			    if ( $user_tutor_info && $this->seller_id )
    			    {
    			        $dataArray['seller_id'] = $this->seller_id;
    			        $vv['seller_id'] = $dataArray['seller_id'];
    			        $dataArray['user_tutor_id'] = $user_tutor_id;
    			        
    			        $seller_info = seller_class::get_seller_info($dataArray['seller_id']);
    			        $vv['name'] = $seller_info['true_name'];
    			        $vv['spec'] = category_class::get_category_title($user_tutor_info['grade_level']) . category_class::get_category_title($user_tutor_info['grade']);
    			        
    			        $teacher_info = Teacher_class::get_teacher_info_by_seller2($dataArray['seller_id']);
    			        
    			        // 是否续聘
    			        $dataArray['is_rehired'] = seller_class::check_seller_hired($dataArray['seller_id'], $user_id);
    			        
    			        // 如果有奖励机制，付款金额需要增加奖金
    			        $tutor_reward_list = array();
    			        if ( $test_time && $test_type && $test_condition && $test_money )
    			        {
    			            foreach($test_time as $k => $v )
    			            {
    			                if ( $vv && $test_type[$k] && $test_condition[$k] && $test_money[$k] )
    			                {
    			                    $tutor_reward_list[] = array(
    			                        'user_id'    =>  $user_id,
    			                        'seller_id'  =>  $dataArray['seller_id'],
    			                        'test_time'  =>  strtotime($test_time[$k]),
    			                        'test_type'  =>  $test_type[$k],
    			                        'test_condition' =>  $test_condition[$k],
    			                        'test_money' =>  $test_money[$k],
    			                        'status' =>  1,
    			                    );
    			                    $vv['sum'] += $test_money[$k];
    			                }
    			            }
    			        }
    			        
    			        $dataArray['payable_amount'] = $dataArray['real_amount'] = $dataArray['order_amount'] = $vv['sum'];
    			    }

    			    $vv['market_price'] = $dprice;
    			    $vv['sell_price'] = $dprice;
    			    $vv['cost_price'] = $dprice;
    			    $vv['img'] = $teacher_info['icon'];
    			    
    			    // 获取家教分类
                    $tutor_cate_list = category_class::get_category_list_by_parent(2);
                    $cates_arr = array();
                    if($tutor_cate_list)
                    {
                        foreach($tutor_cate_list as $key => $val)
                        {
                            $cates_arr[$val['id']] = $val['name'];
                        }
                    }
    			    
    			    $dataArray['tutor_type'] = ($is_tutor_detail) ? 1 : 0;
    			    
    			    // 续聘的操作
    			    if($dataArray['is_rehired'] )
    			    {
    			        $dataArray['receive_method'] = $receive_method;
    			        $class_time_rule = array();
    			        if ( $teaching_time && $teaching_time2 )
    			        {
    			            foreach( $teaching_time as $kk => $v )
    			            {
    			                if ( $teaching_time[$kk] && $teaching_time2[$kk] )
    			                {
    			                    $class_time_rule[] = array(
    			                        'week' => $v,
    			                        'time' => $teaching_time2[$kk],
    			                    );
    			                }
    			            }
    			        }
    			        
    			        $dataArray['class_time_rule'] = serialize($class_time_rule);
    			        $dataArray['class_start_date'] = tutor_class::get_start_date($class_time_rule);
    			        $dataArray['class_end_date'] = tutor_class::get_end_date($dataArray['class_start_date'], $class_time_rule, $num);
    			    }
    			}
    			$dataArray['statement'] = $statement;

    			// 全款和定金模式下可使用代金券
    			if( in_array($statement, array(1,3)) && $user_prop_ids )
    			{
    			    $coupon_nums = 0;
    			    foreach( $user_prop_ids as $kks => $vvs )
    			    {
    			        $info = prop_class::get_prop_info($vvs);
    			        $coupon_nums += $info['value'];
    			        $ticket_list[] = $info;
    			    }
    			    $dataArray['coupon_nums'] = $coupon_nums;
    			    $dataArray['prop'] = implode(',', $user_prop_ids );    				
    				$dataArray['promotions']   += $coupon_nums;
    				
    				if ( $statement == 1)
    				{
    				    $dataArray['order_amount'] -= $coupon_nums;
    				    
    				    $dataArray['payable_amount'] -= $coupon_nums;
    				} else {
    				    $dataArray['order_amount'] -= $vv['order_chit'];
    				    
    				    $dataArray['payable_amount'] -= $vv['order_chit'];
    				}

    				if ( $ticket_list )
    				{
    				    foreach( $ticket_list as $k => $v )
    				    {
    				        $goodsResult['promotion'][] = array("plan" => "代金券","info" => "使用了￥".$v['value']."代金券");
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
    			
    			// 处理1对1的学习券
    			if ( $ischit )
    			{
    			    $chit_info = brand_chit_class::get_chit_info($chitid);
    			    if ( $chit_info )
    			    {
    			        $seller_id = $chit_info['seller_id'];
    			        $dataArray['seller_id'] = $chit_info['seller_id'];
    			        $dataArray['chit_id'] = $chitid;
    			    }
    			    $vv['name'] = brand_chit_class::get_chit_name($chit_info['max_price'], $chit_info['max_order_chit']);
    			    $vv['spec'] = '';
    			}

    			//生成代金券
    			if ( $statement == 2 )
    			{
    			    $chit_info = brand_chit_class::get_chit_info($dataArray['chit_id']);
    			    $prop_id = prop_class::add_prop('代金券', $chit_info['max_order_chit'], $seller_id, $user_id);
    			    if ( !$prop_id )
    			    {
    			        $this->json_error('生成代金券失败');
    			        exit();
    			    }

    			    $dataArray['prop'] = ( $dataArray['prop'] == '' ) ? $prop_id : $dataArray['prop'] . ',' . $prop_id;

    			}

                if($seats)
                {
                    $dataArray['seats'] = $seats;
                }
                
    			//生成订单插入order表中
    			$orderObj  = new IModel('order');
    			$orderObj->setData($dataArray);
    			$order_id = $orderObj->add();

    			if($order_id == false)
    			{
    				$this->json_error('订单生成错误');
    				exit();
    			}

    			/*将订单中的商品插入到order_goods表*/
    	    	$orderInstance = new Order_Class();
    	    	$aa = array();
    	    	$aa['goodsList'][] = $vv;
    	    	$orderInstance->insertOrderGoods($order_id,$aa);

    			//订单金额小于等于0直接免单
    			if($dataArray['order_amount'] <= 0)
    			{
    				Order_Class::updateOrderStatus($dataArray['order_no']);
    			} else {
    				$orderIdArray[]  = $order_id;
    				$orderNumArray[] = $dataArray['order_no'];
    				$final_sum      += $dataArray['order_amount'];

    				// 读取商家信息
    				$order_info = order_class::get_order_info($dataArray['order_no'], 2);
    				$seller_info = seller_class::get_seller_info($order_info['seller_id']);
    				$tuition += $vv['market_price'] * $vv['count'];
    				$goods_arr[] = $vv;
    				$seller_arr[] = $seller_info;
    			}

    			// 生成订单日志
    			order_log_class::add_log( $order_id, 2 );
    			
    			// 插入奖励列表
    			if ( $statement == 4 && $user_tutor_info && $tutor_reward_list )
    			{
    			    $order_tutor_rewards_db = new IModel('order_tutor_rewards');
    			    foreach($tutor_reward_list as $k => $v)
    			    {
    			        $v['order_id'] = $order_id;
    			        $order_tutor_rewards_db->setData($v);
    			        $order_tutor_rewards_db->add();
    			    }
    			}
    			
    			// 添加家教具体信息到
    			if ($is_tutor_detail)
    			{
    			    $tutor_data['order_id'] = $order_id;
    			    $tutor_db->setData($tutor_data);
    			    $user_tutor_id = $tutor_db->add();
    			    
    			    // 生成合同
    			    tutor_class::create_contract($user_tutor_id);
    			}
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
					'takeself' => $takeself,
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

		//课程名称
		$goods_name = '';
		if ( $goods_arr )
		{
		    foreach( $goods_arr as $kk => $vv )
		    {
		        $goods_name .= ( !$goods_name ) ? $vv['name'] : ',' . $vv['name'];
		        $goods_name .= ( $vv['spec'] ) ? ' - ' . $vv['spec'] : '';
		    }
		}
		if ( $statement == 3)
		    $goods_name .= ' (定金)';
		elseif ( $statement == 4)
		    $goods_name .= ' (家教)';

		//学校名称
		$seller_name_arr = array();
    	if ( $seller_arr )
		{
		    foreach( $seller_arr as $kk => $vv )
		    {
		        $seller_name_arr[] = $vv['true_name'];
		    }
		}

		//数据渲染
		$this->order_id    = join("_",$orderIdArray);
		$this->final_sum   = $final_sum;
		$this->order_num   = join(",",$orderNumArray);
		$this->payment     = $paymentName;
		$this->paymentType = $paymentType;
		$this->payment_id = $payment;
		$this->delivery    = $deliveryRow['name'];
		$this->tax_title   = $tax_title;
		$this->deliveryType= $deliveryRow['type'];
		$this->chitid = $chitid;
		$this->goods_name  = $goods_name;
		$this->seller_name = join(',', $seller_name_arr );

		//订单金额为0时，订单自动完成
		if($this->final_sum <= 0)
		{
            $this->json_result($dataArray);
            exit();
		} else {
		    if ( $dataArray['statement'] == 4 && $dataArray['tutor_type'] == 1)
		    {
		        $tutor_info = tutor_class::get_tutor_info_by_order_id($this->order_id);
		        $dataArray['tutor_info'] = $tutor_info;
		    }
			if ( $statement == 3)
			     $this->choose_date = date('Y-m-d', $order_info['choose_date']);
			$this->tuition = number_format( $tuition, 2, '.', '');
			$is_set_trade_passwd = member_class::is_set_trade_passwd($user_id);
			$this->is_set_trade_passwd = $is_set_trade_passwd;
		}
		
		$result = $dataArray;
		$result['this'] = array(
		    'seller_id'   =>  $this->seller_id,
		    'order_id'    =>  $this->order_id,
		    'final_sum'   =>  $this->final_sum,
		    'order_num'   =>  $this->order_num,
		    'payment'     =>  $this->payment,
		    'paymentType' =>  $this->paymentType,
		    'payment_id'  =>  $this->payment_id,
		    'delivery'    =>  $this->delivery,
		    'tax_title'   =>  $this->tax_title,
		    'deliveryType'    =>  $this->deliveryType,
		    'chitid'      =>  $this->chitid,
		    'goods_name'  =>  $this->goods_name,
		    'seller_name' =>  $this->seller_name,
		    'tuition'     =>  $this->tuition,
		    'is_set_trade_passwd' =>  $this->is_set_trade_passwd,
		);
		
		$this->json_result($result);
    }
    
    
    function address_add_ajax()
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
        
        $address_db = new IQuery('address');
        $address_db->where = 'user_id = ' . $user_id;
        $my_address_list = $address_db->find();
        if ( $my_address_list )
        {
            foreach( $my_address_list as $kk => $vv )
            {
                if ( $vv['accept_time'] == $accept_name && $vv['mobile'] == $mobile )
                {
                    $result = array('result' => false,'msg' => '姓名和电话号码重复');
                    die(JSON::encode($result));
                }
            }
        }

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
            'is_default'  => 1
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
        
        $model = new IModel('address');
        foreach($my_address_list as $v){
            if( $v['is_default'] == 1 ){
                $model->setData(array('is_default'=>0));
                $model->update("id = ".$v['id']);
            }
        }
        
        if($user_id)
        {
            $model->setData($sqlData);
            if($id)
            {
                $model->update("id = ".$id." and user_id = ".$user_id);
            } else {
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
    
    function get_user_account_info()
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
        $frozen_amount = order_tutor_rebates_class::get_user_rebate_amount($this->user['user_id']);
        
        $result = array(
            'page'  =>  $page,
            'page_size' =>  $page_size,
            'page_count'    =>  $paging->totalpage,
            'frozen_amount' =>  $frozen_amount,
            'memberRow'     =>  $this->memberRow,
            'result_list'   =>  $result_list,
        );

        $this->json_result($result);
    }
    
    function get_user_consult_list()
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
                $consult_list[$kk]['time'] = date('Y-m-d', $vv['time']);
            }
        }
        
        $this->json_result($consult_list);
    }
    
    function get_user_integral_info()
    {
        $memberObj         = new IModel('member');
        $where             = 'user_id = '.$this->user['user_id'];
        $memberRow   = $memberObj->getObj($where,'point');
        
        /*获取积分增减的记录日期时间段*/
        $this->historyTime = IFilter::string( IReq::get('history_time','post') );
        $defaultMonth = 3;//默认查找最近3个月内的记录
        $lastStamp    = ITime::getTime(ITime::getNow('Y-m-d')) - (3600*24*30*$defaultMonth);
        $lastTime     = ITime::getDateTime('Y-m-d',$lastStamp);
        if($this->historyTime != null && $this->historyTime != 'default')
        {
            $historyStamp = ITime::getDateTime('Y-m-d',($lastStamp - (3600*24*30*$this->historyTime)));
            $this->c_datetime = 'datetime >= "'.$historyStamp.'" and datetime < "'.$lastTime.'"';
        } else {
            $this->c_datetime = 'datetime >= "'.$lastTime.'"';
        }
        
        $queryPointLog = Api::run('getUcenterPointLog',$this->user['user_id'],$this->c_datetime);
        $integral_list = $queryPointLog->find();
        
        $result = array(
            'member_info'   =>  $memberRow,
            'integral_list' =>  $integral_list,
        );
        
        $this->json_result($result);
    }
    
    function get_user_message_list()
    {
        $msgObj = new Mess($this->user['user_id']);
        $page = IFilter::act(IReq::get('page'),'int');
        $page = max($page,1);
        $message_db = Mess::get_user_message_list_db($this->user['user_id'], $page);
        $message_list = $message_db->find();
        
        $this->json_result($message_list);
    }
    
    function get_user_message_info()
    {
        $id = IFilter::act( IReq::get('id'),'int' );
        $user_id = $this->user['user_id'];
        if ( !$id )
        {
            $this->json_error('参数不正确');
            exit();
        }
        
        $message_info = Mess::get_message_info($id);
        if ( !$message_info )
        {
            $this->json_error('消息可能已被删除');
            exit();
        }
        
        if ( $message_info && $message_info['user_id'] != $user_id )
        {
            $this->json_error('您没有权限查看此消息');
            exit();
        }
        
        $message_db = new IModel('message');
        $message_db->setData(array(
            'is_read' => 1,
        ));
        $message_db->update('id = ' . $id);
        
        $this->json-result($message_info);
    }
    
    function update_user_password()
    {
        $user_id    = $this->user['user_id'];
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
                $this->json_result();
                exit();
            } else {
                $message = '交易密码修改失败';
            }
        }
        
        $this->json_error($message);
    }
    
    function get_user_redpacket()
    {
        $type = IFilter::act(IReq::get('type'),'int');
        $my_prop_list_ing = $this->format_prop(API::run('getUserPropListing', $this->user['user_id']));
        $my_prop_list_ed = $this->format_prop(API::run('getUserPropListed', $this->user['user_id']));
        $my_prop_list_notpay = $this->format_prop(API::run('getUserPropListNotPay', $this->user['user_id']));
        
        if($type == 1){
            $my_prop_list_ing['num'] = count($my_prop_list_ing);
            $result = $my_prop_list_ing;
        }elseif($type == 2){
            $my_prop_list_ed['num'] = count($my_prop_list_ed);
            $result = $my_prop_list_ed;
        }else{
            $my_prop_list_notpay['num'] = count($my_prop_list_notpay);
            $result = $my_prop_list_notpay;
        }
        
        $this->json_result($result);
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
                $order_goods_list = Order_goods_class::get_order_goods_list($vv['id'] );
                $my_prop_list[$kk]['goods'] = current( $order_goods_list );
                $my_prop_list[$kk]['goods']['goods_array'] = json_decode( $my_prop_list[$kk]['goods']['goods_array'] );
                $my_prop_list[$kk]['goods']['name'] = $my_prop_list[$kk]['goods']['goods_array']->name;
                $my_prop_list[$kk]['goods']['value'] = $my_prop_list[$kk]['goods']['goods_array']->value;
                $my_prop_list[$kk]['isrefund'] = Order_Class::isRefundmentApply($vv);
                $my_prop_list[$kk]['state'] = order_class::getOrderStatus($vv);
                if($vv['chit_id'])
                {
                    $my_prop_list[$kk]['chit_info'] = brand_chit_class::get_chit_info($vv['chit_id']);
                    $my_prop_list[$kk]['chit'] = $my_prop_list[$kk]['chit_info']['max_order_chit'];
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
    
    function get_user_order_list()
    {
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
                $order_list[$kk]['total_amount'] = number_format($order_list[$kk]['goods']['market_price'] * $order_list[$kk]['goods']['goods_nums'], 2, '.', '');
            }
        }
        
        $order_list['num'] = sizeof($order_list);
        $order_list['page'] = $page + 1;
        $this->initPayment();
        $is_set_trade_passwd = member_class::is_set_trade_passwd($user_id);
        
        $arr = array(
            'order_list'    =>  $order_list,
            'is_set_trade_passwd'   =>  $is_set_trade_passwd,
        );
        
        $this->json_result($arr);
        
    }
    
    function get_order_detail()
    {
        $id = IFilter::act(IReq::get('id'),'int');
        $orderObj = new order_class();
        $user_id = $this->user['user_id'];
        $this->order_info = $orderObj->getOrderShow($id,$user_id);
        if(!$this->order_info)
        {
            $this->json_error('订单信息不存在');
            exit();
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
        $seller_info = Seller_class::get_seller_info( $this->order_info['seller_id'] );
        $this->order_info['seller_info'] = $seller_info;
        if($this->order_info['chit_id'])
        {
            $chit_info = brand_chit_class::get_chit_info($this->order_info['chit_id']);
        } else {
            $chit_info = '';
        }
        $this->order_info['chit_info'] = $chit_info;
        if ( $this->order_info['statement'] == 4 && $this->order_info['user_tutor_id'] > 0 )
        {
            $tutor_info = tutor_class::get_tutor_info($this->order_info['user_tutor_id']);
            $test_rewards = order_tutor_rewards_class::get_order_rewards($id);
            if ( $test_rewards )
                $tutor_info['test_reward'] = $test_rewards;
            else if ( $tutor_info['test_reward'] )
            {
                $tutor_info['test_reward'] = unserialize($tutor_info['test_reward']);
            }
        
            if ( !$tutor_info || $tutor_info['user_id'] != $user_id )
                $tutor_info = array();
        }
        
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
                
        //虚拟商品 by xgy
        $goodsDB = new IModel('goods');
        $goodInfo = $goodsDB->getObj('id = '.$goods_list[0]['goods_id'],'model_id');
        if($goodInfo['model_id'] == 9){
        
            $accountsDB = new IQuery('goods_virtual_accounts as v');
            $accountsDB->join = " left join goods as g on v.goods_id = g.id left join seller as s on g.seller_id = s.id";
            $accountsDB->fields = "v.id,v.goods_id,v.accounts,v.status,g.name,g.seller_id,s.true_name";
            $accountsDB->where = "v.order_id = ".$id;
            $info = $accountsDB->find();
        }
        
        $result = array(
            'seller_info'   =>  $seller_info,
            'order_info'    =>  $this->order_info,
            'chit_info'     =>  $chit_info,
            'goods_list'    =>  $goods_list,
            'orderStatus'   =>  $orderStatus,
            'order_id'      =>  $id,
            'is_set_trade_passwd'   =>  $is_set_trade_passwd,
            'tutor_info'    =>  $tutor_info,
            'cates_arr'     =>  $cates_arr,
            'accounts'      =>  $info[0],
            'orderStatusStr'   =>  Order_Class::orderStatusText($orderStatus),
            'orderStatus'   =>  $orderStatus,
            'orderStep'     =>  $this->orderStep,
        );
        
        $this->json_result($result);
        
    }
    
    function order_confirm()
    {
        $order_id = IFilter::act(IReq::get('order_id'),'int');
        $user_id = $this->user['user_id'];
        $order_info = order_class::get_order_info($order_id);
        if ( !$order_info )
        {
            $this->json_error('订单信息不存在');
            exit();
        }

        if ( order_class::getOrderStatus( $order_info ) == 13 )
        {
            $order_db = new IModel('order');
            $order_db->setData(array(
                'is_confirm'   =>  1,
            ));
            if ( $order_db->update('id = ' . $order_id ) )
            {
                $seller_info = Seller_class::get_seller_info($order_info['seller_id'] );
                $mobile = $seller_info['mobile'];
                $order_goods = Order_goods_class::get_order_goods_list( $order_id );
        
                // 商户代金券-发短信给用户
                if ( $order_info['mobile'] && $order_info['chit_id'] > 0 )
                {
                    // 代金券的内容
                    $chit_info = brand_chit_class::get_chit_info($order_info['chit_id']);
                    if ( $chit_info )
                    {
                        $chit_str = $chit_info['max_price'] . '抵' . $chit_info['max_order_chit'];
                        $content = '您购买的' . $seller_info['shortname'] . ' ' . $chit_str . '代金券您已确认使用！【乐享生活】';
                        $sms = new Sms_class();
                        $result = $sms->send( $mobile, $content );
                    }
        
                    if ( $order_info['prop'] )
                    {
                        prop_class::update_prop_use_status($order_info['prop']);
                    }
                }
        
                // 发短信给商户
                if ( $order_goods && $mobile != '')
                {
                    $goods_array = JSON::decode( $order_goods[0]['goods_array'] );
                    $goods_name = $goods_array['name'];
                    $content = '您好，用户' . $order_info['accept_name'] . '在乐享生活上订购了您的课程' . $goods_name . '，已经付款成功。【乐享生活】';
                    $sms = new Sms_class();
                    $result = $sms->send( $mobile, $content );
                }
            }
        
            // 生成订单日志
            order_log_class::add_log( $order_info['id'], 4 );
        
            // 家教订单，支付定金的类型自动完成
            if ( $order_info['statement'] == 4 && !$order_info['is_rehired'])
            {
                $order_goods_list = Order_goods_class::get_order_goods_list($order_id);
                $sendgoodsarr = array( $order_goods_list[0]['id'] );
                $result=Order_Class::sendDeliveryGoods($order_id,$sendgoodsarr,$order_info['seller_id'],'seller');
                 
                // 订单完成
                $model = new IModel('order');
                $model->setData(array('status' => 5,'completion_time' => ITime::getDateTime()));
                $user_id = $order_info['user_id'];
                if($model->update("id = ".$order_id." and distribution_status = 1 and user_id = ".$user_id))
                {
                    $orderRow = $order_info;
                     
                    //确认收货后进行支付
                    Order_Class::updateOrderStatus($orderRow['order_no']);
                     
                    //增加用户评论商品机会
                    Order_Class::addGoodsCommentChange($order_id);
                }
            }
            
            $this->json_result();
            exit();
        }
        
        $this->json_error('该订单可能已经确认，请勿重复操作');
    }
    
    function get_user_evaluation_list()
    {
        $page = IFilter::act(IReq::get('page'),'int');
        $page = max( $page, 1);
        $page_size = 10;
        $user_id = $this->user['user_id'];
        $type = IFilter::act(IReq::get('type'),'int');

        $queryEvaluationList = Api::run('getUcenterEvaluation',$user_id,$type);
        $queryEvaluationList->pagesize = $page_size;
        $result_list = $queryEvaluationList->find();
         
        if ( $result_list )
        {
            foreach( $result_list as $kk => $vv )
            {
                $goods_list = Api::run('getOrderGoodsListByGoodsid',array('#order_id#',$vv['id'] ));
                if ( $goods_list )
                {
                    foreach($goods_list as $key => $val )
                    {
                        $goods_array = json_decode($val['goods_array']);
                        $goods_list[$key]['value'] = $goods_array->value;
                    }
                }
                $result_list[$kk]['goods_list'] = ($goods_list) ? current($goods_list) : array();
                $result_list[$kk]['order_info'] = order_class::get_order_info($vv['order_no'],2);
                if ( $result_list[$kk]['order_info']['statement'] == 4)
                {
                    $seller_info = seller_class::get_seller_info($vv['seller_id']);
                    $result_list[$kk]['name'] = $seller_info['true_name'];
                }
            }
        }
        
        $result_list['num'] = sizeof($result_list);
        $result_list['page'] = $page + 1;
        $this->json_result($result_list);
    }
    
    
    // 验证用户token信息
    function check_user_token($user_id = 0, $token = '')
    {
        if ( !$user_id || !$token || strlen($token) != 32)
            return false;
        
        $user_db = new IQuery('user');
        $user_db->where = "id = $user_id and token = '$token'";
        $user_db->fields = 'id as user_id,username,password,trade_password,head_ico,email,promo_code,token';
        $user_info = $user_db->getOne();
        return ($user_info) ? $user_info : false;
    }
    
    function reset_trade_password()
    {
        $user_id    = $this->user['user_id'];
        member_class::reset_user_trade_password($user_id);
        $this->json_result();
    }
    
    function update_trade_password()
    {
        $user_id    = $this->user['user_id'];
        $password   = IReq::get('password');
        $repassword   = IReq::get('repassword');
        if(!preg_match('|\w{6,32}|',$password))
        {
            $this->json_error('密码格式不正确，请重新输入');
            exit();
        } else if($password != $repassword) {
            $this->json_error('二次密码输入的不一致，请重新输入');
            exit();
        } else {
            $passwordMd5 = md5($password);
            $dataArray = array(
                'trade_password' => $passwordMd5,
            );
            $userObj    = new IModel('user');
            $where      = 'id = '.$user_id;
            $userObj->setData($dataArray);
            $result  = $userObj->update($where);
            if ( $result )
            {
                $this->json_result();
            } else {
                $this->json_error('修改交易密码失败');
            }
        }
    }
    
    function check_trade_password()
    {
        $user_id    = $this->user['user_id'];
        $trade_password   = IReq::get('trade_password');
        
        $user_info = user_class::get_user_info($user_id);
        if ( !$user_info['trade_password'])
        {
            $this->json_error('您尚未设置交易密码，操作失败');
        } else if (md5($trade_password) == $user_info['trade_password']) {
            $this->json_result();
        } else {
            $this->error('交易密码不正确');
        }
    }
    
    function doPay_balance_app()
    {
        $user_id    = $this->user['user_id'];
        $payment_id = 1;
        $order_id   = IReq::get('order_id');
        
        $paymentInstance = Payment::createPaymentInstance(1);
    	if(!is_object($paymentInstance))
		{
			$this->json_error('支付方式不存在');
			exit();
		}
		
		if($order_id)
		{
		    $order_id = explode("_",$order_id);
		    $order_id = current($order_id);
		
		    //获取订单信息
		    $orderDB  = new IModel('order');
		    $orderRow = $orderDB->getObj('id = '.$order_id.' and user_id = ' . $user_id);

		    if(empty($orderRow))
		    {
		        $this->json_error('订单信息不存在');
		        exit();
		    }
		    if ( $payment_id != $orderRow['pay_type'] )
		    {
		        $this->json_error('支付方式不正确');
		        exit();
		    }
		    if ( $orderRow['pay_status'] == 1)
		    {
		        $this->json_error('订单已支付，请勿重复操作');
		        exit();
		    }
		} else {
		    $this->json_error('订单不存在');
		    exit();
		}
		
		$data = array(
		    'order_no' => $orderRow['order_no'],
		    'total_fee'   =>  $orderRow['order_amount'],
		);
		$this->pay_balance($data);
    }
    
    // 余额支付
    function pay_balance($data)
    {
        $urlStr  = '';
        $user_id = intval($this->user['user_id']);
        $return['total_fee']  = $data['total_fee'];
        $return['order_no']   = $data['order_no'];
        if(stripos($return['order_no'],'recharge') !== false)
        {
            $this->json_error('余额支付方式不能用于在线充值');
            exit();
        }
        
        if(floatval($return['total_fee']) < 0 || $return['order_no'] == '' )
        {
            $this->json_error('支付参数不正确');
            exit();
        }

        $paymentDB  = new IModel('payment');
        $paymentRow = $paymentDB->getObj('class_name = "balance" ');
        $pkey       = Payment::getConfigParam($paymentRow['id'],'M_PartnerKey');

        //md5校验
        ksort($return);
        foreach($return as $key => $val)
        {
            $urlStr .= $key.'='.urlencode($val).'&';
        }

        $memberObj = new IModel('member');
        $memberRow = $memberObj->getObj('user_id = '.$user_id);
        
        if(empty($memberRow))
        {
            $this->json_error('用户信息不存在');
            exit();
        }
        
        if($memberRow['balance'] < $return['total_fee'])
        {
            $this->json_error('账户余额不足');
            exit();
        }

        //检查订单状态
        $orderObj = new IModel('order');
        $orderRow = $orderObj->getObj('order_no  = "'.$return['order_no'].'" and pay_status = 0 and status = 1 and user_id = '.$user_id);
        if(!$orderRow)
        {
            $this->json_error('订单号【'.$return['order_no'].'】已经被处理过，请查看订单状态');
            exit();
        }

        //扣除余额并且记录日志
        $logObj = new AccountLog();
        $config = array(
            'user_id'  => $user_id,
            'event'    => 'pay',
            'num'      => $return['total_fee'],
            'order_no' => $return['order_no'],
        );
        
        $is_success = $logObj->write($config);
        if(!$is_success)
        {
            $this->json_error($logObj->error ? $logObj->error : '用户余额更新失败');
            exit();
        }

        Order_Class::updateOrderStatus($return['order_no']);
        $this->json_result();
    }
}


?>