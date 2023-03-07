<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StageProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $array_insert = [
            'Cắt',
            'May bán thành phẩm',
            'Hoàn thiện',
            'Là ủi'
        ];

        foreach($array_insert as $item){
            DB::table('stage_products')->insert([
                'name' => $item
            ]);
        }
    }
}
