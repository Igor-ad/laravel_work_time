<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MachineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $machines = [
            ['id' => 44],
            ['id' => 56],
            ['id' => 23],
            ['id' => 78],
            ['id' => 102],
        ];

        DB::table('machines')->insert($machines);
    }
}
