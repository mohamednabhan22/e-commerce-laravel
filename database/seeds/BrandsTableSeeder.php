<?php

use App\Brand;
use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brandRecords=[
            ['id'=>1,'name'=>'arrow','status'=>1
        ],
        ['id'=>2,'name'=>'gap','status'=>1
        ]
        ,
        ['id'=>3,'name'=>'lee','status'=>1
    ],
    ['id'=>4,'name'=>'monte carlo','status'=>1
],

      
    ];
    Brand::insert($brandRecords);
    }
}
