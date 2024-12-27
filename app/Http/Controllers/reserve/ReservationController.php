<?php

namespace App\Http\Controllers\reserve;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ReservationController extends Controller
{
    public function show()
    {

        // $name = 'Ali';
        // $response = Http::get("https://api.genderize.io?name={$name}");
        // $data = $response->json();
        // dd($data);

        return view('reserve/ReservationController');
    }
}
