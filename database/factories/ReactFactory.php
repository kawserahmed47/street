<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ReactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    public $react_types = ['like', 'love', 'angry', 'sad', 'wow', 'cry'];
    public function definition()
    {
        return [
            'user_id' => rand(1, 10),
            'shot_id' => rand(1, 10),
            'react' => $this->react_types[rand(0, 4)],
        ];
    }
}
