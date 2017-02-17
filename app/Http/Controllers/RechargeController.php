<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Services\RechargeService;
class RechargeController extends Controller
{
    //
    public $recharge;

    function __construct(RechargeService $recharge){
    	$this->recharge=$recharge;
    }
    public function recharge(Request $request){
    	 $model=$this->recharge->create($request);
    	 return $model;
    }

    public function reviewed(Request $request){
    	$model=$this->recharge->find($request);
    	return $model;
    }
    public function submit(Request $request){
        $model=$this->recharge->update($request);
        return $model;
    }

    public function getRechange(Request $request){
        $model=$this->recharge->getRechange($request);
        return $model;
    }

    public function delete(Request $request){
        $model=$this->recharge->delChange($request);
        return $model;
    }

    public function updateRecharge(Request $request){
         $model=$this->recharge->updateRecharge($request);
        return $model;   
    }
}
