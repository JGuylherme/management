<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['name' => 'Admin', 'code' => 'ADM0001'],
            ['name' => 'Manager', 'code' => 'MGR0001'],
            ['name' => 'Tester', 'code' => 'TST0001'],
            ['name' => 'Support', 'code' => 'SUP0001'],
        ];

        DB::table('roles')->insert($roles);
    }
}
