<?php

namespace App\Livewire\Reservation;

use App\Models\Car;
use App\Models\CarModel;
use App\Models\Contract;
use App\Models\ContractCharges;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ReserveCarForm extends Component
{
    public $selectedBrand;
    public $selectedCarId;
    public $pickup_location;
    public $return_location;
    public $pickup_date;
    public $return_date;
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $messenger_phone;
    public $accept_terms = false;
    public $selected_services = [];
    public $selected_insurance;
    public $services_total = 0;
    public $insurance_total = 0;
    public $transfer_costs = ['pickup' => 0, 'return' => 0, 'total' => 0];
    public $tax_rate = 0.05;
    public $tax_amount = 0;
    public $subtotal = 0;
    public $final_total = 0;
    public $rental_days = 1;
    public $dailyRate;
    public $base_price;
    public $brands = [];
    public $cars = [];
    public $services = [];

    private $locationCosts = [
        'UAE/Dubai/Clock Tower/Main Branch' => ['under_3' => 0, 'over_3' => 0],
        'UAE/Dubai/Downtown' => ['under_3' => 50, 'over_3' => 50],
        'UAE/Dubai/Dubai Airport/Terminal 1' => ['under_3' => 50, 'over_3' => 0],
        'UAE/Dubai/Dubai Airport/Terminal 2' => ['under_3' => 50, 'over_3' => 0],
        'UAE/Dubai/Dubai Airport/Terminal 3' => ['under_3' => 50, 'over_3' => 0],
        'UAE/Dubai/Jumeirah 1, 2, 3' => ['under_3' => 45, 'over_3' => 45],
        'UAE/Dubai/JBR' => ['under_3' => 45, 'over_3' => 45],
        'UAE/Dubai/Marina' => ['under_3' => 45, 'over_3' => 45],
        'UAE/Dubai/JLT' => ['under_3' => 45, 'over_3' => 45],
        'UAE/Dubai/JVC' => ['under_3' => 60, 'over_3' => 60],
        'UAE/Dubai/Damac Hills' => ['under_3' => 60, 'over_3' => 60],
        'UAE/Dubai/Palm' => ['under_3' => 70, 'over_3' => 70],
        'UAE/Dubai/Jebel Ali – Ibn Battuta – Hatta & more' => ['under_3' => 70, 'over_3' => 70],
        'UAE/Sharjah Airport' => ['under_3' => 100, 'over_3' => 100],
        'UAE/Abu Dhabi Airport' => ['under_3' => 200, 'over_3' => 200],
    ];

    public function mount()
    {
        $this->services = config('carservices');
        $this->brands = CarModel::distinct()->pluck('brand')->filter()->sort()->values()->toArray();
        $this->loadCars();
    }

    public function updated($propertyName)
    {
        if ($this->isCostRelatedField($propertyName)) {
            $this->calculateCosts();
        }

        if ($propertyName === 'selectedBrand') {
            $this->selectedCarId = null;
            $this->loadCars();
        }

        if ($propertyName === 'selectedCarId') {
            $car = Car::find($this->selectedCarId);
            if ($car) {
                $this->services['ldw_insurance']['amount'] = $car->ldw_price ?? 0;
                $this->services['scdw_insurance']['amount'] = $car->scdw_price ?? 0;
            }
        }
    }

    private function isCostRelatedField($propertyName)
    {
        $base = explode('.', $propertyName)[0];
        return in_array($base, [
            'pickup_date',
            'return_date',
            'selectedCarId',
            'pickup_location',
            'return_location',
            'selected_services',
            'selected_insurance',
        ]);
    }

    private function loadCars()
    {
        $this->cars = $this->selectedBrand
            ? Car::whereHas('carModel', fn($query) => $query->where('brand', $this->selectedBrand))
            ->with('carModel')
            ->get()
            : Car::with('carModel')->get();
    }

    public function selectCar($carId)
    {
        $this->selectedCarId = $carId;
        $this->selected_services = []; // Reset services
        $this->selected_insurance = 'ldw_insurance';
        $car = Car::find($carId);
        if ($car) {
            $this->services['ldw_insurance']['amount'] = $car->ldw_price ?? 0;
            $this->services['scdw_insurance']['amount'] = $car->scdw_price ?? 0;
        }
        $this->calculateCosts();
    }

    private function calculateRentalDays()
    {
        if ($this->pickup_date && $this->return_date) {
            $pickup = Carbon::parse($this->pickup_date);
            $return = Carbon::parse($this->return_date);
            $minutes = $pickup->diffInMinutes($return);
            $this->rental_days = max(1, ceil($minutes / (24 * 60)));
        } else {
            $this->rental_days = 1;
        }
    }

    private function calculateBasePrice()
    {
        if ($this->selectedCarId && $this->rental_days) {
            $car = Car::find($this->selectedCarId);
            $this->dailyRate = $this->getCarDailyRate($car, $this->rental_days);
            $this->base_price = $this->dailyRate * $this->rental_days;
        } else {
            $this->dailyRate = 0;
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
            'pickup' => $this->calculateLocationFee($this->pickup_location, $this->rental_days),
            'return' => $this->calculateLocationFee($this->return_location, $this->rental_days),
            'total' => 0,
        ];
        $this->transfer_costs['total'] = $this->transfer_costs['pickup'] + $this->transfer_costs['return'];
    }

    private function calculateLocationFee($location, $days)
    {
        $feeType = ($days < 3) ? 'under_3' : 'over_3';
        return $this->locationCosts[$location][$feeType] ?? 0;
    }

    private function calculateServicesTotal()
    {
        $servicesTotal = 0;
        $insuranceTotal = 0;
        $days = $this->rental_days;

        foreach ($this->selected_services as $serviceId) {
            $service = $this->services[$serviceId] ?? null;
            if ($service && !in_array($serviceId, ['ldw_insurance', 'scdw_insurance'])) {
                $amount = $service['amount'] ?? 0;
                $servicesTotal += $service['per_day'] ? $amount * $days : $amount;
            }
        }

        if ($this->selected_insurance && $this->selectedCarId) {
            $car = Car::find($this->selectedCarId);
            if ($car) {
                if ($this->selected_insurance === 'ldw_insurance') {
                    $insuranceTotal += ($car->ldw_price ?? 0) * $days;
                } elseif ($this->selected_insurance === 'scdw_insurance') {
                    $insuranceTotal += ($car->scdw_price ?? 0) * $days;
                }
            }
        }

        $this->services_total = $servicesTotal;
        $this->insurance_total = $insuranceTotal;
    }

    private function calculateTaxAndTotal()
    {
        $this->subtotal = $this->base_price + $this->services_total + $this->insurance_total + $this->transfer_costs['total'];
        $this->tax_amount = round($this->subtotal * $this->tax_rate);
        $this->final_total = $this->subtotal + $this->tax_amount;
    }

    public function calculateCosts()
    {
        $this->calculateRentalDays();
        $this->calculateBasePrice();
        $this->calculateTransferCosts();
        $this->calculateServicesTotal();
        $this->calculateTaxAndTotal();
    }

    public function submit()
    {

        DB::beginTransaction();

        try {
            $this->calculateCosts();

            $customer = Customer::updateOrCreate(
                ['phone' => $this->phone, 'email' => $this->email],
                [
                    'first_name' => $this->first_name,
                    'last_name' => $this->last_name,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'messenger_phone' => $this->messenger_phone,
                ]
            );

            $contract = Contract::create([
                'user_id' => null,
                'customer_id' => $customer->id,
                'car_id' => $this->selectedCarId,
                'total_price' => $this->final_total,
                'pickup_location' => $this->pickup_location,
                'return_location' => $this->return_location,
                'pickup_date' => $this->pickup_date,
                'return_date' => $this->return_date,
                'selected_services' => $this->selected_services,
                'selected_insurance' => $this->selected_insurance,
            ]);

            $contract->changeStatus('pending', null);
            $this->storeContractCharges($contract);

            DB::commit();

            return redirect()->route('reservation.thanks');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'خطایی رخ داد: ' . $e->getMessage());
        }
    }


    private function storeContractCharges(Contract $contract)
    {
        ContractCharges::where('contract_id', $contract->id)->delete();

        ContractCharges::create([
            'contract_id' => $contract->id,
            'title' => 'base_rental',
            'amount' => $this->base_price,
            'type' => 'base',
            'description' => "{$this->rental_days} روز × {$this->dailyRate} درهم",
        ]);

        if ($this->transfer_costs['pickup'] > 0) {
            ContractCharges::create([
                'contract_id' => $contract->id,
                'title' => 'pickup_transfer',
                'amount' => $this->transfer_costs['pickup'],
                'type' => 'location_fee',
                'description' => $this->pickup_location,
            ]);
        }

        if ($this->transfer_costs['return'] > 0) {
            ContractCharges::create([
                'contract_id' => $contract->id,
                'title' => 'return_transfer',
                'amount' => $this->transfer_costs['return'],
                'type' => 'location_fee',
                'description' => $this->return_location,
            ]);
        }

        foreach ($this->selected_services as $serviceId) {
            if (!array_key_exists($serviceId, $this->services)) continue;
            $service = $this->services[$serviceId];
            $amount = $service['per_day'] ? $service['amount'] * $this->rental_days : $service['amount'];

            ContractCharges::create([
                'contract_id' => $contract->id,
                'title' => $serviceId,
                'amount' => $amount,
                'type' => 'addon',
                'description' => $service['per_day'] ? "{$this->rental_days} روز × {$service['amount']} درهم" : 'یک‌بار هزینه',
            ]);
        }

        if ($this->selected_insurance && in_array($this->selected_insurance, ['ldw_insurance', 'scdw_insurance'])) {
            $insuranceAmount = 0;
            $car = Car::find($this->selectedCarId);
            if ($car) {
                if ($this->selected_insurance === 'ldw_insurance') {
                    $insuranceAmount = ($car->ldw_price ?? 0) * $this->rental_days;
                } elseif ($this->selected_insurance === 'scdw_insurance') {
                    $insuranceAmount = ($car->scdw_price ?? 0) * $this->rental_days;
                }

                if ($insuranceAmount > 0) {
                    ContractCharges::create([
                        'contract_id' => $contract->id,
                        'title' => $this->selected_insurance,
                        'amount' => $insuranceAmount,
                        'type' => 'insurance',
                        'description' => "{$this->rental_days} روز",
                    ]);
                }
            }
        }

        if ($this->tax_amount > 0) {
            ContractCharges::create([
                'contract_id' => $contract->id,
                'title' => 'tax',
                'amount' => $this->tax_amount,
                'type' => 'tax',
                'description' => '۵٪ مالیات بر ارزش افزوده',
            ]);
        }
    }

    public function render()
    {
        $services = array_map(function ($service) {
            $service['label'] = $service['label_fa'];
            return $service;
        }, $this->services);

        return view('livewire.reservation.reserve-car-form', [
            'brands' => $this->brands,
            'services' => $services,
            'cars' => $this->cars,
            'selectedCar' => $this->selectedCarId ? Car::find($this->selectedCarId) : null,
        ])->layout('layouts.reservation');
    }
}
