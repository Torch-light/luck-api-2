<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CashService;
class CashController extends Controller
{
	public $cash;
	function __construct(CashService $cash){
		 $this->cash=$cash;
	}
    public function cash(Request $request){
    	$model=$this->cash->cash($request);
    	return $model;
    }

    // public function getcash(Request $requset){
    //     $model=$this->cash->getcash($requset);
    //     return $model;
    // }
    public function updateCash(Request $requset){
        
        $model=$this->cash->setCash($requset);
        return $model;
    }
    public function setcash(Request $requset){
        $model=$this->cash->setcash($requset);
        return $model;
    }  

    public function delcash(Request $requset){
       $model=$this->cash->delcash($requset);
        return $model; 
    }

    public function getOkay(Request $requset){
         $model=$this->cash->getOkay($requset);
        return $model;    
    }

    public function getCash(Request $requset){
        $model=$this->cash->getCash($requset);
        return $model;    
    }
}
