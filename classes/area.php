<?php
/**
 * @copyright Copyright(c) 2014 aircheng.com
 * @file area.php
 * @brief 省市地区调用函数
 * @author nswe
 * @date 2014/8/6 20:46:52
 * @version 2.6
 * @note
 */

 /**
 * @class area
 * @brief 省市地区调用函数
 */
class area
{
	/**
	 * @brief 根据传入的地域ID获取地域名称，获取的名称是根据ID依次获取的
	 * @param int 地域ID 匿名参数可以多个id
	 * @return array
	 */
	public static function name()
	{
		$result     = array();
		$paramArray = func_get_args();

		//根据参数ID初始化数组值
		foreach($paramArray as $key => $val)
		{
			$result[$val] = "";
		}

		$areaDB     = new IModel('areas');
		$areaData   = $areaDB->query("area_id in (".trim(join(',',$paramArray),",").")");

		foreach($areaData as $key => $value)
		{
			$result[$value['area_id']] = $value['area_name'];
		}
		return $result;
	}
	public static function getName($id)
	{
		$areaDB     = new IModel('areas');
		$areaData   = $areaDB->getObj("area_id = '$id'", 'area_name');
		return $areaData['area_name'];
	}
	public static function getJsonArea()
	{
		$json = array();
	    $area_db = new IQuery('areas');
        $area_db->where = "parent_id = '0'";
        $areas = $area_db->find();
    	foreach($areas AS $idx => $area)
    	{
    		$json[$idx]['value'] = $area['area_id'];
    		$json[$idx]['text'] = $area['area_name'];
    		$child_db = new IQuery('areas');
        	$child_db->where = "parent_id = '$area[area_id]'";
    		$child = $child_db->find();
    		foreach($child AS $k => $c)
    		{
    			$json[$idx]['children'][$k]['value'] = $c['area_id'];
    			$json[$idx]['children'][$k]['text'] = $c['area_name'];
    			$childer_db = new IQuery('areas');
        		$childer_db->where = "parent_id = '$c[area_id]'";
    			$childer = $childer_db->find();
    			foreach($childer AS $j => $cr)
    			{
    				$json[$idx]['children'][$k]['children'][$j]['value'] = $cr['area_id'];
    				$json[$idx]['children'][$k]['children'][$j]['text'] = $cr['area_name'];
    			}
    		}
    	}
    	return $json;
	}
	/**
	 * 获取区域信息
	 * @param array 由area_id组成的数组，例如：array(1,2,3,4);
	 * @return array
	 */
	public static function get_area_info_by_id_arr( $id_arr )
	{
	    if ( !is_array( $id_arr ))
	    {
	        return false;
	    }
	    $area_db = new IQuery('areas');
	    $area_db->where = db_create_in( $id_arr, 'area_id');
	    return $area_db->find();
	}
	/**
	 * @brief 根据传入的区域ID，获取子区域ID列表，单级别，暂无递归 added by jack 20160616
	 * @param int 
	 * @return array
	 */
	public static function get_child_area_id_list( $area_id )
	{
	    $area_list = area::get_child_area_list( $area_id );
	    $areas = array();
	    if ( $area_list )
	    {
	        foreach( $area_list as $kk => $vv )
	        {
	            $areas[] = $vv['area_id'];
	        }
	    }
	    return $areas;
	}
	public static function get_child_area_list( $area_id )
	{
	    if ( !$area_id )
	        return array();
	    $area_db = new IModel("areas");
	    return $area_db->query('parent_id = ' . $area_id);
	}
	public static function get_area_info( $area_id )
	{
	    if ( !$area_id )
	        return array();
	    $area_db = new IQuery("areas");
	    $area_db->where = 'area_id = ' . $area_id;
	    return $area_db->getOne();
	}
}