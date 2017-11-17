<?php
/**
 * @copyright Copyright(c) 2016 lelele999.com
 * @file function.php
 * @brief 乐享生活系统核心函数库
 * @author jack
 * @date 20160616
 * @version 1.0
 * @note
 */



/**
 * 创建像这样的查询: "IN('a','b')";
 *
 * @access   public
 * @param    mix      $item_list      列表数组或字符串,如果为字符串时,字符串只接受数字串
 * @param    string   $field_name     字段名称
 * @param    bollen   $boolen         是否存在某个字段 in or not in
 * @author   wj
 *
 * @return   void
 */
function db_create_in($item_list, $field_name = '', $boolen = true )
{
    if (empty($item_list))
    {
        return $field_name . " IN ('') ";
    }
    else
    {
        if (!is_array($item_list))
        {
            $item_list = explode(',', $item_list);
            foreach ($item_list as $k=>$v)
            {
                $item_list[$k] = intval($v);
            }
        }

        $item_list = array_unique($item_list);
        $item_list_tmp = '';
        foreach ($item_list AS $item)
        {
            if ($item !== '')
            {
                $item_list_tmp .= $item_list_tmp ? ",'$item'" : "'$item'";
            }
        }
        if (empty($item_list_tmp))
        {
            return ( $boolen ) ? $field_name . " IN ('') " : $field_name . " NOT IN ('') " ;
        }
        else
        {
            return ( $boolen ) ? $field_name . ' IN (' . $item_list_tmp . ') ' : $field_name . ' NOT IN (' . $item_list_tmp . ') ';
        }
    }
}


/**
 *  rdump的别名
 *
 *  @author Garbin
 *  @param  any
 *  @return void
 */
function dump($arr)
{
    $args = func_get_args();
    call_user_func_array('rdump', $args);
}

/**
 *  格式化显示出变量
 *
 *  @author Garbin
 *  @param  any
 *  @return void
 */
function rdump($arr)
{
    echo '<pre>';
    array_walk(func_get_args(), create_function('&$item, $key', 'print_r($item);'));
    echo '</pre>';
    exit();
}

/**
 *  格式化并显示出变量类型
 *
 *  @author Garbin
 *  @param  any
 *  @return void
 */
function vdump($arr)
{
    echo '<pre>';
    array_walk(func_get_args(), create_function('&$item, $key', 'var_dump($item);'));
    echo '</pre>';
    exit();
}

/**
 * 获取IP地址
 */
function GetIp(){
    $realip = '';
    $unknown = 'unknown';
    if (isset($_SERVER)){
        if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']) && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], $unknown)){
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach($arr as $ip){
                $ip = trim($ip);
                if ($ip != 'unknown'){
                    $realip = $ip;
                    break;
                }
            }
        }else if(isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP']) && strcasecmp($_SERVER['HTTP_CLIENT_IP'], $unknown)){
            $realip = $_SERVER['HTTP_CLIENT_IP'];
        }else if(isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR']) && strcasecmp($_SERVER['REMOTE_ADDR'], $unknown)){
            $realip = $_SERVER['REMOTE_ADDR'];
        }else{
            $realip = $unknown;
        }
    }else{
        if(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), $unknown)){
            $realip = getenv("HTTP_X_FORWARDED_FOR");
        }else if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), $unknown)){
            $realip = getenv("HTTP_CLIENT_IP");
        }else if(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), $unknown)){
            $realip = getenv("REMOTE_ADDR");
        }else{
            $realip = $unknown;
        }
    }
    $realip = preg_match("/[\d\.]{7,15}/", $realip, $matches) ? $matches[0] : $unknown;
    return $realip;
}

/**
 * 根据IP地址
 */
function getIPLoc_sina($queryIP){
    $url = 'http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip=' . $queryIP;
    $ch = curl_init($url);//初始化url地址
    curl_setopt($ch, CURLOPT_ENCODING, 'utf8');//设置一个cURL传输选项
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 获取数据返回
    $location = curl_exec($ch);//执行一个cURL会话
    $location = json_decode($location);//对 JSON 格式的字符串进行编码
    curl_close($ch);//关闭一个cURL会话
    $loc = "";
    if ($location === FALSE) return "地址不正确";
    if (empty($location->desc)) {
        $loc = $location->city;
    } else { $loc = $location->desc;}
    return $loc;
}

/**
 * 根据城市获取城市id
 */
function get_city_num( $city ) {

    $default_num = 430200;
    $city_arr = get_city_list();

    if ( !$city )
        return $default_num;

    if ( $citys )
    {
        foreach( $citys as $kk => $vv ) {
            if ( $vv['city'] == $city )
                return $vv['city_num'];
        }
    }

    return $default_num;
}

/**
 * 获取当前城市ID，株洲/长沙以外的用户显示为株洲
 */
function get_city()
{
    $SA_IP=getip();
    $city = getIPLoc_sina($SA_IP);
    $city_num = get_city_num( $city );
    return $city_num;
}

/**
 * 根据城市ID，返回城市名称
 * @param int
 * @return string
 */
function get_city_name( $num )
{
    $city_arr = get_city_list();
    if ( $city_arr )
    {
        foreach( $city_arr as $kk => $vv )
        {
            if ( $vv['city_num'] == $num )
                return $vv['city'];
        }
    }
    return '';
}

/**
 * 获取城市列表，暂时只需要株洲和长沙
 */
function get_city_list()
{
    $city_arr = array(
        0    =>  array(
            'city'      =>  '株洲',
            'city_num'  =>  430200,
        ),
        1    =>  array(
            'city'      =>  '长沙',
            'city_num'  =>  430100,
        ),
    );
    return $city_arr;
}

/**
 * 计算出当天与下单日期相差几天
 * @param time
 */
function get_distance_day( $day1, $day2 )
{
    $second1 = strtotime($day1);
    $second2 = strtotime($day2);

    if ($second1 < $second2) {
        $tmp = $second2;
        $second2 = $second1;
        $second1 = $tmp;
    }
    return ($second1 - $second2) / 86400;
}

function get_sex( $sex )
{
  return ( $sex == 1 ) ? '男' : '女';
}

/**
 * 计算返利的金额
 * @param unknown $goods_price
 * @param unknown $goods_fanli_bili
 * @param unknown $store_fanli_bili
 * @return string
 */
function get_fanli_num( $goods_price, $goods_fanli_bili, $store_fanli_bili )
{
    $fanli = $goods_fanli_bili * $goods_price / $store_fanli_bili;
    $fanli = number_format( $fanli, 1, '.', '' );
    $fanli = number_format( $fanli, 2, '.', '' );
    return $fanli;
}



/**
 * 检测非法关键词
 * @param string $content
 * @param unknown $keyword
 */
function check_bad_words($content, $keyword ){                  //定义处理违法关键字的方法  
    //$m = 0;  
    $m = '';
    for($i = 0; $i < count ( $keyword ); $i ++) {    //根据数组元素数量执行for循环  
        //应用substr_count检测文章的标题和内容中是否包含敏感词  
        if ( $keyword[$i] )
        {
            if (substr_count ( $content, $keyword[$i] ) > 0) {  
                //$m ++;  
                $m[] = $keyword[$i];
                //return $keyword[$i];
            }
        }
    }  
    return $m;              //返回变量值，根据变量值判断是否存在敏感词  
}  

function br2nl($text){
    return preg_replace('/<br\\s*?\/??>/i','',$text);
}

function get_gender_title($gender = 0)
{
    switch($gender)
    {
        case 0:
            return '保密';
        case 1:
            return '男';
        case 2:
            return '女';
    }
}

function get_boolen_title($boolen)
{
    return ($boolen) ? '是' : '否';
}

function get_default_icon($sex = 1)
{
    return ($sex == 2) ? '/views/default/skin/default/images/women.jpg' : '/views/default/skin/default/images/man.jpg';
}

// 实名认证
function check_auth($name = '', $mobile = '', $cardsn = '', $account = '')
{
    if ( !$name )
    {
        IError::show('姓名不能为空',403);
        exit();
    }
    
    if ( !$mobile )
    {
        IError::show('手机号不能为空',403);
        exit();
    }
    
    if ( !$cardsn )
    {
        IError::show('身份证号不能为空',403);
        exit();
    }
    
    if ( !$account )
    {
        IError::show('银行卡号不能为空',403);
        exit();
    }
    
    $host = "http://aliyuncardby4element.haoservice.com";
    $path = "/creditop/BankCardQuery/QryBankCardBy4Element";
    $method = "GET";
    $appcode = "fdbcfe6c9239431aa076fca284c57e35";
    $headers = array();
    array_push($headers, "Authorization:APPCODE " . $appcode);
    $querys = "accountNo=$account&bankPreMobile=$mobile&idCardCode=$cardsn&name=$name";
    $bodys = "";
    $url = $host . $path . "?" . $querys;
    
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_FAILONERROR, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false );
    if (1 == strpos("$".$host, "https://"))
    {
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    }
    
    $result = curl_exec($curl);
    $result = json_decode($result);
    $check_result = $result->result;
    if ( $check_result->result == 'T')
    {
        return true;
    } else if ($check_result->result == 'P') {
        IError::show('实名认证超时',403);
        exit();
    } else {
        IError::show('实名认证失败，信息不正确',403);
        exit();
    }
    
}

function get_host()
{
    $host = $_SERVER['HTTP_HOST'];
    $host_arr = explode('.', $host );
    if ( $host_arr[0] == '192')
    {
        return $host;
    } else {
        $host_arr[0] = 'www';
        return implode('.', $host_arr);
    }
}

function get_real_money($profit = 0 )
{
    if ( !$profit )
        return $profit;
    
    $profit = $profit * 100;
    $profit = floor($profit);
    $profit = $profit / 100;
    return $profit;
}

function calcAge($birthday) {
    $age = 0;
    if(!empty($birthday)){
        $age = strtotime($birthday);
        if($age === false){
            return 0;
        }

        list($y1,$m1,$d1) = explode("-",date("Y-m-d", $age));

        list($y2,$m2,$d2) = explode("-",date("Y-m-d"), time());

        $age = $y2 - $y1;
        if((int)($m2.$d2) < (int)($m1.$d1)){
            $age -= 1;
        }
    }
    return $age;
}

define('IS_POST',       $_SERVER['REQUEST_METHOD'] =='POST' ? true : false);

?>
