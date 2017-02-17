<?php 

namespace App\Services;
use App\Helps\Utils;
use App\Interfaces\BaseSystemInterface;

/**
* 
*/
class SystemService 
{
	protected $utils;
	protected $service;
	function __construct(
						 BaseSystemInterface $stysem,
							Utils $utils)
	{
		$this->utils=$utils;
		$this->service=$stysem;		
	}

	public function getAnarchy(){
		$model=$this->service->find();
		$i=date('i');
		$m=5;
		if(date('s')==0){
			$time=($m-(date('i')%$m))*60;
		}else{
			$time=(($m-(date('i')%$m))-1)*60+(60-date('s'));
		}
		if(date('H')==23&&date('i')>=55){
				$time=100000;
			}else if(date('H')<9){
				$time=100000;
		}
		if(empty($model)){
			return $this->utils->errorMessage('失败');
		}else{
			if($model['updateNum']&&$model['updatePOints']){

			}else{
			$arr=array('updateNum'=>$model['updateNum'],
				'updatePoints'=>$model['updatePoints'],
				'time'=>$time);
			}
			return $this->utils->successMessage('成功',$arr);
		}
	}

	public function getTime(){
		$i=date('i');
		$m=5;
		if(date('s')==0){
			$time=($m-(date('i')%$m))*60;
		}else{
			$time=(($m-(date('i')%$m))-1)*60+(60-date('s'));
		}
		if(date('H')==23&&date('i')>=55){
				$time=100000;
			}else if(date('H')<9){
				$time=100000;
		}

		return $time;
	}

}