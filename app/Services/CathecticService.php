<?php 

namespace App\Services;
use App\Helps\Utils;
use App\Interfaces\BaseCathecticInterface;
use App\Interfaces\BaseActionInterface;

/**
* 
*/
class CathecticService 
{
	protected $cathectic;

	function __construct(BaseCathecticInterface $cathectic,
						BaseActionInterface $action,
						Utils $utils
						)
	{
		$this->cathectic=$cathectic;
		$this->utils=$utils;
		$this->action=$action;
			
	}

	public function history($obj){
		
		$data=$this->cathectic->getHistory($obj);
		if(!empty($data)){
			return $this->utils->successMessage('成功',$data);
		}else{
			return $this->utils->errorMessage('失败');
		}

	}

	public function pagging($index=1,$size=10){
		
	}

	public function cathectic($obj){
				if($obj['id']>6){
					return $this->utils->errorMessage('没有权限');			
				}

				$model=$this->cathectic->getCathectic();
				if($model){
					$arr=[];
					foreach ($model as $key) {
							

						$action=$this->action->waitAction($key)->count();
						if($action>0){
							$_arr=array('id'=>$key['id'],
									 'num'=>$key['num'],
									 'count'=>$action);
						array_push($arr,$_arr);	
						}
						
					}
					return $this->utils->successMessage('成功',$arr);		
				}else{
					return $this->utils->errorMessage('失败');		
				}
	}

}