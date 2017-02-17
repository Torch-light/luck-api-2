<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\UserService;
use JWTAuth;
use App\Users;
class UserController extends Controller
{
	public $user;
	public $baseInterface;
    //
    public function __construct (UserService $userService)
    {
    	$this->user=$userService;
      
    }

    public function login(Request $request){
          $model=$this->user->getToken($request);
          return $model;
    }

    public function codeCreate(Request $request){
          $code=$this->user->codeCreate($request);
          return $code;
    }
    public function review(Request $request){
              $review=$this->user->review($request);
          return $review; 
    }
    public function getUsers(Request $request){

        $model=$this->user->getUsers($request);
        return $model;
      
    }
    public function getCode(Request $request){
         $model=$this->user->getCode($request);
          return $model;
       
    }
    public function register(Request $request){
           $model=$this->user->register($request);
          return $model;
        
    }
    public function getAll(Request $request){
           $model=$this->user->getAll($request);
           return $model;
        
    }
    public function seeting(Request $request){
          $model=$this->user->seeting($request);
           return $model;
    }

    public function userManage(Request $request){
        $model=$this->user->userManage($request);
           return $model; 
    }

    public function changePoints(Request $request){
      $model=$this->user->changePoints($request);
           return $model; 
    }

    public function userInfo(Request $request){
      $model=$this->user->userInfo($request);
      return $model;  
    }

    public function updatePoint(Request $request){
      $model=$this->user->updatePoint($request);
      return $model;  
    }
}


