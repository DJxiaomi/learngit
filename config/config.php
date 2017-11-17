<?php return array (
  'logs' => 
  array (
    'path' => 'backup/logs',
    'type' => 'file',
  ),
  'DB' => 
  array (
    'type' => 'mysqli',
    'tablePre' => 'iwebshop_',
    'read' => 
    array (
      0 => 
      array (
      'host' => 'localhost:3306',
      'user' => 'root',
      'passwd' => '6317284',
      'name' => 'lelele999-139',
      ),
    ),
    'write' => 
    array (
      'host' => 'localhost:3306',
      'user' => 'root',
      'passwd' => '6317284',
      'name' => 'lelele999-139',
    ),
  ),
  'interceptor' => 
  array (
    0 => 'themeroute@onCreateController',
    1 => 'layoutroute@onCreateView',
    2 => 'plugin',
  ),
  'langPath' => 'language',
  'viewPath' => 'views',
  'skinPath' => 'skin',
  'classes' => 'classes.*',
  'rewriteRule' => 'pathinfo',
  'theme' => 
  array (
    'pc' => 
    array (
      'default' => 'default',
      'sysdefault' => 'green',
      'sysseller' => 'green',
    ),
    'mobile' => 
    array (
      'mobile' => 'blue',
      'msysdefault' => 'blue',
      'msysseller' => 'blue',
    ),
  ),
  'timezone' => 'Etc/GMT-8',
  'upload' => 'upload',
  'dbbackup' => 'backup/database',
  'safe' => 'cookie',
  'lang' => 'zh_sc',
  'debug' => '0',
  'configExt' => 
  array (
    'site_config' => 'config/site_config.php',
  ),
  'encryptKey' => '76a7276cb2cda8b84668925604db1310',
  'authorizeCode' => '',
  
)?>