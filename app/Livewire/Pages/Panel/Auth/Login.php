<?php

namespace App\Livewire\Pages\Panel\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public function render()
    {
        return view('livewire.pages.panel.auth.login')
        ->layout('layouts.auth');
    }

    public $phone;
    public $password;

    public function login()
    {
        $this->validate([
            'phone' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt(['phone' => $this->phone, 'password' => $this->password])) {
            return redirect()->route('dashboard'); // Adjust route
        } else {
            session()->flash('error', 'Invalid credentials');
        }
    }


}