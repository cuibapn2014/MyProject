<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QualitySeeder extends Seeder
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
            'Thấp',
            'Bình thường',
            'Cao'
        ];

        foreach($array_insert as $item){
            DB::table('qualities')->insert([
                'Ten' => $item
            ]);
        }
    }
}
