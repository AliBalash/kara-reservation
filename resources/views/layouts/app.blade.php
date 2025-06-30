<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ asset('assets/reserve/assets/images/favicon-32x32.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/reserve/styles/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/reserve/styles/main.css') }}" />

    <title>Registery Discount Code</title>
    <style>
        .attribution {
            font-size: 11px;
            text-align: center;
        }

        .attribution a {
            color: hsl(228, 45%, 44%);
        }
        
    </style>
    @stack('styles')
</head>

<body>
    <div class="container">
        {{ $slot }}
    </div>

    {{-- <script src="{{ asset('assets/reserve/js/main.js') }}" defer></script> --}}
    <script src="{{ asset('assets/reserve/js/bootstrap.min.js') }}"></script>
    @stack('scripts')
</body>

</html>
