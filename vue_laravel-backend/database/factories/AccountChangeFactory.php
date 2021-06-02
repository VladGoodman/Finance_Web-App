<?php

namespace Database\Factories;

use App\Models\AccountChange;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountChangeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AccountChange::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->randomNumber(),
            'change_id' => $this->faker->randomNumber(),
            'currency_id' => $this->faker->randomNumber(),
            'name_id' => $this->faker->randomNumber(),
            'quantity' => $this->faker->randomNumber(),
            'date'=>$this->faker->dateTime()
        ];
    }
}
