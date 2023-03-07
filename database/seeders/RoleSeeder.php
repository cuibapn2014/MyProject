<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
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
            'ADMIN' => 'Admin',
            'USER_MANAGER' => 'Quản lý',
            'USER' => 'Nhân viên',
            'CUSTOMER' => 'Khách hàng',
            'CEO' => 'Giám đốc',
            'USER_WAREHOUSE' => 'Thủ kho',
            'USER_ACCOUNTING' => 'Kế toán',
            'USER_HR' => 'Quản lý nhân sự'
        ];

        foreach($array_insert as $key => $item){
            DB::table('roles')->insert([
                'name' => $item,
                'alias' => $key
            ]);
        }
    }
}
