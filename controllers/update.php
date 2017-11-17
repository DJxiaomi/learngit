<?php
/**
 * @brief 升级更新控制器
 */
class Update extends IController
{
	/**
	 * @brief iwebshop16060600 版本升级更新
	 */
	public function index()
	{
		set_time_limit(0);

		$sql = array(
			"ALTER TABLE  `{pre}goods` ADD  `is_delivery_fee` tinyint(1) NOT NULL default '0' COMMENT '免运费 0收运费 1免运费';",
			"INSERT INTO `{pre}payment` VALUES (NULL, '微信APP支付', 1, 'app_wechat', '微信APP支付接口，必须有独立的APP才可以使用此支付方式。<a href=\"https://open.weixin.qq.com/\" target=\"_blank\">立即申请</a>', '/payments/logos/pay_app_wechat.png', 1, 99, NULL, 0.00, 1, NULL,2);",
			"ALTER TABLE  `{pre}seller` ADD  `logo` varchar(255) NOT NULL default '' COMMENT '店铺logo图标'",
		);

		foreach($sql as $key => $val)
		{
			IDBFactory::getDB()->query( $this->_c($val) );
		}

		die("升级成功!! V4.7版本");
	}

	public function _c($sql)
	{
		return str_replace('{pre}',IWeb::$app->config['DB']['tablePre'],$sql);
	}

	//查询规格标准
	public function searchSpec($specVal,$specValueArray)
	{
		foreach($specValueArray as $tip => $item)
		{
			if($item == $specVal && !is_numeric($tip))
			{
				return $tip;
			}
		}
		return "";
	}
}