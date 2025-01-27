@can('user-access')
    @extends('layouts.Users.app')

    @section('content')
        <div class="container overflow-hidden py-4 px-5">

            {{-- Announcment --}}
            <div class="row gap-3"> <!-- gap-3 adds space between columns -->
                <div class="col-md-8 bg-white rounded p-3 shadow overflow-auto">
                    <div class="fw-bold fs-4"> <i class="fa-solid fa-bullhorn me-2 text-primary"></i> Announcement</div>
                    <div class="mt-2 text-gray-600">
                        <p><strong class="text-success">Important Update:</strong> Our annual maintenance will take place this
                            weekend
                            from 10:00 PM
                            on Saturday to 4:00 AM on Sunday. All services will be unavailable during this time. Please plan
                            accordingly.</p>
                        <p><strong class="text-danger">Notice:</strong> The new website features will be live starting next week.
                            Expect improved
                            performance and a new layout design.</p>
                    </div>
                </div>

                {{-- Next Schedule --}}
                <div class="col-md-3 ms-auto bg-white rounded p-3 shadow">
                    <div class="fw-bold fs-4"> <i class="fa-solid fa-calendar-day text-primary me-2"></i> Next Schedule</div>
                    <div class="mt-2 text-gray-600">
                        <p><strong>Date:</strong> 2025-01-20</p>
                        <p><strong>Time:</strong> 3:00 PM</p>
                        <p><strong>Event:</strong> Staff Training - Topic: "Advanced User Management"</p>
                    </div>
                </div>

                {{-- Forum --}}
                <div class="card me-5 shadow">
                    <div class="card-header bg-white py-3 px-3">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="fw-bold fs-4"><i class="fa-brands fa-forumbee text-primary me-2"></i> Forum</div>
                            </div>

                            <div class="col-md-3 text-right">
                                <!-- Create Thread Button trigger modal -->
                                <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal"
                                    data-bs-target="#createThread">
                                    <i class="fa-solid fa-plus me-2"></i>Create
                                    Threads
                                </button>

                                <!-- Create Thread Modal -->
                                <form method="POST" id="createThreadForm">
                                    @csrf

                                    <div class="modal modal-lg fade" id="createThread" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">

                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                        <i class="fa-solid fa-plus me-2 text-primary"></i>
                                                        <strong class="fs-5">Create Thread</strong>
                                                    </h1>

                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">

                                                    <div class="row">
                                                        <div class="col-md-7">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" id="title" placeholder="Title"
                                                                    class="form-control shadow" name="title" required>
                                                                <label for="title">Title/Questions</label>
                                                                @error('title')
                                                                    <p style="color: red;">{{ $message }}</p>
                                                                @enderror
                                                            </div>

                                                        </div>

                                                        <div class="col-md-5">
                                                            <div class="form-floating mb-3">
                                                                <select id="category" class="form-select mb-3 shadow"
                                                                    aria-label="Large select example" name="category" required>

                                                                    <option selected disabled></option>

                                                                    @foreach ($categoryGroups as $group)
                                                                        <optgroup label="{{ $group->name }}">
                                                                            @foreach ($group->categories as $category)
                                                                                <option value="{{ $category->id }}">
                                                                                    {{ $category->name }}</option>
                                                                            @endforeach
                                                                        </optgroup>
                                                                    @endforeach


                                                                </select>
                                                                <label for="category">Select Category</label>
                                                                @error('category')
                                                                    <p style="color: red;">{{ $message }}</p>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <input type="hidden" name="farmers_id" value="{{ auth()->id() }}">
                                                    @error('farmers_id')
                                                        <p style="color: red;">{{ $message }}</p>
                                                    @enderror

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Create</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <a href="users/viewThread" class="card-link text-dark text-decoration-none">
                            <h5 class="card-title">Farming Forum: Equipment Ripper</h5>
                            <p class="card-text">Discussion about the equipment ripper and its benefits for modern farming
                                techniques.</p>
                            <p class="card-text text-right"><small class="text-muted">Posted on: <span
                                        class="date-posted">[Date]</span> by
                                    <span class="author">[Author]</span></small></p>

                        </a>

                        <div class="separator" style="border-top: 1px solid #ddd; margin: 20px 0;"></div>


                        <a href="[Your URL]" class="card-link text-dark text-decoration-none">
                            <h5 class="card-title">Farming Forum: Tractor Innovations</h5>
                            <p class="card-text">Explore the latest innovations in tractor technology for sustainable
                                farming.</p>
                            <p class="card-text text-right"><small class="text-muted">Posted on: <span
                                        class="date-posted">[Date]</span> by
                                    <span class="author">[Author]</span></small>
                            </p>
                        </a>

                        <div class="separator" style="border-top: 1px solid #ddd; margin: 20px 0;"></div>

                        <a href="[Your URL]" class="card-link text-dark text-decoration-none">
                            <h5 class="card-title">Farming Forum: Soil Health Practices</h5>
                            <p class="card-text">Learn about the best practices for maintaining healthy soil on your farm.
                            </p>
                            <p class="card-text text-right"><small class="text-muted">Posted on: <span
                                        class="date-posted">[Date]</span> by
                                    <span class="author">[Author]</span></small>
                            </p>
                        </a>

                        <div class="separator" style="border-top: 1px solid #ddd; margin: 20px 0;"></div>

                        <a href="[Your URL]" class="card-link text-dark text-decoration-none">
                            <h5 class="card-title">Farming Forum: Irrigation Solutions</h5>
                            <p class="card-text">A discussion on effective irrigation techniques for water conservation in
                                farming.</p>
                            <p class="card-text text-right"><small class="text-muted">Posted on: <span
                                        class="date-posted">[Date]</span> by
                                    <span class="author">[Author]</span></small>
                            </p>
                        </a>

                        <div class="separator" style="border-top: 1px solid #ddd; margin: 20px 0;"></div>

                    </div>
                </div>

            </div>




        </div>


        {{-- creating thread via ajax --}}
        <script>
            document.getElementById('createThreadForm').addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission behavior

                // Get the form element
                let form = document.getElementById('createThreadForm');

                // Create a FormData object from the form
                let formData = new FormData(form);

                // Send the form data via AJAX
                fetch('/users/createThreads', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}', // Include CSRF token
                        },
                        body: formData, // Form data will automatically be handled as multipart/form-data
                    })
                    .then(response => response.json()) // Process the JSON response
                    .then(data => {
                        if (data.status === 'success') {
                            toastr.success('Thread created successfully!');
                            setTimeout(() => {
                                window.location.reload(); // Reload the page after success
                            }, 700); // Adjust the delay if necessary (2 seconds here)
                        } else {
                            toastr.error('Failed to create thread');
                        }
                    })
                    .catch(error => console.log('Error:', error));
            });
        </script>
    @endsection
@endcan
