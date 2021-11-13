<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\mcmOrders;

class McmOrdersFactory extends Factory
{
    protected $model = mcmOrders::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_no' => (string)$this->faker->unique()->numberBetween(1000, 9999),
            'order_date' => $this->faker->date(),
            'order_status' => $this->faker->boolean(90),
            'currency' => $this->faker->currencyCode()
        ];
    }
}
