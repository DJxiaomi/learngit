<?php


require 'pscws4.class.php';
$cws = new PSCWS4('gbk');
$cws->set_dict('dict/dict.xdb');
$cws->set_rule('etc/rules.ini');

$cws->send_text('高中数学俱乐部');
while ($tmp = $cws->get_result())
{	
	foreach ($tmp as $w) 
	{
		print_r($w);
	}

}

?>