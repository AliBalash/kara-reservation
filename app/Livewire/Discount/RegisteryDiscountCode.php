<?php

namespace App\Livewire\Discount;

use Livewire\Component;
use App\Models\DiscountCode;

class RegisteryDiscountCode extends Component
{
    public $phone;
    public $discount_code;

    protected $rules = [
        'phone' => 'required|numeric|digits:11', // Fix validation
    ];

    public function submit()
    {
        $this->validate();

        // Check if phone exists in the database
        $discountCode = DiscountCode::where('phone', $this->phone)->first();

        if ($discountCode) {
            // Show the existing discount code and percentage
            $this->discount_code = $discountCode->code;
            $discount_percentage = $discountCode->discount_percentage;

            // Update registery_at
            $discountCode->update([
                'registery_at' => now(),
            ]);

            session()->flash('message', "Code: {$this->discount_code} - Discount: {$discount_percentage}%");
        } else {
            session()->flash('error', 'Shomare mored nazar code takhfif nadarad.');
        }
    }

    public function render()
    {
        return view('livewire.discount.registery-discount-code')->layout('layouts.app');
    }
}
