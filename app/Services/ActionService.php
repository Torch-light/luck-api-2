<?php 

namespace App\Services;
use App\Helps\Utils;
use App\Interfaces\BaseActionInterface;
use App\Interfaces\BaseUserInterface;
use App\Interfaces\BaseCathecticInterface;
use App\Services\EventService;
use App\Services\SystemService;
use App\Interfaces\BaseSystemInterface;
/**
* 
*/
class ActionService 
{
	protected $action;
	protected $utils;
	protected $user;
	function __construct(BaseActionInterface $action,
						 BaseUserInterface $user,
							EventService $event,	
							Utils $utils,
							SystemService $systemService,
							BaseCathecticInterface $cathecitc,
							BaseSystemInterface $system)
	{
		$this->action=$action;
		$this->utils=$utils;
		$this->user=$user;	
		$this->event=$event;
		$this->system=$system;
		$this->cathecitc=$cathecitc;
		$this->systemService=$systemService;
	}

	public function create($obj){

		if(empty($obj)){
			return $this->utils->errorMessage('数据不能为空');
		};
		$point=$this->user->deductPoints($obj);
		if(!$point){
			return $this->utils->errorMessage('积分不足');
		}

		$model=$this->action->create($obj);
		if($model&&$point){

			// $this->event->broadcast($obj);
			$arr=array('id' => $model['id'],
						'name'=>$model['name'],
						'multiple'=>$model['multiple'],
						'action'=>$model['action']);
		 	return $this->utils->successMessage('下注成功',$arr);
		}else{
			return $this->utils->errorMessage('下注失败');
		}
	}
	public function getAll($obj){
		if(empty($obj)){
			return false;
		}
		$ac=$this->action->getAll($obj);
		return $this->utils->successMessage('成功',$ac);
	}

	public function delaction($obj){
		if(empty($obj)){
			return false;
		}
		$data=$this->action->find($obj['num']);
		$arr=array('uid'=>$obj['id'],'money'=>$data['money']);
		$bol=$this->user->updatePoints($arr);
		if($bol){
			$this->action->delaction($obj);
		 return $this->utils->successMessage('删除成功',$bol);
		}else{
			 return $this->utils->errorMessage('删除失败',$del);
		}
	}

	public function actionDel($obj){
		if(empty($obj)){
			return false;
		}
		$data=$this->action->find($obj->get('id'));
		$arr=array('username'=>$obj['name'],'point'=>$data['money']);
		$bol=$this->user->updatePointsV2($arr);
		if($bol){
			$obj=$this->action->delaction($obj);
			
		 return $this->utils->successMessage('删除成功',$obj);
		}else{
			 return $this->utils->errorMessage('删除失败',$del);
		}	
	}

	public function getaction($obj){
		$data=$this->action->getaction($obj);
		return $this->utils->successMessage('成功',$data);	
	}

	public function event(){
		     
	}


	public function history($obj){
		// $arr=[];
		$time=$this->systemService->getTime();
		$system=$this->system->find();
		// array_push($arr,$system);
		$cathe=$this->cathecitc->first();
		// array_push($arr,$cathe);
		$_arr=array('id' =>$obj['id'],
					'cathe_id' =>$cathe['id'],
					'name'=>$obj['name']);
		$action=$this->action->getactionv1($_arr);
		// array_push($arr,$action);
		$arr=array(	'time'=>$time,
					'system'=>$system,
					'cathe'=>$cathe,
					'action'=>$action);
		 if(empty($arr)){
		 	return $this->utils->errorMessage('获取数据失败');
		 }else{
			return $this->utils->successMessage('获取数据成功',$arr);
		 }
	}


	public function actionHistory($obj){
		// return $this->utils->successMessage('获取数据成功');
		$user=$this->user->findId($obj['id']);

		$arr=array("sTime"=>$obj["sTime"],
					"eTime"=>$obj["eTime"],
					"name"=>$user["name"]);
		$model=$this->action->dayHistory($arr);
		return $this->utils->successMessage('获取数据成功',$model);
	}

	public function wait($obj){
			if($obj['role_id']>5){
				return $this->utils->errorMessage('没有权限');
			}
			
			$arr=array('id'=>$obj['cathe_id']);
		$wait=$this->action->waitAction($arr);
		if($wait){

		return $this->utils->successMessage('获取数据成功',$wait);
		}else{
			return $this->utils->errorMessage('获取数据失败');
		}
	}

	public function updateAction($obj){
			if($obj['role_id']>5){
				return $this->utils->errorMessage('没有权限');	
			}
			$model=$this->action->update($obj);
			if($model){
				if($obj['type']){
					$point=$model['money']*$model['multiple'];
					$arr=array('username'=>$model['name'],
								'point'=>$point);
					$user=$this->user->updatePointsV2($arr);
					$_model=$model['id'];
					if($user){
						return $this->utils->successMessage('修改成功积分',$_model);			
					}else{
						return $this->utils->errorMessage('修改积分失败',false);		
					}
				}
				
			}else{
				return $this->utils->successMessage('修改失败',false);	
			}
	}
}