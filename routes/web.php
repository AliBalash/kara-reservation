<?php

use App\Http\Controllers\CarReservationController;
use Illuminate\Support\Facades\Route;



use App\Livewire\Reservation\ReserveCarForm;

Route::get('/', ReserveCarForm::class);
Route::post('/reserve-car', [CarReservationController::class, 'reserveCar'])->name('reserve.car');



use App\Livewire\Discount\RegisteryDiscountCode;

Route::get('/discount-code-form', RegisteryDiscountCode::class);
