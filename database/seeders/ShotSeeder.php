<?php

namespace Database\Seeders;

use App\Models\Shot;
use Illuminate\Database\Seeder;

class ShotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Shot::factory(10)->create();
    }
}
