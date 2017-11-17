<?php
//test.php
//
// Usage on command-line: php test.php <file|textstring>
// Usage on web: 
// 
// 
header("Content-type: text/html; charset=gb2312"); 
error_reporting(E_ALL);



// 
require 'pscws4.class.php';
$cws = new PSCWS4('gbk');
$cws->set_dict('dict/dict.xdb');
$cws->set_rule('etc/rules.ini');
//$cws->set_multi(3);
//$cws->set_ignore(true);
//$cws->set_debug(true);
//$cws->set_duality(true);
$cws->send_text("中小学数学");


while ($tmp = $cws->get_result())
{	

	foreach ($tmp as $w) 
	{
		print_r($w);	
	}

}


$cws->close();
?>