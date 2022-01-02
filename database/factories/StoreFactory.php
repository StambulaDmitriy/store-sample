<?php

namespace Database\Factories;

use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Store::class;


    public function definition()
    {
        $shop_number = $this->faker->randomNumber(3, true);

        $from = $this->faker->time('H');
        $to = $this->faker->time('H');
        $schedule = "ПН-ВС с {$from}:00 до {$to}:00";

        return [
            'name' => "Магазин №{$shop_number}",
            'address' => $this->faker->address(),
            'schedule' => $schedule,
            'phone' => $this->faker->e164PhoneNumber(),
            'coordinate_lat' => $this->faker->latitude(47,48),
            'coordinate_long' => $this->faker->longitude(37,38),
        ];
    }
}
