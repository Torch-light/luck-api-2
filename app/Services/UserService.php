<?php  
namespace App\Services;
use App\Interfaces\BaseUserInterface;
use App\Interfaces\BaseCodeInterface;
use App\Interfaces\BaseCashInterface;
use App\Interfaces\BaseRechargeInterface;
use App\Helps\Utils;
use JWTAuth;
use Illuminate\Support\Facades\Redis;
use Tymon\JWTAuth\Exceptions\JWTException;
use Crypt;
/**
 * 
* 
*/
class UserService
{
	private $user; 
	private $message;
	private $register;
	 function __construct(BaseUserInterface $user,
	 					  BaseCodeInterface $code,
	 					  BaseCashInterface $cash,
	 					  BaseRechargeInterface $recharge,
	 						Utils $message)
	{
		
		$this->user=$user;
		$this->code=$code;
		$this->cash=$cash;
		$this->recharge=$recharge;
		$this->message=$message;
	}

	public  function getToken($obj){
		$name=$obj->get('username');
		$password=$obj->get('password');
		$model=$this->user->find($obj);
		if(empty($model)){
			return $this->message->errorMessage("用户名不存在");
		};
		try 
			{ 
			if($password==Crypt::decrypt($model->password)){
							$res['Token'] = JWTAuth::fromUser($model);
							$res['RoleId']=$model->role_id;
							$res['UserName']=$model->name;
							$res['Id']=$model->id;
							$res['Point']=$model->points;
							$res['Mark']=$model->mark_id;
							$res['Img']="www/www/www";
							$res['Delete']=$model->isdelete;
							return $this->message->successMessage("登录成功",$res);
					}else{
							return $this->message->errorMessage("密码错误");
					}
				} 
			catch(Exception $e) 
			{
				echo json_encode($e);
			 }
		
	}	
	

	public  function codeCreate($obj){
		
		if($obj->get('roleId')>2){

			return "你没有权限";
		};

		
		$model=$this->user->find($obj);	
		$code=$this->message->createCode(6,20);	

		$bol=$this->code->create($code,$obj);
		if($bol){
			return $this->message->successMessage('创建成功',$code);
		};
	}	

	public function getUsers($obj){
		if(empty($obj['type'])){

		$model=$this->user->getUsers($obj);
		}else{
		$model=$this->user->getUsers($obj,2);

		}
		if(!empty($model)){
			return $this->message->successMessage('成功',$model);
		};
	}
	public function getCode($obj){
		$model=$this->code->getCode($obj);
			return $this->message->successMessage('成功',$model);
		
	}

	public function register($obj){
		$user=$this->user->find($obj);
		$code=$this->code->getOnceCode($obj);
		
		if(empty($code)){
			return $this->message->errorMessage('验证码无效'); 
		};
		if(!empty($user)){
			return $this->message->errorMessage('注册失败,该用户名已经存在'); 
		};
		$model=$this->user->register($obj,$code);
		if($model){
			 $this->code->setOnceCode($code);
			 	$res['Token'] = JWTAuth::fromUser($model);
							$res['RoleId']=$model->role_id;
							$res['UserName']=$model->name;
							$res['Id']=$model->id;
							$res['Point']=$model->points;
							$res['Mark']=$model->mark_id;
							$res['Img']="www/www/www";
							$res['Delete']=$model->deleted_at;
							return $this->message->successMessage("登录成功",$res);
		}else{
			return $this->message->errorMessage('注册失败');
		};
	}
	
	public function deductPoints($obj){
		if(!empty($obj)){
			$model=$this->user->deductPoints($obj);
		}
		if(!$model){
			return $this->message->errorMessage('下注失败');
		}else{
			return $model;
		}
	}

	public function review($obj){
		if($obj['role_id']>2){
			return $this->message->errorMessage('没有权限'); 
		}

		$_i=$this->cash->getReview($obj);
		$_j=$this->recharge->getReview($obj);
		$arr=array('reviewCash' =>$_i ,
		'reviewRecharge' =>$_j  );
		return $this->message->successMessage('获取成功',$arr);
	}

	public function getAll($obj){
		$model=$this->user->getAll($obj);
		if($model){
			 return $this->message->successMessage('获取成功',$model);
		}else{
			return $this->message->errorMessage('获取失败');
		}

	}

	public function seeting($obj){
		$role_id=$obj['role_id'];
		if($role_id>1){
			return $this->message->errorMessage('没有权限');
		}
		$model=$this->user->settingUser($obj);
		if($model){
			 return $this->message->successMessage('设置成功',$model);
		}else{
			return $this->message->errorMessage('设置失败');
		}
	}

	public function changePoints($obj){
		$role_id=$obj['role_id'];
		if($role_id>2){
			return $this->message->errorMessage('没有权限');
		}else{
			$model=$this->user->changePoints($obj);
		}
		if(!empty($model)){

		return $this->message->successMessage('更改积分成功',$model);
		}
	}

	public function userInfo($obj){

			if($obj['uid']){
				$model=$this->user->findId($obj['uid']);
			}else{
						if($obj['role_id']<2){
							$model=$this->user->findAll();
						}else{
							$model=$this->user->onceData($obj['id'],'points');
								return $this->message->successMessage('成功',$model);
						}				
			}
			if($model){
				return $this->message->successMessage('获取成功',$model);
			}else{
				return $this->message->errorMessage('获取失败');
			}
	}

	public function updatePoint($obj){
		if($obj['id']<10){
			$model=$this->user->changePoints($obj);
			if($model){
				return $this->message->successMessage('获取成功',$model['points']);
			}else{
				return $this->message->errorMessage('获取失败');	
			}

		}else{
			return $this->message->errorMessage('没有权限');
		}
	}
}