<?php
/**
 * @brief 营销模块
 * @class Market
 * @note  后台
 */
class Market extends IController implements adminAuthorization
{
	public $checkRight  = 'all';
	public $layout = 'admin';

	function init()
	{

	}

	//修改代金券状态is_close和is_send
	function ticket_status()
	{
		$status    = IFilter::act(IReq::get('status'));
		$id        = IFilter::act(IReq::get('id'),'int');
		$ticket_id = IFilter::act(IReq::get('ticket_id'));

		if(!empty($id) && $status != null && $ticket_id != null)
		{
			$ticketObj = new IModel('prop');
			if(is_array($id))
			{
				foreach($id as $val)
				{
					$where = 'id = '.$val;
					$ticketRow = $ticketObj->getObj($where,$status);
					if($ticketRow[$status]==1)
					{
						$ticketObj->setData(array($status => 0));
					}
					else
					{
						$ticketObj->setData(array($status => 1));
					}
					$ticketObj->update($where);
				}
			}
			else
			{
				$where = 'id = '.$id;
				$ticketRow = $ticketObj->getObj($where,$status);
				if($ticketRow[$status]==1)
				{
					$ticketObj->setData(array($status => 0));
				}
				else
				{
					$ticketObj->setData(array($status => 1));
				}
				$ticketObj->update($where);
			}
			$this->redirect('ticket_more_list/ticket_id/'.$ticket_id);
		}
		else
		{
			$this->ticket_id = $ticket_id;
			$this->redirect('ticket_more_list',false);
			Util::showMessage('请选择要修改的id值');
		}
	}

	//[代金券]添加,修改[单页]
	function ticket_edit()
	{
		$id = IFilter::act(IReq::get('id'),'int');
		if($id)
		{
			$ticketObj       = new IModel('ticket');
			$where           = 'id = '.$id;
			$this->ticketRow = $ticketObj->getObj($where);
		}
		$this->redirect('ticket_edit');
	}

	//[代金券]添加,修改[动作]
	function ticket_edit_act()
	{
		$id        = IFilter::act(IReq::get('id'),'int');
		$ticketObj = new IModel('ticket');

		$dataArray = array(
			'name'      => IFilter::act(IReq::get('name','post')),
			'value'     => IFilter::act(IReq::get('value','post')),
			'start_time'=> IFilter::act(IReq::get('start_time','post')),
			'end_time'  => IFilter::act(IReq::get('end_time','post')),
			'point'     => IFilter::act(IReq::get('point','post')),
		);

		$ticketObj->setData($dataArray);
		if($id)
		{
			$where = 'id = '.$id;
			$ticketObj->update($where);
		}
		else
		{
			$ticketObj->add();
		}
		$this->redirect('ticket_list');
	}

	//[代金券]生成[动作]
	function ticket_create()
	{
		$propObj   = new IModel('prop');
		$prop_num  = intval(IReq::get('num'));
		$ticket_id = intval(IReq::get('ticket_id'));

		if($prop_num && $ticket_id)
		{
			$prop_num  = ($prop_num > 5000) ? 5000 : $prop_num;
			$ticketObj = new IModel('ticket');
			$where     = 'id = '.$ticket_id;
			$ticketRow = $ticketObj->getObj($where);

			for($item = 0; $item < intval($prop_num); $item++)
			{
				$dataArray = array(
					'condition' => $ticket_id,
					'name'      => $ticketRow['name'],
					'card_name' => 'T'.IHash::random(8),
					'card_pwd'  => IHash::random(8),
					'value'     => $ticketRow['value'],
					'start_time'=> $ticketRow['start_time'],
					'end_time'  => $ticketRow['end_time'],
				);

				//判断code码唯一性
				$where = 'card_name = \''.$dataArray['card_name'].'\'';
				$isSet = $propObj->getObj($where);
				if(!empty($isSet))
				{
					$item--;
					continue;
				}
				$propObj->setData($dataArray);
				$propObj->add();
			}
			$logObj = new Log('db');
			$logObj->write('operation',array("管理员:".$this->admin['admin_name'],"生成了代金券","面值：".$ticketRow['value']."元，数量：".$prop_num."张"));
		}
		$this->redirect('ticket_list');
	}

	//[代金券]删除
	function ticket_del()
	{
		$id = IFilter::act(IReq::get('id'),'int');
		if(!empty($id))
		{
			$ticketObj = new IModel('ticket');
			$propObj   = new IModel('prop');
			$propRow   = $propObj->getObj(" `type` = 0 and `condition` = {$id} and (is_close = 2 or (is_userd = 0 and is_send = 1)) ");

			if($propRow)
			{
				$this->redirect('ticket_list',false);
				Util::showMessage('无法删除代金券，其下还有正在使用的代金券');
				exit;
			}

			$where = "id = {$id} ";
			$ticketRow = $ticketObj->getObj($where);
			if($ticketObj->del($where))
			{
				$where = " `type` = 0 and `condition` = {$id} ";
				$propObj->del($where);

				$logObj = new Log('db');
				$logObj->write('operation',array("管理员:".$this->admin['admin_name'],"删除了一种代金券","代金券名称：".$ticketRow['name']));
			}
			$this->redirect('ticket_list');
		}
		else
		{
			$this->redirect('ticket_list',false);
			Util::showMessage('请选择要删除的id值');
		}
	}

	//[代金券详细]删除
	function ticket_more_del()
	{
		$id        = IFilter::act(IReq::get('id'),'int');
		$ticket_id = IFilter::act(IReq::get('ticket_id'),'int');
		if($id)
		{
			$ticketObj = new IModel('ticket');
			$ticketRow = $ticketObj->getObj('id = '.$ticket_id);
			$logObj    = new Log('db');
			$propObj   = new IModel('prop');
			if(is_array($id))
			{
				$idStr = join(',',$id);
				$where = ' id in ('.$idStr.')';
				$logObj->write('operation',array("管理员:".$this->admin['admin_name'],"批量删除了实体代金券","代金券名称：".$ticketRow['name']."，数量：".count($id)));
			}
			else
			{
				$where = 'id = '.$id;
				$logObj->write('operation',array("管理员:".$this->admin['admin_name'],"删除了1张实体代金券","代金券名称：".$ticketRow['name']));
			}
			$propObj->del($where);
			$this->redirect('ticket_more_list/ticket_id/'.$ticket_id);
		}
		else
		{
			$this->ticket_id = $ticket_id;
			$this->redirect('ticket_more_list',false);
			Util::showMessage('请选择要删除的id值');
		}
	}

	//[代金券详细] 列表
	function ticket_more_list()
	{
		$this->ticket_id = IFilter::act(IReq::get('ticket_id'),'int');
		$this->redirect('ticket_more_list');
	}

	//[代金券] 输出excel表格
	function ticket_excel()
	{
		//代金券excel表存放地址
		$ticket_id = IFilter::act(IReq::get('id'));

		if($ticket_id)
		{
			$propObj = new IModel('prop');
			$where   = 'type = 0';
			$ticket_id_array = is_array($ticket_id) ? $ticket_id : array($ticket_id);

			//当代金券数量没有时不允许备份excel
			foreach($ticket_id_array as $key => $tid)
			{
				if(statistics::getTicketCount($tid) == 0)
				{
					unset($ticket_id_array[$key]);
				}
			}

			if($ticket_id_array)
			{
				$id_num_str = join('","',$ticket_id_array);
			}
			else
			{
				$this->redirect('ticket_list',false);
				Util::showMessage('实体代金券数量为0张，无法备份');
				exit;
			}

			$where.= ' and `condition` in("'.$id_num_str.'")';
			$propList = $propObj->query($where,'*','`condition` asc',10000);

			$ticketFile = "ticket_".join("_",$ticket_id_array);
			$reportObj = new report($ticketFile);
			$reportObj->setTitle(array("名称","卡号","密码","面值","已被使用","是否关闭","是否发送","开始时间","结束时间"));
			foreach($propList as $key => $val)
			{
				$is_userd = ($val['is_userd']=='1') ? '是':'否';
				$is_close = ($val['is_close']=='1') ? '是':'否';
				$is_send  = ($val['is_send']=='1') ? '是':'否';

				$insertData = array(
					$val['name'],
					$val['card_name'],
					$val['card_pwd'],
					$val['value'].'元',
					$is_userd,
					$is_close,
					$is_send,
					$val['start_time'],
					$val['end_time'],
				);
				$reportObj->setData($insertData);
			}
			$reportObj->toDownload();
		}
		else
		{
			$this->redirect('ticket_list',false);
			Util::showMessage('请选择要操作的文件');
		}
	}

	//[代金券]获取代金券数据
	function getTicketList()
	{
		$ticketObj  = new IModel('ticket');
		$ticketList = $ticketObj->query();
		echo JSON::encode($ticketList);
	}

	//[促销活动] 添加修改 [单页]
	function pro_rule_edit()
	{
		$id = IFilter::act(IReq::get('id'),'int');
		if($id)
		{
			$promotionObj = new IModel('promotion');
			$where = 'id = '.$id;
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
		);

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
			$promotionObj->del($where);
			$this->redirect('pro_rule_list');
		}
		else
		{
			$this->redirect('pro_rule_list',false);
			Util::showMessage('请选择要删除的促销活动');
		}
	}

	//[限时抢购]添加,修改[单页]
	function pro_speed_edit()
	{
		$id = IFilter::act(IReq::get('id'),'int');
		if($id)
		{
			$promotionObj = new IModel('promotion');
			$where = 'id = '.$id;
			$promotionRow = $promotionObj->getObj($where);
			if(empty($promotionRow))
			{
				$this->redirect('pro_speed_list');
			}

			//促销商品
			$goodsObj = new IModel('goods');
			$goodsRow = $goodsObj->getObj('id = '.$promotionRow['condition'],'id,name,sell_price,img');
			if($goodsRow)
			{
				$result = array(
					'isError' => false,
					'data'    => $goodsRow,
				);
			}
			else
			{
				$result = array(
					'isError' => true,
					'message' => '关联商品被删除，请重新选择要抢购的商品',
				);
			}

			$promotionRow['goodsRow'] = JSON::encode($result);
			$this->promotionRow = $promotionRow;
		}
		$this->redirect('pro_speed_edit');
	}

	//[限时抢购]添加,修改[动作]
	function pro_speed_edit_act()
	{
		$id = IFilter::act(IReq::get('id'),'int');

		$condition   = IFilter::act(IReq::get('condition','post'));
		$award_value = IFilter::act(IReq::get('award_value','post'));
		$user_group  = IFilter::act(IReq::get('user_group','post'));

		if(is_string($user_group))
		{
			$user_group_str = $user_group;
		}
		else
		{
			$user_group_str = ",".join(',',$user_group).",";
		}

		$dataArray = array(
			'id'         => $id,
			'name'       => IFilter::act(IReq::get('name','post')),
			'condition'  => $condition,
			'award_value'=> $award_value,
			'is_close'   => IFilter::act(IReq::get('is_close','post')),
			'start_time' => IFilter::act(IReq::get('start_time','post')),
			'end_time'   => IFilter::act(IReq::get('end_time','post')),
			'intro'      => IFilter::act(IReq::get('intro','post')),
			'type'       => 1,
			'award_type' => 0,
			'user_group' => $user_group_str,
		);

		if(!$condition || !$award_value)
		{
			$this->promotionRow = $dataArray;
			$this->redirect('pro_speed_edit',false);
			Util::showMessage('请添加促销的商品，并为商品填写价格');
		}

		$proObj = new IModel('promotion');
		$proObj->setData($dataArray);
		if($id)
		{
			$where = 'id = '.$id;
			$proObj->update($where);
		}
		else
		{
			$proObj->add();
		}
		$this->redirect('pro_speed_list');
	}

	//[限时抢购]删除
	function pro_speed_del()
	{
		$id = IFilter::act(IReq::get('id'),'int');
		if(!empty($id))
		{
			$propObj = new IModel('promotion');
			if(is_array($id))
			{
				$idStr = join(',',$id);
				$where = ' id in ('.$idStr.')';
			}
			else
			{
				$where = 'id = '.$id;
			}
			$where .= ' and type = 1';
			$propObj->del($where);
			$this->redirect('pro_speed_list');
		}
		else
		{
			$this->redirect('pro_speed_list',false);
			Util::showMessage('请选择要删除的id值');
		}
	}

	//[团购]添加修改[单页]
	function regiment_edit()
	{
		$id = IFilter::act(IReq::get('id'),'int');

		if($id)
		{
			$regimentObj = new IModel('regiment');
			$where       = 'id = '.$id;
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
			'is_close'      => IFilter::act(IReq::get('is_close','post')),
			'intro'     	=> IFilter::act(IReq::get('intro','post')),
			'goods_id'      => $goodsId,
			'store_nums'    => IFilter::act(IReq::get('store_nums','post')),
			'limit_min_count' => IFilter::act(IReq::get('limit_min_count','post'),'int'),
			'limit_max_count' => IFilter::act(IReq::get('limit_max_count','post'),'int'),
			'regiment_price'=> IFilter::act(IReq::get('regiment_price','post')),
			'sort'          => IFilter::act(IReq::get('sort','post')),
		);

		$dataArray['limit_min_count'] = $dataArray['limit_min_count'] <= 0 ? 1 : $dataArray['limit_min_count'];
		$dataArray['limit_max_count'] = $dataArray['limit_max_count'] <= 0 ? $dataArray['store_nums'] : $dataArray['limit_max_count'];

		if($goodsId)
		{
			$goodsObj = new IModel('goods');
			$where    = 'id = '.$goodsId;
			$goodsRow = $goodsObj->getObj($where);

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
			$where = 'id = '.$id;
			$regimentObj->update($where);
		}
		else
		{
			$regimentObj->add();
		}
		$this->redirect('regiment_list');
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
			$where = ' id in ('.$id.')';
			$regObj->del($where);
			$this->redirect('regiment_list');
		}
		else
		{
			$this->redirect('regiment_list',false);
			Util::showMessage('请选择要删除的id值');
		}
	}

	//账户余额记录
	function account_list()
	{
		$page       = intval(IReq::get('page')) ? IReq::get('page') : 1;
		$event      = intval(IReq::get('event'));
		$startDate  = IFilter::act(IReq::get('startDate'));
		$endDate    = IFilter::act(IReq::get('endDate'));

		$where      = "event != 3";
		if($startDate)
		{
			$where .= " and time >= '{$startDate}' ";
		}

		if($endDate)
		{
			$temp   = $endDate.' 23:59:59';
			$where .= " and time <= '{$temp}' ";
		}

		if($event)
		{
			$where .= " and event = $event ";
		}

		$accountObj = new IQuery('account_log');
		$accountObj->where = $where;
		$accountObj->order = 'id desc';
		$accountObj->page  = $page;

		$this->accountObj  = $accountObj;
		$this->event       = $event;
		$this->startDate   = $startDate;
		$this->endDate     = $endDate;
		$this->accountList = $accountObj->find();

		$this->redirect('account_list');
	}

	//后台操作记录
	function operation_list()
	{
		$page       = intval(IReq::get('page')) ? IReq::get('page') : 1;
		$startDate  = IFilter::act(IReq::get('startDate'));
		$endDate    = IFilter::act(IReq::get('endDate'));

		$where      = "1";
		if($startDate)
		{
			$where .= " and datetime >= '{$startDate}' ";
		}

		if($endDate)
		{
			$temp   = $endDate.' 23:59:59';
			$where .= " and datetime <= '{$temp}' ";
		}

		$operationObj = new IQuery('log_operation');
		$operationObj->where = $where;
		$operationObj->order = 'id desc';
		$operationObj->page  = $page;

		$this->operationObj  = $operationObj;
		$this->startDate     = $startDate;
		$this->endDate       = $endDate;
		$this->operationList = $operationObj->find();

		$this->redirect('operation_list');
	}

	//清理后台管理员操作日志
	function clear_log()
	{
		$type  = IReq::get('type');
		$month = intval(IReq::get('month'));
		if(!$month)
		{
			die('请填写要清理日志的月份');
		}

		switch($type)
		{
			case "account":
			{
				$logObj = new IModel('account_log');
				$logObj->del("event = 1 and TIMESTAMPDIFF(MONTH,time,NOW()) >= '{$month}'");
				$this->redirect('account_list');
				break;
			}
			case "operation":
			{
				$logObj = new IModel('log_operation');
				$logObj->del("TIMESTAMPDIFF(MONTH,datetime,NOW()) >= '{$month}'");
				$this->redirect('operation_list');
				break;
			}
			default:
				die('缺少类别参数');
		}
	}

	//修改结算账单
	public function bill_edit()
	{
		$id = IFilter::act(IReq::get('id'),'int');
		$billDB = new IModel('bill');
		$this->billRow = $billDB->getObj('id = '.$id);
		$this->redirect('bill_edit');
	}

	//结算单修改
	public function bill_update()
	{
		$id = IFilter::act(IReq::get('id'),'int');
		$pay_content = IFilter::act(IReq::get('pay_content'));
		$is_pay = IFilter::act(IReq::get('is_pay'),'int');

		if($id)
		{
			$data = array(
				'admin_id' => $this->admin['admin_id'],
				'pay_content' => $pay_content,
				'is_pay' => $is_pay,
			);

			$billDB = new IModel('bill');

			$data['pay_time'] = ($is_pay == 1) ? ITime::getDateTime() : "";

			$billRow= $billDB->getObj('id = '.$id);
			if(isset($billRow['order_ids']) && $billRow['order_ids'])
			{
				//更新订单商品关系表中的结算字段
				$orderDB = new IModel('order');
				$orderIdArray = explode(',',$billRow['order_ids']);
				foreach($orderIdArray as $key => $val)
				{
					$orderDB->setData(array('is_checkout' => $is_pay));
					$orderDB->update('id = '.$val);
				}
			}

			$billDB->setData($data);
			$billDB->update('id = '.$id);
		}
		$this->redirect('bill_list');
	}

	//结算单删除
	public function bill_del()
	{
		$id = IFilter::act(IReq::get('id'),'int');

		if($id)
		{
			$billDB = new IModel('bill');
			$billDB->del('id = '.$id.' and is_pay = 0');
		}

		$this->redirect('bill_list');
	}

	//导出用户统计数据
	public function user_report()
	{
		$start = IFilter::act(IReq::get('start'));
		$end   = IFilter::act(IReq::get('end'));

		$memberQuery = new IQuery('member as m');
		$memberQuery->join   = "left join user as u on m.user_id=u.id";
		$memberQuery->fields = "u.username,m.time,m.email,m.mobile";
		$memberQuery->where  = "m.time between '".$start."' and '".$end." 23:59:59'";
		$memberList          = $memberQuery->find();

		$reportObj = new report('user');
		$reportObj->setTitle(array("日期","用户名","邮箱","手机号"));
		foreach($memberList as $k => $val)
		{
			$insertData = array($val['time'],$val['username'],$val['email'],$val['mobile']);
			$reportObj->setData($insertData);
		}
		$reportObj->toDownload();
	}

	//导出人均消费数据
	public function spanding_report()
	{
		$start = IFilter::act(IReq::get('start'));
		$end   = IFilter::act(IReq::get('end'));

		$reportObj = new report('spanding');
		$reportObj->setTitle(array("日期","人均消费金额"));

		$db = new IQuery('collection_doc');
		$db->fields   = "sum(amount)/count(*) as count,`time`,DATE_FORMAT(`time`,'%Y-%m-%d') as `timeData`";
		$db->where    = "pay_status = 1";
		$db->group    = "DATE_FORMAT(`time`,'%Y-%m-%d') having `time` >= '{$start}' and `time` < '{$end} 23:59:59'";
		$spandingList = $db->find();
		foreach($spandingList as $k => $val)
		{
			$insertData = array($val['timeData'],$val['count']);
			$reportObj->setData($insertData);
		}
		$reportObj->toDownload();
	}

	//导出销售数据
	public function amount_report()
	{
		$start = IFilter::act(IReq::get('start'));
		$end   = IFilter::act(IReq::get('end'));

		$reportObj = new report('amount');
		$reportObj->setTitle(array("完成订单日期","订单量","商品销售额","商品销售成本","商品销售毛利"));

		$orderDB   = new IModel('order');
		$orderList = $orderDB->query(" `completion_time` between '{$start}' and '{$end} 23:59:59' "," DATE_FORMAT(`completion_time`,'%Y-%m-%d') as ctime,id ","id asc");
		if($orderList)
		{
			//按照订单时间组合订单ID
			$ids = array();
			foreach($orderList as $key => $val)
			{
				if(!isset($ids[$val['ctime']]))
				{
					$ids[$val['ctime']] = array();
				}
				$ids[$val['ctime']][] = $val['id'];
			}

			//获取订单数据
			$db        = new IQuery('order_goods as og');
			$db->join  = "left join goods as go on go.id = og.goods_id left join products as p on p.id = og.product_id ";
			$db->fields= "og.*,go.cost_price as go_cost,p.cost_price as p_cost";
			$db->order = "og.order_id asc";
			$result    = array();
			foreach($ids as $ctime => $idArray)
			{
				$db->where = "og.order_id in (".join(',',$idArray).") and og.is_send = 1";
				$orderList = $db->find();

				$result[$ctime] = array("orderNum" => count($idArray),"goods_sum" => 0,"goods_cost" => 0,"goods_diff" => 0);
				foreach($orderList as $key => $val)
				{
					$result[$ctime]['goods_sum']  += $val['real_price'] * $val['goods_nums'];
					$cost                          = $val['p_cost'] ? $val['p_cost'] : $val['go_cost'];
					$result[$ctime]['goods_cost'] += $cost * $val['goods_nums'];
				}
				$result[$ctime]['goods_diff'] += $result[$ctime]['goods_sum'] - $result[$ctime]['goods_cost'];
			}

			foreach($result as $ctime => $val)
			{
				$insertData = array(
					$ctime,
					$val['orderNum'],
					$val['goods_sum'],
					$val['goods_cost'],
					$val['goods_diff'],
				);
				$reportObj->setData($insertData);
			}
		}
		$reportObj->toDownload();
	}

	//[特价商品]添加,修改[单页]
	function sale_edit()
	{
		$id = IFilter::act(IReq::get('id'),'int');
		if($id)
		{
			$promotionObj = new IModel('promotion');
			$where = 'id = '.$id.' and award_type = 7';
			$this->promotionRow = $promotionObj->getObj($where);
			if(!$this->promotionRow)
			{
				IError::show("信息不存在");
			}
		}
		$this->redirect('sale_edit');
	}

	//[特价商品]添加,修改[动作]
	function sale_edit_act()
	{
		$id           = IFilter::act(IReq::get('id'),'int');
		$award_value  = IFilter::act(IReq::get('award_value'),'int');
		$type         = IFilter::act(IReq::get('type'));
		$is_close     = IFilter::act(IReq::get('is_close','post'));
		$intro        = array();//商品ID => 促销金额(或者折扣率)

		$proObj = new IModel('promotion');
		if($id)
		{
			//获取旧数据和原始价格
			$proRow = $proObj->getObj("id = ".$id);
			if(!$proRow)
			{
				IError::show('特价活动不存在');
			}

			if($proRow['is_close'] == 0)
			{
				$tempUpdate = JSON::decode($proRow['intro']);
				if($tempUpdate)
				{
					foreach($tempUpdate as $gid => $g_discount)
					{
						goods_class::goodsDiscount($gid,$g_discount,"constant","add");
					}
				}
			}
		}

		switch($type)
		{
			case 2:
			{
				$category = IFilter::act(IReq::get('category'),'int');
				if(!$category)
				{
					IError::show(403,'商品分类信息没有设置');
				}
				$condition = join(",",$category);
				$goodsData = Api::run("getCategoryExtendList",array("#categroy_id#",$condition),500);
				foreach($goodsData as $key => $val)
				{
					$intro[$val['id']] = $val['sell_price'] - $val['sell_price']*$award_value/100;
				}
			}
			break;

			case 3:
			{
				$gid = IFilter::act(IReq::get('goods_id'),'int');
				if(!$gid)
				{
					IError::show(403,'商品信息没有设置');
				}
				$condition   = join(",",$gid);
				$goodsDB     = new IModel('goods');
				$goodsData   = $goodsDB->query('id in ('.$condition.')');
				$goods_price = IFilter::act(IReq::get('goods_price'),'float');

				foreach($goodsData as $key => $val)
				{
					if(isset( $goods_price[$val['id']] ))
					{
						$intro[$val['id']] = $val['sell_price'] - $goods_price[$val['id']];
					}
				}
			}
			break;

			case 4:
			{
				$condition = IFilter::act(IReq::get('brand_id'),'int');
				if(!$condition)
				{
					IError::show(403,'品牌信息没有设置');
				}
				$goodsDB   = new IModel('goods');
				$goodsData = $goodsDB->query("brand_id = ".$condition,"*","sort asc",500);
				foreach($goodsData as $key => $val)
				{
					$intro[$val['id']] = $val['sell_price'] - $val['sell_price']*$award_value/100;
				}
			}
			break;
		}

		if(!$intro)
		{
			IError::show(403,'商品信息不存在，请确定你选择的条件有商品');
		}

		//去掉重复促销的商品
		$proData = $proObj->query("award_type = 7 and id != ".$id);
		foreach($proData as $key => $val)
		{
			$temp  = JSON::decode($val['intro']);
			$intro = array_diff_key($intro,$temp);
		}

		if(!$intro)
		{
			IError::show(403,'商品不能重复设置特价');
		}

		$dataArray = array(
			'name'       => IFilter::act(IReq::get('name','post')),
			'condition'  => $condition,
			'award_value'=> $award_value,
			'is_close'   => $is_close,
			'start_time' => ITime::getDateTime(),
			'intro'      => JSON::encode($intro),
			'type'       => $type,
			'award_type' => 7,
			'sort'       => IFilter::act(IReq::get('sort'),'int'),
		);

		$proObj->setData($dataArray);
		if($id)
		{
			$where = 'id = '.$id;
			$proObj->update($where);
		}
		else
		{
			$proObj->add();
		}

		//开启
		if($is_close == 0)
		{
			$tempUpdate = $intro;
			if($tempUpdate)
			{
				foreach($tempUpdate as $gid => $g_discount)
				{
					goods_class::goodsDiscount($gid,$g_discount,"constant","reduce");
				}
			}
		}
		$this->redirect('sale_list');
	}

	//[特价商品]删除
	function sale_del()
	{
		$id = IFilter::act(IReq::get('id'),'int');
		if($id)
		{
			$proObj = new IModel('promotion');
			if(is_array($id))
			{
				$idStr = join(',',$id);
				$where = ' id in ('.$idStr.')';
			}
			else
			{
				$where = ' id = '.$id;
			}
			$where .= ' and award_type = 7 ';

			//恢复特价商品价格
			$proList = $proObj->query($where);
			foreach($proList as $key => $val)
			{
				if($val['is_close'] == 0)
				{
					$tempUpdate = JSON::decode($val['intro']);
					if($tempUpdate)
					{
						foreach($tempUpdate as $gid => $g_discount)
						{
							goods_class::goodsDiscount($gid,$g_discount,"constant","add");
						}
					}
				}
			}
			$proObj->del($where);
			$this->redirect('sale_list');
		}
		else
		{
			$this->redirect('sale_list',false);
			Util::showMessage('请选择要删除的id值');
		}
	}

	//商家销售报表明细导出
	function sellerReport()
	{
		$where  = util::search(IReq::get('search'));
		$billDB = new IQuery('bill as b');
		$billDB->join   = "left join seller as s on s.id = b.seller_id";
		$billDB->where  = $where;
		$billDB->fields = "b.*,s.email,s.true_name";
		$billDB->group  = "b.seller_id";
		$billData       = $billDB->find();

		$reportObj = new report('seller_bill');
		$reportObj->setTitle(array("收款人email","收款人姓名","付款金额（元）","付款理由"));
		if($billData)
		{
			foreach($billData as $key => $val)
			{
				$insertData = array(
					$val['email'],
					$val['true_name'],
					$val['amount'],
					$val['start_time']."至".$val['end_time']."货款",
				);
				$reportObj->setData($insertData);
			}
		}
		$reportObj->toDownload();
	}
	
	function brand_zuhe_list()
	{
	    $brand_chit_zuhe_db = new IQuery('brand_chit_zuhe');
	    $brand_chit_zuhe_db->where = '1 = 1 and is_system = 1';
	    $brand_chit_zuhe_list = $brand_chit_zuhe_db->find();
	
	    $this->setRenderData(array(
	        'brand_chit_zuhe_list'	=>	$brand_chit_zuhe_list,
	        //'page_info'			=>	$brand_chit_zuhe_db->getPageBar(),
	    ));
	
	    $this->redirect('brand_zuhe_list');
	}
	
	function brand_zuhe_edit()
	{
	    $id = IFilter::act(IReq::get('id'),'int');
	    $zuhe_db = new IQuery('brand_chit_zuhe');
	
	    if ( $id )
	    {
	        $zuhe_db->where = 'id = ' . $id;
	        $zuhe_info = $zuhe_db->getOne();
	        if ( !$zuhe_info )
	        {
	            IError::show(403,'参数不正确');
	            exit();
	        }
	        	
	        $zuhe_info['start_time'] = ($zuhe_info['start_time'] > 0 ) ? date('Y-m-d H:i:s', $zuhe_info['start_time']) : 0;
	        $zuhe_info['end_time'] = ($zuhe_info['end_time'] > 0 ) ? date('Y-m-d H:i:s', $zuhe_info['end_time']) : 0;
	        	
	        $zuhe_detail_db = new IQuery('brand_chit_zuhe_detail as d');
	        $zuhe_detail_db->join = 'left join brand_chit as c on d.brand_chit_id = c.id';
	        $zuhe_detail_db->fields = 'd.*,c.max_price,c.name,c.commission,c.use_times';
	        $zuhe_detail_db->where = 'zuhe_id = ' . $id;
	        $zuhe_detail_list = $zuhe_detail_db->find();
	        	
	        $detail_ids = array();
	        if ( $zuhe_detail_list )
	        {
	            foreach( $zuhe_detail_list as $kk => $vv )
	            {
	                $detail_ids[] = $vv['brand_chit_id'];
	            }
	        }
	        $zuhe_info['prop_id'] = implode(',', $detail_ids);
	        	
	        $this->setRenderData(array(
	            'zuhe_info' => $zuhe_info,
	            'zuhe_detail_list' => $zuhe_detail_list,
	        ));
	    } else {
	        $ids = IFilter::act(IReq::get('ids'));
	        if ( !$ids )
	        {
	            IError::show(403,'参数不正确,操作失败');
	        }
	        
	        $brand_chit_db = new IQuery('brand_chit');
	        $brand_chit_db->where = db_create_in(explode(',', $ids), 'id') . ' and category = 2';
	        $zuhe_detail_list = $brand_chit_db->find();
	        $this->setRenderData(array(
	            'zuhe_detail_list' =>  $zuhe_detail_list,
                'zuhe_info'         =>  array(
                    'prop_id'   =>  $ids,
                ),
	        ));
	    }
	
	    $this->redirect('brand_zuhe_edit');
	}
	
	function brand_zuhe_save()
	{
	    $name = IReq::get('name');
	    $start_time = IReq::get('start_time');
	    $end_time = IReq::get('end_time');
	    $price = IReq::get('price');
	    $prop_id = IReq::get('prop_id');
	
	    if ( !$prop_id )
	    {
	        IError::show(403,'代金券不能为空');
	        exit();
	    }
	
	    $prop_id = explode(',', $prop_id);
	    $content = IReq::get('content');
	    $zuhe_id = IReq::get('zuhe_id');
	
	    if ( $start_time )
	    {
	        $start_time = strtotime($start_time);
	    }
	    if ( $end_time )
	    {
	        $end_time = strtotime($end_time);
	    }
	
	    if ( !$name )
	    {
	        IError::show(403,'名称不能为空');
	        exit();
	    }
	
	    $chit_zuhe_db = new IModel('brand_chit_zuhe');
	    $data = array(
	        'name' => $name,
	        'price' => $price,
	        'start_time' => $start_time,
	        'end_time' => $end_time,
	        'content' => $content,
	        'is_system' => 1,
	    );
	    if ( $zuhe_id )
	    {
	        $chit_zuhe_db->setData($data);
	        $chit_zuhe_db->update('id = ' . $zuhe_id);
	        	
	        $brand_chit_zuhe_detail_db = new IModel('brand_chit_zuhe_detail');
	        $brand_chit_zuhe_detail_db->del('zuhe_id = ' . $zuhe_id);
	    } else {
	        $chit_zuhe_db->setData($data);
	        $zuhe_id = $chit_zuhe_db->add();
	    }
	
	    if ( !$zuhe_id )
	    {
	        IError::show(403,'添加组合失败');
	        exit();
	    }
	
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
	
	    $this->redirect('brand_zuhe_list');
	}
	
	function brand_zuhe_del()
	{
	    $id = IReq::get('id') + 0;
	    $zuhe_db = new IQuery('brand_chit_zuhe');
	    $zuhe_db->where = 'id = ' . $id;
	    $zuhe_info = $zuhe_db->getOne();
	    if ( !$zuhe_info )
	    {
	        IError::show(403,'组合信息不存在');
	        exit();
	    }
	
	    if ( !$zuhe_info['status'] )
	    {
	        IError::show(403,'该组合已下架，请勿重复操作');
	        exit();
	    }
	
	    $zuhe_db = new IModel('brand_chit_zuhe');
	    $zuhe_db->setData(array(
	        'status' => 0,
	    ));
	    $zuhe_db->update('id = ' . $id);
	
	    $this->redirect('brand_zuhe_list');
	}
	
	public function prom_rules_list()
	{
	    $prom_rules_list = prom_rules_class::get_prom_rules_list();
	    if ( $prom_rules_list )
	    {
	        foreach( $prom_rules_list as $kk => $vv )
	        {
	            $prom_rules_list[$kk]['title'] = prom_rules_class::get_prom_info_title($vv['promo_type'], $vv['promo_value']);
	        }
	    }
	
	    $this->setRenderData(array(
	        'prom_rules_list'  =>  $prom_rules_list,
	    ));
	    $this->redirect('prom_rules_list');
	}
	
	public function prom_rules_edit()
	{
	    $id = IFilter::act(IReq::get('id'), 'int');
	    if ( $id )
	    {
	        $prom_rules_info = prom_rules_class::get_prom_rules_info($id);
	        $this->setRenderData(array(
	            'prom_rules_info'  =>  $prom_rules_info,
	            'id'               =>  $id,
	        ));
	    }
	     
	    $this->redirect('prom_rules_edit');
	}
	
	public function prom_rules_edit_act()
	{
	    $id = IFilter::act(IReq::get('id'), 'int');
	    $data = array(
	        'level'        =>  IFilter::act(IReq::get('level'), 'int'),
	        'promo_type'   =>  IFilter::act(IReq::get('promo_type'), 'float'),
	        'promo_value'  =>  IFilter::act(IReq::get('promo_value'), 'float'),
	        'user_value'   =>  IFilter::act(IReq::get('user_value'), 'float'),
	        'seller_value' =>  IFilter::act(IReq::get('seller_value'), 'float'),
	        'order_value'  =>  IFilter::act(IReq::get('order_value'), 'float'),
	    );
	     
	    if ( !$data['level'] )
	    {
	        IError::show(403,'请选择级别');
	        exit();
	    }
	
	    if ( $data['user_value'] + $data['seller_value'] + $data['order_value'] > 100 )
	    {
	        IError::show(403,'提成总比例大于100');
	        exit();
	    }
	
// 	    if ( $data['level'] > 1 && $data['order_value'] > 0 )
// 	    {
// 	        IError::show(403,'该级别没有订单推广人');
// 	        exit();
// 	    }
	     
	    if ( $id > 0 )
	    {
	        $prom_rules_info = prom_rules_class::get_prom_rules_info($id);
	        if ( !$prom_rules_info )
	        {
	            IError::show(403,'该规则可能已被删除');
	            exit();
	        }
	    }
	     
	    if ( prom_rules_class::is_has_prom_rules_by_type($data['level'], $id))
	    {
	        IError::show(403,'该级别已存在');
	        exit();
	    }
	     
	    $prom_rules_db = new IModel('prom_rules');
	    $prom_rules_db->setData($data);
	    if ( $id > 0 )
	    {
	        $prom_rules_db->update('id = ' . $id );
	    } else {
	        $prom_rules_db->add();
	    }
	     
	    $this->redirect('prom_rules_list');
	}
	
	function prom_rules_del()
	{
	    $id = IFilter::act(IReq::get('id'), 'int');
	    if ( !$id )
	    {
	        IError::show(403,'参数不正确');
	        exit();
	    }
	     
	    $prom_rules_info = prom_rules_class::get_prom_rules_info($id);
	    if ( !$prom_rules_info )
	    {
	        IError::show(403,'该规则可能已被删除');
	        exit();
	    }
	     
	    $prom_rules_db = new IModel('prom_rules');
	    $prom_rules_db->del('id = ' . $id);
	     
	    $this->redirect('prom_rules_list');
	}
	
	function prom_user_list()
	{
	    $page = IFilter::act(IReq::get('page'), 'int');
	    $page = max($page,1);
	    $page_size = 15;
	    $search = IFilter::act(IReq::get('search'));
	     
	    // 获取推广人列表
	    $user_db = new IQuery('user');
	    $user_db->fields = 'distinct(promo_code) as promo_code';
	    $user_db->where = "promo_code != ''";
	    $promotor_list = $user_db->find();
	    if ( $promotor_list )
	    {
	        foreach($promotor_list as $kk => $vv )
	        {
	            $info = promotor_class::get_promotor_info($vv['promo_code']);
	            $info['promo_code'] = $vv['promo_code'];
	            $promotor_list[$kk] = $info;
	        }
	    }
	     
	    // 处理条件
	    $where = '';
	    if ( $search['start_time'] )
	    {
	        $start_time = $search['start_time'];
	        $where = " and m.time > '$start_time'";
	    }
	    if ( $search['end_time'] )
	    {
	        $end_time = $search['end_time'];
	        $where = " and m.time < '$end_time'";
	    }
	    if ( $search['promo_code'] )
	    {
	        $where = " and promo_code ='" . $search['promo_code'] . "'";
	    }
	
	    // 获取结果
	    $member_db = new IQuery('member as m');
	    $member_db->join = 'left join user as u on m.user_id = u.id';
	    $member_db->page = $page;
	    $member_db->pagesize = $page_size;
	    $member_db->fields = 'm.user_id,m.mobile,m.time,u.promo_code,u.username';
	    $member_db->where = "u.promo_code != ''" . $where;
	    $member_db->order = 'm.time desc';
	    $member_list = $member_db->find();
	     
	    // 处理结果
	    if ( $member_list )
	    {
	        foreach($member_list as $kk => $vv )
	        {
	            $member_list[$kk]['pay_count'] = order_class::get_user_pay_count($vv['user_id']);
	            $promotor_info = promotor_class::get_promotor_info($vv['promo_code']);
	            //$member_list[$kk]['promotor_name'] = isset($promotor_info['username']) ? $promotor_info['username'] : $promotor_info['shortname'];
	             
	            $member_list[$kk]['promotor_name'] = promotor_class::get_promotor_name_by_promotor_info($promotor_info);
	        }
	    }
	     
	    $this->setRenderData(array(
	        'member_list'    =>  $member_list,
	        'page_info'    =>  $member_db->getPageBar(),
	        'search'       =>  $search,
	        'promotor_list'    =>  $promotor_list,
	    ));
	     
	    $this->redirect('prom_user_list');
	     
	}
	
	
	function prom_seller_list()
	{
	    $page = IFilter::act(IReq::get('page'), 'int');
	    $page = max($page,1);
	    $page_size = 15;
	    $search = IFilter::act(IReq::get('search'));
	
	    // 获取推广人列表
	    $user_db = new IQuery('seller');
	    $user_db->fields = 'distinct(promo_code) as promo_code';
	    $user_db->where = "promo_code != ''";
	    $promotor_list = $user_db->find();
	    if ( $promotor_list )
	    {
	        foreach($promotor_list as $kk => $vv )
	        {
	            $info = promotor_class::get_promotor_info($vv['promo_code']);
	            $info['promo_code'] = $vv['promo_code'];
	            $promotor_list[$kk] = $info;
	        }
	    }
	
	    // 处理条件
	    $where = '';
	    if ( $search['start_time'] )
	    {
	        $start_time = $search['start_time'];
	        $where = " and m.time > '$start_time'";
	    }
	    if ( $search['end_time'] )
	    {
	        $end_time = $search['end_time'];
	        $where = " and m.time < '$end_time'";
	    }
	    if ( $search['promo_code'] )
	    {
	        $where = " and promo_code ='" . $search['promo_code'] . "'";
	    }
	
	    // 获取结果
	    $seller_db = new IQuery('seller');
	    $seller_db->page = $page;
	    $seller_db->pagesize = $page_size;
	    $seller_db->fields = 'id,mobile,create_time,shortname,true_name,promo_code';
	    $seller_db->where = "promo_code != ''" . $where;
	    $seller_db->order = 'create_time desc';
	    $seller_list = $seller_db->find();
	
	    // 处理结果
	    if ( $seller_list )
	    {
	        foreach($seller_list as $kk => $vv )
	        {
	            $seller_list[$kk]['order_count'] = order_class::get_seller_order_count($vv['id']);
	            $promotor_info = promotor_class::get_promotor_info($vv['promo_code']);
	            //$seller_list[$kk]['promotor_name'] = isset($promotor_info['username']) ? $promotor_info['username'] : $promotor_info['shortname'];
	             
	            $seller_list[$kk]['promotor_name'] = promotor_class::get_promotor_name_by_promotor_info($promotor_info);
	        }
	    }
	     
	    $this->setRenderData(array(
	        'seller_list'    =>  $seller_list,
	        'page_info'    =>  $seller_db->getPageBar(),
	        'search'       =>  $search,
	        'promotor_list'    =>  $promotor_list,
	    ));
	
	    $this->redirect('prom_seller_list');
	}
	
	// 本功能从2017-02-09日上线开始统计
	function prom_order_list()
	{
	    $page = IFilter::act(IReq::get('page'), 'int');
	    $page = max($page,1);
	    $page_size = 15;
	    $search = IFilter::act(IReq::get('search'));
	
	    // 获取推广人列表
	    $promotor_list = array();
	    $order_db = new IQuery('order as o');
	    $order_db->join = 'left join user as u on u.id = o.user_id left join member as m on m.user_id = u.id left join seller as s on s.id = o.seller_id';
	    $order_db->page = $page;
	    $order_db->pagesize = $page_size;
	    $order_db->fields = 'o.id,u.username,m.true_name,u.promo_code as user_promo_code,s.shortname,s.promo_code as seller_promo_code';
	    $order_db->where = "o.pay_status = 1 and o.order_amount > 0 and (u.promo_code != '' or s.promo_code != '' or o.promo_code != '') and o.create_time > '2017-02-09'";
	    $order_db->order = 'o.create_time desc';
	    $order_list = $order_db->find();
	    if ( $order_list )
	    {
	        foreach( $order_list as $kk => $vv )
	        {
	            if(!isset($promotor_list[$vv['user_promo_code']]) && $vv['user_promo_code'] != '')
	                $promotor_list[$vv['user_promo_code']] = ($vv['true_name']) ? $vv['true_name'] : $vv['username'];
	            if(!isset($promotor_list[$vv['seller_promo_code']]) && $vv['seller_promo_code'] != '')
	                $promotor_list[$vv['seller_promo_code']] = $vv['shortname'];
	        }
	    }
	
	    // 处理条件
	    $where = '';
	    if ( $search['start_time'] )
	    {
	        $start_time = $search['start_time'];
	        $where = " and o.create_time > '$start_time'";
	    }
	    if ( $search['end_time'] )
	    {
	        $end_time = $search['end_time'];
	        $where = " and o.create_time < '$end_time'";
	    }
	    if ( $search['promo_code'] )
	    {
	        $where = " and (u.promo_code ='" . $search['promo_code'] . "' or s.promo_code = '" . $search['promo_code'] . "')";
	    }
	    $where .= " and o.create_time > '2017-02-09'";
	
	    // 获取结果
	    $order_db = new IQuery('order as o');
	    $order_db->join = 'left join user as u on u.id = o.user_id left join seller as s on s.id = o.seller_id';
	    $order_db->page = $page;
	    $order_db->pagesize = $page_size;
	    $order_db->fields = 'o.*,u.username,u.promo_code as user_promo_code,s.shortname,s.promo_code as seller_promo_code';
	    $order_db->where = "o.pay_status = 1 and o.order_amount > 0 and (u.promo_code != '' or s.promo_code != '' or o.promo_code != '')" . $where;
	    $order_db->order = 'o.create_time desc';
	    $order_list = $order_db->find();
	
	    // 处理结果
	    if ( $order_list )
	    {
	        foreach($order_list as $kk => $vv )
	        {
	            $goods_list = Order_goods_class::get_order_goods_list($vv['id']);
	            $goods_list = current($goods_list);
	            $goods_array = json_decode($goods_list['goods_array']);
	            $goods_list['name'] = $goods_array->name;
	            $goods_list['value'] = $goods_array->value;
	            $order_list[$kk]['order_goods'] = $goods_list;
	            $order_list[$kk]['commission_count'] = order_class::get_order_promo_commission_count($vv['id']);
	            $order_list[$kk]['order_str'] = Order_Class::orderStatusText(Order_Class::getOrderStatus($vv), 1, $vv['statement']);
	        }
	    }
	
	    $this->setRenderData(array(
	        'order_list'    =>  $order_list,
	        'page_info'    =>  $order_db->getPageBar(),
	        'search'       =>  $search,
	        'promotor_list'    =>  $promotor_list,
	    ));
	
	    $this->redirect('prom_order_list');
	}
	
	function brand_chit_list()
	{
		$page = IFilter::act(IReq::get('page'), 'int');
	    $page = max($page,1);
	    $page_size = 15;
		$brand_chit_db = new IQuery('brand_chit');
		$brand_chit_db->where = 'category = 1';
		$brand_chit_db->page = $page;
		$brand_chit_db->pagesize = $page_size;
		$brand_chit_db->order = 'id desc';
		$brand_chit_list = $brand_chit_db->find();
		$page_info = $brand_chit_db->getPageBar();
		
		if ( $brand_chit_list )
		{
			foreach( $brand_chit_list as $kk => $vv )
			{
				if ( $vv['seller_id'] > 0 )
				{
					$brand_chit_list[$kk]['seller_info'] = seller_class::get_seller_info($vv['seller_id']);
				}
				if ( $vv['goods_id'] > 0 )
				{
					$brand_chit_list[$kk]['goods_info'] = goods_class::get_goods_info($vv['goods_id']);
				}
			}
		}
		
		$this->setRenderData(array(
			'brand_chit_list'	=>	$brand_chit_list,
			'page'	=>	$page,
			'page_info'	=>	$page_info,
		));
		
		$this->redirect('brand_chit_list');
	}
	
	
	
	// 短期课列表
	function brand_chit_list2()
	{
	    $search = IFilter::act(IReq::get('search'));
		$page = IFilter::act(IReq::get('page'), 'int');
	    $page = max($page,1);
	    $page_size = 15;
	    $where = 'bc.category = 2';
	    
	    // 处理搜索条件
	    // 根据商户ID搜索
	    if ( $search['seller_id'] )
	    {
	        $where .= ' and bc.seller_id = ' . $search['seller_id'];
	    }
	    
	    // 根据短期课分类搜索
	    if ( $search['manual_category_id'] > 0 )
	    {
	        $where .= ' and s.manual_category_id = ' . $search['manual_category_id'];
	    }
	    
	    // 根据推荐搜索
	    if ( $search['is_intro'] != '')
	    {
	        $is_intro = $search['is_intro'] + 0;
	        $where .= ' and is_intro = ' . $is_intro;
	    }
	    
	    // 根据置顶搜索
	    if ( $search['is_top'] != '')
	    {
	        $is_top = $search['is_top'] + 0;
	        $where .= ' and is_top = ' . $is_top;
	    }
	    
	    // 根据状态搜索
	    if ( $search['is_del'] != '')
	    {
	        $is_del = $search['is_del'] + 0;
	        $where .= ' and is_del = ' . $is_del;
	    }
	    
	    // 根据关键词
	    if ( $search['keywords'] )
	    {
	        $where .= " and g.search_words like '%" . $search['keywords'] . "%'";
	    }
	    
		$brand_chit_db = new IQuery('brand_chit as bc');
		$brand_chit_db->join = 'left join goods as g on bc.goods_id = g.id left join seller as s on bc.seller_id = s.id';
		$brand_chit_db->where = $where;
		$brand_chit_db->fields = 'bc.*';
		$brand_chit_db->page = $page;
		$brand_chit_db->pagesize = $page_size;
		$brand_chit_db->order = 'bc.id desc';
		$brand_chit_list = $brand_chit_db->find();
		$page_info = $brand_chit_db->getPageBar();
		
		if ( $brand_chit_list )
		{
			foreach( $brand_chit_list as $kk => $vv )
			{
				if ( $vv['seller_id'] > 0 )
				{
					$brand_chit_list[$kk]['seller_info'] = seller_class::get_seller_info($vv['seller_id']);
				}
				if ( $vv['goods_id'] > 0 )
				{
					$brand_chit_list[$kk]['goods_info'] = goods_class::get_goods_info($vv['goods_id']);
				}
			}
		}
		
		// 获取短期课分类
		$category_list = manual_category_class::get_category_list();
		$cate_arr = array();
        if ( $category_list )
        {
            foreach($category_list as $kk => $vv )
            {
                $cate_arr[$vv['id']] = $vv;
            }
        }
        
        // 获取所有商户
        $seller_db = new IQuery('seller as s');
        $seller_db->fields = 'distinct(s.id) as seller_id,s.id,s.shortname';
        $seller_db->join = 'left join brand_chit as bc on s.id = bc.seller_id';
        $seller_db->where = 'bc.category = 2';
        $seller_db->order = 'id desc';
        $seller_list = $seller_db->find();
		
		$this->setRenderData(array(
			'brand_chit_list'	=>	$brand_chit_list,
			'page'	=>	$page,
			'page_info'	=>	$page_info,
		    'category_list'   =>  $cate_arr,
		    'seller_list'     =>  $seller_list,
		    'search'          =>  $search,
		));
		
		$this->redirect('brand_chit_list2');
	}
	
	// 学习通优惠列表
	function brand_chit_list3()
	{
	    $search = IFilter::act(IReq::get('search'));
	    $page = IFilter::act(IReq::get('page'), 'int');
	    $page = max($page,1);
	    $page_size = 15;
	    $where = 'bc.category = 3';
	     
	    // 处理搜索条件
	    // 根据商户ID搜索
	    if ( $search['seller_id'] )
	    {
	        $where .= ' and bc.seller_id = ' . $search['seller_id'];
	    }
	     
	    // 根据短期课分类搜索
	    if ( $search['manual_category_id'] > 0 )
	    {
	        $where .= ' and s.manual_category_id = ' . $search['manual_category_id'];
	    }
	     
	    // 根据推荐搜索
	    if ( $search['is_intro'] != '')
	    {
	        $is_intro = $search['is_intro'] + 0;
	        $where .= ' and is_intro = ' . $is_intro;
	    }
	     
	    // 根据置顶搜索
	    if ( $search['is_top'] != '')
	    {
	        $is_top = $search['is_top'] + 0;
	        $where .= ' and is_top = ' . $is_top;
	    }
	     
	    // 根据状态搜索
	    if ( $search['is_del'] != '')
	    {
	        $is_del = $search['is_del'] + 0;
	        $where .= ' and is_del = ' . $is_del;
	    }
	     
	    // 根据关键词
	    if ( $search['keywords'] )
	    {
	        $where .= " and g.search_words like '%" . $search['keywords'] . "%'";
	    }
	     
	    $brand_chit_db = new IQuery('brand_chit as bc');
	    $brand_chit_db->join = 'left join goods as g on bc.goods_id = g.id left join seller as s on bc.seller_id = s.id';
	    $brand_chit_db->where = $where;
	    $brand_chit_db->fields = 'bc.*';
	    $brand_chit_db->page = $page;
	    $brand_chit_db->pagesize = $page_size;
	    $brand_chit_db->order = 'bc.id desc';
	    $brand_chit_list = $brand_chit_db->find();
	    $page_info = $brand_chit_db->getPageBar();
	
	    if ( $brand_chit_list )
	    {
	        foreach( $brand_chit_list as $kk => $vv )
	        {
	            if ( $vv['seller_id'] > 0 )
	            {
	                $brand_chit_list[$kk]['seller_info'] = seller_class::get_seller_info($vv['seller_id']);
	            }
	            if ( $vv['goods_id'] > 0 )
	            {
	                $brand_chit_list[$kk]['goods_info'] = goods_class::get_goods_info($vv['goods_id']);
	            }
	        }
	    }
	
	    // 获取短期课分类
	    $category_list = manual_category_class::get_category_list();
	    $cate_arr = array();
	    if ( $category_list )
	    {
	        foreach($category_list as $kk => $vv )
	        {
	            $cate_arr[$vv['id']] = $vv;
	        }
	    }
	
	    // 获取所有商户
	    $seller_db = new IQuery('seller as s');
	    $seller_db->fields = 'distinct(s.id) as seller_id,s.id,s.shortname';
	    $seller_db->join = 'left join brand_chit as bc on s.id = bc.seller_id';
	    $seller_db->where = 'bc.category = 3';
	    $seller_db->order = 'id desc';
	    $seller_list = $seller_db->find();
	
	    $this->setRenderData(array(
	        'brand_chit_list'	=>	$brand_chit_list,
	        'page'	=>	$page,
	        'page_info'	=>	$page_info,
	        'category_list'   =>  $cate_arr,
	        'seller_list'     =>  $seller_list,
	        'search'          =>  $search,
	    ));
	
	    $this->redirect('brand_chit_list3');
	}
	
	// 创建短期课套餐页面，步骤一
	function brand_zuhe_edit_step1()
	{
	    $brand_chit_db = new IQuery('brand_chit as bc');
	    $brand_chit_db->join = 'left join goods as g on bc.goods_id = g.id';
	    $brand_chit_db->where = 'g.is_del = 0 and bc.category = 2';
	    $brand_chit_db->fields = 'bc.*';
	    $brand_chit_db->order = 'bc.id desc';
	    $brand_chit_list = $brand_chit_db->find();
	    
	    if ( $brand_chit_list )
	    {
	        foreach( $brand_chit_list as $kk => $vv )
	        {
	            if ( $vv['seller_id'] > 0 )
	            {
	                $brand_chit_list[$kk]['seller_info'] = seller_class::get_seller_info($vv['seller_id']);
	            }
	            if ( $vv['goods_id'] > 0 )
	            {
	                $brand_chit_list[$kk]['goods_info'] = goods_class::get_goods_info($vv['goods_id']);
	            }
	        }
	    }
	    
	    $this->setRenderData(array(
	        'brand_chit_list'	=>	$brand_chit_list,
	    ));
	    
	    $this->redirect('brand_zuhe_edit_step1');
	}
	
	function brand_chit_del()
	{
	    $id = IReq::get('id') + 0;
	    $brand_chit_db = new IQuery('brand_chit');
	    $brand_chit_db->where = 'id = ' . $id;
	    $brand_chit_info = $brand_chit_db->getOne();
	    if ( !$brand_chit_info )
	    {
	        IError::show(403,'代金券/短期课不存在');
	        exit();
	    }
		
	    $brand_chit_db = new IModel('brand_chit');
	    $brand_chit_db->del('id = ' . $id);
	
	    $this->redirect('brand_chit_list2');
	}
	
	function brand_chit_del3()
	{
	    $id = IReq::get('id') + 0;
	    $brand_chit_db = new IQuery('brand_chit');
	    $brand_chit_db->where = 'id = ' . $id;
	    $brand_chit_info = $brand_chit_db->getOne();
	    if ( !$brand_chit_info )
	    {
	        IError::show(403,'代金券/短期课不存在');
	        exit();
	    }
	
	    $brand_chit_db = new IModel('brand_chit');
	    $brand_chit_db->del('id = ' . $id);
	
	    $this->redirect('brand_chit_list3');
	}
	
	function brand_chit_zuhe_setting()
	{
	    $siteObj = new Config('site_config');
	    $this->commission = $siteObj->commission;
	    $this->redirect('brand_chit_zuhe_setting');
	}
	
	function brand_chit_zuhe_save()
	{
	    $commission = IFilter::act(IReq::get('commission'), 'int');
	    $inputArray = array('commission' => $commission);
	    $siteObj = new Config('site_config');
	    $siteObj->write($inputArray);
	    
	    $this->redirect('brand_chit_zuhe_setting');
	}
	
	// 平台利润列表
	function profit_list()
	{
	    $page =  IFilter::act(IReq::get('page'), 'int');
	    $page = max($page,1);
	    $page_size = 20;
	    
	    $company_profit_db = new IQuery('company_profit as cp');
	    $company_profit_db->where = '1=1';
	    $company_profit_db->join = 'left join order as o on cp.order_id = o.id left join seller as s on cp.seller_id = s.id left join user as u on cp.user_id = u.id';
	    $company_profit_db->fields = 'cp.*,s.shortname,u.username,o.order_no,o.mobile';
	    $company_profit_db->page = $page;
	    $company_profit_db->pagesize = $page_size;
	    $company_profit_db->order = 'id desc';
	    $company_profit_list = $company_profit_db->find();
	    
	    $this->setRenderData(array(
	        'company_profit_list'  =>  $company_profit_list,
	        'page_info'                 =>  $company_profit_db->getPageBar(),
	    ));
	    
	    $this->redirect('profit_list');
	}
	
	// 提现列表
	public function sale_tixian()
	{
	    $page= (isset($_GET['page'])&&(intval($_GET['page'])>0))?intval($_GET['page']):1;
	    $search = IReq::get('search') ? IFilter::act(IReq::get('search'),'strict') : array();
	    $page_size = 12;
	    $where = 1;
	    if ( $search )
	    {
	        foreach( $search as $kk => $vv )
	        {
	            if ( $vv )
	                $where .= " and ".$kk."'".$vv."'";
	        }
	    }
	
	    $sale_tixian_db = new IQuery('sale_tixian as b');
	    $sale_tixian_db->join = 'left join seller as s on s.id = b.seller_id left join admin as a on b.admin_id = a.id';
	    $sale_tixian_db->where = $where;
	    $sale_tixian_db->fields = 'b.*,s.account_name,s.account_bank_name,s.account_cart_no,s.account_bank_branch,s.bank, s.bankname,s.account,s.alipaysn,s.accountname,s.alipayname,s.shortname,s.true_name,a.admin_name';
	    $sale_tixian_db->pagesize = $page_size;
	    $sale_tixian_db->page = $page;
	    $sale_tixian_db->order = 'id desc';
	    $sale_tixian_list = $sale_tixian_db->find();
	    $page_info = $sale_tixian_db->getPageBar();
	
	    $this->setRenderData(array(
	        'search'       =>  $search,
	        'page'         =>  $page,
	        'where'        =>  $where,
	        'page_info'    =>  $page_info,
	        'sale_tixian_list'     =>  $sale_tixian_list,
	    ));
	
	    $this->redirect('sale_tixian');
	}
	
	public function sale_work(){
	    $id= IReq::get('id');
	    $result= IReq::get('result');
	    $time = time();
	
	    if(!$id||!$result)
	    {
	        $this->redirect('sale_tixian',false);
	        Util::showMessage('操作失败，参数错误');
	    }
	
	    $saleObj = new IModel('sale_tixian');
	    $saleRow = $saleObj->getObj('id='.$id);
	    if($saleRow)
	    {
	        if($saleRow['status']!=0)
	        {
	            $this->redirect('sale_tixian',false);
	            Util::showMessage('操作失败，申请单已经被处理过');
	        }
	        if($result==1)
	        {//同意
	
	            $salelogObj = new IModel('salelog');
	            $dataArray3 = array(
	                'note' =>'管理员'.$this->admin['admin_name'].'通过了商户【'.$saleRow['seller_id'].'】的销售额提现申请，账户减少'.$saleRow['num'].'元',
	                'time' =>time(),
	                'num' =>'-'.$saleRow['num'],
	                'seller_id' =>$saleRow['seller_id'],
	                'sale_balance' =>$sellerRow['sale_balance']-$saleRow['num'],
	            );
	
	            $salelogObj->setData($dataArray3);
	            $salelogObj->add();
	
	            $dataArray = array(
	                'status'    => 1,
	                'end_time'  => $time,
	            );
	            $saleObj->setData($dataArray);
	            $saleObj->update('id = '.$id);
	        }
	        if($result==2){//反对
	            $dataArray = array(
	                'status'    =>  2,
	                'end_time'  =>  $time,
	            );
	            $saleObj->setData($dataArray);
	            $saleObj->update('id = '.$id);
	        }
	    }else{
	        $this->redirect('fanli_tixian',false);
	        Util::showMessage('操作失败，没有对应的提现申请');
	    }
	
	    $this->redirect('sale_tixian',false);
	    Util::showMessage('操作成功');
	}
	
	// 教育手册列表
	function manual_list()
	{
	    $page       = intval(IReq::get('page')) ? IReq::get('page') : 1;
	    $page_size = 12;
	    $search = IFilter::act(IReq::get('search'));
	    
	    $where = '1=1';
	    if ( $search['user_id'] )
	    {
	        $where .= ' and user_id = ' . $search['user_id'];
	    }
	    if ( $search['is_activation'] )
	    {
	        $type = ($search['is_activation'] == 1) ? 1 : 0;
	        $where .= ' and is_activation = ' . $type;
	    }
	    
        $manual_info = manual_class::get_manual_list($where, $page, $page_size);
        
        $manual_db = new IQuery('manual as m');
        $manual_db->join = 'left join user as u on m.user_id = u.id';
        $manual_db->fields = 'distinct(m.user_id) as user_id, u.username';
        $manual_db->where = '1=1';
        $manual_user_list = $manual_db->find();
	    
	    $this->setRenderData(array(
	        'manual_list'  =>  $manual_info['list'],
	        'page_info'    =>  $manual_info['page_info'],
	        'manual_user_list' =>  $manual_user_list,
	        'search'       =>  $search,
	    ));
	    $this->redirect('manual_list');
	}
	
	function create_manual()
	{
	    $nums = IReq::get('nums');
	    $nums = $nums + 0;
	    if ( $nums > 0 )
	    {
	        for( $i = 0; $i < $nums; $i++ )
	        {
	            manual_class::create_manual();
	        }
	        
	        header("location:" . IUrl::creatUrl('/market/manual_list'));
	    } else {
	        $this->redirect('manual_list',false);
	        Util::showMessage('操作失败，参数错误');
	    }
	}
}