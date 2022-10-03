<?php

namespace Database\Seeders;

use App\Models\React;
use Illuminate\Database\Seeder;

class ReactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        React::factory(10)->create();

    }
}
