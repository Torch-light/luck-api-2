<?php 

namespace App\Services;
use App\Helps\Utils;
use App\Interfaces\BaseRechargeInterface;
use App\Interfaces\BaseUserInterface;
use App\Interfaces\BaseCashInterface;
use App\Services\EventService;
/**
* 
*/
class RechargeService 
{
	protected $recharge;
	protected $utils;
	protected $user;
	protected $cash;
	protected $event;
	function __construct(BaseRechargeInterface $recharge,
							Utils $utils,
							BaseUserInterface $user,
							EventService $event,
							BaseCashInterface $cash
							)
	{
		$this->recharge=$recharge;
		$this->utils=$utils;
		$this->user=$user;
		$this->event=$event;
		$this->cash=$cash;		
	}

	public function create($obj){
		if(empty($obj)){
			return $this->utils->errorMessage('数据不能为空');
		};
		
		$rechange=$this->recharge->waitingReviewRecharge($obj);
		if($rechange){
			return $this->utils->errorMessage('提交失败,还有待审核充值',$rechange);
		}
		$_user=$this->user->selectFind($obj,'id');
		$arr=array('recharge_type' =>$obj->get('recharge_type'),
					'money'=>$obj->get('money'),
					'id'=>$obj['id'],
					'name'=>$_user['name'],
					'mark_id'=>$_user['mark_id']
		);
		$model=$this->recharge->create($arr);
		return $this->utils->successMessage('提交成功,请等待审核',$model);
		if($model){
				
			$this->event->rechange($model,$arr['mark']);
		 	return $this->utils->successMessage('提交成功,请等待审核',$model);
		}else{
			return $this->utils->errorMessage('提交失败');
		}
	}

	public function find($obj){
		if($obj['type']=='rechange'){
		$model=$this->recharge->find($obj);
		}
		else if($obj['type']=='cash'){
		 $model=$this->cash->getall($obj);
		}
		if(empty($model)){
			return $this->utils->successMessage('无待审核');
		}else{
			return $this->utils->successMessage('获取成功',$model);
		}
	}

	public function update($obj){
		$model=$this->recharge->update($obj);
		if($model){
			$bol=$this->user->updatePoints($obj);
			if($bol){
				$this->event->rechange($bol,$obj['uid']);
				return $this->utils->successMessage('充值成功');
			}
		}else{
			return $this->utils->errorMessage('失败');
		}
	}

	public function getRechange($obj){
		if($obj['role_id']<10){
			
			$model=$this->recharge->getReviewRecharge($obj);
			return $this->utils->successMessage('获取成功',$model);
		}else{
			try{
			$model=$this->recharge->getRechange($obj);
			return $this->utils->successMessage('获取成功',$model);
		}catch(Exception $e){
			return $this->utils->errorMessage('获取失败',false);
		 }
		 }
	}


	public function delChange($obj){

		$model=$this->recharge->delChange($obj);
		if($model){
			 $this->event->delChange(0,0);
			return $this->utils->successMessage('删除成功');
		}else{
			
			return $this->utils->errorMessage('删除失败',false);
		}
	}

	public function updateRecharge($obj){
		
		if($obj['role_id']<10){
			$bol=$this->user->updatePointsV2($obj);
			if($bol){
				$model=$this->recharge->setRecharge($obj);
				// $this->event->recharge($obj,$obj['uid']);
				return $this->utils->successMessage('成功',$model);		
			}
		}else{
			$model=$this->recharge->updateRecharge($obj);	
		if($model){
			$_model=array('message' =>'有用户充值',
							'model'=>$model);
			$this->event->recharge($_model,$model['mark']);
			return $this->utils->successMessage('成功',$model);
		}else{
			
			return $this->utils->errorMessage('失败');
		}
		}
		
	}
}