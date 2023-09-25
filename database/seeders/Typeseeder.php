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
            ['name' => 'POST SEM CÓDIGO', 'value' => 'SC'],
            ['name' => 'PHP', 'value' => 'php'],
            ['name' => 'HTML', 'value' => 'html'],
            ['name' => 'JAVA', 'value' => 'java'],
            ['name' => 'CSS', 'value' => 'css'],
            ['name' => 'JAVASCRIPT', 'value' => 'javascript'],
        ];

        DB::table('types')->insert($types);
    }
}
