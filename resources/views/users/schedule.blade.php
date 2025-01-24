<div class="container">
    <h2>Schedule an Appointment</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="" method="POST">
        @csrf

        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" id="date" name="date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="time">Time</label>
            <input type="time" id="time" name="time" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" class="form-control" rows="3" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Schedule Appointment</button>
    </form>
</div>
