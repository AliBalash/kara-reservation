<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer; // مدل مربوط به Customer

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // ایجاد داده‌های نمونه برای جدول customers
        Customer::create([
            'first_name' => 'Ali',
            'last_name' => 'Balash',
            'national_code' => '1234567890',
            'gender' => 'male',
            'email' => 'ali@example.com',
            'phone' => '09121234567',
            'address' => 'Tehran, Iran',
            'passport_number' => 'A123456789',
            'passport_expiry_date' => '2025-12-31',
            'nationality' => 'Iranian',
            'license_number' => '987654321',
            'status' => 'active',
            'registration_date' => '2024-12-14',
        ]);

        Customer::create([
            'first_name' => 'Sara',
            'last_name' => 'Rezaei',
            'national_code' => '0987654321',
            'gender' => 'female',
            'email' => 'sara@example.com',
            'phone' => '09121234568',
            'address' => 'Shiraz, Iran',
            'passport_number' => 'B987654321',
            'passport_expiry_date' => '2026-05-10',
            'nationality' => 'Iranian',
            'license_number' => '123456789',
            'status' => 'inactive',
            'registration_date' => '2023-11-20',
        ]);

        // می‌توانید از Faker برای داده‌های تصادفی استفاده کنید:
        \App\Models\Customer::factory(10)->create(); // ایجاد 10 مشتری تصادفی
    }
}
