<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cathectic extends Model
{
    //
    protected $table="cathectic";

   	public function action(){
   		return $this->hasOne('App\Model\action','num');
   	}
}
