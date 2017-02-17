<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
// Route::any('/user', function (Request $request) {
//     header("Access-Control-Allow-Origin: *");
//     header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
//     header("Access-Control-Allow-Headers: content-type,authorization");
//     return [$request->user()];
// })->middleware('auth:api');
$api = app('api.router');
$api->version('v1', ['namespace'=>'App\Http\Controllers','middleware' => 'cors'], function ($api) {
		$api->post('/login','UserController@login');
		$api->post('/register','UserController@register');
		$api->get('/history','CathecticController@history');
		// $api->get('/event','ActionController@event');
		$api->group(['middleware' =>'auth'],function($api){
			$api->post('/code','UserController@codeCreate');
			$api->get('/user/{uid?}/{type?}','UserController@userInfo');
			$api->get('/recharge/history/{type?}','RechargeController@getRechange');
			$api->post('/recharge','RechargeController@recharge');
			$api->post('/update/recharge','RechargeController@updateRecharge');
			$api->post('/update/point','UserController@updatePoint');
			$api->post('/cash','CashController@cash');
			$api->post('/update/cash','CashController@updateCash');
			$api->get('/getcode','UserController@getCode');
			$api->get('/cash/history/{type?}','CashController@getCash');
			$api->get('/review','UserController@review');
			$api->get('/actionhistory','ActionController@actionHistory');
			$api->get('/action/history','ActionController@history');
			$api->get('/cathectic','CathecticController@cathectic');
			$api->post('/action','ActionController@action');
			$api->post('update/action','ActionController@updateAction');
			$api->get('/action/wait','ActionController@wait');
			$api->post('/action/delete','ActionController@actionDel');



			
			// $api->post('/addcode','UserController@addcode');
			// $api->post('/addbets','ActionController@action');
			
			// $api->get('/reviewed','RechargeController@reviewed');
			// $api->post('/submit','RechargeController@submit');
			// $api->get('/users','UserController@getUsers');
			
			// $api->get('/getHistory','CathecticController@getPlay');
			// $api->get('/getAnarchy','SystemController@getAnarchy');
			// $api->get('/getNum','ActionController@getIndexNum');
			// $api->get('/allusers','UserController@getAll');
			// $api->post('/seeting','UserController@seeting');
			// $api->post('/delaction','ActionController@delaction');
			// $api->get('/action','ActionController@getaction');
			
			// $api->get('/getcash','CashController@getcash');
			// $api->get('/getOkay','CashController@getOkay');
			// $api->post('/setcash','CashController@setcash');
			// $api->get('/getRechange','RechargeController@getRechange');
			// $api->post('/delChange','RechargeController@delChange');
			// $api->post('/delCash','CashController@delcash');
			// $api->post('/changePoints','UserController@changePoints');
			// // $api->post('/userManage','UserController@userManage');
			

		});
});

