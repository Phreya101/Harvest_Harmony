@can('user-access')
    @extends('layouts.Users.app')

    @section('content')
        @php
            $commentCount = $comments->count();
        @endphp
        <div class="container overflow-hidden py-4 px-5">

            <div class="card">
                <h5 class="card-header bg-white py-3">
                    <a href="{{ url('users/dashboard') }}" class="text-decoration-none me-3 ms-2">
                        <i class="fa-solid fa-arrow-left text-primary"></i>
                    </a>

                    <strong class="fs-3">{{ $thread->category->name }}</strong>


                    {{-- This Show when the thread poster is the one who logged in --}}
                    @if (Auth::user()->id === $thread->user->id)
                        <div class="btn-group float-end">
                            <button type="button" class="btn btn-md rounded" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>
                            <ul class="dropdown-menu">

                                {{-- Updating Thread --}}
                                <li>
                                    <button type="button" class="btn btn-sm dropdown-item text-success" data-bs-toggle="modal"
                                        data-bs-target="#updateThread">
                                        <i class="fa-solid fa-pen me-2"></i>Edit
                                    </button>
                                </li>


                                {{-- delete thread button --}}
                                <li>
                                    <button id="deleteThread" data-id="{{ $thread->id }}"
                                        class="dropdown-item btn btn-sm text-danger">
                                        <i class="fa-solid fa-trash me-2"></i>Delete
                                    </button>
                                </li>
                            </ul>
                        </div>

                        {{-- Updating Thread Modal --}}
                        <form method="POST" id="updateThreadForm">
                            @csrf

                            <div class="modal modal-lg fade" id="updateThread" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">

                                            <h1 class="modal-title fs-6" id="exampleModalLabel">
                                                <i class="fa-solid fa-pen me-2 text-success"></i>
                                                <strong class="fs-6">Edit Thread</strong>
                                            </h1>

                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            <div class="row">
                                                <div class="col-md-7">

                                                    <input type="text" id="title" value="{{ $thread->title }}"
                                                        class="form-control shadow" name="title" placeholder="Title/Question"
                                                        required>
                                                    @error('title')
                                                        <p style="color: red;">{{ $message }}</p>
                                                    @enderror


                                                </div>

                                                <div class="col-md-5">

                                                    <select id="category" class="form-select mb-3 shadow"
                                                        aria-label="Large select example" name="category" required>

                                                        <option selected disabled>Select Category</option>

                                                        @foreach ($categoryGroups as $group)
                                                            <optgroup label="{{ $group->name }}">
                                                                @foreach ($group->categories as $category)
                                                                    <option value="{{ $category->id }}"
                                                                        @if ($thread->category->id == $category->id) selected @endif>
                                                                        {{ $category->name }}</option>
                                                                @endforeach
                                                            </optgroup>
                                                        @endforeach


                                                    </select>
                                                    @error('category')
                                                        <p style="color: red;">{{ $message }}</p>
                                                    @enderror

                                                </div>
                                            </div>

                                            <input type="hidden" name="farmers_id" value="{{ auth()->id() }}">
                                            <input type="hidden" name="thread_id" value="{{ $thread->id }}">
                                            @error('farmers_id')
                                                <p style="color: red;">{{ $message }}</p>
                                            @enderror

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-success">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                    @endif


                </h5>
                <div class="card-body">
                    <h5 class="card-title">{{ $thread->title }}</h5>
                    <p class="card-text text-right">
                        <small class="text-muted">
                            @if ($thread->created_at == $thread->updated_at)
                                Posted on:
                            @elseif($thread->created_at < $thread->updated_at)
                                Updated at:
                            @endif
                            <span class="date-posted">
                                @if ($thread->created_at == $thread->updated_at)
                                    {{ $thread->created_at->format('F d, Y') }}
                                @elseif($thread->created_at < $thread->updated_at)
                                    {{ $thread->updated_at->format('F d, Y ') }}
                                @endif

                            </span>
                            by <span class="author">
                                @if (Auth::user()->id === $thread->user->id)
                                    <small class="text-primary">YOU</small>
                                @else
                                    {{ $thread->user->name }}
                                @endif
                            </span>
                        </small>
                    </p>
                    <div class="card-footer bg-white">

                        {{-- Add Comment --}}
                        <button class="btn btn-sm btn-success shadow round w-100" type="button" data-bs-toggle="collapse"
                            data-bs-target="#commentInput" aria-expanded="false" aria-controls="collapseExample">
                            Comment
                            <span class="badge rounded-pill text-bg-secondary">{{ $commentCount }}</span>
                        </button>

                        <div class="collapse" id="commentInput">
                            <div class="card card-body border-0">
                                <form method="POST" id="addCommentForm">
                                    @csrf
                                    <div class="input-group mb-3">
                                        <input type="text" name="comment" class="form-control"
                                            placeholder="Write a Comment...." aria-label="Write a Comment...."
                                            aria-describedby="addComment">

                                        <input type="hidden" name="thread_id" value="{{ $thread->id }}">
                                        <input type="hidden" name="farmers_id" value="{{ Auth::user()->id }}">
                                        <button class="btn btn-outline-secondary" type="submit" id="addComment"><i
                                                class="fa-regular fa-paper-plane"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                </div>


            </div>

            <div class="card mt-2">
                <div class="card-body">
                    <div class="card-title">
                        <i class="fa-regular fa-comments me-2 text-primary"></i> Comments
                    </div>

                    <div class="separator" style="border-top: 1px solid #ddd; margin: 10px 0;"></div>

                    <ul class="list-group list-group-flush">

                        {{-- Comment add Replies --}}
                        @foreach ($comments as $comment)
                            <li class="list-group-item">

                                <div class="row">
                                    <div class="col-sm-8">
                                        <h6 class="card-title">{{ $comment->comment }}</h6>
                                    </div>

                                    <div class="col-sm-4">
                                        {{-- This Show when comment the poster is the one who logged in --}}
                                        @if (Auth::user()->id == $comment->farmers_id)
                                            <button type="button" class="btn btn-sm text-secondary rounded float-end"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu">

                                                {{-- Updating comment --}}
                                                <li>
                                                    <button type="button" class="btn btn-sm dropdown-item text-success"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#updateComment{{ $comment->id }}">
                                                        <i class="fa-solid fa-pen me-2"></i>Edit
                                                    </button>
                                                </li>


                                                {{-- delete comment button --}}
                                                <li>
                                                    <button id="deleteComment{{ $comment->id }}"
                                                        data-id="{{ $comment->id }}"
                                                        class="dropdown-item btn btn-sm text-danger">
                                                        <i class="fa-solid fa-trash me-2"></i>Delete
                                                    </button>
                                                </li>
                                        @endif

                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-sm-6">

                                        <p class="card-text my-2">
                                            <small>
                                                <span class="text-muted">

                                                    @if ($comment->created_at == $comment->updated_at)
                                                        {{ $comment->created_at->format('F d, Y ') }}
                                                    @elseif($comment->created_at < $comment->updated_at)
                                                        {{ $comment->updated_at->format('F d, Y ') }}
                                                    @endif
                                                    by
                                                    @if (Auth::user()->id == $comment->farmers_id)
                                                        <small class="text-primary">YOU</small>
                                                    @else
                                                        {{ $comment->user->name }}
                                                    @endif

                                                </span>
                                            </small>
                                        </p>
                                    </div>



                                    <div class="col-sm-6">
                                        <div class="btn-group float-end" role="group" aria-label="Basic example">
                                            <button class="btn btn-sm my-2 text-decoration-underline" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#replies{{ $comment->id }}"
                                                aria-expanded="false" aria-controls="collapseExample">
                                                <i class="fa-regular fa-comment-dots me-2 text-success"></i>View Replies
                                                <span class="badge text-dark fw-bold">{{ $comment->replies->count() }}</span>
                                            </button>

                                            <button class="btn btn-sm" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#replyInput{{ $comment->id }}" aria-expanded="false"
                                                aria-controls="collapseExample"><i
                                                    class="fa-solid fa-reply text-secondary me-2"></i>Reply
                                            </button>
                                        </div>

                                    </div>



                                    {{-- Add Reply --}}
                                    <div class="collapse" id="replyInput{{ $comment->id }}">
                                        <div class="card card-body border-0 p-1">
                                            <form action="post" id="addReplyForm{{ $comment->id }}">
                                                <div class="input-group mb-3">
                                                    <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                                                    <input type="hidden" name="farmers_id" value="{{ Auth::user()->id }}">
                                                    <input type="text" class="form-control"
                                                        placeholder="Write a Reply...." aria-label="Write a Reply...."
                                                        aria-describedby="addReply" name="reply">

                                                    <button class="btn btn-outline-secondary" type="submit"
                                                        id="addReply"><i class="fa-regular fa-paper-plane"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    {{-- Replies --}}
                                    <div class="collapse" id="replies{{ $comment->id }}">
                                        <div class="card card-body p-2">

                                            @if ($comment->replies->count() > 0)
                                                <ul class="list-group list-group-flush">
                                                    @foreach ($comment->replies as $reply)
                                                        <li class="list-group-item p-2">

                                                            <div class="row">
                                                                <div class="col-sm-7">
                                                                    {{ $reply->reply }}
                                                                </div>

                                                                <div class="col-sm-5">

                                                                    {{-- This Show when the reply poster is the one who logged in --}}
                                                                    @if (Auth::user()->id == $reply->farmers_id)
                                                                        <button type="button"
                                                                            class="btn btn-sm text-secondary rounded float-end"
                                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                                                        </button>
                                                                        <ul class="dropdown-menu">

                                                                            {{-- delete reply button --}}
                                                                            <li>
                                                                                <button id="deleteReply{{ $reply->id }}"
                                                                                    data-id="{{ $reply->id }}"
                                                                                    class="dropdown-item btn btn-sm text-danger">
                                                                                    <i
                                                                                        class="fa-solid fa-trash me-2"></i>Delete
                                                                                </button>
                                                                            </li>
                                                                    @endif

                                                                </div>
                                                            </div>


                                                            <div class="row">
                                                                <div class="col-sm-7"></div>
                                                                <div class="col-sm-5">
                                                                    <p class="card-text text-right">
                                                                        <span class="text-muted">
                                                                            <small>
                                                                                @if ($reply->created_at == $reply->updated_at)
                                                                                    {{ $reply->created_at->format('F d, Y ') }}
                                                                                @elseif($reply->created_at < $reply->updated_at)
                                                                                    {{ $reply->updated_at->format('F d, Y ') }}
                                                                                @endif
                                                                                by
                                                                                @if (Auth::user()->id == $reply->farmers_id)
                                                                                    <strong class="text-primary">YOU</strong>
                                                                                @else
                                                                                    {{ $reply->user->name }}
                                                                                @endif
                                                                            </small>
                                                                        </span>
                                                                    </p>
                                                                </div>
                                                            </div>

                                                        </li>

                                                        {{-- delete reply --}}
                                                        <script>
                                                            $(document).ready(function() {
                                                                $('#deleteReply{{ $reply->id }}').click(function() {

                                                                    let replyId = $(this).data('id');

                                                                    Swal.fire({
                                                                        title: "Are you sure?",
                                                                        text: "You won't be able to revert this!",
                                                                        icon: "warning",
                                                                        showCancelButton: true,
                                                                        confirmButtonColor: "#3085d6",
                                                                        cancelButtonColor: "#d33",
                                                                        confirmButtonText: "Yes, delete it!"
                                                                    }).then((result) => {
                                                                        if (result.isConfirmed) {

                                                                            $.ajax({
                                                                                url: "/users/deleteReply/" + replyId, // Update route
                                                                                type: "DELETE",
                                                                                headers: {
                                                                                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                                                                        "content"), // CSRF Token
                                                                                },
                                                                                success: function(response) {
                                                                                    if (response.status === "success") {
                                                                                        toastr.success(
                                                                                            "Reply deleted successfully!"
                                                                                        ); // Show success notification
                                                                                        setTimeout(() => {
                                                                                            location
                                                                                                .reload(); // Reload the page after 700ms
                                                                                        }, 700);
                                                                                    } else {
                                                                                        toastr.error("Failed to reply comment.");
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
                                                    @endforeach

                                                </ul>
                                            @else
                                                <h5 class="text-center text-muted">No Reply!</h5>
                                            @endif

                                        </div>
                                    </div>
                                </div>


                            </li>

                            {{-- edit comment form --}}
                            <form method="post" id="updateCommentForm{{ $comment->id }}">
                                <div class="modal modal-lg fade" id="updateComment{{ $comment->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">

                                                <h1 class="modal-title fs-6" id="exampleModalLabel">
                                                    <i class="fa-solid fa-pen me-2 text-success"></i>
                                                    <strong class="fs-6">Edit Comment</strong>
                                                </h1>

                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body">

                                                <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                                                <input name="comment" type="text" class="form-control shadow-sm"
                                                    value="{{ $comment->comment }}">
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-success">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            {{-- update comment ajax --}}
                            <script>
                                $(document).ready(function() {
                                    $('#updateCommentForm{{ $comment->id }}').submit(function(event) {
                                        event.preventDefault(); // Prevent default form submission

                                        let formData = new FormData(this); // Get form data
                                        let commentId = $('input[name="comment_id"]').val(); // Get thread ID

                                        $.ajax({
                                            url: "/users/updateComment/" + commentId, // Update route
                                            type: "POST",
                                            data: formData,
                                            processData: false, // Required for FormData
                                            contentType: false, // Required for FormData
                                            headers: {
                                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"), // CSRF Token
                                            },
                                            success: function(response) {
                                                if (response.status === "success") {
                                                    toastr.success(
                                                        "Comment updated successfully!"); // Show success notification
                                                    setTimeout(() => {
                                                        location.reload(); // Reload after a short delay
                                                    }, 700);
                                                } else {
                                                    toastr.error("Failed to update comment.");
                                                }
                                            },
                                            error: function(xhr) {
                                                console.log(xhr.responseText);
                                                toastr.error("Something went wrong!");
                                            },
                                        });
                                    });
                                });
                            </script>


                            {{-- delete comment --}}
                            <script>
                                $(document).ready(function() {
                                    $('#deleteComment{{ $comment->id }}').click(function() {

                                        let commentId = $(this).data('id');

                                        Swal.fire({
                                            title: "Are you sure?",
                                            text: "You won't be able to revert this!",
                                            icon: "warning",
                                            showCancelButton: true,
                                            confirmButtonColor: "#3085d6",
                                            cancelButtonColor: "#d33",
                                            confirmButtonText: "Yes, delete it!"
                                        }).then((result) => {
                                            if (result.isConfirmed) {

                                                $.ajax({
                                                    url: "/users/deleteComment/" + commentId, // Update route
                                                    type: "DELETE",
                                                    headers: {
                                                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                                            "content"), // CSRF Token
                                                    },
                                                    success: function(response) {
                                                        if (response.status === "success") {
                                                            toastr.success(
                                                                "Comment deleted successfully!"
                                                            ); // Show success notification
                                                            setTimeout(() => {
                                                                location
                                                                    .reload(); // Reload the page after 700ms
                                                            }, 700);
                                                        } else {
                                                            toastr.error("Failed to delete comment.");
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

                            {{-- add reply --}}
                            <script>
                                $(document).ready(function() {
                                    $("#addReplyForm{{ $comment->id }}").submit(function(event) {
                                        event.preventDefault(); // Prevent default form submission

                                        let formData = $(this).serialize(); // Serialize form data

                                        $.ajax({
                                            url: "/users/addReply", // Update this with your actual route
                                            type: "POST",
                                            data: formData,
                                            headers: {
                                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") // CSRF token
                                            },
                                            success: function(response) {
                                                if (response.status === "success") {
                                                    toastr.success(
                                                        "Reply added successfully!"); // Show success notification

                                                    setTimeout(() => {
                                                        location.reload(); // Reload the page after 700ms
                                                    }, 700);
                                                } else {
                                                    toastr.error("Failed to add comment.");
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
                        @endforeach



                    </ul>

                </div>
            </div>



            {{-- Update Thread AJAX --}}
            <script>
                $(document).ready(function() {
                    $('#updateThreadForm').submit(function(event) {
                        event.preventDefault(); // Prevent default form submission

                        let formData = new FormData(this); // Get form data
                        let threadId = $('input[name="thread_id"]').val(); // Get thread ID

                        $.ajax({
                            url: "/users/updateThread/" + threadId, // Update route
                            type: "POST",
                            data: formData,
                            processData: false, // Required for FormData
                            contentType: false, // Required for FormData
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"), // CSRF Token
                            },
                            success: function(response) {
                                if (response.status === "success") {
                                    toastr.success(
                                        "Thread updated successfully!"); // Show success notification
                                    setTimeout(() => {
                                        location.reload(); // Reload after a short delay
                                    }, 700);
                                } else {
                                    toastr.error("Failed to update thread.");
                                }
                            },
                            error: function(xhr) {
                                console.log(xhr.responseText);
                                toastr.error("Something went wrong!");
                            },
                        });
                    });
                });
            </script>

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
                            confirmButtonText: "Yes, delete it!"
                        }).then((result) => {
                            if (result.isConfirmed) {

                                $.ajax({
                                    url: "/users/deleteThread/" + threadId, // Update route
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

            {{-- Add Comment --}}
            <script>
                $(document).ready(function() {
                    $("#addCommentForm").submit(function(event) {
                        event.preventDefault(); // Prevent default form submission

                        let formData = $(this).serialize(); // Serialize form data

                        $.ajax({
                            url: "/users/addComment", // Update this with your actual route
                            type: "POST",
                            data: formData,
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") // CSRF token
                            },
                            success: function(response) {
                                if (response.status === "success") {
                                    toastr.success(
                                        "Comment added successfully!"); // Show success notification

                                    setTimeout(() => {
                                        location.reload(); // Reload the page after 700ms
                                    }, 700);

                                } else {
                                    toastr.error("Failed to add comment.");
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

        </div>
    @endsection
@endcan
