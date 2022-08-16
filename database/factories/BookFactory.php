<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'author_id'=>rand(1,10),
            'janre_id'=>rand(1,10),
            'name'=>$this->faker->name(),
            'describtion'=>$this->faker->text(),
            'img'=>$this->faker->image(),
            'file'=>$this->faker->name()
        ];
    }
}
