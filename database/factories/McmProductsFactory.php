<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\mcmProducts;

class McmProductsFactory extends Factory
{
    protected $model = mcmProducts::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $MRP = $this->faker->randomFloat(2, 500, 10000);
        return [
            'code' => $this->faker->unique()->bothify('??##?###'),
            'currency' => $this->faker->currencyCode(),
            'mrp' => $MRP,
            'price' => $MRP + $MRP*0.1
        ];
    }
}
