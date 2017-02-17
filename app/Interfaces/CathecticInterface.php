<?php  
namespace App\Interfaces;

use App\Interfaces\BaseCathecticInterface;
use App\Model\Cathectic;
/**
* 
*/
class CathecticInterface implements BaseCathecticInterface
{
	

	function __construct()
	{
		
		# code...
	}
	public function getModel(){
		return Cathectic::class;

	}

	public function find($obj)
	{
		$dd=$this->getModel();
		if(!empty($obj['stime'])){
			$date=$dd::where([])->limit(10)->orderBy('id','desc')->get();
		}else{
			$date=$dd::orderBy('id','desc')->first();
		}

		return $date;
	}
	public function first(){
		$dd=$this->getModel();
		$date=$dd::orderBy('id','desc')->first();
		return $date;
	}

	public function getHistory($index=1,$size=8){
			$dd=$this->getModel();
			$date=$dd::where([])->orderBy('id','desc')->paginate($size);
		return $date;
	}

	public function count(){
			$dd=$this->getModel();
			$date=$dd::where([])->get()->count();
	}
	public function delete($obj)
	{

	}

	public function update($obj)
	{
		
	}

	public function create($code)
	{
		
	}

	public function getCathectic(){
		$dd=$this->getModel();
		$model=$dd::where([])->orderBy('id','desc')->get(['id','num']);
		return $model;
	}


}