<?php

use App\DeliveryAddress;
use Illuminate\Database\Seeder;

class DeliveryAddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productAttributesRecords=[
            ['id'=>1,'user_id'=>1,'name'=>'meso','address'=>'test','city'=>'city',
            'status'=>1,'state'=>'messo','country'=>'test country','pinCode'=>11001,'mobile'=>0124563652
        ],
        ['id'=>2,'user_id'=>1,'name'=>'meso','address'=>'test','city'=>'city',
            'status'=>1,'state'=>'messo','country'=>'test country','pinCode'=>11001,'mobile'=>0124563652
        ],
      
    ];

    DeliveryAddress::insert( $productAttributesRecords);
    }
}
