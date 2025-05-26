@can('admin-access')
    @extends('layouts.Admin.app')

    @section('content')
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 container-fluid d-flex flex-column vh-100">
                        {{-- start --}}


                        <div class="row flex-grow-1 g-3">
                            <!-- Forum Management Panel -->
                            <div class="col-lg-8 d-flex flex-column bg-white rounded overflow-auto">
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
                                        <tr>
                                            <td>ExampleUser1</td>
                                            <td>Topic One</td>
                                            <td>This is a sample forum post content.</td>
                                            <td>
                                                <button class="btn btn-sm btn-danger" disabled>Delete</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>ExampleUser2</td>
                                            <td>Topic Two</td>
                                            <td>Another example post content.</td>
                                            <td>
                                                <button class="btn btn-sm btn-danger" disabled>Delete</button>
                                            </td>
                                        </tr>
                                        <!-- Additional rows here -->
                                    </tbody>
                                </table>
                            </div>

                            <!-- User Management Panel -->

                            <!-- User Management Panel -->
                            <div class="col-lg-4 d-flex flex-column bg-white rounded shadow overflow-auto">
                                <h3 class="text-success mb-3 mt-3 ms-2">User Management</h3>
                                <ul class="list-group flex-grow-1">

                                    <!-- User Two -->
                                    <li class="list-group-item">
                                        <form method="POST" action="/user/update"
                                            class="d-flex justify-content-between align-items-center flex-wrap">
                                            <input type="hidden" name="user_id" value="2">
                                            <div class="flex-grow-1">
                                                <strong>User Two</strong><br>
                                                <small>Account Type: Editor</small>
                                            </div>
                                            <div class="d-flex gap-1 mt-2 mt-md-0">
                                                <button type="submit" name="action" value="edit"
                                                    class="btn btn-sm btn-outline-primary"><i
                                                        class="fa-solid fa-pen"></i></button>
                                                <button type="submit" name="action" value="delete"
                                                    class="btn btn-sm btn-outline-danger"><i
                                                        class="fa-solid fa-trash"></i></button>
                                                <button type="submit" name="action" value="disable"
                                                    class="btn btn-sm btn-outline-warning"><i
                                                        class="fa-solid fa-user-slash"></i></button>
                                            </div>
                                        </form>
                                    </li>

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
    @endsection
@endcan


</body>

</html>
