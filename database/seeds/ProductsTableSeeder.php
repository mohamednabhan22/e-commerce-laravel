<?php

use App\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productRecords=[
            ['id'=>1,'category_id'=>2,'section_id'=>1,'product_name'=>'Blue Casual T-shirts','product_code'=>'BT001','product_color'=>'blue',
            'product_price'=>1500,'product_discount'=>10,'product_weight'=>200,'product_video'=>'','main_Image'=>'','description'=>'test product',
            'wash_care'=>'','fabric'=>'','pattern'=>'','sleeve'=>'','fit'=>'','occasion'=>' ','meta_title'=>'','meta_description'=>'','meta_keywords'=>'test product',
            'is_featured'=>'no','status'=>1
        ],
        ['id'=>2,'category_id'=>2,'section_id'=>1,'product_name'=>'Red T-shirts','product_code'=>'VT001','product_color'=>'red',
        'product_price'=>1500,'product_discount'=>10,'product_weight'=>400,'product_video'=>'','main_Image'=>'','description'=>'test product',
        'wash_care'=>'','fabric'=>'','pattern'=>'','sleeve'=>'','fit'=>'','occasion'=>' ','meta_title'=>'','meta_description'=>'','meta_keywords'=>'test product',
        'is_featured'=>'yes','status'=>1
    ],
    ];

    Product::insert( $productRecords);
    }
}
