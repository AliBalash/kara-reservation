<?php
namespace App\Services;

use Carbon\Carbon;
use App\Models\Car;

class CarReservationService
{
    protected $services = [
        'basic_insurance'    => ['label'=>'بیمه پایه',      'amount'=>0,  'per_day'=>false],
        'ldw_insurance'      => ['label'=>'بیمه LDW',        'amount'=>15, 'per_day'=>true],
        'scdw_insurance'     => ['label'=>'بیمه کامل',       'amount'=>35, 'per_day'=>true],
        'child_seat'         => ['label'=>'صندلی کودک',     'amount'=>20, 'per_day'=>true],
        'additional_driver'  => ['label'=>'راننده اضافه',   'amount'=>20, 'per_day'=>false],
    ];

    protected $locationCosts = [ /* مثل تعریف شما */ ];

    public function calculateRentalDays(string $pickup, string $return): int
    {
        $d1 = Carbon::parse($pickup);
        $d2 = Carbon::parse($return);
        return max(1, $d1->diffInDays($d2));
    }

    public function calculateServiceCost(array $selectedServices, int $days): array
    {
        $total = 0;
        $breakdown = [];
        foreach ($selectedServices as $key) {
            if (! isset($this->services[$key])) continue;
            $svc = $this->services[$key];
            $amount = $svc['per_day'] ? $svc['amount'] * $days : $svc['amount'];
            $total += $amount;
            $breakdown[] = compact('key','amount');
        }
        return ['total'=>$total, 'breakdown'=>$breakdown];
    }

    public function calculateLocationFee(string $loc, int $days): int
    {
        $type = $days < 3 ? 'under_3' : 'over_3';
        return $this->locationCosts[$loc][$type] ?? 0;
    }

    public function calculateBasePrice(Car $car, int $days): int
    {
        return $car->price_per_day * $days;
    }
}
