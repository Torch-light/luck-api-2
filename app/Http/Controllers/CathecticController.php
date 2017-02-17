<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Services\CathecticService;

class CathecticController extends Controller
{
    //
    public $cathectic;
    function __construct(CathecticService $cathectic){
    	$this->cathectic=$cathectic;
    }

    public function getPlay(Request $request){
		$model=$this->cathectic->play($request);
		return $model;
    }

    public function history(Request $request){
    	$model=$this->cathectic->history($request);
		return $model;
    }

    public function cathectic(Request $request){
        $model=$this->cathectic->cathectic($request);
        return $model;
    }
}
