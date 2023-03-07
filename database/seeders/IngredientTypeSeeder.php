<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientTypeSeeder extends Seeder
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
            'Vật tư',
            'Bán thành phẩm',
            'Thành phẩm'
        ];

        foreach($array_insert as $item){
            DB::table('ingredient_types')->insert([
                'name' => $item
            ]);
        }
    }
}
