<?php

use App\Coupon;
use Illuminate\Database\Seeder;

class CouponsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $couponRecords=[
            ['id'=>1,'coupon_option'=>'manual','coupon_code'=>'test10','categories'=>'1,2',
            'users'=>'medo11@gmail.com,medo12@gmail.com,medo13@gmail.com','coupon_type'=>'single',
            
            'amount_type'=>'percentage','amount'=>10,'expiry_date'=>'2021-9-4','status'=>1]
        ];
        Coupon::insert($couponRecords);
    }
}
