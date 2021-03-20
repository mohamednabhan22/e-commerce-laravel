<?php

use App\Banner;
use Illuminate\Database\Seeder;

class BannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $BannerRecords=[
            ['id'=>1,'image'=>'banner1.png','link'=>'','title'=>'black jacket','alt'=>'black jacket','status'=>1
        ],
        ['id'=>2,'image'=>'banner2.png','link'=>'','title'=>'half sleeve t-shirt','alt'=>'half sleeve t-shirt','status'=>1
        ]
        ,
        ['id'=>3,'image'=>'banner3.png','link'=>'','title'=>'half sleeve t-shirt','alt'=>'half sleeve t-shirt','status'=>1
    ]
    


      
    ];
    Banner::insert($BannerRecords);
    }
    }

