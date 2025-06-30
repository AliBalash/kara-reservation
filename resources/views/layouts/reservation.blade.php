<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <!-- displays site properly based on user's device -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}

    <!-- اضافه کردن فونت فارسی (Vazir) -->
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazir-font@v30.1.0/dist/font-face.css" rel="stylesheet"
        type="text/css" />

    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ asset('assets/reserve/assets/images/favicon-32x32.png') }}" />
    <!-- Bootstrap css file -->
    <link rel="stylesheet" href="{{ asset('assets/reserve/styles/bootstrap.min.css') }}" />
    <!-- main style file -->
    <link rel="stylesheet" href="{{ asset('assets/reserve/styles/main.css') }}" />


    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css">


    <title>Reservation Car | KARA Plus</title>

    <!-- Feel free to remove these styles or customise in your own stylesheet 👍 -->
    <style>
        @font-face {
            font-family: "IRANSans_Regular";
            src: url("../assets/fonts/IRANSans_Regular.ttf");
            font-weight: bold !important;
            font-style: normal !important;
        }

        /* اصلاحات RTL */
        body {
            font-family: 'IRANSans_Regular', Vazir, sans-serif !important;
            text-align: right !important;
        }

        .car-card {
            transition: all 0.3s ease;
            /* cursor: pointer; */
            border-radius: var(--card-radius);
        }

        .car-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        .card-active .card {
            border: 2px solid #CD1D1D !important;
            background-color: var(--primary-hover);
        }

        .car-image-container {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .price-box {
            transition: all 0.2s;
            border: 1px solid #eef2f7;
        }

        .price-box:hover {
            transform: scale(1.05);
            /* border-color: #CD1D1D; */
        }

        .feature-badge {
            padding: 6px 12px;
            background: rgba(13, 110, 253, 0.08);
            border-radius: 20px;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
        }

        .selection-circle {
            width: 24px;
            height: 24px;
            border: 2px solid #dee2e6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .selection-circle.selected {
            background: #CD1D1D;
            border-color: #CD1D1D;
        }

        .selection-circle.selected i {
            color: white;
            font-size: 0.7rem;
            display: block;
        }

        .car-img {
            transition: transform 0.5s;
        }

        .car-card:hover .car-img {
            transform: scale(1.05);
        }

        .form-check-input {
            margin-left: 0.5rem;
            margin-right: -1.5rem;
        }

        /* اصلاح جهت dropdown */
        .dropdown-menu {
            text-align: right;
            left: auto !important;
            right: 0;
        }

        /* اصلاح ترتیب عناصر فرم */
        .input-group>.form-control {
            border-radius: 0 0.25rem 0.25rem 0 !important;
        }

        .input-group-prepend {
            border-radius: 0.25rem 0 0 0.25rem !important;
        }

        .form-label,
        .form-select,
        .form-control,
        .btn {
            text-align: right;
        }

        /* اصلاح جهت استپ‌ها */
        .step {
            direction: rtl;
        }

        .attribution {
            font-size: 11px;
            text-align: center;
        }

        .attribution a {
            color: hsl(228, 45%, 44%);
        }

        .btn-select-car {
            font-size: 0.9rem;
            padding: 0.4rem 0.8rem;
            border: 1px solid #CD1D1D;
            color: #CD1D1D;
            background-color: transparent;
            border-radius: 30px;
            transition: all 0.3s ease;
        }

        .btn-select-car:hover {
            background-color: #CD1D1D;
            color: white;
        }

        .btn-select-car.selected {
            background-color: #CD1D1D;
            color: white;
            font-weight: bold;
        }

        .feature-badge {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 6px 12px;
            font-size: 0.9rem;
            color: #333;
            display: flex;
            align-items: center;
            gap: 4px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }
    </style>
    @stack('styles')

</head>

<body>
    <div>
        {{ $slot }}
    </div>



    <!-- main js -->
    <script src="{{ asset('assets/reserve/js/main.js') }}" defer></script>
    <!-- Bootstrap js -->
    <script src="{{ asset('assets/reserve/js/bootstrap.min.js') }}"></script>



    @stack('scripts')

</body>

</html>
