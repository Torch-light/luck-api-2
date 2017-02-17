 <?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('cash',function(Blueprint $table){
            $table->bigIncrements('id');
            $table->integer('uid');
            $table->string('number');
            $table->string('name');
            $table->string('text');
            $table->integer('money');
            $table->integer('cashtype');
            $table->integer('mark');
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
