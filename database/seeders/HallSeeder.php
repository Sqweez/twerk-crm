<?php

namespace Database\Seeders;

use App\Models\Club;
use App\Models\Hall;
use Illuminate\Database\Seeder;

class HallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Hall::updateOrCreate(['id' => 1], ['name' => 'Большой зал']);
        Hall::updateOrCreate(['id' => 2], ['name' => 'Малый зал']);
    }
}
