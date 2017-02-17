<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatRechargeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
          Schema::create('recharge',function(Blueprint $table){
            $table->bigIncrements('id')->comment('id');
            $table->integer('uid')->comment('充值用户id');
            $table->string('name')->comment('充值用户');
            $table->string('mark')->comment('充值用户邀请人id');
            $table->integer('money')->comment('充值金额');
            $table->boolean('ispass')->comment('是否通过');
            $table->boolean('recharge_type')->comment('充值方式0微信1支付宝');
            $table->boolean('state')->default(0)->comment('当前状态，用户是否已经确认');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
