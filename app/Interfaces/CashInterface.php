<?php  
namespace App\Interfaces;

use App\Interfaces\BaseCashInterface;
use App\Model\Cash;
/**
* 
*/
class CashInterface implements BaseCashInterface
{
	

	function __construct()
	{
		
		# code...
	}
	public function getModel(){
		return Cash::class;

	}

	public function addcash($obj)
	{
		
		$data=$this->getModel()::create(['uid'=>$obj['uid'],
									'mark'=>$obj['mark'],
									'money'=>$obj['money'],
									'number'=>$obj['number'],
									'text'=>$obj['text'],
									'state'=>0,
									'name'=>$obj['name']
									]);
		return $data;
	}

	public function delete($obj)
	{

	}

	public function update($obj)
	{
		
	}

	public function getOnlyCash($obj,$type=1){
		if($type==1){

			$model=$this->getModel()::where(['uid'=>$obj['id'],'deleted_at'=>NULL,'state'=>0])
		->orderBy('created_at','desc')->get(['id','uid','state','money','text','created_at','number','name'])->first();	
		}else{
			$model=$this->getModel()::where(['uid'=>$obj['id'],'deleted_at'=>NULL])
		->orderBy('created_at','desc')->get(['id','uid','state','money','text','created_at','number','name'])->first();
		}
		
		return $model;
	}

	public function getCash($obj){
		$model=$this->getModel()::where(['uid'=>$obj['id'],'deleted_at'=>NULL])
		->orderBy('created_at','desc')->get(['id','uid','state','money','text','created_at','number','name']);
		return $model;
	}

	public function getall($obj)
	{
		
		$data=$this->getModel()::where(['deleted_at'=>NUll,'state'=>0,'mark'=>$obj['id']])->orderBy('created_at','desc')->get(['id','uid','state','money','text','created_at','number','name']);	
		return $data;
	}

	public function getReview($obj){
		$data=$this->getModel()::where(['mark'=>$obj['id'],'deleted_at'=>NUll,'state'=>0])->get()->count();	
		return $data;	
	}
	public function setcash($obj,$type){
			
			$model=$this->getModel()::find($obj->get('cashId'));
			$model->state=$type;
			return $model->save();
	}

	public function delcash($obj){
		$model=$this->getModel()::find($obj['cashId']);
		$model->deleted_at=date("Y-m-d H:i:s");
		if($model->save()){
			return $model; 
		}else{
			return false;
		}
	}

	public function getOkay($obj){
			$data=$this->getModel()::where(['uid'=>$obj['userid'],'deleted_at'=>NUll])->orderBy('created_at','desc')->get(['name','number','id','created_at','cashtype','mark','money','uid','ispass','updated_at']);	
			return $data; 

	}

}