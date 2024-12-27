<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fine;
use App\Models\Contract;

class FineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Fine::create([
            'contract_id' => Contract::first()->id, // ارجاع به اولین قرارداد
            'amount' => 100.00,
            'description' => 'Speeding violation',
            'fine_date' => now(),
            'is_paid' => false,
        ]);
    }
}
