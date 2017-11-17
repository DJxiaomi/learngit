<?php
/**
 * @copyright Copyright(c) 2016 aircheng.com
 * @file menuSeller.php
 * @brief 商家系统菜单管理
 * @author nswe
 * @date 2016/3/8 9:30:34
 * @version 4.4
 */
class menuSeller
{
    //菜单的配制数据
	public static $menu = array
	(
		"后台首页" => array(
			"/seller/index" => "数据汇总",
		    //"/seller/order_verification" => "授课确认",
		),
		"学校设置" => array( 
			 "/seller/brand_edit" => "页面信息",		
			 "/seller/seller_edit" => "基本信息",
			'/seller/seller_edit4' => '结算账户',
			'/seller/seller_edit5' => '账户安全',
			'/seller/seller_edit6' => '认证信息',
		),

		"课程老师" => array(
			"/seller/goods_list_1" => "课程列表",
			"/seller/goods_edit_1" => "添加课程",
			"/seller/teacher_list" => "老师列表",
			"/seller/teacher_edit" => "添加老师",			
		),
		
		"交易管理" => array(
			"/seller/order_goods_list" => "已完成",
			"seller/order_list" => "已付款",
			"/seller/refer_list" => "咨询",
			"/seller/comment_list" => "评价",
			"/seller/refundment_list" => "退款",
		    "/seller/order_list_dqk" => "短期课",
		    "/seller/order_list_receive" => "商户收款",
			"/seller/message_list" => "消息通知",
		),		
	    "账户余额" => array(
	        "/seller/sale_tixian" => "账户提现",
	        "/seller/tixian_list" => "提现记录",
	    ),
		"商品模块" => array(
			"/seller/share_list" => "平台共享商品",
			"/seller/regiment_list" => "团购",
			"/seller/pro_rule_list" => "促销活动",
    	),
	);

    /**
     * @brief 根据权限初始化菜单
     * @param int $roleId 角色ID
     * @return array 菜单数组
     */
    public static function init($roleId = "")
    {
		//菜单创建事件触发
		plugin::trigger("onSellerMenuCreate");
		return self::$menu;
    }
}