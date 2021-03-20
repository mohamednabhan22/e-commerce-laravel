<?php

use App\Section;
use Illuminate\Database\Seeder;

class SectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sectionsRecords=[
            ['id'=>1,'name'=>'men','status'=>'1'],
            ['id'=>2,'name'=>'women','status'=>'1'],
            ['id'=>3,'name'=>'kids','status'=>'1'],
        ];

        Section::insert($sectionsRecords);
    }
}
