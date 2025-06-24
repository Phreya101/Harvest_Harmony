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

    <style>
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

        .hero-section {
            background: url('{{ asset('image/logo.png') }}') no-repeat center center;
            background-size: contain;
            /* Keeps the aspect ratio of the logo */
            min-height: 93vh;
            /* Minimum height for smaller screens */
            max-height: 100vh;
            /* Prevents overflowing on large screens */
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: #fff;
            position: relative;
        }

        .hero-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            /* Dark overlay for text readability */
            z-index: 1;
        }

        .hero-section h1,
        .hero-section p {
            position: relative;
            z-index: 2;
        }

        .hero-section h1 {
            font-size: 3rem;
            font-weight: bold;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
        }

        .hero-section p {
            font-size: 1.25rem;
            margin-top: 10px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        }
    </style>


</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Harvest Harmony</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">

                    <li class="nav-item">
                        <a href="{{ route('scheduler') }}" class="nav-link">Scheduler</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section">
        <div>
            <h1>Welcome to Harvest Harmony</h1>
            <p>Effortlessly Schedule Crop Equipment for Maximum Efficiency and Yield</p>
        </div>
    </div>



    <!-- Bootstrap JS -->
    <script src="{{ asset('build/bootstrap/bootstrap.bundle.v5.3.2.min.js') }}"></script>
</body>

</html>
