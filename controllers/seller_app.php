<?php 


class Seller_app extends IController
{
    private $user = array();
    function init()
    {
        header( "Access-Control-Allow-Origin:*" );
        $this->seller_id = IFilter::act(IReq::get('seller_id'),'int');

    }

    function get_seller_info(){
        $seller_info = seller_class::get_seller_info($this->seller_id);        
        $brand_info = brand_class::get_brand_info($seller_info['brand_id']);

        if($brand_info){
            $brand_info['province_name'] = ($brand_info['province'] != 0)?area::getName($brand_info['province']):0;
            $brand_info['city_name'] = ($brand_info['city'] != 0)?area::getName($brand_info['city']):0;
            $brand_info['discrict_name'] = ($brand_info['discrict'] != 0)?area::getName($brand_info['discrict']):0;
            
            $brand_info['area'] = area::getJsonArea();


            $current_cate = brand_class::get_brand_category_by_ids($brand_info['category_ids']);
            $brand_info['current_cate'] = implode(',',$current_cate);
            //分类
            $brand_info['category'] = brand_class::get_brand_category_list();

            $result = array(
                'status' => 1,
                'data' => $brand_info
            );

        }else{
            $result = array(
                'status' => 0,
                'info' => '获取商家信息失败'
            );
        }        

        echo json_encode($result);
    }


    /**
     * @brief 商户的增加动作
     */
    public function brand_add()
    {
        $brand_id = IFilter::act(IReq::get('brand_id'),'int');
        $url = IFilter::act(IReq::get('url'));
        $category = IFilter::act(IReq::get('category'),'int');
        $password = IFilter::act(IReq::get('password'));
        $telephone = IFilter::act(IReq::get('telephone'));
        $mobile = IFilter::act(IReq::get('mobile'));
        $email = IFilter::act(IReq::get('email'));
        $province = IFilter::act(IReq::get('province'));
        $city = IFilter::act(IReq::get('city'));
        $discrict = IFilter::act(IReq::get('area'));
        $address = IFilter::act(IReq::get('address'));
        $qq = IFilter::act(IReq::get('qq'));
        $shortname = IFilter::act(IReq::get('shortname'));

        if(!$brand_id){
            echo json_encode(array('info'=>'提交数据有误！','status'=>0));
            return;
        }        

        if ( !$url )
            $url = brand_class::get_rand_host();        
        
        $tb_brand = new IModel('brand');
        $brand = array(
            'url'=>$url,
            'category_ids' => $category,
            'telephone' => $telephone,
            'mobile' => $mobile,
            'email' => $email,
            'province' => $province,
            'city' => $city,
            'discrict' => $discrict,
            'address' => $address,
            'qq' => $qq,
            'shortname' =>  $shortname,
        );

        if($brand_id && !empty($password))
        {
            $brand['password'] = md5($password);
            $sellerModel = new IModel('seller');
            $sellerModel->setData(array('password' => md5($password)));
            $sellerModel->update("brand_id = '$brand_id'");
        }

        $tb_brand->setData($brand);
        $where = "id=".$brand_id;
        $tb_brand->update($where);

        $sellerModel = new IModel('seller');
        $sellerData = array(
            'brand_id' => $brand_id,
            'home_url' => $url,
            'phone' => $telephone,
            'mobile' => $mobile,
            'email' => $email,
            'province' => $province,
            'city' => $city,
            'area' => $discrict,
            'address' => $address,
            'qq' => $qq,
            'shortname' =>  $shortname
        );
        if(!empty($password))
        {
            $sellerData['password'] = md5($password);
        }

        $sellerModel->setData($sellerData);
        $where = "brand_id=".$brand_id;
        $sellerModel->update($where);   
        
        echo json_encode(array('info'=>'编辑成功！','status'=>1));
    }


    public function ajax_goods_list()
    {
        
        $where = "go.seller_id='$this->seller_id' ";
        $page   = IReq::get('page') ? IFilter::act(IReq::get('page'),'int') : 1;

        $goodHandle = new IQuery('goods as go');
        $goodHandle->order  = "go.id desc";
        $goodHandle->fields = "distinct go.id,go.name,go.sell_price,go.market_price,go.store_nums,go.img,go.is_del,go.seller_id,go.is_share,go.sort";
        $goodHandle->where  = $where;
        $goodHandle->page   = $page;
        $goodHandle->limit  = 10;

        $goods_info = $goodHandle->find();
        foreach($goods_info AS $idx => $goods)
        {
            $goods_info[$idx]['brief'] = strip_tags($goods['content']);
        }
        $goods_info['num'] = count($goods_info);
        $goods_info['page'] = $page + 1;
        echo json_encode($goods_info);
    }


    public function ajax_order_list()
    {
        
        $orderHandle = new IQuery('order_goods as og');
        $orderHandle->join = 'left join goods as g on og.goods_id = g.id left join order as o on og.order_id = o.id';
        $orderHandle->order  = "o.id desc";
        $orderHandle->fields = 'o.*,og.img,og.cost_price,og.goods_nums,g.name';

        $orderHandle->where  = 'o.pay_status = 1 and og.seller_id = '.$this->seller_id.' and o.if_del = 0 and o.statement = 1 and o.status not in(3,4)';

        // $orderHandle->page   = $page;
        // $orderHandle->limit  = 10;

        $order_info = $orderHandle->find();

        if($order_info){
            foreach( $order_info as $k => $v ){
                $status_num = order_class::getOrderStatus($v);
                $order_info[$k]['order_status'] = order_class::orderStatusText($status_num,2,$v['statement']);
                $order_info[$k]['order_notice'] = order_class::get_order_notice($status_num,2);
                $order_info[$k]['total'] = $v['cost_price'] * $v['goods_nums'];
                $order_info[$k]['status_num'] = $status_num;
            }
        }

        $order_info['num'] = count($order_info);
        $order_info['page'] = $page + 1;
        
        echo json_encode($order_info);        
    }


    /**
     * @brief全款订单详情
     */
    public function get_order_info()
    {
        //获得post传来的值
        $order_id = IFilter::act(IReq::get('order_id'),'int');
        $verification_code = IFilter::act(IReq::get('verification_code'));

        $data = array();
        if($order_id)
        {
            $order_show = new Order_Class();
            $data = $order_show->getOrderShow($order_id,0,$this->seller_id);
            
            if($data)
            {
                //获取地区
                $data['area_addr'] = join('&nbsp;',area::name($data['province'],$data['city'],$data['area']));
                $data['verification_code'] = $verification_code;
                $data['goods_list'] = order_class::get_order_goods_list( $order_id );
                
                $data['status_num'] = order_class::getOrderStatus($data);
                $data['order_status'] = order_class::orderStatusText($data['status_num'],2,$data['statement']);
                
                //日志
                $data['log'] = order_log_class::get_order_logs($order_id);
                if(count($data['log']) > 0){
                    foreach($data['log'] as $k => $v){
                        $data['log'][$k]['action_name'] = order_log_class::read_log($v);
                    }
                }
                
                $result = array(
                    'status' => 1,
                    'data' => $data
                );
            }
        }
        if(!$data)
        {
            $result = array(
                'status' => 0,
                'info' => '该订单可能已被删除'
            );
        }       

        echo json_encode($result);
    }


    //确认收款
    public function order_finish()
    {
        $order_id = IFilter::act(IReq::get('order_id'),'int');
        $order_info = Order_Class::get_order_info( $order_id );



        if ( !$order_info )
        {
            $message = '该订单可能已被删除';
        }
        
        if ( $order_info['pay_status'] != 1)
        {
            $message = '该订单未付款，不能完成订单';
        }
        
        if ( !$order_info['is_confirm'] )
        {
            $message = '该订单未确认付款，不能完成订单';
        }
        
        // 发货
        $order_goods_list = Order_goods_class::get_order_goods_list($order_id);
        if ( !$order_goods_list )
        {
            $message = '该订单下无任何课程';
        }
        
        foreach( $order_goods_list as $kk => $vv )
        {
            if ( $vv['is_send'] == 1)
            {
                $message = '该订单已确认，不能重复确认';
            }
        }        

        
        $sendgoodsarr = array( $order_goods_list[0]['id'] );
        $result=Order_Class::sendDeliveryGoods($order_id,$sendgoodsarr,$this->seller_id,'seller');
        
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
        
        if($message){
            $result = array(
                'status' => 0,
                'data' => $message
            );
        }else{
            $result = array(
                'status' => 1,
                'data' => '确认成功'
            );
        }
        

        echo json_encode($result);
    }


    //咨询列表
    public function ajax_refer_list(){
        $page   = IReq::get('page') ? IFilter::act(IReq::get('page'),'int') : 1;

        $handleDB = new IQuery('refer as re');
        $handleDB->join = 'left join goods as go on go.id = re.goods_id left join user as u on u.id = re.user_id left join admin as a on a.id = re.admin_id left join seller as se on se.id = re.seller_id';
        $handleDB->fields = "se.seller_name,a.admin_name,u.username,re.*,go.name";
        $handleDB->where  = 'go.seller_id = '.$this->seller_id;
        $handleDB->page   = $page;
        $handleDB->limit  = 10;

        $info = $handleDB->find();

        $info['num'] = count($info);
        $info['page'] = $page + 1;

        
        echo json_encode($info);
    }

    //咨询内容
    public function refer_edit(){
        $refer_id = IFilter::act(IReq::get('refer_id'),'int');

        if( $refer_id ){
            $referDB = new IQuery('refer');
            $referDB->where = 'id='.$refer_id;
            $info = $referDB->getOne();

            if(!$info){
                $info['message'] = '内容不存在！';
            }

        }else{
            $info['message'] = 'ID错误！';
        }

        echo json_encode($info);

    }

    //咨询回复
    public function refer_reply()
    {
        $rid     = IFilter::act(IReq::get('refer_id'),'int');
        $content = IFilter::act(IReq::get('content'),'text');

        if($rid && $content)
        {
            $tb_refer = new IModel('refer');
            $seller_id = $this->seller_id;//商户id
            $data = array(
                'answer' => $content,
                'reply_time' => ITime::getDateTime(),
                'seller_id' => $seller_id,
                'status' => 1
            );
            $tb_refer->setData($data);
            $tb_refer->update("id=".$rid);

            $result = array(
                'status' => 1,
                'data' => '回复成功！'
            );
        }else{
            $result = array(
                'status' => 0,
                'data' => '回复内容不能为空!'
            );
        }
        echo json_encode($result);
    }

    /**
     * @brief 删除咨询信息
     */
    function refer_del()
    {
        $refer_id = IFilter::act(IReq::get('refer_id'),'int');
        if($refer_id)
        {
            $referModel = new IModel('refer');
            if($referModel->del('id='.$refer_id)){
                echo json_encode(array('status'=>1,'info'=>'删除成功！'));
                return;
            }

        }
        echo json_encode(array('status'=>0,'info'=>'删除失败！'));
    }


    //评价列表
    public function comment_list(){
        $page   = IReq::get('page') ? IFilter::act(IReq::get('page'),'int') : 1;

        $handleDB = new IQuery('comment as c');
        $handleDB->join = 'left join goods as g on c.goods_id = g.id left join user as u on c.user_id = u.id';
        $handleDB->fields = "c.*,u.username,g.id as goods_id,g.name as goods_name";
        $handleDB->order = 'c.id desc';
        $handleDB->where  = 'c.status = 1 and g.seller_id = '.$this->seller_id;
        $handleDB->page   = $page;
        $handleDB->limit  = 10;

        $info = $handleDB->find();

        if($info){
            $info['num'] = count($info);
            $info['page'] = $page + 1;
        }
       
        echo json_encode($info);
    }

    //帮助信息
    function help()
    {
        $id       = IFilter::act(IReq::get("id"),'int');
        $tb_help  = new IModel("help");
        $help_row = $tb_help->getObj("id=".$id);
        
        if(!$help_row)
        {
            $message = "您查找的页面已经不存在了";
            echo json_encode(array('info'=>$message,'status'=>0));
            return;
        }

        $help_row['content'] = str_replace('\n', '',$help_row['content']);


        echo json_encode(array('info'=>$help_row,'status'=>1));
    }

    //帐户详情
    public function sale_tixian()
    {
        $page   = IReq::get('page') ? IFilter::act(IReq::get('page'),'int') : 1;

        $sellerRow = seller_class::get_seller_info($this->seller_id);
        // 通过是否认证判断商户是否可以提现
        $can_tixian = ( $sellerRow['is_authentication'] == 1 ) ? true : false;

        $orderGoodsQuery = CountSum::getSellerGoodsFeeQuery($this->seller_id);
        $orderGoodsQuery->page = $page;
        $order_list = $orderGoodsQuery->find();
                
        $result = array(
            'sellerRow'   =>  $sellerRow,
            'order_list'  => $order_list,
            'can_tixian'      =>  $can_tixian,
            'frozen_amount'   =>  order_tutor_rebates_class::get_seller_rebate_amount($this->seller_id),
            'status' => 1
        );
        
        echo json_encode($result);
    }

    //聊天室列表
    public function seller_chat_list(){
        $page   = IReq::get('page') ? IFilter::act(IReq::get('page'),'int') : 1;

        $chat_db = new IQuery('chat');
        $chat_db->page = $page;
        $chat_db->pagesize = 10;
        $chat_db->order = 'id DESC';
        $chat_db->where = 'seller_id = '.$this->seller_id;
        $list = $chat_db->find();
        $seller_db = new IModel('seller');
        foreach( $list as $v ){
            $tmp = $seller_db->getObj('id='.$v['seller_id'],'seller_name');
            $v['seller_name'] = $tmp['seller_name'];
            $v['create_time'] = $v['create_time'] > 0?date('Y-m-d H:i:s',$v['create_time']):'';
            $result['chat'][] = $v;
        }

        if($result['chat']){
            $result['num'] = count($result['chat']);
            $result['page'] = $page + 1;
        }
       
        echo json_encode($result);
    }

    public function seller_chat_edit(){
        $name = IFilter::act(IReq::get("name"),'text');
        $image = IFilter::act(IReq::get("image"));
        if(!$name){
            echo json_encode(array('info'=>'请输入聊天室名称！','status'=>0));
            return;
        }
        if(!$image){
            echo json_encode(array('info'=>'请上传列表展示图！','status'=>0));
            return;
        }

        $chat_db = new IModel('chat');
        $chat_db->setData(array(
            'name' => $name,
            'image' => $image,
            'seller_id' => $this->seller_id,
            'create_time' => time()
        ));
        $chat_db->add();

        echo json_encode(array('info'=>'添加成功！','status'=>1));
    }


    //前台聊天室列表
    public function chat_list(){
        $page   = IReq::get('page') ? IFilter::act(IReq::get('page'),'int') : 1;

        $chat_db = new IQuery('chat');
        $chat_db->page = $page;
        $chat_db->pagesize = 10;
        $chat_db->order = 'id DESC';
        $list = $chat_db->find();
        $seller_db = new IModel('seller');
        foreach( $list as $v ){
            $tmp = $seller_db->getObj('id='.$v['seller_id'],'seller_name');
            $v['seller_name'] = $tmp['seller_name'];
            $v['create_time'] = $v['create_time'] > 0?date('Y-m-d H:i:s',$v['create_time']):'';
            $result['chat'][] = $v;
        }

        if($result['chat']){
            $result['num'] = count($result['chat']);
            $result['page'] = $page + 1;
        }
        
        echo json_encode($result);
    }

    public function get_user_info(){
        $uid       = IFilter::act(IReq::get("uid"),'int');
        $num       = IFilter::act(IReq::get("num"),'int');

        $real_value = $num;

        if(!$uid || !$num){
            echo json_encode(array('info'=>'错误！','status'=>0));
            return;
        }

        $member = member_class::get_member_info($uid);

        if(!$member){
            echo json_encode(array('info'=>'帐号不存在！','status'=>0));
            return false;
        }

        $plugin_db = new IModel('plugin');
        $plugin_info = $plugin_db->getObj('class_name = "workerman"');

        if($plugin_info){
            $gift_config = json_decode($plugin_info['config_param'],true);
            if( $gift_config['rate'] > 0 ){
                $real_value = $real_value * $gift_config['rate'];
            }
        }

        if($member['balance'] < $real_value){
            echo json_encode(array('info'=>'帐号余额不足，请先充值！','status'=>-1));
            return false;
        }

        $balance = $member['balance'] - $real_value;

        $member_db = new IModel('member');
        $member_db->setData(array('balance'=>$balance));
        $member_db->update('user_id='.$uid);

        $seller = seller_class::get_seller_info($this->seller_id);

        $sale_balance = $seller['sale_balance'] + $real_value;
        $seller_db = new IModel('seller');
        $seller_db->setData(array('sale_balance'=>$sale_balance));
        $seller_db->update('id='.$this->seller_id);

        echo json_encode(array('info'=>'打赏成功','status'=>1));
    }

    public function seller_chat_del(){
        $id       = IFilter::act(IReq::get("id"),'int');

        if( !$id ){
            echo json_encode(array('info'=>'ID错误！','status'=>0));
            return false;
        }

        $chat_db = new IModel('chat');
        $chat_db->del('id='.$id);
            
        echo json_encode(array('info'=>'删除成功！','status'=>1));       
    }

    
    public function gift_list(){
        $gift_db = new IQuery('chat_gift');
        $gift_db->order = 'sort DESC';
        $gift_list = $gift_db->find();

        $plugin_db = new IModel('plugin');
        $plugin_info = $plugin_db->getObj('class_name = "workerman"');

        if($plugin_info){
            $gift_config = json_decode($plugin_info['config_param'],true);
        }
        
        $result = array(
            'gift_list' => $gift_list,
            'unit' => $gift_config['unit']
        );
        
        echo json_encode(array('info'=>$result,'status'=>1)); 
    }


    public function goods_edit2()
    {
        
        $seller_info = Seller_class::get_seller_info($this->seller_id);

        $brandModel = new IModel('brand');
        $brand = $brandModel->getObj("id = ".$seller_info['brand_id']);

        //初始化数据

        $goods_class = new goods_class($this->seller['seller_id']);

        if($brand['shop_desc_img']){
            $brand['school_intro_img'] = explode(',',$brand['shop_desc_img']);
        }
        if($brand['img']){
            $brand['school_img'] = explode(',',$brand['img']);
        }

        $goods_list = goods_class::get_goods_list_by_seller_id($this->seller_id);
        $teacher_list = teacher_class::get_goods_list_by_seller_id($this->seller_id);

        $result = array(
            'goods_list' => $goods_list,
            'brand' => $brand,
            'teacher_list' => $teacher_list,
            'content' => $seller_info['content'],
        );

        echo json_encode(array('info'=>$result,'status'=>1));
    }


    // 修改教师资料
    function teacher_edit2()
    {
        $id = IFilter::act(IReq::get('id'),'int');
        $seller_info = seller_class::get_seller_info($this->seller_id);
        $brand_info = brand_class::get_brand_info($seller_info['brand_id']);
        if ( $brand_info['category_ids'] == 16 )
        {
            $teacher_db = new IQuery('teacher');
            $teacher_db->where = 'seller_id = ' . $this->seller_id;
            $info = $teacher_db->getOne();
            if ( $info )
                $id = $info['id'];
        }
        if ( $id )
        {
            $teacher_info = Teacher_class::get_teacher_info( $id );
            $teacher_info['birth_date'] = ( $teacher_info['birth_date'] ) ? date('Y-m-d', $teacher_info['birth_date'] ) : '';
            $result['teacher_info'] = $teacher_info;
        }
        
        $result['seller_info'] = $seller_info;
        $result['brand_info'] = $brand_info;

        // dump($result);
        echo json_encode(array('info'=>$result,'status'=>1));
    }

    public function goods_edit3()
    { 
        $seller_info = Seller_class::get_seller_info($this->seller_id);
        $goods_id = IFilter::act(IReq::get('id'),'int');

        $sellerModel = new IModel('seller');
        $brandModel = new IModel('brand');
        $seller = $sellerModel->getObj("id = '$this->seller_id'", 'brand_id');
        $brand = $brandModel->getObj("id = '$seller[brand_id]'");

        //初始化数据

        $goods_class = new goods_class($this->seller_id);

        
        //获取所有商品扩展相关数据

        $data = $goods_class->edit($goods_id);


        $jsoncat = array();
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

        $model_id = 1;
        $tb_attribute = new IModel('attribute');
        $attribute_info = $tb_attribute->query('model_id='.$model_id);
        $attribute = JSON::encode($attribute_info);
        

        $result = array(
            'data' => $data,
            'category' => $jsoncat,
            'attribute' => $attribute,
            'catname' => implode(',', $catname),
            'status' => 1
        );        
        // dump($result);
        echo json_encode($result);
        return;
    }


    //商品删除
    public function goods_del()
    {
        //post数据
        $id = IFilter::act(IReq::get('id'),'int');

        //生成goods对象
        $goods = new goods_class();
        $goods->seller_id = $this->seller_id;

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
        echo json_encode(array('info'=>'删除成功！','status'=>1));
    }

    public function get_course_list()
    {
        //post数据
        $room_id = IFilter::act(IReq::get('room_id'),'int');

        $chat = new IQuery('chat_images');
        $chat->where = 'room_id='.$room_id;
        $chat->order = 'id ASC';
        $list = $chat->find();

        if($list){
            echo json_encode(array('info'=>$list,'status'=>1));
        }
        
    }

}


?>