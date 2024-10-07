<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
class NationalitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('nationalities')->insert([
            ['name' => 'Egytain'],
            ['name' => 'Canadian'],
            ['name' => 'British'],
            ['name' => 'Australian'],
            ['name' => 'Indian'],
        ]);
    }
}
