<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Harvest Harmony: Crop Equipment Scheduling for Efficiency and Yield</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('build/bootstrap/bootstrap.v5.3.2.min.css') }}">

    {{-- toastr --}}
    <link href="{{ asset('build/toastr/build/toastr.min.css') }}" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        /* Reset & Page Setup */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: darkblue;
        }

        .navbar-brand {
            font-weight: bold;
            color: #fff !important;
        }

        .nav-link {
            color: #fff !important;
            margin-right: 15px;
            transition: color 0.3s, background-color 0.3s;
        }

        .nav-link:hover {
            background-color: #45a049;
            border-radius: 5px;
        }

        /* Calendar Container */
        .hero-section {
            padding: 50px;
            max-width: 100%;
            height: 700px;
            min-height: 80vh;
            box-sizing: border-box;
            overflow: hidden;
            background-color: #f9f9f9;
        }

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

</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">

            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('image/logo.png') }}" alt="Logo" width="50" height="50" class="me-2">
                Harvest Harmony
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">

                    <li class="nav-item">
                        <a href="{{ url('/') }}" class="nav-link">Return Home</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section">
        <div id="calendar"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1/index.global.min.js"></script>

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="appointmentModal" tabindex="-1" aria-labelledby="appointmentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="appointmentForm" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Appointment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p id="selectedDateText"></p>
                        <!-- Add your input fields here -->
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contact Number</label>
                            <input type="number" class="form-control" name="contact" required>
                        </div>
                        <input type="hidden" name="date" id="selectedDate">
                        <input type="hidden" name="status" value="pending">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                aspectRatio: 1.5,
                contentHeight: 'auto',

                events: '/appointments/events', // 👈 Load events from Laravel route

                dateClick: function(info) {
                    const clickedDate = new Date(info.dateStr);
                    const today = new Date();
                    const events = calendar.getEvents();
                    const isFullyBooked = events.some(event =>
                        event.startStr === clickedDate && event.title === 'Fully Booked'
                    );

                    if (isFullyBooked) {
                        alert("Sorry, this date is fully booked.");
                        return;
                    }

                    today.setHours(0, 0, 0, 0);

                    if (clickedDate < today) {
                        alert("You cannot schedule on past dates.");
                        return;
                    }


                    document.getElementById('selectedDateText').textContent = info.dateStr;
                    document.getElementById('selectedDate').value = info.dateStr;
                    const modal = new bootstrap.Modal(document.getElementById(
                        'appointmentModal'));
                    modal.show();
                }
            });

            calendar.render();
        });
    </script>

    <script>
        $(document).ready(function() {
            $("#appointmentForm").submit(function(event) {
                event.preventDefault(); // Prevent default form submission

                let formData = $(this).serialize(); // Serialize form data

                $.ajax({
                    url: "scheduler/add", // 🔁 Update with your actual route
                    type: "POST",
                    data: formData,
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content") // If using Laravel
                    },
                    success: function(response) {
                        if (response.status === "success") {
                            toastr.success("Appointment saved!");

                            // Optional: close modal and reset form
                            $("#appointmentModal").modal("hide");
                            $("#appointmentForm")[0].reset();

                            setTimeout(() => {
                                location.reload(); // 🔁 Reload to reflect changes
                            }, 700);
                        } else {
                            toastr.error("Failed to save appointment.");
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        toastr.error("Something went wrong!");
                    }
                });
            });
        });
    </script>

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

</body>



</html>
