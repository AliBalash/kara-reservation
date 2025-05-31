<?php

namespace App\Livewire\Reservation;

use App\Models\Car;
use App\Models\CarModel;
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

    public function mount()
    {
        // مقدار اولیه نمایش تمام ماشین‌ها
        $this->cars = $this->getUniqueModelCars();
    }

    public function selectCar($carId)
    {
        $this->selectedCar = Car::find($carId);
    }

    public function updatedSelectedBrand($value)
    {
        $this->cars = $this->getUniqueModelCars($value);
    }


    private function getUniqueModelCars($brand = null)
    {
        $query = Car::with('carModel');

        if ($brand) {
            $query->whereHas('carModel', function ($q) use ($brand) {
                $q->where('brand', $brand);
            });
        }

        $cars = $query->get();

        // فقط یک ماشین برای هر car_model_id
        return $cars->unique('car_model_id')->values();
    }


    public function render()
    {
        // ارسال لیست برندها برای نمایش در Select Box
        $brands = CarModel::distinct()->pluck('brand');
        return view('livewire.reservation.reserve-car-form', compact('brands'))->layout('layouts.reservation');
    }
}
