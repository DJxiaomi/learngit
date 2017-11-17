<?php
/**
 * Powered by       xiaomi
 * Date             2017/11/8
 * Des              第三课web端获取城市相关数据 
 */

class city
{
    public static $area_arr_file = 'runtime/cache/a_a_f.dat';


/**
 * 获取当前城市id
 */
	public static function get_my_city_code()
	{
	    $my_city_code = $_COOKIE['iweb_my_city_code'];
	    if (!$my_city_code)
	    {
	        $my_city_code = get_city();
            $file = self::$area_arr_file;
            if (file_exists($file)){
                $area_arr = unserialize(file_get_contents($file));
            }else{
        		$seller = new IQuery('seller');
        		$seller->where = "logo != '' and is_del = 0 and is_lock = 0 and is_authentication = 1";
                $seller->fields = 'distinct(city)';
        		$citys = $seller->find();
        		$tmp_arr = array();
                foreach($citys as $k => $v)
                {
                    if ($v['city']<>0) { $tmp_arr[] = $v['city']; }
                }
                if (!in_array($my_city_code,$tmp_arr)) {$my_city_code = '430200';}  //设置默认城市【株洲/430200】
                foreach($tmp_arr as $k => $v)
                {
                    $vv['citycode'] = $v;
                    $vv['cityname'] = area::getName($v);
                    $vv['cache_time'] = date('m/d H:i:s');
                    $area_arr[] = $vv;
                    unset($vv);
                }
                file_put_contents($file,serialize($area_arr));
            }
            setcookie('iweb_my_city_code',$my_city_code,60*60);
	    }
		return $my_city_code;
	}


/**
 * 获取城市列表
 */
	public static function get_city_arr()
	{
        $file = self::$area_arr_file;
        if (!file_exists($file)){
            $my_city_code = city::get_my_city_code();
        }
        $area_arr = unserialize(file_get_contents($file));
		return $area_arr;
	}
	

/**
 * 更新城市列表缓存
 */
	public static function update_city_arr()
	{
        $file = self::$area_arr_file;
        $res = true;
        if (file_exists($file)){
            if (unlink($file)){
                $res = true;
            }else{
                $res = false;
            }
        }
		return $res;
	}
	
	
}