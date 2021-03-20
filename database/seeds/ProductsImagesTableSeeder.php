<?php

use App\ProductsImage;
use Illuminate\Database\Seeder;

class ProductsImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productsImageRecords=[
            ['id'=>1,'product_id'=>2,'image'=>1,'image'=>'plain-t-shirt-500x500.png-6351.png','status'=>1
        ]
      
    ];

    ProductsImage::insert( $productsImageRecords);
    
    }
}
