<?php

namespace Database\Factories;

use App\Models\Trademark;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TrademarkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Trademark::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->randomElement(['Hombre', 'Mujer', 'Hogar', 'Niño', 'Accesorios', 'Zapatos']),
            'code' => Str::random(10)
        ];
    }
}
