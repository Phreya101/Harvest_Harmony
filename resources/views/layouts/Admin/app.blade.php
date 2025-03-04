<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Capstone') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])


    <!-- bootstrap v5.3.2 -->
    <link rel="stylesheet" href="{{ asset('build/bootstrap/bootstrap.v5.3.2.min.css') }}">

    {{-- dhtmlxScheduler --}}
    <script src="https://cdn.dhtmlx.com/scheduler/edge/dhtmlxscheduler.js"></script>
    <link href="https://cdn.dhtmlx.com/scheduler/edge/dhtmlxscheduler.css" rel="stylesheet">

    {{-- toastr --}}
    <link href="{{ asset('build/toastr/build/toastr.min.css') }}" rel="stylesheet">

    {{-- Fontawesome --}}
    <script src="https://kit.fontawesome.com/bace51c485.js" crossorigin="anonymous"></script>

    {{-- flatpickr --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">



</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">

        <!-- renders here the navigation -->
        @include('layouts.Admin.navigation')

        {{-- <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif --}}

        <!-- Page Content -->
        <main>
            <!-- starts to render the blade content -->
            @yield('content')
        </main>
    </div>

    @stack('scripts')

    {{-- bootstrap --}}
    <script src="{{ asset('build/bootstrap/bootstrap.v5.3.2.min.js') }}"></script>

    <!-- Toastr JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('build/toastr/build/toastr.min.js') }}"></script>

    <script>
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": true,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "500",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    </script>

    {{-- flatpickr --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

</body>

</html>
