<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();
        $adminRecords=[
            ['id'=>1,'name'=>'admin','type'=>'admin','mobile'=>'98565312453','email'=>'admin@admin.com',
            'password'=>'','image'=>'','status'=>1,
        ],
    ];
    DB::table('admins')->insert($adminRecords);
    // foreach($adminRecords as $key=> $record){
    //     \App\Admin::create($record);
    // }
    }
}
