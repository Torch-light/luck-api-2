<?php 

namespace App\Services;
use App\Helps\Utils;
use App\Interfaces\BaseCashInterface;
use App\Interfaces\BaseUserInterface;
use App\Services\EventService;

/**
* 
*/
class CashService 
{
	protected $utils;
	protected $cash;
	protected $user;
	protected $event;
	function __construct(BaseCashInterface $cash,
							BaseUserInterface $user,
							EventService $event,
							Utils $utils)
	{
		$this->utils=$utils;
		$this->cash=$cash;	
		$this->user=$user;	
		$this->event=$event;
	}

	public function cash($obj){
		if($obj['role_id']<10){
			$model=$this->reviewcash($obj);
		}else{
			$model=$this->addcash($obj);
		}
		
		return $model;
	}

	public function addcash($obj){
		$cash=$this->cash->getOnlyCash($obj);
		if($cash){
			return $this->utils->errorMessage('还有待审核提现',false);
		}
		$user=$this->user->selectFind($obj,'id');
		if($obj->get('money')>$user->points){
			return $this->utils->errorMessage('余额不足');
		}
		$bol=$this->user->updatePoints($obj,2);
		if($bol){
		$arr=array("name"=>$user->name,
						"mark"=>$user->mark_id,
						"money"=>$obj->get('money'),
						"text"=>$obj->get('text'),
						"number"=>$obj->get('number'),
						"uid"=>$obj['id'],
						);
		$model=$this->cash->addcash($arr);
		
		}else{
			return $this->utils->errorMessage('失败');
		}
		if(empty($model)){
			return $this->utils->errorMessage('获取失败');
		}else{
			$this->event->cash($model,$arr['mark']);
			return $this->utils->successMessage('提现成功',$model);
		}
	}

	public function getCash($obj){

		// return $this->utils->successMessage('成功','$model');	
		if($obj['role_id']<10){
			$model=$this->cash->getall($obj);

		}else{
			if($obj->get('type')==1){
				$model=$this->cash->getOnlyCash($obj,2);
			}else{
				$model=$this->cash->getCash($obj);	
			}
			
		}
		if($model){
			return $this->utils->successMessage('成功',$model);	
		}else{
			return $this->utils->successMessage('失败',false);	
		}
		
		
	}

	public function getOkay($obj){
		$model=$this->cash->getOkay($obj);
		return $this->utils->successMessage('成功',$model);
	}
	public function setCash($obj){

		// return $this->utils->successMessage('成功');
		if($obj['role_id']>2){
			return $this->utils->errorMessage('失败'); 
		}
		

		if($obj['type']==1){
			$model=$this->cash->setcash($obj,2);
		}else{
			$model=$this->cash->setcash($obj,1);
		}
		
		if($model){
		$this->event->cash(true,$obj['userId']);
		if($obj['type']==1){
			
		}else{
			$this->user->updatePoints($obj);	
		}	
		
		return $this->utils->successMessage('成功',$model);
		}else{
		return $this->utils->errorMessage('失败',$model);

		}
		
	}

	public function delcash($obj){
		$model=$this->cash->delcash($obj);
		if(!empty($model)){
			$bol=$this->user->updatePoints($model);
			$this->event->delcash(true,$obj['userId']);
			if($bol){
				return $this->utils->successMessage('删除成功',false);	
			}
		}else{
			return $this->utils->errorMessage('失败',false);
		}
	}
}