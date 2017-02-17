<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Services\ActionService;
class ActionController extends Controller
{
	public $action;
	function __construct(ActionService $action){
		$this->action=$action;
	}
    public function action(Request $request){
    	$model=$this->action->create($request);
    	return $model;
    }

    public function getIndexNum(Request $request){
    	$model=$this->action->getAll($request);
    	return $model;
    }

    public function delaction(Request $request){
        $model=$this->action->delaction($request);
        return $model;
    }
    public function getaction(Request $request){
         $model=$this->action->getaction($request);
        return $model;
    }

    public function event(Request $request){
        $this->action->event();
    
    }

    public function history(Request $request){
        $model=$this->action->history($request);
        return $model;
    }

    public function actionDel(Request $request){
        $model=$this->action->actionDel($request);
        return $model;       
    }

    public function actionHistory(Request $request){
        $model=$this->action->actionHistory($request);
        return $model;         
    }

    public function wait(Request $request){
        $model=$this->action->wait($request);
        return $model;         
    }

    public function updateAction(Request $request){
        $model=$this->action->updateAction($request);
        return $model;         
    }    
}
