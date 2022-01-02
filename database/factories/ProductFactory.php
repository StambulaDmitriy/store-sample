<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Product::class;

    public function definition()
    {
        $name = $this->faker->words($this->faker->numberBetween(1,5), true);
        $name = Str::ucfirst($name);
        return [
            'name' => $name,
            'vendor_code' => $this->faker->numerify("####-####"),
            'description' => $this->faker->paragraphs(3, true),
            'price_in_pennies' => $this->faker->numberBetween(99,1000000),
        ];
    }
}
