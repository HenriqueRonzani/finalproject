<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Typeseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['name' => 'php'],
            ['name' => 'html'],
            ['name' => 'java'],
            ['name' => 'css'],
            ['name' => 'javascript'],
        ];

        DB::table('types')->insert($types);
    }
}
