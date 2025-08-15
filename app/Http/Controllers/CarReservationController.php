<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Contract;
use App\Models\ContractCharges;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class CarReservationController extends Controller
{
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

    private function getCarDailyRate(Car $car, int $days): float
    {
        if ($days >= 28) return $car->price_per_day_long ?? $car->price_per_day_mid ?? $car->price_per_day_short;
        if ($days >= 7) return $car->price_per_day_mid ?? $car->price_per_day_short;
        return $car->price_per_day_short;
    }

    public function reserveCar(Request $request)
    {
        try {
            $validated = $request->validate([
                'carId' => ['required', 'exists:cars,id'],
                'pickup_date' => ['required', 'date', 'after_or_equal:today'],
                'return_date' => ['required', 'date', 'after:pickup_date', 'after_or_equal:today'],
                'pickup_location' => ['required', Rule::in(array_keys($this->locationCosts))],
                'return_location' => ['required', Rule::in(array_keys($this->locationCosts))],
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', Rule::unique('customers')],
                'phone' => ['required', 'max:15'],
                'messenger_phone' => ['required', 'max:15'],
                'selected_services' => ['array'],
                'selected_services.*' => ['in:child_seat,additional_driver'],
                'insurance' => ['required', Rule::in(['ldw_insurance', 'scdw_insurance'])],
            ]);

            return DB::transaction(function () use ($validated) {
                $car = Car::findOrFail($validated['carId']);
                $pickupDate = Carbon::parse($validated['pickup_date']);
                $returnDate = Carbon::parse($validated['return_date']);
                $rentalDays = max(1, $pickupDate->diffInDays($returnDate));

                // بررسی رزروهای موجود
                $reservations = Contract::where('car_id', $car->id)
                    ->whereIn('current_status', ['pending', 'assigned', 'under_review', 'reserved', 'delivery', 'agreement_inspection', 'awaiting_return'])
                    ->where('return_date', '>=', now())
                    ->get();

                foreach ($reservations as $reservation) {
                    $existingPickup = Carbon::parse($reservation->pickup_date);
                    $existingReturn = Carbon::parse($reservation->return_date);
                    if ($pickupDate->lessThanOrEqualTo($existingReturn) && $returnDate->greaterThanOrEqualTo($existingPickup)) {
                        throw new \Exception("این خودرو از {$reservation->pickup_date} تا {$reservation->return_date} رزرو شده است.");
                    }
                }

                $dailyRate = $this->getCarDailyRate($car, $rentalDays);
                $basePrice = $dailyRate * $rentalDays;

                $allServices = config('carservices');
                $selectedServices = $validated['selected_services'] ?? [];
                $insurance = $validated['insurance'];

                $servicesTotal = 0;
                $insuranceTotal = 0;
                $serviceBreakdown = [];
                $insuranceBreakdown = null;

                foreach ($selectedServices as $serviceId) {
                    if (!isset($allServices[$serviceId])) continue;
                    $svc = $allServices[$serviceId];
                    $amount = $svc['per_day'] ? $svc['amount'] * $rentalDays : $svc['amount'];
                    $servicesTotal += $amount;
                    $serviceBreakdown[] = [
                        'label' => $svc['label_fa'],
                        'amount' => $amount,
                        'per_day' => $svc['per_day'],
                        'unit' => $svc['amount'],
                    ];
                }

                if ($insurance && isset($allServices[$insurance])) {
                    $ins = $allServices[$insurance];
                    $amount = $insurance === 'ldw_insurance' ? $car->ldw_price : $car->scdw_price;
                    $insuranceTotal = $ins['per_day'] ? $amount * $rentalDays : $amount;
                    $insuranceBreakdown = [
                        'label' => $ins['label_fa'],
                        'amount' => $insuranceTotal,
                        'per_day' => $ins['per_day'],
                        'unit' => $amount,
                    ];
                }

                $pickupFee = $this->calculateLocationFee($validated['pickup_location'], $rentalDays);
                $returnFee = $this->calculateLocationFee($validated['return_location'], $rentalDays);
                $locationTotal = $pickupFee + $returnFee;

                $subtotal = $basePrice + $servicesTotal + $insuranceTotal + $locationTotal;
                $taxRate = 0.05;
                $taxAmount = round($subtotal * $taxRate, 2);
                $finalTotalPrice = $subtotal + $taxAmount;

                $customer = Customer::updateOrCreate(
                    ['email' => $validated['email']],
                    [
                        'first_name' => $validated['first_name'],
                        'last_name' => $validated['last_name'],
                        'phone' => $validated['phone'],
                        'messenger_phone' => $validated['messenger_phone'],
                        'registration_date' => now(),
                        'status' => 'active',
                    ]
                );

                $contract = Contract::create([
                    'customer_id' => $customer->id,
                    'car_id' => $car->id,
                    'pickup_date' => $pickupDate,
                    'return_date' => $returnDate,
                    'pickup_location' => $validated['pickup_location'],
                    'return_location' => $validated['return_location'],
                    'total_price' => $finalTotalPrice,
                    'current_status' => 'pending',
                    'selected_services' => $selectedServices,
                    'selected_insurance' => $insurance,
                ]);

                $this->createContractCharges($contract, $basePrice, $serviceBreakdown, $insuranceBreakdown, $pickupFee, $returnFee, $rentalDays, $taxAmount, $dailyRate);

                return response()->noContent();
            });
        } catch (QueryException $e) {
            Log::error('Database error in reserveCar: ' . $e->getMessage());
            return response()->json(['error' => 'خطایی در ثبت رزرو رخ داد. لطفاً دوباره تلاش کنید.'], 500);
        } catch (\Exception $e) {
            Log::error('General error in reserveCar: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function calculateLocationFee($location, $rentalDays)
    {
        $feeType = ($rentalDays < 3) ? 'under_3' : 'over_3';
        return $this->locationCosts[$location][$feeType] ?? 0;
    }

    private function createContractCharges($contract, $basePrice, $serviceBreakdown, $insuranceBreakdown, $pickupFee, $returnFee, $rentalDays, $taxAmount, $dailyRate)
    {
        $validTypes = ['base', 'addon', 'location_fee', 'tax', 'insurance'];

        ContractCharges::create([
            'contract_id' => $contract->id,
            'title' => 'base_rental',
            'amount' => $basePrice,
            'type' => in_array('base', $validTypes) ? 'base' : throw new \Exception('Invalid charge type: base'),
            'description' => "{$rentalDays} روز × {$dailyRate} درهم",
        ]);

        foreach ($serviceBreakdown as $svc) {
            ContractCharges::create([
                'contract_id' => $contract->id,
                'title' => array_search($svc['label'], array_column(config('carservices'), 'label_fa')),
                'amount' => $svc['amount'],
                'type' => in_array('addon', $validTypes) ? 'addon' : throw new \Exception('Invalid charge type: addon'),
                'description' => $svc['per_day'] ? "{$rentalDays} روز × {$svc['unit']} درهم" : 'یک‌بار هزینه',
            ]);
        }

        if ($insuranceBreakdown) {
            ContractCharges::create([
                'contract_id' => $contract->id,
                'title' => array_search($insuranceBreakdown['label'], array_column(config('carservices'), 'label_fa')),
                'amount' => $insuranceBreakdown['amount'],
                'type' => in_array('insurance', $validTypes) ? 'insurance' : throw new \Exception('Invalid charge type: insurance'),
                'description' => $insuranceBreakdown['per_day'] ? "{$rentalDays} روز × {$insuranceBreakdown['unit']} درهم" : 'یک‌بار هزینه',
            ]);
        }

        if ($pickupFee > 0) {
            ContractCharges::create([
                'contract_id' => $contract->id,
                'title' => 'pickup_transfer',
                'amount' => $pickupFee,
                'type' => in_array('location_fee', $validTypes) ? 'location_fee' : throw new \Exception('Invalid charge type: location_fee'),
                'description' => $contract->pickup_location,
            ]);
        }

        if ($returnFee > 0) {
            ContractCharges::create([
                'contract_id' => $contract->id,
                'title' => 'return_transfer',
                'amount' => $returnFee,
                'type' => in_array('location_fee', $validTypes) ? 'location_fee' : throw new \Exception('Invalid charge type: location_fee'),
                'description' => $contract->return_location,
            ]);
        }

        if ($taxAmount > 0) {
            ContractCharges::create([
                'contract_id' => $contract->id,
                'title' => 'tax',
                'amount' => $taxAmount,
                'type' => in_array('tax', $validTypes) ? 'tax' : throw new \Exception('Invalid charge type: tax'),
                'description' => '۵٪ مالیات بر ارزش افزوده',
            ]);
        }
    }
}
