<?php

use App\Http\Controllers\CarReservationController;
use Illuminate\Support\Facades\Route;



// use App\Imports\CarImport;
// use Maatwebsite\Excel\Facades\Excel;
// Route::get('/import-cars', function () {
//     // Masir file Excel ro moshakhas mikonid
//     $filePath = storage_path('app/private/Cars.xlsx');
//     // Import file Excel
//     Excel::import(new CarImport, $filePath);

//     // Return success message
//     return 'Data has been imported successfully from the given file.';
// });


use App\Livewire\Reservation\ReserveCarForm;

Route::get('/', ReserveCarForm::class);
Route::post('/reserve-car', [CarReservationController::class, 'reserveCar'])->name('reserve.car');
