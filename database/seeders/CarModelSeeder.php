<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CarModel; // مدل مربوط به CarModel

class CarModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // ایجاد داده‌های نمونه برای جدول car_models
        CarModel::create([
            'brand' => 'Toyota',
            'model' => 'Corolla',
            'engine_capacity' => 1.8,
            'fuel_type' => 'petrol',
            'gearbox_type' => 'automatic',
            'seating_capacity' => 5,
        ]);

        CarModel::create([
            'brand' => 'Honda',
            'model' => 'Civic',
            'engine_capacity' => 1.6,
            'fuel_type' => 'diesel',
            'gearbox_type' => 'manual',
            'seating_capacity' => 5,
        ]);

        // می‌توانید از Faker برای داده‌های تصادفی استفاده کنید:
        \App\Models\CarModel::factory(10)->create(); // ایجاد 10 مدل خودروی تصادفی
    }
}
