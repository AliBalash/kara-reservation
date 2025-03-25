<div class="container mt-5">
    <div class="card p-4 shadow-lg rounded-3"
        style="direction: rtl; text-align: right; font-family: 'Vazirmatn', sans-serif;">
        <form wire:submit.prevent="submit">
            <!-- شماره تلفن -->
            <!-- Hidden input for full phone number -->
            <input type="hidden" id="full_phone" wire:model="phone">

            <!-- Phone input -->
            <div class="mb-3">
                <div class="col-md-6"wire:ignore>
                    <label for="phone" class="form-label fw-bold">شماره تلفن</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-phone-alt"></i></span>
                        <input type="tel" id="phone" class="form-control" wire:model="phone"
                            placeholder="مثال: 09123456789">
                    </div>
                </div>
                @error('phone')
                    <span class="text-danger small d-block mt-1">{{ $message }}</span>
                @enderror
            </div>





            <!-- نام و نام خانوادگی در کنار هم -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="firstname" class="form-label fw-bold">نام</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-user"></i></span>
                        <input type="text" id="firstname" wire:model="firstname" class="form-control"
                            placeholder="نام">
                    </div>
                    @error('firstname')
                        <span class="text-danger small d-block mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="lastname" class="form-label fw-bold">نام خانوادگی</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-user"></i></span>
                        <input type="text" id="lastname" wire:model="lastname" class="form-control"
                            placeholder="نام خانوادگی">
                    </div>
                    @error('lastname')
                        <span class="text-danger small d-block mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            @if ($discount_code)
                @php
                    $groups = [
                        3 => ['name' => 'طرح نقره‌ای', 'color' => '#A8A8A8'],
                        6 => ['name' => 'طرح طلایی', 'color' => '#FFD700'],
                        10 => ['name' => 'طرح پلاتینیوم', 'color' => '#E5E4E2'],
                    ];
                    $group = $groups[$discount_percentage] ?? ['name' => 'باشگاه مشتریان', 'color' => '#007BFF'];
                @endphp

                <div class="alert text-center p-4"
                    style="background: {{ $group['color'] }}; color: #333; border-radius: 10px; box-shadow: 0px 4px 10px rgba(0,0,0,0.1);">
                    <h4 class="fw-bold mb-2">🎉 تبریک!</h4>
                    <p class="mb-2">
                        <span class="fw-bold" dir="auto">{{ $firstname }}</span>
                        عزیز،
                        بر اساس سابقه سفارشات شما، در گروه <span class="fw-bold">{{ $group['name'] }}</span> قرار دارید
                        و <b>{{ $discount_percentage }}٪</b> تخفیف دارید.
                    </p>
                    <p class="mt-2">کد تخفیف خود را کپی کنید و هنگام سفارش استفاده کنید.</p>
                </div>

                <div class="mb-3">
                    <label for="discount_code" class="form-label fw-bold">کد تخفیف شما:</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-gift"></i></span>
                        <input type="text" id="discount_code" value="{{ $discount_code }}"
                            class="form-control text-center fw-bold" readonly>
                    </div>
                </div>
            @endif

            <!-- دکمه ارسال -->
            <button type="submit" class="btn btn-secondary w-100 mt-3 p-2 fw-bold" wire:loading.attr="disabled"
                wire:target="submit">
                <span wire:loading.remove>ارسال اطلاعات</span>
                <span wire:loading>در حال ارسال...</span>
            </button>
        </form>
    </div>
</div>



@push('styles')
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazir-font/dist/font-face.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: "Vazir", sans-serif !important;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var input = document.querySelector("#phone");
            var hiddenInput = document.querySelector("#full_phone");

            var phoneContainer = input.closest('.col-md-6');
            phoneContainer.classList.remove('col-md-6');
            phoneContainer.classList.add('col-12');

            var iti = window.intlTelInput(input, {
                initialCountry: "ir",
                preferredCountries: ["ir", "ae", "tr", "kw"],
                separateDialCode: true,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
            });

            // input.addEventListener("blur", function() {
            //     var fullNumber = iti.getNumber(intlTelInputUtils.numberFormat
            //         .NATIONAL); // Show local number
            //     input.value = fullNumber; // Keep input field without country code
            //     hiddenInput.value = iti.getNumber(); // Keep full number in hidden input for backend
            //     @this.set('phone', hiddenInput
            //         .value); // Update Livewire model with full international number
            // });

            document.querySelector("form").addEventListener("submit", function(event) {
                var fullNumber = iti.getNumber(intlTelInputUtils.numberFormat.NATIONAL);
                input.value = fullNumber; // Show local number
                hiddenInput.value = iti.getNumber(); // Keep full number in hidden input for backend
                @this.set('phone', hiddenInput
                    .value); // Update Livewire model with full international number
            });

            Livewire.hook("message.processed", (message, component) => {
                iti.destroy();
                iti = window.intlTelInput(input, {
                    initialCountry: "ir",
                    preferredCountries: ["ir", "ae", "tr", "kw"],
                    separateDialCode: true,
                    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
                });
            });
        });



        // document.addEventListener("livewire:load", function() {
        //     var input = document.querySelector("#phone");
        //     var hiddenInput = document.querySelector("#full_phone");

        //     var iti = window.intlTelInput(input, {
        //         initialCountry: "ir",
        //         preferredCountries: ["ir", "ae", "tr", "kw"],
        //         separateDialCode: true,
        //         utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
        //     });

        //     input.addEventListener("blur", function() {
        //         var fullNumber = iti.getNumber();
        //         hiddenInput.value = fullNumber;
        //         @this.set('phone', fullNumber); // This updates the Livewire model
        //     });

        //     Livewire.hook('message.processed', (message, component) => {
        //         iti.destroy();
        //         iti = window.intlTelInput(input, {
        //             initialCountry: "ir",
        //             preferredCountries: ["ir", "ae", "tr", "kw"],
        //             separateDialCode: true,
        //             utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
        //         });
        //     });
        // });

        // document.querySelector("#submit-btn").addEventListener("click", function() {
        //     let btn = this;
        //     btn.innerHTML = `<i class="fas fa-spinner fa-spin"></i> در حال ارسال ...`;
        //     btn.disabled = true;
        //     setTimeout(() => {
        //         btn.innerHTML = `<i class="fas fa-check"></i> ارسال شد`;
        //     }, 2000);
        // });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Peyda kardan input element-ha ba class-haye specific
            var phoneInput = document.querySelector('.iti.iti--allow-dropdown.iti--separate-dial-code');

            // Agar element ro peyda kardim, class 'col' ro ezafe mikonim
            if (phoneInput) {
                phoneInput.classList.add('col-md-6'); // Class col ro ezafe mikonim
            }
        });
    </script>
@endpush
