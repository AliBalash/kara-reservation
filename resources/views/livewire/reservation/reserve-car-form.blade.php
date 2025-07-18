<!-- main container start -->
<div class="center-box d-flex justify-content-center align-items-center">
    <div class="wrapper p-4">
        <div class="gx-1">
            <form class="col-md-12 p-1 needs-validation" id="checkoutForm" action="{{ route('reserve.car') }}"
                method="post" novalidate>
                @csrf

                <!-- Start profile step - ترجمه و RTL -->
                <div class="step step-1 row profile-step d-none" wire:ignore.self>
                    <header class="col-12 mb-5">
                        <h1>اطلاعات قرارداد</h1>
                        <p class="lead">لطفا اطلاعات مکان و تاریخ را وارد کنید</p>
                    </header>


                    <div class="mb-3 col-12 col-md-6">
                        <label for="pickup_date" class="form-label">
                            <i class="fa fa-calendar-alt text-danger ms-1"></i>
                            تاریخ و زمان تحویل
                        </label>
                        <input type="datetime-local" id="pickup_date" class="form-control" name="pickup_date"
                            wire:model.live.debounce.500ms="pickup_date" placeholder="تاریخ و زمان تحویل"
                            min="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}" />
                        <div class="invalid-feedback">تاریخ تحویل الزامی است</div>
                    </div>

                    <div class="mb-3 col-12 col-md-6">
                        <label for="return_date" class="form-label">
                            <i class="fa fa-calendar-check text-danger ms-1"></i>
                            تاریخ و زمان بازگشت
                        </label>
                        <input type="datetime-local" id="return_date" class="form-control" name="return_date"
                            wire:model.live.debounce.500ms="return_date" placeholder="تاریخ و زمان بازگشت"
                            min="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}" />
                        <div class="invalid-feedback">تاریخ بازگشت الزامی است</div>
                    </div>

                    <div class="mb-3 col-12 col-md-6">
                        <label for="pickup_location" class="form-label">
                            <i class="fa fa-map-marker-alt text-danger ms-1"></i>
                            محل تحویل
                        </label>
                        <select id="pickup_location" class="form-select" name="pickup_location"
                            wire:model.live.debounce.1000ms="pickup_location">
                            <option value="">مکان را انتخاب کنید</option>
                            <option value="UAE/Dubai/Clock Tower/Main Branch">امارات / دبی / برج ساعت / شعبه اصلی
                            </option>
                            <option value="UAE/Dubai/Dubai Airport/Terminal 1">امارات / دبی / فرودگاه دبی / ترمینال ۱
                            </option>
                            <option value="UAE/Dubai/Dubai Airport/Terminal 2">امارات / دبی / فرودگاه دبی / ترمینال ۲
                            </option>
                            <option value="UAE/Dubai/Dubai Airport/Terminal 3">امارات / دبی / فرودگاه دبی / ترمینال ۳
                            </option>
                            <option value="UAE/Dubai/Downtown">امارات / دبی / مرکز شهر (داون‌تاون)</option>
                            <option value="UAE/Dubai/Jumeirah 1, 2, 3">امارات / دبی / جمیرا ۱، ۲، ۳</option>
                            <option value="UAE/Dubai/Palm">امارات / دبی / پالم</option>
                            <option value="UAE/Dubai/Damac Hills">امارات / دبی / داماک هیلز</option>
                            <option value="UAE/Dubai/JVC">امارات / دبی / JVC</option>
                            <option value="UAE/Dubai/JLT">امارات / دبی / JLT</option>
                            <option value="UAE/Dubai/Marina">امارات / دبی / مارینا</option>
                            <option value="UAE/Dubai/JBR">امارات / دبی / JBR</option>
                            <option value="UAE/Dubai/Jebel Ali – Ibn Battuta – Hatta & more">امارات / دبی / جبل علی –
                                ابن بطوطه – حتا و غیره</option>
                            <option value="UAE/Sharjah Airport">امارات / فرودگاه شارجه</option>
                            <option value="UAE/Abu Dhabi Airport">امارات / فرودگاه ابوظبی</option>
                            <!-- سایر گزینه‌ها به فارسی ترجمه شوند -->
                        </select>
                        <div class="invalid-feedback">لطفا محل تحویل معتبر انتخاب کنید</div>
                    </div>

                    <div class="mb-3 col-12 col-md-6">
                        <label for="return_location" class="form-label">
                            <i class="fa fa-map-marked-alt text-danger ms-1"></i>
                            محل بازگشت
                        </label>
                        <select id="return_location" class="form-select" name="return_location"
                            wire:model.live.debounce.1000ms="return_location">
                            <option value="">مکان را انتخاب کنید</option>
                            <option value="UAE/Dubai/Clock Tower/Main Branch">امارات / دبی / برج ساعت / شعبه اصلی
                            </option>
                            <option value="UAE/Dubai/Dubai Airport/Terminal 1">امارات / دبی / فرودگاه دبی / ترمینال ۱
                            </option>
                            <option value="UAE/Dubai/Dubai Airport/Terminal 2">امارات / دبی / فرودگاه دبی / ترمینال ۲
                            </option>
                            <option value="UAE/Dubai/Dubai Airport/Terminal 3">امارات / دبی / فرودگاه دبی / ترمینال ۳
                            </option>
                            <option value="UAE/Dubai/Downtown">امارات / دبی / مرکز شهر (داون‌تاون)</option>
                            <option value="UAE/Dubai/Jumeirah 1, 2, 3">امارات / دبی / جمیرا ۱، ۲، ۳</option>
                            <option value="UAE/Dubai/Palm">امارات / دبی / پالم</option>
                            <option value="UAE/Dubai/Damac Hills">امارات / دبی / داماک هیلز</option>
                            <option value="UAE/Dubai/JVC">امارات / دبی / JVC</option>
                            <option value="UAE/Dubai/JLT">امارات / دبی / JLT</option>
                            <option value="UAE/Dubai/Marina">امارات / دبی / مارینا</option>
                            <option value="UAE/Dubai/JBR">امارات / دبی / JBR</option>
                            <option value="UAE/Dubai/Jebel Ali – Ibn Battuta – Hatta & more">امارات / دبی / جبل علی –
                                ابن بطوطه – حتا و غیره</option>
                            <option value="UAE/Sharjah Airport">امارات / فرودگاه شارجه</option>
                            <option value="UAE/Abu Dhabi Airport">امارات / فرودگاه ابوظبی</option>
                            <!-- سایر گزینه‌ها به فارسی ترجمه شوند -->
                        </select>
                        <div class="invalid-feedback">لطفا محل بازگشت معتبر انتخاب کنید</div>
                    </div>

                    <div id="date-error" class="bad-feedback d-none">تاریخ بازگشت باید بعد از تاریخ تحویل باشد</div>
                </div>
                <!-- End profile-step -->

                <!-- Start car step -->
                <div class="step row car-step" wire:ignore.self>
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

                                <input type="radio" name="carId" id="car-{{ $car->id }}"
                                    class="form-check-input car-type d-none" value="{{ $car->id }}"
                                    {{ $selectedCar?->id === $car->id ? 'checked' : '' }} />

                                <div class="card border-0 shadow-sm h-100 overflow-hidden">
                                    <div class="row g-0">
                                        <!-- Car Image -->
                                        <div class="col-md-4 car-image-container p-3">
                                            <div class="ratio ratio-16x9 position-relative rounded-3 overflow-hidden">
                                                <img loading="lazy"
                                                    src="{{ $car->carModel->image ? 'https://mypanel.karaplusrental.com/assets/car-pics/' . $car->carModel->image->file_name : asset('assets/car-pics/car test.webp') }}"
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

                                                    <h1>
                                                        @if ($car->carModel->is_featured)
                                                            <span
                                                                class="badge bg-warning text-dark position-absolute top-0 end-0 m-2">
                                                                ویژه</span>
                                                        @endif
                                                    </h1>

                                                    <!-- New selection button -->
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
                                                                    {{ $car->price_per_day_short }} درهم</div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-md-3">
                                                            <div class="price-box bg-light rounded p-2 text-center">
                                                                <div class="text-muted small">7-20 روز</div>
                                                                <div class="fw-bold text-danger fs-5">
                                                                    {{ $car->price_per_day_mid }} درهم</div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-md-3">
                                                            <div class="price-box bg-light rounded p-2 text-center">
                                                                <div class="text-muted small">+20 روز</div>
                                                                <div class="fw-bold text-danger fs-5">
                                                                    {{ $car->price_per_day_long }} درهم</div>
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
                                                        'base_insurance' => 'text-success',
                                                        'min_days' => 'text-dark',
                                                        'unlimited_km' => 'text-purple',
                                                        'fuel_type' => 'text-danger',
                                                        'engine_size' => 'text-muted',
                                                    ];
                                                @endphp

                                                @php
                                                    $optionPriority = [
                                                        'engine_size',
                                                        'unlimited_km',
                                                        'base_insurance',
                                                        'min_days',
                                                        'seats',
                                                        'doors',
                                                        'luggage',
                                                        'fuel_type',
                                                    ];
                                                @endphp
                                                @php
                                                    $sortedOptions = $car->options->sortBy(function ($option) use (
                                                        $optionPriority,
                                                    ) {
                                                        $index = array_search($option->option_key, $optionPriority);
                                                        return $index !== false ? $index : PHP_INT_MAX; // چیزایی که تو لیست نیستن آخر قرار می‌گیرن
                                                    });
                                                @endphp
                                                @php
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
                                                        'base_insurance' => [
                                                            'icon' => 'fas fa-shield-alt',
                                                            'label' => 'بیمه پایه',
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

                                                                // آیکن و رنگ را آماده کن
                                                                $iconClass = $map['icon'] ?? 'fas fa-info-circle';
                                                                $colorClass = $optionColors[$key] ?? 'text-muted';

                                                                // متن نهایی
                                                                if (isset($map['labels']) && is_array($map['labels'])) {
                                                                    $text = $map['labels'][$value] ?? $value;
                                                                } elseif (isset($map['label'])) {
                                                                    $text = $map['label'];
                                                                } elseif (isset($map['label_suffix'])) {
                                                                    $text = $value . $map['label_suffix'];
                                                                } else {
                                                                    $text = $value;
                                                                }
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
                    </div>


                    <div class="bad-feedback-car bad-feedback d-none">لطفاً یک خودرو انتخاب کنید.</div>
                </div>
                <!-- End car-step -->


                <!-- Start addons step -->
                <div class="step step-4 row review-step d-none" wire:ignore.self>


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
                        <div class="g-3">

                            @foreach ($services as $serviceId => $service)
                                <div class="col-md-4">
                                    <div class="card shadow-sm border-0">
                                        <div class="card-body d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center gap-3">
                                                <input class="form-check-input ms-2" type="checkbox"
                                                    wire:model.live="selected_services" name="selected_services[]"
                                                    value="{{ $serviceId }}" id="{{ $serviceId }}">
                                                <label for="{{ $serviceId }}"
                                                    class="d-flex align-items-center m-0">
                                                    <i class="fa {{ $service['icon'] }} text-primary ms-2 fs-5"></i>
                                                    <span class="fw-semibold">{{ $service['label'] }}</span>
                                                </label>
                                            </div>
                                            <small class="text-muted">
                                                @if ($service['amount'] == 0)
                                                    <span class="badge bg-success">رایگان</span>
                                                @else
                                                    {{ number_format($service['amount']) }} درهم
                                                    @if ($service['per_day'])
                                                        /روز
                                                    @endif
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            @isset($selectedCar)
                                {{-- بیمه LDW --}}
                                <div class="col-md-4">
                                    <div class="card shadow-sm border-0">
                                        <div class="card-body d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center gap-3">
                                                <input type="radio" class="form-check-input ms-2"
                                                    wire:model.live="selected_insurance" name="insurance"
                                                    {{-- نام گروه --}} value="ldw_insurance" id="ldw_insurance">
                                                <label for="ldw_insurance" class="d-flex align-items-center m-0">
                                                    <i class="fa fa-car-burst text-primary ms-2 fs-5"></i>
                                                    <span class="fw-semibold">بیمه LDW</span>
                                                </label>
                                            </div>
                                            <small class="text-muted">
                                                @if ($selectedCar->ldw_price == 0)
                                                    <span class="badge bg-success">رایگان</span>
                                                @else
                                                    {{ number_format($selectedCar->ldw_price) }} درهم /روز
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                {{-- بیمه SCDW --}}
                                <div class="col-md-4">
                                    <div class="card shadow-sm border-0">
                                        <div class="card-body d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center gap-3">
                                                <input type="radio" class="form-check-input ms-2"
                                                    wire:model.live="selected_insurance" name="insurance"
                                                    value="scdw_insurance" id="scdw_insurance">
                                                <label for="scdw_insurance" class="d-flex align-items-center m-0">
                                                    <i class="fa fa-lock text-primary ms-2 fs-5"></i>
                                                    <span class="fw-semibold">بیمه کامل SCDW</span>
                                                </label>
                                            </div>
                                            <small class="text-muted">
                                                @if ($selectedCar->scdw_price == 0)
                                                    <span class="badge bg-success">رایگان</span>
                                                @else
                                                    {{ number_format($selectedCar->scdw_price) }} درهم /روز
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                </div>
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

                        {{-- <div class="form-check d-flex align-items-center mb-2 ps-0">
                            <input type="checkbox" class="form-check-input m-2" id="confirm_deposit" />
                            <label class="form-check-label text-dark" for="confirm_deposit">
                                جزئیات ودیعه و پرداخت را تأیید می‌کنم.
                            </label>
                        </div> --}}
                        <div id="confirm_deposit_error" class="invalid-feedback d-block text-danger text-end"></div>

                        <div class="form-check d-flex align-items-center mb-2 ps-0">
                            <input type="checkbox" class="form-check-input m-2" id="accept_terms" />
                            <label class="form-check-label text-dark" for="accept_terms">
                                شرایط و ضوابط را می‌پذیرم.
                            </label>
                        </div>
                        <div id="accept_terms_error" class="invalid-feedback d-block text-danger text-end"></div>
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

                    <!-- پیش‌فاکتور هزینه‌ها -->
                    <div class="col-12 mb-5">
                        <h4 class="text-xl text-gray-800 mb-3 flex items-center gap-2">
                            <i class="fas fa-file-invoice-dollar text-blue-600"></i> پیش‌فاکتور هزینه‌ها
                        </h4>
                        <ul class="list-group shadow-sm rounded-lg overflow-hidden">

                            {{-- هزینه اجاره خودرو --}}
                            @if ($selectedCar)
                                @php
                                    $days = $rental_days ?? 1;

                                    if ($days >= 21) {
                                        $dailyRate = $selectedCar->price_per_day_long;
                                    } elseif ($days >= 7) {
                                        $dailyRate = $selectedCar->price_per_day_mid;
                                    } else {
                                        $dailyRate = $selectedCar->price_per_day_short;
                                    }

                                    $carCost = $dailyRate * $days;
                                @endphp
                                <li class="list-group-item d-flex justify-content-between align-items-center text-success"
                                    style="background:#fefefe; border-bottom:2px solid #ccc;">
                                    <div>
                                        <i class="fas fa-car text-blue-600 text-dark ms-2"></i>
                                        هزینه اجاره خودرو (× {{ $days }} روز)
                                    </div>
                                    <span class="badge bg-success rounded-pill px-3 py-2" style="font-size:1rem;">
                                        {{ number_format($carCost) }} درهم
                                    </span>
                                </li>
                            @endif


                            {{-- هزینه انتقال تحویل --}}
                            <li class="list-group-item d-flex justify-content-between align-items-center"
                                style="background:#fefefe; border-bottom:1px solid #eee;">
                                <div>
                                    <i class="fas fa-location-arrow text-blue-600 ms-2"></i>
                                    هزینه انتقال (تحویل)
                                </div>
                                <span class="badge bg-primary rounded-pill px-3 py-2" style="font-size:1rem;">
                                    {{ number_format($this->transferCosts['pickup']) }} درهم
                                </span>
                            </li>

                            {{-- هزینه انتقال بازگشت --}}
                            <li class="list-group-item d-flex justify-content-between align-items-center"
                                style="background:#fefefe; border-bottom:1px solid #eee;">
                                <div>
                                    <i class="fas fa-undo-alt text-blue-600 ms-2"></i>
                                    هزینه انتقال (بازگشت)
                                </div>
                                <span class="badge bg-primary rounded-pill px-3 py-2" style="font-size:1rem;">
                                    {{ number_format($this->transferCosts['return']) }} درهم
                                </span>
                            </li>

                            {{-- جمع هزینه انتقال --}}
                            <li class="list-group-item d-flex justify-content-between align-items-center fw-semibold text-success"
                                style="background:#fefefe; border-bottom:2px solid #ccc;">
                                <div>جمع هزینه انتقال</div>
                                <span class="badge bg-success rounded-pill px-3 py-2" style="font-size:1rem;">
                                    {{ number_format($this->transferCosts['total']) }} درهم
                                </span>
                            </li>


                            @if (!empty($selected_services) || $selected_insurance)


                                {{-- سپس سایر سرویس‌های checkbox --}}
                                @foreach ($selected_services as $serviceId)
                                    @php
                                        $service = $services[$serviceId] ?? null;
                                        $days = $rental_days ?? 1;
                                        $price = $service['per_day'] ? $service['amount'] * $days : $service['amount'];
                                    @endphp

                                    @if ($service)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="fa {{ $service['icon'] }} ms-2 fs-5"></i>
                                                {{ $service['label'] }}
                                                @if ($service['per_day'])
                                                    (× {{ $days }} روز)
                                                @endif
                                            </div>
                                            <span class="badge bg-primary rounded-pill px-3 py-2">
                                                {{ number_format($price) }} درهم
                                            </span>
                                        </li>
                                    @endif
                                @endforeach
                                {{-- اول بیمهٔ انتخاب‌شده (radio) --}}
                                @if ($selected_insurance)
                                    @php
                                        // تشخیص عنوان و قیمت بیمه‌ی انتخابی
                                        if ($selected_insurance === 'ldw_insurance') {
                                            $label = 'بیمه LDW';
                                            $price = $selectedCar->ldw_price;
                                        } elseif ($selected_insurance === 'scdw_insurance') {
                                            $label = 'بیمه کامل SCDW';
                                            $price = $selectedCar->scdw_price;
                                        }
                                        $days = $rental_days ?? 1;
                                        $totalPrice = $price * $days;
                                    @endphp
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="fa fa-car-burst ms-2 fs-5"></i>
                                            {{ $label }} (× {{ $days }} روز)
                                        </div>
                                        <span class="badge bg-primary rounded-pill px-3 py-2">
                                            {{ number_format($totalPrice) }} درهم
                                        </span>
                                    </li>
                                @endif
                                {{-- جمع کل --}}
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center fw-semibold text-success">
                                    <div>جمع کل خدمات و بیمه</div>
                                    <span class="badge bg-success rounded-pill px-3 py-2">
                                        {{ number_format($services_total) }} درهم
                                    </span>
                                </li>
                            @endif


                            {{-- محاسبه کل نهایی (انتقال + اجاره خودرو + خدمات) --}}
                            @php
                                $transferTotal = $this->transferCosts['total'] ?? 0;
                                $servicesTotal = $services_total ?? 0;
                                $rentalTotal = isset($carCost) ? $carCost : 0;
                                $invoiceTotal = $transferTotal + $rentalTotal + $servicesTotal;
                                // محاسبه مالیات ۵٪
                                $taxAmount = round($invoiceTotal * 0.05);
                                $totalWithTax = $invoiceTotal + $taxAmount;
                            @endphp
                            <li class="list-group-item d-flex justify-content-between align-items-center fw-bold text-white"
                                style="background:#007bff;">
                                <div>جمع کل نهایی</div>
                                <span class="badge bg-white text-primary rounded-pill px-3 py-2"
                                    style="font-size:1rem;">
                                    {{ number_format($invoiceTotal) }} درهم
                                </span>
                            </li>

                            {{-- مالیات ۵٪ --}}
                            <li class="list-group-item d-flex justify-content-between align-items-center"
                                style="background:#fefefe; border-bottom:1px solid #eee;">
                                <div>مالیات (۵٪)</div>
                                <span class="badge bg-warning text-dark rounded-pill px-3 py-2"
                                    style="font-size:1rem;">
                                    {{ number_format($taxAmount) }} درهم
                                </span>
                            </li>

                            {{-- جمع کل با مالیات --}}
                            <li class="list-group-item d-flex justify-content-between align-items-center fw-semibold text-success"
                                style="background:#fefefe; border-bottom:2px solid #ccc;">
                                <div>جمع کل با مالیات</div>
                                <span class="badge bg-success rounded-pill px-3 py-2" style="font-size:1rem;">
                                    {{ number_format($totalWithTax) }} درهم
                                </span>
                            </li>

                        </ul>
                    </div>

                    <!-- جزئیات تحویل و بازگشت -->
                    <div class="col-12 mb-5">
                        <h4 class="text-xl text-gray-800 mb-3 flex items-center gap-2">
                            <i class="fas fa-calendar-alt text-blue-600"></i> جزئیات تحویل و بازگشت
                        </h4>
                        <ul class="list-group overflow-hidden">
                            <li class="list-group-item border-bottom">
                                <strong>محل تحویل:</strong> {{ $pickup_location }}
                            </li>
                            <li class="list-group-item border-bottom">
                                <strong>محل بازگشت:</strong> {{ $return_location }}
                            </li>
                            <li class="list-group-item border-bottom">
                                <strong>تاریخ تحویل:</strong>
                                {{ \Carbon\Carbon::parse($pickup_date)->format('Y/m/d H:i') }}
                            </li>
                            <li class="list-group-item">
                                <strong>تاریخ بازگشت:</strong>
                                {{ \Carbon\Carbon::parse($return_date)->format('Y/m/d H:i') }}
                            </li>
                        </ul>
                    </div>
                    <!-- خودروی انتخاب‌شده -->
                    <div class="col-12 mb-5">
                        <h4 class="text-xl text-gray-800 mb-3 flex gap-2">
                            <i class="fas fa-car-side text-blue-600"></i> خودروی انتخاب شده
                        </h4>
                        @if ($selectedCar)
                            <div class="overflow-hidden" style="max-width: 400px">
                                <img loading="lazy"
                                    src="{{ $selectedCar->carModel->image
                                        ? asset('assets/car-pics/' . $selectedCar->carModel->image->file_name)
                                        : asset('assets/car-pics/car test.webp') }}"
                                    alt="Car Image" style="width: 100%; height: auto; object-fit: cover;" />
                                <div class="card-body p-4">
                                    <h5 class="card-title text-lg font-semibold text-gray-900 mb-2">
                                        {{ $selectedCar->carModel->brand }} {{ $selectedCar->carModel->model }}
                                    </h5>
                                    <p class="card-text text-gray-700">
                                        سال ساخت: {{ $selectedCar->manufacturing_year }}
                                    </p>
                                </div>
                            </div>
                        @else
                            <p class="text-center text-gray-600 mt-4">هیچ خودرویی انتخاب نشده است.</p>
                        @endif
                    </div>

                </div>
                <!-- End review step -->

                <!-- Start profile info step -->
                <div class="step row review-step d-none" wire:ignore.self>
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
                            wire:model="first_name" placeholder="نام " />
                        <div class="invalid-feedback">وارد کردن نام الزامی است!</div>
                    </div>

                    <div class="col-12 col-md-6 mb-4">
                        <label for="last_name" class="form-label text-gray-700 font-semibold flex items-center gap-1">
                            <i class="fas fa-user text-blue-400 w-5 h-5"></i>
                            نام خانوادگی
                        </label>
                        <input type="text" id="last_name" class="form-control rounded-md" name="last_name"
                            wire:model="last_name" placeholder="نام خانوادگی" />
                        <div class="invalid-feedback">وارد کردن نام خانوادگی الزامی است!</div>
                    </div>

                    <div class="col-12 col-md-6 mb-4">
                        <label for="email" class="form-label text-gray-700 font-semibold flex items-center gap-1">
                            <i class="fas fa-envelope text-blue-400 w-5 h-5"></i>
                            آدرس ایمیل
                        </label>
                        <input type="email" id="email" class="form-control rounded-md" name="email"
                            wire:model="email" placeholder="name@example.com" />
                        <div class="invalid-feedback">ایمیل معتبر الزامی است!</div>
                    </div>

                    <div class="col-12 col-md-6 mb-4">
                        <label for="phone" class="form-label text-gray-700 font-semibold flex items-center gap-1">
                            <i class="fas fa-phone text-blue-400 w-5 h-5"></i>
                            شماره تماس
                        </label>
                        <input type="tel" id="phone" class="form-control rounded-md" name="phone"
                            wire:model="phone" placeholder="مثال: 09123456789" />
                        <div class="invalid-feedback">وارد کردن شماره تماس الزامی است!</div>
                    </div>

                    <div class="col-12 col-md-6 mb-4">
                        <label for="messenger_phone"
                            class="form-label text-gray-700 font-semibold flex items-center gap-1">
                            <i class="fab fa-telegram text-blue-400 w-5 h-5"></i>
                            شماره تلگرام/واتساپ
                        </label>
                        <input type="tel" id="messenger_phone" class="form-control rounded-md"
                            name="messenger_phone" wire:model="messenger_phone" placeholder="مثال: 09123456789" />
                        <div class="invalid-feedback">وارد کردن شماره پیام‌رسان الزامی است!</div>
                    </div>
                </div>
                <!-- End profile info step -->

                <!-- تغییر جهت دکمه‌ها برای RTL -->
                <div class="next-step mt-5 d-flex align-items-center" wire:ignore.self>
                    <button type="button" id="next" class="btn btn-red">مرحله بعد</button>
                    <button type="button" id="back" class="fw-bold btn me-2">بازگشت</button>
                </div>

            </form>
            <!-- Start thanks step - ترجمه -->
            <div class="thanks-step step d-flex align-items-center col-md-8 d-none">
                <header class="d-flex flex-column align-items-center text-center">
                    <img class="w-50 mb-4" src="{{ asset('assets/reserve/assets/images/icon-thank-you.svg') }}"
                        alt="Thank You Icon" />
                    <h1 class="display-4">سپاس از رزرو شما!</h1>
                    <p class="text-center lead mb-4">
                        درخواست اجاره شما با موفقیت ثبت شد. کارشناسان ما به زودی برای تایید و اطلاعات بیشتر با شما تماس
                        خواهند گرفت.
                    </p>
                    <div class="alert alert-secondary w-100 mb-4" role="alert">
                        <strong>توجه:</strong> لطفا ایمیل خود را برای دریافت به‌روزرسانی‌های رزرو بررسی کنید
                    </div>
                    <p>در صورت نیاز به کمک می‌توانید با ما تماس بگیرید</p>
                    <a href="https://karaplusrental.com/" class="btn btn-primary mt-4">بازگشت به صفحه اصلی</a>
                </header>
            </div>
        </div>
    </div>
</div>
