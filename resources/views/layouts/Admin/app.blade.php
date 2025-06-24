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



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- bootstrap v5.3.2 -->
    <link rel="stylesheet" href="{{ asset('build/bootstrap/bootstrap.v5.3.2.min.css') }}">


    {{-- toastr --}}
    <link href="{{ asset('build/toastr/build/toastr.min.css') }}" rel="stylesheet">

    {{-- Fontawesome --}}
    <script src="https://kit.fontawesome.com/bace51c485.js" crossorigin="anonymous"></script>

    {{-- flatpickr --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">



</head>

<style>
    #calendar {
        height: 100%;
        width: 100%;
    }

    /* Day Cell Styling */
    .fc-daygrid-day-frame {
        min-height: 100px;
        min-width: 100px;
        padding: 5px;
        cursor: pointer;
    }

    .fc-daygrid-day:hover {
        background-color: #dbdedf;
    }

    /* Responsive Font */
    @media (max-width: 768px) {
        .fc-daygrid-day-frame {
            min-height: 80px;
            font-size: 0.9rem;
        }

        .fc-event {
            font-size: 1.1rem;
        }
    }

    @media (max-width: 480px) {
        .fc-toolbar-title {
            font-size: 1rem;
        }

        .fc-button {
            font-size: 0.8rem;
            padding: 0.2rem 0.4rem;
        }
    }

    /* Default calendar event (reset style) */
    .fc-event {
        background-color: rgb(145, 81, 240) !important;
        border: none !important;
        text-align: center;
        font-weight: bold;
        font-size: 1.2rem;
        justify-content: center;
    }

    /* Center text inside cell */
    .fc-daygrid-event {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100%;
    }

    /* Prevent shrinking of events */
    .fc-daygrid-day-events {
        min-height: 30px;
    }

    /* Appointment count */
    .fc-count {
        color: #0d6efd !important;
        /* Blue */
    }

    /* Fully booked */
    .fc-full {
        color: #dc3545 !important;
        /* Red */
    }

    /* Force text inside the event to inherit color */
    .fc-event-title,
    .fc-event-title-container {
        color: inherit !important;
    }
</style>

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

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1/index.global.min.js"></script>

    {{-- sweet_alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                allDayText: '',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth'
                },
                events: '/admin/appointments/schedule', // route that returns the JSON above

                /* 1) Show contact right in the list view rows */
                eventDidMount: function(info) {
                    if (info.view.type.startsWith('list')) {
                        const contact = info.event.extendedProps.contact;
                        info.el.querySelector('.fc-list-item-title').innerHTML =
                            `${info.event.title} <small class="text-muted">(${contact})</small>`;
                    }
                },

                /* 2) Or open a modal on click */
                eventClick: function(info) {
                    const name = info.event.title;
                    const contact = info.event.extendedProps.contact;

                    // Example alert (replace with Bootstrap modal, Toastr, etc.)
                    alert(`Name: ${name}\nContact: ${contact}`);
                }
            });

            calendar.render();
        });
    </script>
</body>

</html>
