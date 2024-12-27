<?php

namespace Database\Factories;

use App\Models\CarModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarModelFactory extends Factory
{
    protected $model = CarModel::class;

    public function definition(): array
    {
        return [
            'brand' => $this->faker->word, // تولید یک کلمه تصادفی برای برند
            'model' => $this->faker->word, // تولید یک کلمه تصادفی برای مدل
            'engine_capacity' => $this->faker->randomFloat(1, 1.0, 5.0), // تولید حجم موتور بین 1.0 تا 5.0
            'fuel_type' => $this->faker->randomElement(['petrol', 'diesel', 'hybrid', 'electric']),
            'gearbox_type' => $this->faker->randomElement(['manual', 'automatic']),
            'seating_capacity' => $this->faker->numberBetween(2, 7), // ظرفیت سرنشین بین 2 تا 7
        ];
    }
}
