<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitCalSeeder extends Seeder
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
            'm2',
            'm',
            'cái',
            'bộ',
            'cm',
            'mm',
            'cuộn',
            'ống'
        ];

        foreach($array_insert as $item){
            DB::table('unit_calculate')->insert([
                'name' => $item
            ]);
        }
    }
}
