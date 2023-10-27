<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'=>$this->faker->sentence(2),
            'description'=>$this->faker->sentence(4),
            'image'=>$this->faker->image(),
            'owner_id'=> Usuario::inRandomOrder()->first()->id,
        ];
    }
}
