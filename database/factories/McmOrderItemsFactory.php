<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\mcmOrderItems;
use App\Models\mcmProducts;
use App\Models\mcmOrders;

class McmOrderItemsFactory extends Factory
{
    protected $model = mcmOrderItems::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $pid = mcmProducts::all()->random()->id;
        return [
            'product_id' => $pid,
            'order_id' => mcmOrders::where('order_status', 1)->get()->random()->id,
            'code' => mcmProducts::select('code')->where('id', $pid)->get()[0]->code,
            'currency' => mcmProducts::select('currency')->where('id', $pid)->get()[0]->currency,
            'item_price' => mcmProducts::select('price')->where('id', $pid)->get()[0]->price,
            'quantity_ordered' => $this->faker->numberBetween(1, 20)
        ];
    }
}
