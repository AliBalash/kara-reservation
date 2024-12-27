<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Toll;
use App\Models\Car;
use App\Models\Contract;

class TollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Toll::create([
            'car_id' => Car::first()->id, // ارجاع به اولین خودرو
            'contract_id' => Contract::first()->id, // ارجاع به اولین قرارداد
            'amount' => 50.00,
            'location' => 'Toll Plaza 1',
            'toll_date' => now(),
            'is_paid' => false,
        ]);
    }
}
