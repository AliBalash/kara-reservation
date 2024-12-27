<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contract;
use App\Models\User;
use App\Models\Customer;
use App\Models\Car;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Contract::create([
            'user_id' => User::first()->id, // ارجاع به اولین کاربر
            'customer_id' => Customer::first()->id, // ارجاع به اولین مشتری
            'car_id' => Car::first()->id, // ارجاع به اولین خودرو
            'start_date' => now(),
            'end_date' => now()->addDays(7),
            'total_price' => 700.00,
            'status' => 'active',
            'notes' => 'First contract',
        ]);
    }
}
