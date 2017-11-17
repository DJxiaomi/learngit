<?php
/**
 * @class Brand
 * @brief 品牌模块
 * @note  后台
 */
class Brand extends IController implements adminAuthorization
{
	public $checkRight  = 'all';
    public $layout='admin';
	private $data = array();

	function init()
	{

	}

	/**
	 * @brief 品牌分类添加、修改
	 */
	function category_edit()
	{
		$category_id = (int)IReq::get('cid');
		//编辑品牌分类 读取品牌分类信息
		if($category_id)
		{
			$obj_brand_category = new IModel('brand_category');
			$category_info = $obj_brand_category->getObj('id='.$category_id);

			if($category_info)
			{
				$this->catRow = $category_info;
			}
			else
			{
				$this->redirect('category_list');
				Util::showMessage("没有找到相关品牌分类！");
				return;
			}
		}
		$this->redirect('category_edit');
	}


	/**
	 * @brief 品牌分类添加、修改
	 */
	function category_edit_1()
	{
		$category_id = (int)IReq::get('cid');

		//编辑品牌分类 读取品牌分类信息
		if($category_id)
		{
			$obj_brand_category = new IModel('brand_category');
			$category_info = $obj_brand_category->getObj('id='.$category_id);
			
			if($category_info)
			{
				$this->catRow = $category_info;
			}
			else
			{
				$this->redirect('category_list_1');
				Util::showMessage("没有找到相关品牌分类！");
				return;
			}
		}

		$brand_category = new IQuery('brand_category');
		$info = $brand_category->find();

		$this->setRenderData(array(
			'list' => $info
		));

		$this->redirect('category_edit_1');
	}

	/**
	 * @brief 保存品牌分类
	 */
	function category_save()
	{
		$id                = IFilter::act(IReq::get('id'),'int');
		$goods_category_id = IFilter::act(IReq::get('goods_category_id'),'int');
		$name              = IFilter::act(IReq::get('name'));

		$category_info = array(
			'name' => $name,
			'goods_category_id' => $goods_category_id
		);
		$tb_brand_category = new IModel('brand_category');
		$tb_brand_category->setData($category_info);

		//更新品牌分类
		if($id)
		{
			$where = "id=".$id;
			$tb_brand_category->update($where);
		}
		//添加品牌分类
		else
		{
			$tb_brand_category->add();
		}
		$this->redirect('category_list');
	}


	/**
	 * @brief 保存品牌分类
	 */
	function category_save_1()
	{
		$id  = IFilter::act(IReq::get('id'),'int');
		$pid = IFilter::act(IReq::get('pid'),'int');
		$name = IFilter::act(IReq::get('name'));

		$category_info = array(
			'name' => $name,
			'pid' => $pid
		);
		$tb_brand_category = new IModel('brand_category');
		$tb_brand_category->setData($category_info);

		//更新品牌分类
		if($id)
		{
			$where = "id=".$id;
			$tb_brand_category->update($where);
		}
		//添加品牌分类
		else
		{
			$tb_brand_category->add();
		}
		$this->redirect('category_list_1');
	}

	/**
	 * @brief 删除品牌分类
	 */
	function category_del()
	{
		$category_id = (int)IReq::get('cid');
		if($category_id)
		{
			$brand_category = new IModel('brand_category');
			$where = "id=".$category_id;
			if($brand_category->del($where))
			{
				$this->redirect('category_list');
			}
			else
			{
				$this->redirect('category_list');
				$msg = "没有找到相关分类记录！";
				Util::showMessage($msg);
			}
		}
		else
		{
			$this->redirect('category_list');
			$msg = "没有找到相关分类记录！";
			Util::showMessage($msg);
		}
	}
	
	function brand_chit()
	{
	    $page = max( intval($_GET['page']), 1 );
	    $bid = IFilter::act(IReq::get('bid'));
	    $where = "brand_id = '$bid' and category = 2";
	
	    $page_size = 15;
	    $brand_db = new IModel('brand');
	    $brand_chit_db = new IQuery('brand_chit');
	    $brand_chit_db->where = "$where";
	    $brand_chit_db->order = 'id desc';
	    $brand_chit_db->page = $page;
	    $brand_chit_db->pagesize = $page_size;
	    $brand_chit_list = $brand_chit_db->find();
	    $page_info = $brand_chit_db->getPageBar();
	    foreach($brand_chit_list AS $idx => $chit)
	    {
	        $brand = $brand_db->getObj("id = '$chit[brand_id]'", 'name');
	        $brand_chit_list[$idx]['seller_name'] = $brand['name'];
	    }

	    $this->setRenderData(array(
	        'where'         =>  $where,
	        'brand_chit_list'   =>  $brand_chit_list,
	        'brand_id'         =>  $bid,
	        'page_info'     =>  $page_info,
	    ));
	    $this->redirect('brand_chit');
	}
	
	function brand_chit_edit2()
	{
	    $brand_id = (int)IReq::get('brand_id');
	    $id = (int)IReq::get('id');
	    $brand_chit_db2 = new IModel('brand_chit');
	    $page = IFilter::act(IReq::get('page'),'int');
	    $page = max($page,1);
	    
	    //编辑品牌 读取品牌信息
	    if($id)
	    {
	        $chit2 = $brand_chit_db2->getObj('id='.$id);
	        $this->setRenderData(array('isedit' => 1));
	    }
	    else
	    {
	        $chit2['brand_id'] = $brand_id;
	    }
	
	    $this->setRenderData(array('chit2' => $chit2,'page' => $page));
	    $this->redirect('brand_chit_edit2',false);
	}
	
	function brand_chit_edit3()
	{
	    $brand_id = (int)IReq::get('brand_id');
	    $id = (int)IReq::get('id');
	    $brand_chit_db2 = new IModel('brand_chit');
	    $page = IFilter::act(IReq::get('page'),'int');
	    $page = max($page,1);
	     
	    //编辑品牌 读取品牌信息
	    if($id)
	    {
	        $chit2 = $brand_chit_db2->getObj('id='.$id);
	        $this->setRenderData(array('isedit' => 1));
	    }
	    else
	    {
	        $chit2['brand_id'] = $brand_id;
	    }
	
	    $this->setRenderData(array('chit2' => $chit2,'page' => $page));
	    $this->redirect('brand_chit_edit3',false);
	}
	
	function brand_chit_save2()
	{
	    $brand_id = (int)IReq::get('brand_id');
	    $id = (int)IReq::get('id');
	    $brand_chit_db2 = new IModel('brand_chit');
	    $seller_db = new IModel('seller');
	    $seller = $seller_db->getObj("brand_id = '$brand_id'", 'id');
	    $page = IFilter::act(IReq::get('page'),'int');
	    $page = max($page,1);
	    
	    if(isset($_FILES['logo']['name']) && $_FILES['logo']['name']!='')
	    {
	        $uploadObj = new PhotoUpload();
	        $uploadObj->setIterance(false);
	        $photoInfo = $uploadObj->run();
	        if(isset($photoInfo['logo']['img']) && file_exists($photoInfo['logo']['img']))
	        {
	            $logo = $photoInfo['logo']['img'];
	        }
	    } else {
	        $logo = IFilter::act(IReq::get('logo2'));
	    }
	
	    $name = IFilter::act(IReq::get('name'));
	    $max_price = IFilter::act(IReq::get('max_price'));
	    $tc_price = IFilter::act(IReq::get('tc_price'));
	    $max_order_chit = IFilter::act(IReq::get('max_order_chit'));
	    $limittime = strtotime(IFilter::act(IReq::get('limittime')));
	    $limitnum = IFilter::act(IReq::get('limitnum'));
	    $use_times = IFilter::act(IReq::get('use_times'));
	    $each_times = IFilter::act(IReq::get('each_times'));
	    $content = IFilter::act(IReq::get('content'),'text');
	    $limitinfo = IFilter::act(IReq::get('limitinfo'),'text');
	    $type = IFilter::act(IReq::get('type'));
	    $commission = IFilter::act(IReq::get('commission'));
	    $isedit = IFilter::act(IReq::get('isedit'));
	    $class_time = IFilter::act(IReq::get('class_time'));
	    $is_booking = IFilter::act(IReq::get('is_booking'),'int');
	    $is_intro = IFilter::act(IReq::get('is_intro'),'int');
	    $is_top = IFilter::act(IReq::get('is_top'),'int');
	    $is_del = IFilter::act(IReq::get('is_del'),'int');
	    $booking_desc = IFilter::act(IReq::get('booking_desc'));
	
	    $chit2 = array(
	        'brand_id'=>$brand_id,
	        'seller_id' => $seller['id'],
	        'limittime'=>$limittime,
	        'limitnum'=>$limitnum,
	        'limitinfo'=>$limitinfo,
	        'content'=>$content,
	        'commission' => $commission,
	        'name' => $name,
	        'max_price' => $max_price,
	        'max_order_chit'   =>  $max_order_chit,
	        'tc_price' =>  $tc_price,
	        'logo' => $logo,
	        'use_times' => $use_times,
	        'each_times' => max($each_times,1),
	        'category' => 2,
	        'class_time'   =>  $class_time,
	        'is_booking'   =>  $is_booking,
	        'is_intro'   =>  $is_intro,
	        'is_top'   =>  $is_top,
	        'is_del'   =>  $is_del,
	        'booking_desc' =>  $booking_desc,
	    );
	    if(!$isedit)
	    {
	        $chit2['type'] = $type;
	    }
	
	
	    $brand_chit_db2->setData($chit2);
	    if($id)
	    {
	        $brand_chit_db2->update("id = '$id'");
	    }
	    else
	    {
	        $brand_chit_db2->add();
	    }
	
	    $this->redirect('/market/brand_chit_list2?page=' . $page);
	}
	
	function brand_chit_save3()
	{
	    $brand_id = (int)IReq::get('brand_id');
	    $id = (int)IReq::get('id');
	    $brand_chit_db2 = new IModel('brand_chit');
	    $seller_db = new IModel('seller');
	    $page = IFilter::act(IReq::get('page'),'int');
	    $page = max($page,1);
	     
	    if(isset($_FILES['logo']['name']) && $_FILES['logo']['name']!='')
	    {
	        $uploadObj = new PhotoUpload();
	        $uploadObj->setIterance(false);
	        $photoInfo = $uploadObj->run();
	        if(isset($photoInfo['logo']['img']) && file_exists($photoInfo['logo']['img']))
	        {
	            $logo = $photoInfo['logo']['img'];
	        }
	    } else {
	        $logo = IFilter::act(IReq::get('logo2'));
	    }
	
	    $name = IFilter::act(IReq::get('name'));
	    $seller_id = IFilter::act(IReq::get('seller_id'),'int');
	    $max_price = IFilter::act(IReq::get('max_price'));
	    $tc_price = IFilter::act(IReq::get('tc_price'));
	    $max_order_chit = IFilter::act(IReq::get('max_order_chit'));
	    $limittime = strtotime(IFilter::act(IReq::get('limittime')));
	    $limitnum = IFilter::act(IReq::get('limitnum'));
	    $use_times = IFilter::act(IReq::get('use_times'));
	    $each_times = IFilter::act(IReq::get('each_times'));
	    $content = IFilter::act(IReq::get('content'),'text');
	    $limitinfo = IFilter::act(IReq::get('limitinfo'),'text');
	    $type = IFilter::act(IReq::get('type'));
	    $commission = IFilter::act(IReq::get('commission'));
	    $isedit = IFilter::act(IReq::get('isedit'));
	    $class_time = IFilter::act(IReq::get('class_time'));
	    $is_booking = IFilter::act(IReq::get('is_booking'),'int');
	    $is_intro = IFilter::act(IReq::get('is_intro'),'int');
	    $is_top = IFilter::act(IReq::get('is_top'),'int');
	    $is_del = IFilter::act(IReq::get('is_del'),'int');
	    $booking_desc = IFilter::act(IReq::get('booking_desc'));
	
	    $chit2 = array(
	        'brand_id'=>$brand_id,
	        'seller_id' => $seller_id,
	        'limittime'=>$limittime,
	        'limitnum'=>$limitnum,
	        'limitinfo'=>$limitinfo,
	        'content'=>$content,
	        'commission' => $commission,
	        'name' => $name,
	        'max_price' => $max_price,
	        'max_order_chit'   =>  $max_order_chit,
	        'tc_price' =>  $tc_price,
	        'logo' => $logo,
	        'use_times' => $use_times,
	        'each_times' => max($each_times,1),
	        'category' => 3,
	        'class_time'   =>  $class_time,
	        'is_booking'   =>  $is_booking,
	        'is_intro'   =>  $is_intro,
	        'is_top'   =>  $is_top,
	        'is_del'   =>  $is_del,
	        'booking_desc' =>  $booking_desc,
	        'type'     =>  1,
	    );
	
	    $brand_chit_db2->setData($chit2);
	    if($id)
	    {
	        $brand_chit_db2->update("id = '$id'");
	    }
	    else
	    {
	        $brand_chit_db2->add();
	    }
	
	    $this->redirect('/market/brand_chit_list3?page=' . $page);
	}

	/**
	 * @brief 修改品牌
	 */
	function brand_edit()
	{
		$brand_id = (int)IReq::get('bid');
		//编辑品牌 读取品牌信息
		if($brand_id)
		{
			$obj_brand = new IModel('brand');
			$brand_info = $obj_brand->getObj('id='.$brand_id);
			if($brand_info)
			{
				$brand_info['img'] = explode(',',$brand_info['img']);
				$brand_info['class_desc_img'] = explode(',',$brand_info['class_desc_img']);
				$brand_info['shop_desc_img'] = explode(',',$brand_info['shop_desc_img']);
				$brand_info['certificate_of_authorization'] = explode(',',$brand_info['certificate_of_authorization']);
				$this->data['brand'] = $brand_info;
			}
			else
			{
				$this->redirect('category_list');
				Util::showMessage("没有找到相关品牌分类！");
				return;
			}
		}

		$this->setRenderData($this->data);
		$this->redirect('brand_edit',false);
	}

	/**
	 * @brief 保存品牌
	 */
	function brand_save()
	{
		$brand_id = IFilter::act(IReq::get('brand_id'),'int');
		$username = IFilter::act(IReq::get('username'));
		$name = IFilter::act(IReq::get('name'));
		$shortname = IFilter::act(IReq::get('shortname'));
		$brief = IFilter::act(IReq::get('brief'));
		$sort = IFilter::act(IReq::get('sort'),'int');
		$url = IFilter::act(IReq::get('url'));
		$category = IFilter::act(IReq::get('category'),'int');
		$description = IFilter::act(IReq::get('description'));

		$tb_brand = new IModel('brand');
		$brand = array(
			'name'=>$name,
		    'shortname'   =>  $shortname,
		    'brief'   =>  $brief,
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
		
		$sellerData = array(
		    'true_name'=>$name,
		    'shortname'   =>  $shortname,
		    'home_url'=>$url,
		    'logo' => $_POST['logo'],
		    'pc_logo' => $_POST['pc_logo'],
		    'sort'=>$sort,
		);
		/*if(isset($_FILES['logo']['name']) && $_FILES['logo']['name']!='')
		{
			$uploadObj = new PhotoUpload();
			$uploadObj->setIterance(false);
			$photoInfo = $uploadObj->run();
			if(isset($photoInfo['logo']['img']) && file_exists($photoInfo['logo']['img']))
			{
				$brand['logo'] = $photoInfo['logo']['img'];
			}
		}
		if(isset($_FILES['pc_logo']['name']) && $_FILES['pc_logo']['name']!='')
		{
			$uploadObj = new PhotoUpload();
			$uploadObj->setIterance(false);
			$photoInfo = $uploadObj->run();
			if(isset($photoInfo['pc_logo']['img']) && file_exists($photoInfo['pc_logo']['img']))
			{
				$brand['pc_logo'] = $photoInfo['pc_logo']['img'];
			}
		}*/

		$uploadButton = array(
			'logo' => $_POST['logo'],
			'pc_logo' => $_POST['pc_logo'],
			'img' => $_POST['img'],
			'class_desc_img' => isset($_POST['class_desc_img'])?$_POST['class_desc_img']:'',
			'shop_desc_img' => isset($_POST['shop_desc_img'])?$_POST['shop_desc_img']:'',
		    'certificate_of_authorization' => isset($_POST['certificate_of_authorization'])?$_POST['certificate_of_authorization']:'',
		);

		// dump($uploadButton);

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

							/*$photo_db = new IModel('goods_photo');
							$pData = array(
								'id' => md5($filename),
								'img' => $filename
							);
							$photo_db->setData($pData);
							$photo_db->add();*/
						}
					}else{
						$_img[] = $v;
					}
					/*if($k == 0){
						$_POST['img'] = $filename?$filename:$v;
					}*/				
				}
				$brand[$key] = implode(',',$_img);
			}
		}
		
		if ( !$brand_id )
		{
		    $brand['username'] = $username;
		    $sellerData['seller_name'] = $username;
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
			$brand_id = $tb_brand->add();
		}
		
		if ( $brand_id )
		{
		    $sellerData['brand_id'] = $brand_id;
		    $seller_info = seller_class::get_seller_info_by_bid($brand_id);
		    $seller_db = new IModel('seller');
		    $seller_db->setData($sellerData);
		    if ($seller_info)
		    {
		        $seller_db->update('id = ' . $seller_info['id']);
		    } else {
		        $seller_db->add();
		    }
		}
		
		$this->brand_list();
	}

	/**
	 * @brief 删除品牌
	 */
	function brand_del()
	{
		$brand_id = (int)IReq::get('bid');
		if($brand_id)
		{
			$tb_brand = new IModel('brand');
			$where = "id=".$brand_id;
			if($tb_brand->del($where))
			{
				$this->brand_list();
			}
			else
			{
				$this->brand_list();
				$msg = "没有找到相关分类记录！";
				Util::showMessage($msg);
			}
		}
		else
		{
			$this->brand_list();
			$msg = "没有找到相关品牌记录！";
			Util::showMessage($msg);
		}
	}

	/**
	 * @brief 品牌列表
	 */
	function brand_list()
	{
	    $page = IFilter::act(IReq::get('page'),'int');
	    $page = max($page,1);
	    
	    $this->setRenderData(array('page' => $page));
		$this->redirect('brand_list');
	}
	
	function brand_chit_edit()
	{
		$brand_id = (int)IReq::get('brand_id');
		$id = (int)IReq::get('id');
		$brand_chit_db = new IModel('brand_chit');
		//编辑品牌 读取品牌信息
		if($id)
		{
			$chit = $brand_chit_db->getObj('id='.$id);
			$this->setRenderData(array('isedit' => 1));
		}
		else
		{
			$chit['brand_id'] = $brand_id;
		}

		$this->setRenderData(array('chit' => $chit));
		$this->redirect('brand_chit_edit',false);
	}
	
	function brand_chit_save()
	{
		$brand_id = (int)IReq::get('brand_id');
		$id = (int)IReq::get('id');
		$brand_chit_db = new IModel('brand_chit');
		$seller_db = new IModel('seller');
		$seller = $seller_db->getObj("brand_id = '$brand_id'", 'id');

		$max_price = IFilter::act(IReq::get('max_price'));
		$max_order_chit = IFilter::act(IReq::get('max_order_chit'));
		$max_order_amount = IFilter::act(IReq::get('max_order_amount'));
		$limittime = strtotime(IFilter::act(IReq::get('limittime')));
		$limitnum = IFilter::act(IReq::get('limitnum'));
		$content = IFilter::act(IReq::get('content'));
		$limitinfo = IFilter::act(IReq::get('limitinfo'));
		$type = IFilter::act(IReq::get('type'));
		$commission = IFilter::act(IReq::get('commission'));
		$isedit = IFilter::act(IReq::get('isedit'));
		
		$chit = array(
			'brand_id'=>$brand_id,
			'seller_id' => $seller['id'],
			'limittime'=>$limittime,
			'limitnum'=>$limitnum,
			'limitinfo'=>$limitinfo,
			'content'=>$content,
			'commission' => $commission
		);
		if(!$isedit)
		{
			$chit['type'] = $type;
			$chit['max_price'] = $max_price;
			$chit['max_order_chit'] = $max_order_chit;
			$chit['max_order_amount'] = $max_order_amount;
		}


		$brand_chit_db->setData($chit);
		if($id)
		{
			$brand_chit_db->update("id = '$id'");
		}
		else
		{
			$brand_chit_db->add();
		}

		$this->redirect('/market/brand_chit_list');
	}
}