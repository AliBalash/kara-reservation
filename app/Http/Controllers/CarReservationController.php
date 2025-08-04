<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\ContractCharges;
use App\Models\Customer;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Car;

class CarReservationController extends Controller
{

    public $taxAmount;
    public $dailyRate;

    private $locationCosts = [
        'UAE/Dubai/Clock Tower/Main Branch' => [
            'under_3' => 0,
            'over_3' => 0
        ],
        'UAE/Dubai/Downtown' => [
            'under_3' => 50,
            'over_3' => 50
        ],
        'UAE/Dubai/Dubai Airport/Terminal 1' => [
            'under_3' => 50,
            'over_3' => 0
        ],
        'UAE/Dubai/Dubai Airport/Terminal 2' => [
            'under_3' => 50,
            'over_3' => 0
        ],
        'UAE/Dubai/Dubai Airport/Terminal 3' => [
            'under_3' => 50,
            'over_3' => 0
        ],
        'UAE/Dubai/Jumeirah 1, 2, 3' => [
            'under_3' => 45,
            'over_3' => 45
        ],
        'UAE/Dubai/JBR' => [
            'under_3' => 45,
            'over_3' => 45
        ],
        'UAE/Dubai/Marina' => [
            'under_3' => 45,
            'over_3' => 45
        ],
        'UAE/Dubai/JLT' => [
            'under_3' => 45,
            'over_3' => 45
        ],
        'UAE/Dubai/JVC' => [
            'under_3' => 60,
            'over_3' => 60
        ],
        'UAE/Dubai/Damac Hills' => [
            'under_3' => 60,
            'over_3' => 60
        ],
        'UAE/Dubai/Palm' => [
            'under_3' => 70,
            'over_3' => 70
        ],
        'UAE/Dubai/Jebel Ali – Ibn Battuta – Hatta & more' => [
            'under_3' => 70,
            'over_3' => 70
        ],
        'UAE/Sharjah Airport' => [
            'under_3' => 100,
            'over_3' => 100
        ],
        'UAE/Abu Dhabi Airport' => [
            'under_3' => 200,
            'over_3' => 200
        ]
    ];

    private function getCarDailyRate(Car $car, int $days): float
    {
        if ($days >= 21) {
            return $car->price_per_day_long;
        } elseif ($days >= 7) {
            return $car->price_per_day_mid;
        }

        return $car->price_per_day_short;
    }


    public function reserveCar(Request $request)
    {
        // دریافت اطلاعات ماشین
        $car = Car::findOrFail($request->carId);

        // محاسبه تعداد روزها
        $pickupDate = Carbon::parse($request->pickup_date);
        $returnDate = Carbon::parse($request->return_date);
        $rentalDays = max(1, $pickupDate->diffInDays($returnDate));

        // محاسبه هزینه پایه اجاره ماشین
        $this->dailyRate = $this->getCarDailyRate($car, $rentalDays);
        $basePrice = $this->dailyRate * $rentalDays;
        // لیست کامل خدمات (همانند Livewire component)
        $allServices = [
            'basic_insurance' => [
                'label' => 'بیمه پایه',
                'amount' => 0,
                'per_day' => false
            ],
            'child_seat' => [
                'label' => 'صندلی کودک',
                'amount' => 20,
                'per_day' => true
            ],
            'additional_driver' => [
                'label' => 'راننده اضافه',
                'amount' => 20,
                'per_day' => false
            ],
            'ldw_insurance' => [
                'label' => 'بیمه LDW',
                'amount' => $car->ldw_price,
                'per_day' => true
            ],
            'scdw_insurance' => [
                'label' => 'بیمه کامل',
                'amount' => $car->scdw_price,
                'per_day' => true
            ],
        ];

        // محاسبه هزینه سرویس‌ها
        $selectedServices = $request->selected_services ?? [];
        $insurance = $request->insurance ?? null;

        $allSelected = array_merge($selectedServices, $insurance ? [$insurance] : []);

        $servicesTotal = 0;
        $serviceBreakdown = [];

        foreach ($allSelected as $key) {
            if (!isset($allServices[$key])) continue;

            $svc = $allServices[$key];
            $amount = $svc['per_day'] ? $svc['amount'] * $rentalDays : $svc['amount'];
            $servicesTotal += $amount;
            $serviceBreakdown[] = [
                'key' => $key,
                'label' => $svc['label'],
                'amount' => $amount,
                'per_day' => $svc['per_day'],
                'unit' => $svc['amount']
            ];
        }

        // محاسبه هزینه مکان
        $pickupFee = $this->calculateLocationFee($request->pickup_location, $rentalDays);
        $returnFee = $this->calculateLocationFee($request->return_location, $rentalDays);
        $locationTotal = $pickupFee + $returnFee;


        // جمع کل
        $totalPrice = $basePrice + $servicesTotal + $locationTotal;

        //  tax
        $taxRate = 0.05; // یعنی ۵٪
        $this->taxAmount = round($totalPrice * $taxRate, 2);
        $finalTotalPrice = $totalPrice + $this->taxAmount;

        // ایجاد یا به‌روزرسانی مشتری
        $customer = Customer::updateOrCreate(
            ['email' => $request->email],
            [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'messenger_phone' => $request->messenger_phone,
                'registration_date' => now(),
                'status' => 'active',
            ]
        );

        // ثبت قرارداد
        $contract = Contract::create([
            'customer_id' => $customer->id,
            'car_id' => $car->id,
            'pickup_date' => $pickupDate,
            'return_date' => $returnDate,
            'pickup_location' => $request->pickup_location,
            'return_location' => $request->return_location,
            'total_price' => $finalTotalPrice, // قیمت نهایی با مالیات
            'current_status' => 'pending',
        ]);

        // ثبت ریز هزینه‌ها
        $this->createContractCharges($contract, $basePrice, $serviceBreakdown, $pickupFee, $returnFee, $rentalDays);

        return response()->noContent();
    }


    // تابع کمکی برای محاسبه هزینه مکان
    private function calculateLocationFee($location, $rentalDays)
    {
        $feeType = ($rentalDays < 3) ? 'under_3' : 'over_3';

        return isset($this->locationCosts[$location][$feeType])
            ? $this->locationCosts[$location][$feeType]
            : 0;
    }

    // تابع ثبت هزینه‌ها در جدول contract_charges
    private function createContractCharges($contract, $basePrice, $serviceBreakdown, $pickupFee, $returnFee, $rentalDays)
    {
        ContractCharges::create([
            'contract_id' => $contract->id,
            'title' => 'هزینه پایه اجاره',
            'amount' => $basePrice,
            'type' => 'base',
            'description' => "{$rentalDays} روز × {$this->dailyRate} درهم"
        ]);

        foreach ($serviceBreakdown as $svc) {
            ContractCharges::create([
                'contract_id' => $contract->id,
                'title' => $svc['label'],
                'amount' => $svc['amount'],
                'type' => 'addon',
                'description' => $svc['per_day']
                    ? "{$rentalDays} روز × {$svc['unit']} درهم"
                    : 'یک‌بار هزینه'
            ]);
        }

        if ($pickupFee > 0) {
            ContractCharges::create([
                'contract_id' => $contract->id,
                'title' => 'هزینه مکان تحویل',
                'amount' => $pickupFee,
                'type' => 'location_fee',
                'description' => $contract->pickup_location
            ]);
        }

        if ($returnFee > 0) {
            ContractCharges::create([
                'contract_id' => $contract->id,
                'title' => 'هزینه مکان بازگشت',
                'amount' => $returnFee,
                'type' => 'location_fee',
                'description' => $contract->return_location
            ]);
        }

        if ($this->taxAmount > 0) {
            ContractCharges::create([
                'contract_id' => $contract->id,
                'title' => 'مالیات',
                'amount' => $this->taxAmount,
                'type' => 'tax',
                'description' => '۵٪ مالیات بر ارزش افزوده'
            ]);
        }
    }
}
