<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $workers = [
            ['name' => 'Андрей'],
            ['name' => 'Сергей'],
            ['name' => 'Михаил'],
            ['name' => 'Стас'],
            ['name' => 'Артем'],
            ['name' => 'Татьяна'],
            ['name' => 'Евгений'],
            ['name' => 'Катя'],
            ['name' => 'Борис'],
        ];

        DB::table('workers')->insert($workers);
    }
}
