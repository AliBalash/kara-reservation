<?php

namespace App\Livewire\Discount;

use Livewire\Component;
use App\Models\DiscountCode;
use Illuminate\Support\Str;

class RegisteryDiscountCode extends Component
{
    public $phone;
    public $firstname;
    public $lastname;
    public $discount_code;
    public $discount_percentage;

    // Validation rules
    protected $rules = [
        'phone' => 'required|string|max:20|regex:/^\+?[0-9]*$/',
        'firstname' => 'required|string|max:255|regex:/^[a-zA-Z]+$/', // Faqat horof Englisi
        'lastname' => 'required|string|max:255|regex:/^[a-zA-Z]+$/',  // Faqat horof Englisi
        'discount_code' => 'nullable|string|max:255',
        'discount_percentage' => 'nullable|integer|between:0,100',
    ];
    
    // Custom error messages
    protected $messages = [
        'phone.required' => 'لطفاً شماره تلفن را وارد کنید.',
        'phone.string' => 'شماره تلفن باید به صورت رشته باشد.',
        'phone.max' => 'شماره تلفن بیش از حد طولانی است.',
        'phone.regex' => 'شماره تلفن وارد شده معتبر نیست.',
        'firstname.required' => 'لطفاً نام را وارد کنید.',
        'firstname.regex' => 'نام باید فقط شامل حروف انگلیسی باشد.',
        'lastname.required' => 'لطفاً نام خانوادگی را وارد کنید.',
        'lastname.regex' => 'نام خانوادگی باید فقط شامل حروف انگلیسی باشد.',
        'discount_code.string' => 'کد تخفیف باید به صورت رشته باشد.',
        'discount_percentage.integer' => 'درصد تخفیف باید عدد صحیح باشد.',
        'discount_percentage.between' => 'درصد تخفیف باید بین 0 تا 100 باشد.',
    ];
    


    public function submit()
    {

        $this->validate();
        // Combine firstname and lastname into the 'name' field
        $name = $this->firstname . ' ' . $this->lastname;
        
        $discountCode = DiscountCode::where('phone', $this->phone)->first();

        if ($discountCode) {
            $this->discount_code = $discountCode->code;
            $this->discount_percentage = $discountCode->discount_percentage;

            // Update the name in the database
            $discountCode->update([
                'name' => $name,
                'registery_at' => now(),
            ]);

            session()->flash('message', "Name updated to: {$name}, Code: {$this->discount_code} - Discount: {$this->discount_percentage}%");
        } else {
            $defaultDiscount = 3;
            $specialDiscounts = [10, 6];
            $existingNames = DiscountCode::whereIn('discount_percentage', $specialDiscounts)->pluck('name')->toArray();

            $discountPercentage = in_array($name, $existingNames) ? ($name == '10%' ? 10 : 6) : $defaultDiscount;
            $newCode = Str::random(8);

            // Create a new discount code with the combined name
            $discountCode = DiscountCode::create([
                'name' => $name,
                'phone' => $this->phone,
                'code' => $newCode,
                'discount_percentage' => $discountPercentage,
                'registery_at' => now(),
            ]);

            $this->discount_code = $newCode;
            $this->discount_percentage = $discountPercentage;

            session()->flash('message', "New User: {$name}, Code: {$this->discount_code} - Discount: {$this->discount_percentage}%");
        }

    }


    public function render()
    {
        return view('livewire.discount.registery-discount-code')->layout('layouts.app');
    }
}
