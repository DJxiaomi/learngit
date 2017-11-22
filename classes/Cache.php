<?php

/**
 *  file Cache 20171105
 */

class Cache {
	private $basePth;
	function  Cache ($basePth='cache'){
		$this->basePth =$basePth;
	}
	function  setCache ($key,$con){
		$path=$this->get_Path ($key);
		return file_put_contents($path,$con);
	}
	//参数 time 表示cache的存活期，单位 秒,默认无限期
	
	function  getCache ($key,$time=0){
		$path=$this->get_Path ($key);
		if (!is_file($path))return false;
		if ($time && filemtime($path)+$time<time()){
			//过期删除
			unlink($path);
			return false;
		}
		return file_get_contents($path);
	}
	
	private function  get_Path ($key){
		$key=md5($key);
		$keyDir=$this->basePth .'/'.substr($key,0,1).'/'.substr($key,1,1).'/';
		$this->mkdirs ($keyDir);
		return $keyDir.$key;
	}
	
	//创造指定的多级路径
	//参数 要创建的路径 文件夹的权限
	//返回值 布尔值
	private function  mkdirs ($dir,$mode=0755){
		if (is_dir($dir) || @mkdir($dir,$mode))return true;
		if (!$this->mkdirs (dirname($dir),$mode))return false;
		return @mkdir($dir,$mode);
	}
}
/*
       $hj = new Cache();
         echo $hj->setCache('123','xxxxxx').'<br/>';
         echo $hj->getCache('123',10);
         */
?>