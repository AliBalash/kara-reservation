<!-- main container start -->
<div class="center-box d-flex justify-content-center align-items-center">
    <div class="wrapper p-4" style="min-width: 800px; max-width: 1200px;">
        <div class="gx-1">
            <form class="col-md-12 p-1 needs-validation" id="checkoutForm" wire:submit.prevent="submit" novalidate>
                @csrf

                <!-- Start profile step -->
                <div class="step step-0 row profile-step d-none" wire:ignore.self>
                    <header class="col-12 mb-5">
                        <h1>اطلاعات قرارداد</h1>
                        <p class="lead">لطفاً اطلاعات مکان و تاریخ را وارد کنید</p>
                    </header>

                    <div class="mb-3 col-12 col-md-6">
                        <label for="pickup_date" class="form-label">
                            <i class="fa fa-calendar-alt text-danger ms-1"></i>
                            تاریخ و زمان تحویل
                        </label>
                        <input type="datetime-local" id="pickup_date" class="form-control" name="pickup_date"
                            wire:model.live.debounce.500ms="pickup_date" placeholder="تاریخ و زمان تحویل"
                            min="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}" />
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3 col-12 col-md-6">
                        <label for="return_date" class="form-label">
                            <i class="fa fa-calendar-check text-danger ms-1"></i>
                            تاریخ و زمان بازگشت
                        </label>
                        <input type="datetime-local" id="return_date" class="form-control" name="return_date"
                            wire:model.live.debounce.500ms="return_date" placeholder="تاریخ و زمان بازگشت"
                            min="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}">
                        <div class="invalid-feedback">
                            @error('return_date')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 col-12 col-md-6">
                        <label for="pickup_location" class="form-label">
                            <i class="fa fa-map-marker-alt text-danger ms-1"></i>
                            محل تحویل
                        </label>
                        <select id="pickup_location" class="form-select" name="pickup_location"
                            wire:model.live.debounce.1000ms="pickup_location">
                            <option value="">مکان را انتخاب کنید</option>
                            @foreach ($this->locationCosts as $location => $costs)
                                <option value="{{ $location }}">{{ $location }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3 col-12 col-md-6">
                        <label for="return_location" class="form-label">
                            <i class="fa fa-map-marked-alt text-danger ms-1"></i>
                            محل بازگشت
                        </label>
                        <select id="return_location" class="form-select" name="return_location"
                            wire:model.live.debounce.1000ms="return_location">
                            <option value="">مکان را انتخاب کنید</option>
                            @foreach ($this->locationCosts as $location => $costs)
                                <option value="{{ $location }}">{{ $location }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            @error('return_location')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div id="date-error" class="bad-feedback d-none">تاریخ بازگشت باید بعد از تاریخ تحویل باشد</div>
                </div>
                <!-- End profile-step -->

                <!-- Start car step -->
                <div class="step step-1 row car-step" wire:ignore.self>
                    <header class="col-12 mb-5">
                        <h1>انتخاب خودروی دلخواه</h1>
                        <p class="lead text-muted">مدل مورد نظر خود را از لیست زیر انتخاب کنید</p>
                    </header>

                    <!-- Brand Filter -->
                    <div class="col-12 col-md-6 mb-4">
                        <div class="input-group" dir="ltr">
                            <span class="input-group-text bg-light border-start-0">
                                <i class="fas fa-filter text-muted"></i>
                            </span>
                            <select id="brand" class="form-select border-end-0 ps-0"
                                wire:model.live="selectedBrand">
                                <option value="">همه برندها</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand }}">{{ $brand }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-12" id="month-car">
                        @foreach ($cars as $car)
                            <div class="car-card mt-2 mb-4 position-relative overflow-hidden {{ $selectedCar?->id === $car->id ? 'card-active' : '' }}"
                                wire:key="car-{{ $car->id }}">
                                <div class="card border-0 shadow-sm h-100 overflow-hidden">
                                    <div class="row g-0">
                                        <!-- Car Image -->
                                        <div class="col-md-4 car-image-container p-3">
                                            <div class="ratio ratio-16x9 position-relative rounded-3 overflow-hidden">
                                                <img loading="lazy"
                                                    src="{{ $car->carModel->image ? asset('assets/car-pics/' . $car->carModel->image->file_name) : asset('assets/car-pics/car test.webp') }}"
                                                    class="w-100 h-100 object-fit-cover"
                                                    alt="{{ $car->carModel->brand }}">
                                                <div class="position-absolute bottom-0 start-0 end-0 p-2 text-center">
                                                    <span class="badge bg-dark bg-opacity-10 text-dark fs-6 fw-normal">
                                                        مدل {{ $car->manufacturing_year }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Car Details -->
                                        <div class="col-md-8">
                                            <div class="card-body p-4">
                                                <!-- Header -->
                                                <div class="d-flex justify-content-between align-items-start mb-3">
                                                    <h3 class="card-title fw-bold mb-0">
                                                        {{ $car->carModel->brand }}
                                                        <span class="text-danger">{{ $car->carModel->model }}</span>
                                                    </h3>
                                                    @if ($car->carModel->is_featured)
                                                        <span
                                                            class="badge bg-warning text-dark position-absolute top-0 end-0 m-2">
                                                            ویژه
                                                        </span>
                                                    @endif
                                                    <button type="button"
                                                        class="btn btn-select-car {{ $selectedCar?->id === $car->id ? 'selected' : '' }}"
                                                        wire:click="selectCar({{ $car->id }})">
                                                        @if ($selectedCar?->id === $car->id)
                                                            <i class="fas fa-check-circle me-1"></i> انتخاب شده
                                                        @else
                                                            <i class="fas fa-car me-1"></i> انتخاب خودرو
                                                        @endif
                                                    </button>
                                                </div>

                                                <!-- Pricing -->
                                                <div class="pricing-card mb-4">
                                                    <div class="row g-2">
                                                        <div class="col-6 col-md-3">
                                                            <div class="price-box bg-light rounded p-2 text-center">
                                                                <div class="text-muted small">1-6 روز</div>
                                                                <div class="fw-bold text-danger fs-5">
                                                                    {{ $car->price_per_day_short }} درهم
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-md-3">
                                                            <div class="price-box bg-light rounded p-2 text-center">
                                                                <div class="text-muted small">7-28 روز</div>
                                                                <div class="fw-bold text-danger fs-5">
                                                                    {{ $car->price_per_day_mid }} درهم
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-md-3">
                                                            <div class="price-box bg-light rounded p-2 text-center">
                                                                <div class="text-muted small">+28 روز</div>
                                                                <div class="fw-bold text-danger fs-5">
                                                                    {{ $car->price_per_day_long }} درهم
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Features & Badges -->
                                                @php
                                                    $optionColors = [
                                                        'gear' => 'text-primary',
                                                        'seats' => 'text-info',
                                                        'doors' => 'text-warning',
                                                        'luggage' => 'text-secondary',
                                                        'min_days' => 'text-dark',
                                                        'unlimited_km' => 'text-purple',
                                                        'fuel_type' => 'text-danger',
                                                        'engine_size' => 'text-muted',
                                                    ];
                                                    $optionPriority = [
                                                        'engine_size',
                                                        'unlimited_km',
                                                        'min_days',
                                                        'seats',
                                                        'doors',
                                                        'luggage',
                                                        'fuel_type',
                                                    ];
                                                    $sortedOptions = $car->options->sortBy(function ($option) use (
                                                        $optionPriority,
                                                    ) {
                                                        $index = array_search($option->option_key, $optionPriority);
                                                        return $index !== false ? $index : PHP_INT_MAX;
                                                    });
                                                    $optionMap = [
                                                        'gear' => [
                                                            'icon' => 'fas fa-cog',
                                                            'labels' => [
                                                                'automatic' => 'اتوماتیک',
                                                                'manual' => 'دنده‌ای',
                                                            ],
                                                        ],
                                                        'seats' => [
                                                            'icon' => 'fas fa-user-friends',
                                                            'label_suffix' => ' صندلی',
                                                        ],
                                                        'doors' => [
                                                            'icon' => 'fas fa-door-open',
                                                            'label_suffix' => ' درب',
                                                        ],
                                                        'luggage' => [
                                                            'icon' => 'fas fa-suitcase',
                                                            'label_suffix' => ' چمدان',
                                                        ],
                                                        'min_days' => [
                                                            'icon' => 'fas fa-calendar-day',
                                                            'label_suffix' => ' روز حداقل',
                                                        ],
                                                        'unlimited_km' => [
                                                            'icon' => 'fas fa-infinity',
                                                            'label' => 'مسافت نامحدود',
                                                        ],
                                                        'fuel_type' => [
                                                            'icon' => 'fas fa-gas-pump',
                                                            'labels' => [
                                                                'petrol' => 'بنزینی',
                                                                'diesel' => 'دیزلی',
                                                                'hybrid' => 'هیبرید',
                                                                'electric' => 'الکتریکی',
                                                            ],
                                                        ],
                                                        'engine_size' => [
                                                            'icon' => 'fas fa-tachometer-alt',
                                                            'label_suffix' => ' cc حجم موتور',
                                                        ],
                                                    ];
                                                @endphp

                                                <div class="features-section">
                                                    <div class="row g-3">
                                                        @foreach ($sortedOptions as $option)
                                                            @php
                                                                $key = $option->option_key;
                                                                $value = $option->option_value;
                                                                $map = $optionMap[$key] ?? null;
                                                                $iconClass = $map['icon'] ?? 'fas fa-info-circle';
                                                                $colorClass = $optionColors[$key] ?? 'text-muted';
                                                                $text =
                                                                    isset($map['labels']) && is_array($map['labels'])
                                                                        ? $map['labels'][$value] ?? $value
                                                                        : (isset($map['label'])
                                                                            ? $map['label']
                                                                            : (isset($map['label_suffix'])
                                                                                ? $value . $map['label_suffix']
                                                                                : $value));
                                                            @endphp

                                                            @if ($map && $value && $value !== '0')
                                                                <div class="col-6 col-md-4 col-lg-2">
                                                                    <div
                                                                        class="d-flex align-items-center gap-3 bg-white border rounded-3 p-2 shadow-sm h-100">
                                                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                                                                            style="width: 40px; height: 40px;">
                                                                            <i
                                                                                class="{{ $iconClass }} {{ $colorClass }}"></i>
                                                                        </div>
                                                                        <span
                                                                            class="text-dark small fw-medium">{{ $text }}</span>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="bad-feedback-car bad-feedback text-danger d-none">
                            @error('selectedCarId')
                                {{ $message }}
                            @enderror
                        </div>

                    </div>
                </div>
                <!-- End car-step -->

                <!-- Start addons step -->
                <div class="step step-2 row addons-step d-none" wire:ignore.self>
                    <header class="col-12 mb-5">
                        <h1>خدمات و تأیید نهایی</h1>
                        <p class="lead text-muted">
                            لطفاً هزینه‌های زیر را مرور کرده و در صورت تأیید، برای نهایی کردن رزرو اقدام کنید.
                        </p>
                    </header>

                    <!-- خدمات و تجهیزات -->
                    <div class="col-12 mb-4">
                        <h4 class="mb-3">
                            <i class="fa fa-tools text-danger ms-2"></i>
                            خدمات و تجهیزات انتخابی
                        </h4>
                        <div class="row g-3">
                            <!-- خدمات غیربیمه‌ای -->
                            @foreach ($services as $serviceId => $service)
                                @if (!in_array($serviceId, ['ldw_insurance', 'scdw_insurance']))
                                    <div class="col-md-4">
                                        <div class="card shadow-sm border-0">
                                            <div class="card-body d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center gap-3">
                                                    <input class="form-check-input ms-2" type="checkbox"
                                                        wire:model.live="selected_services"
                                                        value="{{ $serviceId }}" id="service-{{ $serviceId }}"
                                                        @if (in_array($serviceId, $selected_services)) checked @endif>
                                                    <label for="service-{{ $serviceId }}"
                                                        class="d-flex align-items-center m-0">
                                                        <i
                                                            class="fa {{ $service['icon'] }} text-primary ms-2 fs-5"></i>
                                                        <span class="fw-semibold">{{ $service['label_fa'] }}</span>
                                                    </label>
                                                </div>
                                                <small class="text-muted">
                                                    @php
                                                        $price = $service['per_day']
                                                            ? ($service['amount'] ?? 0) * $rental_days
                                                            : $service['amount'] ?? 0;
                                                    @endphp
                                                    @if ($price == 0)
                                                        <span class="badge bg-success">رایگان</span>
                                                    @else
                                                        {{ number_format($price) }} درهم
                                                        @if ($service['per_day'])
                                                            (× {{ $rental_days }} روز)
                                                        @endif
                                                    @endif
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                            <!-- بیمه‌ها -->
                            @isset($selectedCar)
                                @foreach (['ldw_insurance', 'scdw_insurance'] as $insuranceId)
                                    @php
                                        $insurance = $services[$insuranceId] ?? null;
                                        $price =
                                            $insuranceId === 'ldw_insurance'
                                                ? ($selectedCar->ldw_price ?? 0) * $rental_days
                                                : ($selectedCar->scdw_price ?? 0) * $rental_days;
                                    @endphp
                                    @if ($insurance)
                                        <div class="col-md-4">
                                            <div class="card shadow-sm border-0">
                                                <div class="card-body d-flex justify-content-between align-items-center">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <input type="radio" class="form-check-input ms-2"
                                                            wire:model.live="selected_insurance" name="insurance"
                                                            value="{{ $insuranceId }}"
                                                            id="insurance-{{ $insuranceId }}"
                                                            @if ($selected_insurance === $insuranceId) checked @endif>
                                                        <label for="insurance-{{ $insuranceId }}"
                                                            class="d-flex align-items-center m-0">
                                                            <i
                                                                class="fa {{ $insurance['icon'] }} text-primary ms-2 fs-5"></i>
                                                            <span class="fw-semibold">{{ $insurance['label_fa'] }}</span>
                                                        </label>
                                                    </div>
                                                    <small class="text-muted">
                                                        @if ($price == 0)
                                                            <span class="badge bg-success">رایگان</span>
                                                        @else
                                                            {{ number_format($price) }} درهم (× {{ $rental_days }} روز)
                                                        @endif
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endisset
                        </div>
                    </div>

                    <!-- شرایط و ضوابط -->
                    <div class="col-12 mb-4">
                        <h4 class="mb-3">
                            <i class="fa fa-file-contract text-warning ms-2"></i>
                            شرایط و ضوابط
                        </h4>
                        <p class="text-muted">
                            با تأیید رزرو، موارد زیر را می‌پذیرید:
                        </p>
                        <ul class="list-group list-group-flush shadow-sm">
                            <li class="list-group-item">
                                <i class="fa fa-hand-holding-usd text-secondary ms-2"></i>
                                برای اطمینان از تحویل خودرو در محل هماهنگ‌شده، ودیعه‌ای بابت خلافی از مشتری دریافت
                                می‌شود. این مبلغ برای پوشش هزینه‌های احتمالی نظیر عوارض، جریمه و ... استفاده می‌شود.
                            </li>
                            <li class="list-group-item">
                                <i class="fa fa-undo text-success ms-2"></i>
                                ودیعه‌ی موقت، ۴ روز کاری پس از عودت خودرو و پس از کسر مواردی مانند جریمه، سالیک، بنزین،
                                به حساب مشتری در امارات یا ایران بازگردانده می‌شود.
                            </li>
                            <li class="list-group-item">
                                <i class="fa fa-receipt text-danger ms-2"></i>
                                کلیه هزینه‌های مربوط به جریمه، سالیک، سوخت، کارواش احتمالی، پارکینگ عمومی و فرودگاه بر
                                عهده مشتری است.
                            </li>
                            <li class="list-group-item">
                                <i class="fa fa-user-shield text-primary ms-2"></i>
                                تمامی پرداخت‌ها و بازپرداخت‌ها تنها به نام فردی که قرارداد اجاره را امضا کرده انجام
                                می‌شود. در صورت رزرو توسط شخص دیگر، بازپرداخت‌ها همچنان به نام صاحب قرارداد صورت خواهد
                                گرفت.
                            </li>
                        </ul>
                    </div>

                    <!-- تأیید نهایی -->
                    <div class="col-12 mb-4">
                        <h4 class="mb-3"><i class="fa fa-user-check text-success ms-2"></i>تأیید رزرو</h4>
                        <p class="text-muted">لطفاً موارد زیر را بررسی و تأیید نمایید:</p>
                        <div class="form-check d-flex align-items-center mb-2 ps-0">
                            <input type="checkbox" class="form-check-input m-2" id="accept_terms"
                                wire:model="accept_terms">
                            <label for="accept_terms">شرایط و ضوابط را می‌پذیرم.</label>
                        </div>
                        <div id="accept_terms_error" class="invalid-feedback text-danger text-end d-none">
                            @error('accept_terms')
                                {{ $message }}
                            @enderror
                        </div>

                    </div>
                </div>
                <!-- End addons step -->

                <!-- Start review step -->
                <div class="step step-3 row review-step d-none" wire:ignore.self>
                    <header class="col-12 mb-5">
                        <h1>مرور نهایی اطلاعات رزرو</h1>
                        <p class="lead text-muted">
                            لطفاً جزئیات زیر را با دقت بررسی کنید و در صورت صحت، به مرحله بعدی بروید.
                        </p>
                    </header>

                    <!-- Invoice Section -->
                    <div class="col-12 mb-5">
                        <div class="card shadow-sm border-0 rounded-3 overflow-hidden"
                            style="background-color: #F7F7F7;">
                            <div
                                class="card-header d-flex align-items-center justify-content-between p-3 bg-secondary">
                                <h4 class="mb-0 fs-5 fw-bold text-white">
                                    <i class="fas fa-file-invoice-dollar me-2"></i> پیش‌فاکتور هزینه‌ها
                                </h4>
                            </div>
                            <div class="card-body p-4">
                                <!-- Rental Costs -->
                                <div class="mb-4">
                                    <h5 class="fw-semibold mb-3" style="color: #4A4A4A;">هزینه‌های اجاره خودرو</h5>
                                    <div class="d-flex justify-content-between align-items-center rounded p-3 mb-2"
                                        style="background-color: #FFFFFF;">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fas fa-car fs-5 text-dark"></i>
                                            <span>هزینه اجاره خودرو (× {{ $rental_days }} روز)</span>
                                        </div>
                                        <span class="fw-semibold" style="color: #2A9D8F; font-size: 1rem;">
                                            {{ number_format($base_price) }} درهم
                                        </span>
                                    </div>
                                </div>

                                <!-- Transfer Costs -->
                                <div class="mb-4">
                                    <h5 class="fw-semibold mb-3" style="color: #4A4A4A;">هزینه‌های انتقال</h5>
                                    <div class="d-flex justify-content-between align-items-center rounded p-3 mb-2"
                                        style="background-color: #FFFFFF;">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fas fa-location-arrow fs-5 text-dark"></i>
                                            <span>هزینه انتقال (تحویل)</span>
                                        </div>
                                        <span class="fw-semibold text-dark" style="font-size: 1rem;">
                                            {{ number_format($transfer_costs['pickup']) }} درهم
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center rounded p-3 mb-2"
                                        style="background-color: #FFFFFF;">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fas fa-undo-alt fs-5 text-dark"></i>
                                            <span>هزینه انتقال (بازگشت)</span>
                                        </div>
                                        <span class="fw-semibold text-dark" style="font-size: 1rem;">
                                            {{ number_format($transfer_costs['return']) }} درهم
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center rounded p-3 fw-semibold"
                                        style="background-color: #E6F0FA;">
                                        <span>جمع هزینه انتقال</span>
                                        <span class="fw-bold" style="color: #2A9D8F; font-size: 1rem;">
                                            {{ number_format($transfer_costs['total']) }} درهم
                                        </span>
                                    </div>
                                </div>

                                <!-- Services and Insurance -->
                                @if (!empty($selected_services) || $selected_insurance)
                                    <div class="mb-4">
                                        <h5 class="fw-semibold mb-3" style="color: #4A4A4A;">خدمات و بیمه</h5>
                                        <div class="accordion" id="servicesAccordion">
                                            <div class="accordion-item border-0">
                                                <h2 class="accordion-header" id="servicesHeading">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#servicesCollapse"
                                                        aria-expanded="false" aria-controls="servicesCollapse"
                                                        style="background-color: #FFFFFF; color: #4A4A4A; font-weight: 500;">
                                                        مشاهده جزئیات خدمات و بیمه
                                                    </button>
                                                </h2>
                                                <div id="servicesCollapse" class="accordion-collapse collapse"
                                                    aria-labelledby="servicesHeading"
                                                    data-bs-parent="#servicesAccordion">
                                                    <div class="accordion-body" style="background-color: #FFFFFF;">
                                                        @foreach ($selected_services as $serviceId)
                                                            @php
                                                                $service = $services[$serviceId] ?? null;
                                                                $days = $rental_days ?? 1;
                                                                $price =
                                                                    $service && $service['per_day']
                                                                        ? ($service['amount'] ?? 0) * $days
                                                                        : $service['amount'] ?? 0;
                                                            @endphp
                                                            @if ($service && !in_array($serviceId, ['ldw_insurance', 'scdw_insurance']))
                                                                <div
                                                                    class="d-flex justify-content-between align-items-center p-2 mb-2 border-bottom">
                                                                    <div class="d-flex align-items-center gap-2">
                                                                        <i
                                                                            class="fa {{ $service['icon'] }} fs-5 text-dark"></i>
                                                                        <span>
                                                                            {{ $service['label_fa'] }}
                                                                            @if ($service['per_day'])
                                                                                (× {{ $days }} روز)
                                                                            @endif
                                                                        </span>
                                                                    </div>
                                                                    <span class="fw-semibold text-dark"
                                                                        style="font-size: 0.95rem;">
                                                                        {{ number_format($price) }} درهم
                                                                    </span>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                        @if ($selected_insurance && in_array($selected_insurance, ['ldw_insurance', 'scdw_insurance']))
                                                            @php
                                                                $insurance = $services[$selected_insurance] ?? null;
                                                                $price = $selectedCar
                                                                    ? ($selected_insurance === 'ldw_insurance'
                                                                        ? ($selectedCar->ldw_price ?? 0) * $rental_days
                                                                        : ($selectedCar->scdw_price ?? 0) *
                                                                            $rental_days)
                                                                    : 0;
                                                            @endphp
                                                            @if ($insurance && $selectedCar)
                                                                <div
                                                                    class="d-flex justify-content-between align-items-center p-2 mb-2 border-bottom">
                                                                    <div class="d-flex align-items-center gap-2">
                                                                        <i
                                                                            class="fa {{ $insurance['icon'] }} fs-5 text-dark"></i>
                                                                        <span>{{ $insurance['label_fa'] }} (×
                                                                            {{ $rental_days }} روز)</span>
                                                                    </div>
                                                                    <span class="fw-semibold text-dark"
                                                                        style="font-size: 0.95rem;">
                                                                        {{ number_format($price) }} درهم
                                                                    </span>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center rounded p-3 mt-2 fw-semibold"
                                            style="background-color: #E6F0FA;">
                                            <span>جمع کل خدمات و بیمه</span>
                                            <span class="fw-bold" style="color: #2A9D8F; font-size: 1rem;">
                                                {{ number_format($services_total + $insurance_total) }} درهم
                                            </span>
                                        </div>
                                    </div>
                                @endif

                                <!-- Totals -->
                                <div class="mb-4">
                                    <h5 class="fw-semibold mb-3" style="color: #4A4A4A;">جمع کل</h5>
                                    <div class="d-flex justify-content-between align-items-center rounded p-3 mb-2"
                                        style="background-color: #FFFFFF;">
                                        <span>جمع کل بدون مالیات</span>
                                        <span class="fw-semibold" style="color: #2A9D8F; font-size: 1rem;">
                                            {{ number_format($subtotal) }} درهم
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center rounded p-3 mb-2"
                                        style="background-color: #FFFFFF;" data-bs-toggle="tooltip"
                                        title="شامل ۵٪ مالیات بر ارزش افزوده">
                                        <span>مالیات (۵٪)</span>
                                        <span class="fw-semibold text-dark" style="font-size: 1rem;">
                                            {{ number_format($tax_amount) }} درهم
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center rounded p-3 fw-bold bg-secondary"
                                        style="color: #FFFFFF;">
                                        <span>جمع کل با مالیات</span>
                                        <span class="fw-bold" style="font-size: 1.1rem;">
                                            {{ number_format($final_total) }} درهم
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delivery and Return Details -->
                    <div class="col-12 mb-5">
                        <div class="card shadow-lg border-0 rounded-3">
                            <div class="card-header bg-secondary text-white p-3">
                                <h4 class="mb-0 fs-5 fw-bold">
                                    <i class="fas fa-calendar-alt me-2"></i> جزئیات تحویل و بازگشت
                                </h4>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fas fa-map-marker-alt text-dark fs-5"></i>
                                            <div>
                                                <strong>محل تحویل:</strong>
                                                <span>{{ $pickup_location ?: 'انتخاب نشده' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fas fa-map-marked-alt text-dark fs-5"></i>
                                            <div>
                                                <strong>محل بازگشت:</strong>
                                                <span>{{ $return_location ?: 'انتخاب نشده' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fas fa-calendar-check text-dark fs-5"></i>
                                            <div>
                                                <strong>تاریخ تحویل:</strong>
                                                <span>{{ $pickup_date ? \Carbon\Carbon::parse($pickup_date)->format('Y/m/d H:i') : 'انتخاب نشده' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fas fa-calendar-times text-dark fs-5"></i>
                                            <div>
                                                <strong>تاریخ بازگشت:</strong>
                                                <span>{{ $return_date ? \Carbon\Carbon::parse($return_date)->format('Y/m/d H:i') : 'انتخاب نشده' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Selected Car -->
                    <div class="col-12 mb-5">
                        <div class="card shadow-lg border-0 rounded-3">
                            <div class="card-header bg-secondary text-white p-3">
                                <h4 class="mb-0 fs-5 fw-bold">
                                    <i class="fas fa-car-side me-2"></i> خودروی انتخاب‌شده
                                </h4>
                            </div>
                            <div class="card-body p-4">
                                @if ($selectedCar)
                                    <div class="row g-3 align-items-center">
                                        <div class="col-md-4">
                                            <img loading="lazy"
                                                src="{{ $selectedCar->carModel->image
                                                    ? asset('assets/car-pics/' . $selectedCar->carModel->image->file_name)
                                                    : asset('assets/car-pics/car test.webp') }}"
                                                alt="Car Image" class="w-100 rounded-3 shadow-sm"
                                                style="object-fit: cover; height: 200px;" />
                                        </div>
                                        <div class="col-md-8">
                                            <h5 class="fw-bold mb-2">{{ $selectedCar->carModel->brand }}
                                                {{ $selectedCar->carModel->model }}</h5>
                                            <p class="text-muted mb-2">سال ساخت:
                                                {{ $selectedCar->manufacturing_year }}</p>
                                        </div>
                                    </div>
                                @else
                                    <p class="text-center text-muted">هیچ خودرویی انتخاب نشده است.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End review step -->

                <!-- Start profile info step -->
                <div class="step step-4 row profile-info-step d-none" wire:ignore.self>
                    <header class="col-12 mb-5">
                        <h1 class="text-2xl font-bold text-gray-800 flex items-center justify-center gap-2">
                            اطلاعات شخصی
                        </h1>
                        <p class="text-gray-600 mt-2">لطفاً نام، ایمیل و شماره تماس خود را وارد کنید</p>
                    </header>

                    <div class="col-12 col-md-6 mb-4">
                        <label for="first_name"
                            class="form-label text-gray-700 font-semibold flex items-center gap-1">
                            <i class="fas fa-user text-blue-400 w-5 h-5"></i>
                            نام
                        </label>
                        <input type="text" id="first_name" class="form-control rounded-md" name="first_name"
                            wire:model="first_name" placeholder="نام" />
                        <div class="invalid-feedback">
                            @error('first_name')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 col-md-6 mb-4">
                        <label for="last_name" class="form-label text-gray-700 font-semibold flex items-center gap-1">
                            <i class="fas fa-user text-blue-400 w-5 h-5"></i>
                            نام خانوادگی
                        </label>
                        <input type="text" id="last_name" class="form-control rounded-md" name="last_name"
                            wire:model="last_name" placeholder="نام خانوادگی" />
                        <div class="invalid-feedback">
                            @error('last_name')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 col-md-6 mb-4">
                        <label for="email" class="form-label text-gray-700 font-semibold flex items-center gap-1">
                            <i class="fas fa-envelope text-blue-400 w-5 h-5"></i>
                            آدرس ایمیل
                        </label>
                        <input type="email" id="email" class="form-control rounded-md" name="email"
                            wire:model="email" placeholder="name@example.com" />
                        <div class="invalid-feedback">
                            @error('email')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 col-md-6 mb-4">
                        <label for="phone" class="form-label text-gray-700 font-semibold flex items-center gap-1">
                            <i class="fas fa-phone text-blue-400 w-5 h-5"></i>
                            شماره تماس
                        </label>
                        <input type="tel" id="phone" class="form-control rounded-md" name="phone"
                            wire:model="phone" placeholder="مثال: 09123456789" />
                        <div class="invalid-feedback">
                            @error('phone')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 col-md-6 mb-4">
                        <label for="messenger_phone"
                            class="form-label text-gray-700 font-semibold flex items-center gap-1">
                            <i class="fab fa-telegram text-blue-400 w-5 h-5"></i>
                            شماره تلگرام/واتساپ
                        </label>
                        <input type="tel" id="messenger_phone" class="form-control rounded-md"
                            name="messenger_phone" wire:model="messenger_phone" placeholder="مثال: 09123456789" />
                        <div class="invalid-feedback">
                            @error('messenger_phone')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- End profile info step -->

                <!-- Navigation Buttons -->
                <div class="next-step mt-5 d-flex align-items-center justify-content-end" wire:ignore.self>
                    <button type="button" id="back" class="btn btn-outline-secondary me-2">بازگشت</button>
                    <button type="button" id="next" class="btn btn-red">مرحله بعد</button>
                </div>
            </form>

            <!-- Start thanks step -->
            <div class="thanks-step step d-flex align-items-center col-md-8 d-none" wire:ignore.self>
                <header class="d-flex flex-column align-items-center text-center">
                    <img class="w-50 mb-4" src="{{ asset('assets/reserve/assets/images/icon-thank-you.svg') }}"
                        alt="Thank You Icon" />
                    <h1 class="display-4">سپاس از رزرو شما!</h1>
                    <p class="text-center lead mb-4">
                        درخواست اجاره شما با موفقیت ثبت شد. کارشناسان ما به زودی برای تایید و اطلاعات بیشتر با شما تماس
                        خواهند گرفت.
                    </p>
                    <div class="alert alert-secondary w-100 mb-4" role="alert">
                        <strong>توجه:</strong> لطفاً ایمیل خود را برای دریافت به‌روزرسانی‌های رزرو بررسی کنید
                    </div>
                    <p>در صورت نیاز به کمک می‌توانید با ما تماس بگیرید</p>
                    <a href="https://karaplusrental.com/" class="btn btn-primary mt-4">بازگشت به صفحه اصلی</a>
                </header>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style>
        .center-box {
            width: 100%;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .wrapper {
            width: 100%;
            min-width: 800px;
            max-width: 1200px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .step {
            transition: all 0.3s ease-in-out;
        }

        .card {
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-3px);
        }

        .accordion-button {
            font-size: 0.95rem;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            transition: background-color 0.3s ease;
        }

        .accordion-button:not(.collapsed) {
            background-color: #E6F0FA;
            color: #2B2D42;
        }

        .accordion-body {
            padding: 1rem;
        }

        .fw-semibold {
            font-weight: 600;
        }

        .car-card {
            width: 100%;
        }

        @media (max-width: 576px) {
            .wrapper {
                min-width: 100%;
                padding: 1rem;
            }

            .card-body {
                padding: 1rem;
            }

            .fw-semibold {
                font-size: 0.9rem;
            }
        }
    </style>
@endpush
