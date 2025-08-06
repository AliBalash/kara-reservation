<?php

namespace App\Livewire\Reservation;

use App\Models\Car;
use App\Models\CarModel;
use Carbon\Carbon;
use Livewire\Component;

class ReserveCarForm extends Component
{


    public $selectedBrand = '';
    public $cars = [];
    public $first_name;
    public $last_name;
    public $pickup_date;
    public $return_date;
    public $email;
    public $phone;
    public $messenger_phone;
    public $selectedCar = null; // ID of the selected car
    public $pickup_location;
    public $return_location;
    public $rental_days = 1;


    // public $confirm_deposit = false;
    public $accept_terms = false;
    public $total_payment;
    public $selected_services = ['basic_insurance'];
    public $selected_insurance = null;
    public $services_total = 0;


    public $services = [
        'basic_insurance' => [
            'label'   => 'بیمه پایه',
            'icon'    => 'fa-shield-halved',
            'amount'  => 0,       // رایگان
            'per_day' => false,   // یک‌بار اضافه شود
        ],
        'child_seat' => [
            'label'   => 'صندلی کودک',
            'icon'    => 'fa-baby',
            'amount'  => 20,      // ۲۰ درهم در روز
            'per_day' => true,
        ],
        'additional_driver' => [
            'label'   => 'راننده اضافه',
            'icon'    => 'fa-user-plus',
            'amount'  => 20,
            'per_day' => false,
        ],
    ];

    public function getAllServicesProperty()
    {
        $all = $this->services;

        if ($this->selectedCar) {
            $all['ldw_insurance']['amount']  = $this->selectedCar->ldw_price;
            $all['scdw_insurance']['amount'] = $this->selectedCar->scdw_price;
        }

        return $all;
    }


    // پراپرتی نهاییِ پرداخت
    public function getTotalPaymentProperty()
    {
        if ($this->selectedCar && $this->rental_days) {
            $dailyRate = $this->getCarDailyRate($this->selectedCar, $this->rental_days);
            $base_rental_cost = $dailyRate * $this->rental_days;
        }
        return ($base_rental_cost ?? 0)
            + $this->services_total
            + $this->transfer_costs['total'];
    }

    // جمع هزینه‌ی خدمات و بیمه‌ی انحصاری
    public function calculateServicesTotal()
    {
        $days  = $this->rental_days ?: 1;
        $total = 0;

        // جمع سایر سرویس‌ها (checkboxها)
        foreach ($this->selected_services as $svcId) {
            $svc = $this->allServices[$svcId] ?? null;
            if (! $svc) continue;
            $total += $svc['per_day'] ? $svc['amount'] * $days : $svc['amount'];
        }

        // اضافه کردن بیمه‌ی انتخابی (radio)
        if ($this->selected_insurance) {
            $ins = $this->allServices[$this->selected_insurance] ?? null;
            if ($ins) {
                $total += $ins['amount'] * $days;
            }
        }

        $this->services_total = $total;
    }

    // هر بار که بیمه تغییر کرد هم مجدداً جمع بزن:
    public function updatedSelectedInsurance()
    {
        $this->calculateServicesTotal();
    }
    public function updatedSelectedServices()
    {
        $this->calculateServicesTotal();
    }

    public function getCarDailyRate(Car $car, int $days): float
    {
        if ($days >= 21) {
            return $car->price_per_day_long;
        } elseif ($days >= 7) {
            return $car->price_per_day_mid;
        }

        return $car->price_per_day_short;
    }

    public function mount()
    {
        // مقدار اولیه نمایش تمام ماشین‌ها
        $this->cars = $this->getUniqueModelCars();
    }

    public function selectCar($carId)
    {
        // خالی کردن لیست خدمات قبلی
        $this->selected_services = [];
        $this->services_total    = 0;

        // ست کردن ماشین جدید
        $this->selectedCar = Car::find($carId);

        // به‌روزرسانی فوری مجموع
        $this->calculateServicesTotal();
    }

    public function updatedSelectedBrand($value)
    {
        $this->cars = $this->getUniqueModelCars($value);
    }

    private function getUniqueModelCars($brand = null)
    {
        $query = Car::with(['carModel', 'options']);

        if ($brand) {
            $query->whereHas('carModel', function ($q) use ($brand) {
                $q->where('brand', $brand);
            });
        }

        // گرفتن همه ماشین‌ها
        $cars = $query->get();

        // مرتب‌سازی بر اساس اینکه مدلش `is_featured` باشه
        $cars = $cars->sortByDesc(function ($car) {
            return $car->carModel->is_featured;
        });

        // فقط یکی از هر مدل
        return $cars->unique('car_model_id')->values();
    }

    public function render()
    {
        $brands = CarModel::distinct()
            ->pluck('brand')
            ->filter() // حذف null یا رشته‌های خالی
            ->unique()
            ->map(fn($brand) => ucwords(strtolower($brand))) // حروف اول بزرگ
            ->sort()
            ->values();
        return view('livewire.reservation.reserve-car-form', [
            'brands'   => $brands,
            'services' => $this->allServices,  // <-- اینجا
        ])->layout('layouts.reservation');
    }

    public function getTransferCostsProperty()
    {
        $costs = [
            'pickup' => 0,
            'return' => 0,
            'total' => 0
        ];

        if (!$this->pickup_date || !$this->return_date) {
            return $costs;
        }

        try {
            $pickup = Carbon::parse($this->pickup_date);
            $return = Carbon::parse($this->return_date);

            // محاسبه دقیق فاصله زمانی به ساعت
            $diffInHours = $pickup->diffInHours($return);

            // تبدیل به روز، با گرد کردن به بالا: اگر حتی 1.2 روز بود، بشه 2 روز
            $days = (int) ceil($diffInHours / 24);

            // اگر کمتر از 1 روز بود، 1 روز بشه
            $this->rental_days = max(1, $days);

            $costs['pickup'] = $this->calculateLocationCost($this->pickup_location, $this->rental_days);
            $costs['return'] = $this->calculateLocationCost($this->return_location, $this->rental_days);
            $costs['total'] = $costs['pickup'] + $costs['return'];
        } catch (\Exception $e) {
            // لاگ کردن خطا در صورت نیاز
        }

        return $costs;
    }

    private function calculateLocationCost($location, $days)
    {
        $category = ($days < 3) ? 'under_3' : 'over_3';
        $costConfig = $this->locationCosts[$location] ?? ['under_3' => 0, 'over_3' => 0];

        return $costConfig[$category];
    }

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
}
