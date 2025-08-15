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
    public $selectedCar = null;
    public $pickup_location;
    public $return_location;
    public $rental_days = 1;
    public $accept_terms = false;

    public $selected_services = ['basic_insurance'];
    public $selected_insurance = null;
    public $services_total = 0;
    public $insurance_total = 0;
    public $transfer_costs = ['pickup' => 0, 'return' => 0, 'total' => 0];
    public $tax_rate = 0.05;
    public $tax_amount = 0;
    public $final_total = 0;
    public $base_price = 0;

    public $services = [
        'basic_insurance' => [
            'label'   => 'بیمه پایه',
            'icon'    => 'fa-shield-halved',
            'amount'  => 0,
            'per_day' => false,
        ],
        'child_seat' => [
            'label'   => 'صندلی کودک',
            'icon'    => 'fa-baby',
            'amount'  => 20,
            'per_day' => true,
        ],
        'additional_driver' => [
            'label'   => 'راننده اضافه',
            'icon'    => 'fa-user-plus',
            'amount'  => 20,
            'per_day' => false,
        ],
    ];

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

    public function mount()
    {
        $this->cars = $this->getUniqueModelCars();
    }

    public function calculateCosts()
    {
        $this->calculateRentalDays();
        $this->calculateBasePrice();
        $this->calculateTransferCosts();
        $this->calculateServicesTotal();
        $this->calculateTaxAndTotal();
    }

    private function calculateRentalDays()
    {
        if ($this->pickup_date && $this->return_date) {
            $pickup = Carbon::parse($this->pickup_date);
            $return = Carbon::parse($this->return_date);
            $totalMinutes = $pickup->diffInMinutes($return);
            $this->rental_days = max(1, ceil($totalMinutes / 1440));
        } else {
            $this->rental_days = 1;
        }
    }

    private function calculateBasePrice()
    {
        if ($this->selectedCar && $this->rental_days) {
            $this->base_price = $this->getCarDailyRate($this->selectedCar, $this->rental_days) * $this->rental_days;
        } else {
            $this->base_price = 0;
        }
    }

    private function getCarDailyRate(Car $car, int $days): float
    {
        if ($days >= 28) return $car->price_per_day_long ?? $car->price_per_day_mid ?? $car->price_per_day_short;
        if ($days >= 7) return $car->price_per_day_mid ?? $car->price_per_day_short;
        return $car->price_per_day_short;
    }

    private function calculateTransferCosts()
    {
        $this->transfer_costs = [
            'pickup' => $this->calculateLocationCost($this->pickup_location, $this->rental_days),
            'return' => $this->calculateLocationCost($this->return_location, $this->rental_days),
            'total' => 0
        ];
        $this->transfer_costs['total'] = $this->transfer_costs['pickup'] + $this->transfer_costs['return'];
    }

    private function calculateLocationCost($location, $days)
    {
        $category = ($days < 3) ? 'under_3' : 'over_3';
        return $this->locationCosts[$location][$category] ?? 0;
    }

    private function calculateServicesTotal()
    {
        $servicesTotal = 0;
        $insuranceTotal = 0;
        $days = $this->rental_days;

        foreach ($this->selected_services as $serviceId) {
            if ($serviceId === 'basic_insurance') continue;
            $service = $this->services[$serviceId] ?? null;
            if ($service) {
                $servicesTotal += $service['per_day'] ? $service['amount'] * $days : $service['amount'];
            }
        }

        if ($this->selected_insurance && $this->selectedCar) {
            if ($this->selected_insurance === 'basic_insurance') {
                $insuranceTotal += $this->services['basic_insurance']['amount'] * $days;
            } elseif ($this->selected_insurance === 'ldw_insurance') {
                $insuranceTotal += $this->selectedCar->ldw_price * $days;
            } elseif ($this->selected_insurance === 'scdw_insurance') {
                $insuranceTotal += $this->selectedCar->scdw_price * $days;
            }
        }

        $this->services_total = $servicesTotal;
        $this->insurance_total = $insuranceTotal;
    }

    private function calculateTaxAndTotal()
    {
        $subtotal = $this->base_price + $this->services_total + $this->insurance_total + $this->transfer_costs['total'];
        $this->tax_amount = round($subtotal * $this->tax_rate, 2);
        $this->final_total = $subtotal + $this->tax_amount;
    }

    public function selectCar($carId)
    {
        $this->selected_services = ['basic_insurance'];
        $this->selected_insurance = null;
        $this->selectedCar = Car::find($carId);
        $this->calculateCosts();
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, [
            'pickup_date',
            'return_date',
            'selectedCar',
            'pickup_location',
            'return_location',
            'selected_services',
            'selected_insurance',
            'selectedBrand'
        ])) {
            $this->calculateCosts();
        }
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
        $cars = $query->get();
        $cars = $cars->sortByDesc(fn($car) => $car->carModel->is_featured);
        return $cars->unique('car_model_id')->values();
    }

    public function render()
    {
        $brands = CarModel::distinct()
            ->pluck('brand')
            ->filter()
            ->unique()
            ->map(fn($brand) => ucwords(strtolower($brand)))
            ->sort()
            ->values();
        return view('livewire.reservation.reserve-car-form', [
            'brands' => $brands,
            'services' => array_merge($this->services, [
                'ldw_insurance' => ['label' => 'بیمه LDW', 'icon' => 'fa-car-burst', 'amount' => $this->selectedCar ? $this->selectedCar->ldw_price : 0, 'per_day' => true],
                'scdw_insurance' => ['label' => 'بیمه کامل SCDW', 'icon' => 'fa-lock', 'amount' => $this->selectedCar ? $this->selectedCar->scdw_price : 0, 'per_day' => true],
            ]),
        ])->layout('layouts.reservation');
    }
}
