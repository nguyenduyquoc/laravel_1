<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name"=>$this->faker->colorName,
            "thumbnail"=>$this->faker->imageUrl,
            "price"=> random_int(100,1000),
            "quantity"=>random_int(1,10),
            "description"=>$this->faker->realText(),
            "unit"=>"Item",
            // status
            "category_id"=>random_int(1,100)
        ];
    }
}
