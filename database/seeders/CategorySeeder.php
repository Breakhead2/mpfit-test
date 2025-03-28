<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $data = [
            ['name' => 'легкий'],
            ['name' => 'хрупкий'],
            ['name' => 'тяжелый']
        ];

        DB::table('categories')->insert($data);
    }
}
