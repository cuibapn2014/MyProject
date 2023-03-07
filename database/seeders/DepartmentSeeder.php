<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
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
            'Ban quản lý',
            'Tài chính kế toán',
            'Sản xuất',
            'Nhân sự',
            'Kinh doanh'
        ];

        foreach($array_insert as $item){
            DB::table('departments')->insert([
                'name' => $item
            ]);
        }
    }
}
