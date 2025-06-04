@can('admin-access')
    @extends('layouts.Admin.app')

    @section('content')
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 container-fluid d-flex flex-column vh-100">
                        {{-- start --}}


                        <div class="row flex-grow-1 g-3 overflow-auto">
                            <!-- Forum Management Panel -->
                            <div class="col-lg-8 d-flex flex-column bg-white rounded">
                                <h3 class="text-primary mb-3  ms-2">Thread Management</h3>
                                <table class="table table-striped table-hover align-middle mb-0">
                                    <thead class="table-primary sticky-top">
                                        <tr>
                                            <th scope="col">Uploader</th>
                                            <th scope="col">Category</th>
                                            <th scope="col">Content</th>
                                            <th scope="col" style="width: 110px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($threads as $thread)
                                            <tr>
                                                <td>{{ $thread->user->name }}</td>
                                                <td>{{ $thread->category->name }}
                                                </td>
                                                <td>{{ Str::limit($thread->title, 100) }}</td>
                                                <td>
                                                    <button id="deleteThread" data-id="{{ $thread->id }}"
                                                        class="btn btn-sm text-danger">
                                                        <i class="fa-solid fa-trash me-2"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- User Management Panel -->
                            <div class="col-lg-4 d-flex flex-column bg-white rounded shadow overflow-auto">
                                <h3 class="text-success mb-3 mt-3 ms-2">User Management</h3>
                                <ul class="list-group flex-grow-1">

                                    <!-- User Two -->
                                    @foreach ($users as $user)
                                        <li class="list-group-item">
                                            <form method="POST"
                                                class="d-flex justify-content-between align-items-center flex-wrap">
                                                <input type="hidden" name="user_id" value="2">
                                                <div class="flex-grow-1">
                                                    <strong>{{ $user->name }}</strong><br>
                                                    <small>{{ $user->email }}</small>
                                                </div>
                                                <div class="d-flex gap-1 mt-2 mt-md-0">
                                                    <button type="button" class="btn btn-primary btn-edit-thread"
                                                        data-id="{{ $user->id }}" data-name="{{ $user->name }}"
                                                        data-email="{{ $user->email }}" data-address="{{ $user->address }}"
                                                        data-number="{{ $user->number }}" data-bs-toggle="modal"
                                                        data-bs-target="#editModal">
                                                        <i class="fa-solid fa-pen"></i>
                                                    </button>


                                                    {{-- <button type="button" name="action" value="delete"
                                                        class="btn btn-sm btn-outline-danger"><i
                                                            class="fa-solid fa-trash"></i></button>

                                                    <button type="submit" name="action" value="disable"
                                                        class="btn btn-sm btn-outline-warning"><i
                                                            class="fa-solid fa-user-slash"></i></button> --}}
                                                </div>
                                            </form>
                                        </li>
                                    @endforeach

                                    <!-- Add more users below using the same pattern -->

                                </ul>
                            </div>



                            <!-- end User Management Panel -->
                        </div>



                        {{-- end --}}
                    </div>
                </div>
            </div>
        </div>

        {{-- edit user profile --}}

        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <div class="mb-3">
                                <label for="userName" class="form-label">Name</label>
                                <input type="text" class="form-control" id="userName" name="userName" placeholder=""
                                    value="">
                            </div>

                            <div class="mb-3">
                                <label for="userAddress" class="form-label">Address</label>
                                <input type="text" class="form-control" id="userAddress" name="userAddress" placeholder=""
                                    value="">
                            </div>

                            <div class="mb-3">
                                <label for="userNumber" class="form-label">Number</label>
                                <input type="text" class="form-control" id="userNumber" name="userNumber" placeholder=""
                                    value="">
                            </div>

                            <div class="mb-3">
                                <label for="userEmail" class="form-label">Email</label>
                                <input type="Email" class="form-control" id="userEmail" name="userEmail" placeholder=""
                                    value="">
                            </div>

                            <div class="mb-3">
                                <label for="userPassword" class="form-label">Password</label>
                                <input type="password" class="form-control" id="userPassword" name="userPassword"
                                    placeholder="Leave blank to keep current password">
                            </div>
                            <!-- Add other input fields as needed -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>


        {{-- Deleting Thread --}}
        <script>
            $(document).ready(function() {
                $('#deleteThread').click(function() {

                    let threadId = $(this).data('id');

                    Swal.fire({
                        title: "Are you sure?",
                        text: "You won't be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, delete it!",

                        customClass: {
                            confirmButton: 'btn btn-primary m-2',
                            cancelButton: 'btn btn-secondary'
                        },
                        buttonsStyling: false,
                        focusConfirm: false
                    }).then((result) => {
                        if (result.isConfirmed) {

                            $.ajax({
                                url: "/admin/deleteThread/" + threadId, // Update route
                                type: "DELETE",
                                headers: {
                                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                        "content"), // CSRF Token
                                },
                                success: function(response) {
                                    if (response.status === "success") {
                                        toastr.success(
                                            "Thread deleted successfully!"
                                        ); // Show success notification
                                        setTimeout(() => {
                                            location.href =
                                                "/dashboard"; // Redirect to the dashboard after 700ms
                                        }, 700);
                                    } else {
                                        toastr.error("Failed to delete thread.");
                                    }
                                },
                                error: function(xhr) {
                                    console.log(xhr.responseText);
                                    toastr.error("Something went wrong!");
                                },
                            });

                        }
                    });
                });
            });
        </script>

        {{-- edit profile --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var editModal = document.getElementById('editModal');
                editModal.addEventListener('show.bs.modal', function(event) {
                    var button = event.relatedTarget;

                    var userId = button.getAttribute('data-id');
                    var userName = button.getAttribute('data-name');
                    var userAddress = button.getAttribute('data-address');
                    var userNumber = button.getAttribute('data-number');
                    var userEmail = button.getAttribute('data-email');

                    // Set placeholder and value of input
                    var name = editModal.querySelector('#userName');
                    name.placeholder = userName;
                    name.value = userName;

                    var address = editModal.querySelector('#userAddress');
                    address.placeholder = userAddress;
                    address.value = userAddress;

                    var number = editModal.querySelector('#userNumber');
                    number.placeholder = userNumber;
                    number.value = userNumber;

                    var email = editModal.querySelector('#userEmail');
                    email.placeholder = userEmail;
                    email.value = userEmail;


                    // Update form action to send to the right thread update URL
                    var form = editModal.querySelector('#editForm');
                    form.action = 'admin/EditUser/' + userId; // update URL as needed
                });
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('editForm');

                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(form);
                    const actionUrl = form.action;

                    fetch(actionUrl, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                toastr.success(data.message || 'User updated successfully.');

                                // Optional: Refresh after success
                                setTimeout(() => {
                                    location.reload();
                                }, 1500);
                            } else {
                                toastr.error(data.message || 'Failed to update user.');
                            }
                        })
                        .catch(error => {
                            console.error(error);
                            toastr.error('Something went wrong.');
                        });
                });
            });
        </script>
    @endsection
@endcan
