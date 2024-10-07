<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('positions')->insert([
            ['title' => 'Manager'],
            ['title' => 'Developer'],
            ['title' => 'Designer'],
            ['title' => 'Analyst'],
            ['title' => 'Tester'],
        ]);
    }
}
