<?php

use Illuminate\Database\Seeder;

class system extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
            public function run()
    {
        DB::table('system')->insert([
            'id' => 0,
            'updateNum' =>0,
            'updatePoints' => 0,
        ]);
    }
    }
}
