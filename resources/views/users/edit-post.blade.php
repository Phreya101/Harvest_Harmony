@extends('layouts.Users.app')

@section('content')
    <div class="container mx-auto py-8">
        <h2 class="text-2xl font-semibold mb-6">Edit Post</h2>

        <form action="{{route('users.posts.update', $post->id)}}" method="post">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Content:</label>
                <textarea name="content" id="content" rows="5"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" >{{ old('content', $post->content) }}</textarea>
                    <label for="file">Upload Image/Videos:</label>
                    <input type="file" name="file">
                    
                @error('content')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <!-- Update Button -->
            <div class="flex items-center justify-between">
                <button type="submit"
                    class="btn btn-primary">
                    Update Post
                </button>
                <a href="{{route('users.user_postings')}}" class="text-gray-500">Cancel</a>
            </div>
        </form>
    </div>
@endsection
